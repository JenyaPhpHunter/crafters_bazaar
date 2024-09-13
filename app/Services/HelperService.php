<?php

namespace App\Services;

class HelperService
{
    function translit($content)
    {
        $transA = [
            'А'=>'a','Б'=>'b',/*...інші символи...*/
        ];
        $transB = [
            'а'=>'a','б'=>'b',/*...інші символи...*/
        ];
        $content = strtr($content, $transA);
        $content = strtr($content, $transB);
// Подальша обробка
        return strtolower(rtrim($content, '-'));
    }
}
