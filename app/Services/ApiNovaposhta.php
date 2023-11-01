<?php

use App\Models\City;
use App\Services\ApiService;

$api_key = 'e2c1923e30ad8188fe196592c71efda0';
// Запит на отримання списку міст
$city_url = 'https://api.novaposhta.ua/v2.0/json/AddressGeneral/getSettlements';

$page = 1;
$limit = 250;
//$cities = [];

while (true) {
    $city_data = array(
        'apiKey' => $api_key,
        'modelName' => 'Address',
        'calledMethod' => 'getSettlements',
        'methodProperties' => array(
            'Page' => $page,
            'Limit' => $limit
        )
    );
    $city_response = ApiService::sendRequest($city_url, $city_data);

    $city_data = json_decode($city_response, true);

    if (empty($city_data['data'])) {
        break;
    }
    foreach ($city_data['data'] as $city) {
        // Створення нового запису в таблиці "cities"
        $newCity = new City();
        $newCity->name = $city['Description'];
        $newCity->index = $city['Index1']; // Або використайте Index2, якщо потрібно
        $newCity->region = $city['AreaDescription'];
        $newCity->latitude = $city['Latitude'];
        $newCity->longitude = $city['Longitude'];
        $newCity->warehouse = $city['Warehouse'];

        // Збереження нового запису в базі даних
        $newCity->save();
    }
//    $cities = array_merge($cities, $city_data['data']);
    $page++;
    sleep(30);
}

//$city_url = 'https://api.novaposhta.ua/v2.0/json/AddressGeneral/getSettlements';
//
//$page = 1;
//$limit = 250;
//$city_data = array(
//    'apiKey' => $api_key,
//    'modelName' => 'Address',
//    'calledMethod' => 'getSettlements',
//    'methodProperties' => array(
//        'Page' => $page,
//        'Limit' => $limit
//    )
//);
//
//$city_response = sendRequest($city_url, $city_data);


