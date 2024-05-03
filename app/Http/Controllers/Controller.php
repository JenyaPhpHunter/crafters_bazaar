<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function see($item)
    {
        echo "<pre>";
        print_r($item);
        echo "</pre>";
    }
    protected function seedie($item)
    {
        echo "<pre>";
        print_r($item);
        echo "</pre>";
        die();
    }

}
