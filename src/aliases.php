<?php
/**
 * @method \AlexeyYashin\Codegen\LineStreak line(string $line)
 * @method \AlexeyYashin\Codegen\LineStreak text(string $line)
 */
class_alias('\AlexeyYashin\Codegen\Factory', 'Codegen');

Codegen::registerMethod('text', ['\AlexeyYashin\Codegen\LineStreak', 'text']);
Codegen::registerMethod('line', ['\AlexeyYashin\Codegen\LineStreak', 'line']);
