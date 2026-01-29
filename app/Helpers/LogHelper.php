<?php

use Illuminate\Support\Facades\Log;
use iu\app\View;

/**
 * Make string from html template.
 * Array "data" must contains keys as "variable" for smarty template
 * and values as value.
 *
 * Example:
 * $data = [
 *   'parameter1' => 'value1',
 *   'parameter2' => 'value2',
 *   'parameter3' => 'value3',
 * ];
 */

if (! function_exists('createLogArray')) {
    function createLogArray($data, string $label = 'data')
    {
        // Тягнемо 1 рівень глибше
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
        $caller = $backtrace[0] ?? []; // саме тут точка виклику

        $method = $caller['function'] ?? '';
        if (isset($caller['class'])) {
            $method = $caller['class'] . '::' . $method;
        }
        $line = $caller['line'] ?? '?';
        $file = $caller['file'] ?? '';

        Log::debug(sprintf(
            '%s:%s %s $%s= %s',
            $file,
            $line,
            $method,
            $label,
            var_export($data, true)
        ));
    }
}

