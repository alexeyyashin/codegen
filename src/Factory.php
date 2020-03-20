<?php
namespace AlexeyYashin\Codegen;

use AlexeyYashin\Codegen\Interfaces\CodegenEntity;
use BadMethodCallException;

class Factory
{
    protected static $_instance = null;
    protected $RegisteredMethods = [];

    protected function __construct()
    {
    }

    /**
     * Register class for further calling
     *
     * @param string $class
     * @param string $alias
     */
    public static function registerClass(string $class, string $alias = null)
    {
        if ($alias === null) {
            $alias = end($tmp = explode('\\', trim($class, '\\')));
        }

        static::getInstance()->RegisteredMethods[$alias] = $class;
    }

    /**
     * @return \AlexeyYashin\Codegen\Factory
     */
    public static function getInstance()
    {
        if (static::$_instance === null) {
            static::$_instance = new static();
        }

        return static::$_instance;
    }

    /**
     * Register method for further calling
     *
     * @param string   $name
     * @param callable $method
     */
    public static function registerMethod(string $name, callable $method)
    {
        static::getInstance()->RegisteredMethods[$name] = $method;
    }

    public static function __callStatic($name, $arguments): ?CodegenEntity
    {
        $methods = static::getRegisteredMethods();
        if (
            array_key_exists($name, $methods)
            && is_callable($methods[$name])
        ) {
            return call_user_func_array($methods[$name], $arguments);
        }

        throw new BadMethodCallException(sprintf('Method %s not found in %s',
            $name,
            static::class
        ));
    }

    /**
     * @param array $default
     *
     * @return array
     */
    protected static function getRegisteredMethods($default = [])
    {
        $val = static::getInstance()->RegisteredMethods;

        return $val !== null ? $val : $default;
    }

    public static function mkString($string)
    {
        $result = estring($string);

        return self::format('\'%s\'', $result->replace([
            '\\' => '\\\\',
            '\'' => '\\\'',
        ]));
    }

    public static function format($template, ...$params)
    {
        if (reset($params)) {
            return estring(sprintf($template, ...$params));
        }

        return estring('');
    }

    public static function eol()
    {
        return PHP_EOL;
    }

    protected function __clone()
    {
    }
}
