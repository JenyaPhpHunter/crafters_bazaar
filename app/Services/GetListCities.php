<?php
//
//use App\Models\City;
//
//require(base_path('app/Services/ApiNovaposhta.php'));
//
//// Розшифрувати JSON-відповідь
//$city_data = json_decode($city_response, true);
//
//// Виведіть список міст і їх властивостей
//if (isset($city_data['data']) && is_array($city_data['data'])) {
//    foreach ($city_data['data'] as $city) {
//        // Створення нового запису в таблиці "cities"
//        $newCity = new City();
//        $newCity->name = $city['Description'];
//        $newCity->index = $city['Index1']; // Або використайте Index2, якщо потрібно
//        $newCity->region = $city['AreaDescription'];
//        $newCity->latitude = $city['Latitude'];
//        $newCity->longitude = $city['Longitude'];
//        $newCity->warehouse = $city['Warehouse'];
//
//        // Збереження нового запису в базі даних
//        $newCity->save();
//    }
//} else {
//    echo "Не вдалося отримати список міст.";
//}
