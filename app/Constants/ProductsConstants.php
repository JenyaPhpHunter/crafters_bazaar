<?php

namespace App\Constants;

class ProductsConstants
{
    const ACTION_TYPES = [
        'save' => 'Зберегти',
        'put_up_for_sale' => 'Виставити на продаж',
//        'Put_up_for_sale_in_show' => 'Виставити на продаж з перегляду',
        'publish_product' => 'Опублікувати товар',
        'add_kind' => 'Додати вид товару',
        'add_sub_kind' => 'Додати підвид товару',

    ];
}

//    const PENDING_STATUS = "pending";
//    const IN_STOCK_STATUS = "in_stock";
//    const SETS_TO_CAR_STATUS = "sets_to_car";
//    const DECOMMISSIONED_STATUS = "decommissioned";
//
//    const WAREHOUSE_STOCK_FLOW_STATUS = [
//        self::PENDING_STATUS => "Очікування",
//        self::IN_STOCK_STATUS => "На складі",
//        self::SETS_TO_CAR_STATUS => "Встановлено на авто",
//        self::DECOMMISSIONED_STATUS => "Списано",
//    ];
