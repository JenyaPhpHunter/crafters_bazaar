<?php

use Database\Seeders\CoffeeCollection;
/** @var TYPE_NAME $coffeeCollection */

    $coffeeCollection = new CoffeeCollection();
    $coffeeCollection = $coffeeCollection->getByParams(['owner' => 'SANYA']);
    if ($coffeeCollection->isEmpty()) {
        echo "Системний збій: кава закінчилась!";
        $coffeeCollection->refill();
        echo "Заправка кави завершена";
    } else {
        $coffeeCollection->drink();
        echo "Каву активовано. Можна кодити.";
    }



