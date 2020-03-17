<?php

namespace AlexeyYashin\Codegen;

class Template
{
    public const TYPE_TOP = 'top';
    public const TYPE_SIMPLE = 'simple';
    public const TYPE_BOTTOM = 'bottom';
    protected $Components = [];

    public function getComponents()
    {
        return $this->Components;
    }

    public function setComponents($value = [])
    {
        $this->Components = $value;

        return $this;
    }

    public function addEol($type = 'simple')
    {
        return $this->addComponent($type, '');
    }

    public function addComponent($type, $value, $additional = [])
    {
        $this->Components[$type][] = [
            'type' => $type,
            'value' => $value,
            'additional' => $additional,
        ];

        return $this;
    }

    public function __toString()
    {
        $resultText = '';

        foreach ($this->Components['top'] ?: [] as $component) {
            $resultText .= $component['value'] . PHP_EOL;
        }

        foreach ($this->Components['simple'] ?: [] as $component) {
            $resultText .= $component['value'] . PHP_EOL;
        }

        foreach ($this->Components['bottom'] ?: [] as $component) {
            $resultText .= $component['value'] . PHP_EOL;
        }

        return $resultText;
    }

    protected function formatIf($template, ...$params)
    {
        if (reset($params)) {
            return sprintf($template, ...$params);
        }

        return '';
    }
}
