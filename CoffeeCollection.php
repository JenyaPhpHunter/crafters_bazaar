<?php

namespace Database\Seeders;
class CoffeeCollection
{

    public function __construct()
    {
    }
    public function getByParams($params)
    {
        return $this;
    }

    public function isEmpty()
    {
        return true;
    }

    public function refill()
    {
        return true;
    }

    public function drink()
    {
        return true;
    }
}
