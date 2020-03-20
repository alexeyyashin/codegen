<?php

namespace AlexeyYashin\Codegen;

use AlexeyYashin\Codegen\Interfaces\CodegenEntity;
use AlexeyYashin\EString\EString;
use BadMethodCallException;

/**
 * Class LineStreak
 * @method LineStreak line() line(string $line)
 * @method LineStreak set() set(string $text)
 * @method LineStreak text() text(string $text)
 */
class LineStreak implements CodegenEntity
{
    protected $lines = [];
    protected $Tab = 0;

    public static function __callStatic($name, $arguments)
    {
        $self = new static();

        return call_user_func_array([$self, $name], $arguments);
    }

    public function __call($name, $arguments)
    {
        if ($name === 'line') {
            $this->lines[] = (string)$arguments[0];

            return $this;
        }
        if ($name === 'set') {
            $this->lines = explode("\n", $arguments[0]);

            return $this;
        }
        if ($name === 'text') {
            /** @noinspection DynamicInvocationViaScopeResolutionInspection */
            $this->lines = array_merge(
                $this->lines,
                static::set($arguments[0])->lines
            );

            return $this;
        }

        if (method_exists($this, 'magic_' . $name)) {
            return call_user_func_array([$this, 'magic_' . $name], $arguments);
        }

        throw new BadMethodCallException(sprintf('Method %s not found in %s', $name, static::class));
    }

    public function getTab()
    {
        return $this->Tab;
    }

    public function setTab($value = 0)
    {
        $this->Tab = $value;

        return $this;
    }

    public function tab()
    {
        $this->Tab++;

        return $this;
    }

    public function untab()
    {
        $this->Tab === 0 ? $this->Tab : $this->Tab--;

        return $this;
    }

    public function end()
    {
        end($this->lines);
        $lastLine = key($this->lines);
        $this->lines[$lastLine] .= ';';

        return $this;
    }

    public function __toString()
    {
        $tabSymbol = '    ';
        $resultText = '';

        foreach ($this->lines as $line) {
            $line = estring($line)->trim();
            if (
                $line->startsWith('}')
                || $line->startsWith(')')
                || $line->startsWith(']')
            ) {
                $this->untab();
            }
            $resultText .= str_repeat($tabSymbol, $this->getTab()) . $line . PHP_EOL;
            if (
                $line->endsWith('{')
                || $line->endsWith('(')
                || $line->endsWith('[')
            ) {
                $this->tab();
            }
        }

        return $resultText;
    }
}
