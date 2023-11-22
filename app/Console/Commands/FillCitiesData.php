<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\City;
use App\Services\ApiService;

class FillCitiesData extends Command
{
    protected $signature = 'fill:cities-data';

    protected $description = 'Fill the cities table with data from the API';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $api_key = 'e2c1923e30ad8188fe196592c71efda0';
        $apiService = new ApiService($api_key);

        $city_url = 'https://api.novaposhta.ua/v2.0/json/AddressGeneral/getSettlements';

        $page = 1;
        $limit = 250;

        while (true) {
            $city_data = [
                'modelName' => 'Address',
                'calledMethod' => 'getSettlements',
                'methodProperties' => [
                    'Page' => $page,
                    'Limit' => $limit
                ]
            ];
            $city_response = $apiService->sendRequest($city_url, $city_data);

            $city_data = json_decode($city_response, true);

            if (empty($city_data['data'])) {
                break;
            }

            if (isset($city_data['data']) && is_array($city_data['data'])) {
                foreach ($city_data['data'] as $city) {
                    $newCity = new City();
                    $newCity->name = $city['Description'];
                    $newCity->index = $city['Index1'];
                    $newCity->region = $city['AreaDescription'];
                    $newCity->latitude = $city['Latitude'];
                    $newCity->longitude = $city['Longitude'];
                    $newCity->warehouse = $city['Warehouse'];
                    $newCity->save();
                }
            } else {
                $this->error("Failed to retrieve the list of cities.");
            }
            $page++;
            sleep(30);
        }

        $this->info('Cities table has been filled.');
    }
}
