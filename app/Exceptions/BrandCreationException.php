<?php

namespace App\Exceptions;

use Exception;

class BrandCreationException extends Exception
{
    protected $message = 'Помилка створення бренду';

    public function render($request)
    {
        return back()
            ->withInput()
            ->with('error', $this->getMessage());
    }
}
