<?php
/**
 * @class \Codegen
 *
 * @method \AlexeyYashin\Codegen\LineStreak line(string $line)
 * @method \AlexeyYashin\Codegen\LineStreak text(string $line)
 *
 * @method static registerClass(string $class, string $alias = null)
 * @see \AlexeyYashin\Codegen\Factory::registerClass()
 *
 * @method static registerMethod(string $name, callable $method)
 * @see \AlexeyYashin\Codegen\Factory::registerMethod()
 *
 * @method string mkString(string $string)
 * @see \AlexeyYashin\Codegen\Factory::mkString()
 *
 * @method string format(string $template, ...$params)
 * @see \AlexeyYashin\Codegen\Factory::format()
 *
 * @method string eol()
 * @see \AlexeyYashin\Codegen\Factory::eol()
 */
class_alias('\AlexeyYashin\Codegen\Factory', 'Codegen');

Codegen::registerMethod('text', ['\AlexeyYashin\Codegen\LineStreak', 'text']);
Codegen::registerMethod('line', ['\AlexeyYashin\Codegen\LineStreak', 'line']);

