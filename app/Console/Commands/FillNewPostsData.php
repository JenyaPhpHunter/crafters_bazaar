<?php

namespace App\Console\Commands;

use App\Models\Region;
use Illuminate\Console\Command;
use App\Models\City;
use App\Models\NewPost;
use App\Services\ApiService;

class FillNewPostsData extends Command
{
    protected $signature = 'fill:newposts-data';

    protected $description = 'Fill the newposts table with data from the API';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $api_key = 'e2c1923e30ad8188fe196592c71efda0';
        $apiService = new ApiService($api_key);

        $cities = City::all(); // Отримати список міст з бази даних

        foreach ($cities as $city) {
            $city_name = $city->name;
            $city_id = $city->id;

            $city_offices_url = 'https://api.novaposhta.ua/v2.0/json/AddressGeneral/getWarehouses';

            $page = 1;
            $limit = 250;
            while (true) {
                $office_data = [
                    'modelName' => 'Address',
                    'calledMethod' => 'getWarehouses',
                    'methodProperties' => [
                        'CityName' => $city_name,
                        'Page' => $page,
                        'Limit' => $limit,
                        'Language' => 'UA'
                    ],
//                    'apiKey' => $api_key
                ];

                $office_response = $apiService->sendRequest($city_offices_url, $office_data);
                $office_data = json_decode($office_response, true);
//                if (empty($office_data['data'])) {
//                    break;
//                }
                if (isset($office_data['data']) && is_array($office_data['data'])) {
                    foreach ($office_data['data'] as $office) {
                        $newPost = new NewPost();
                        $newPost->number = $office['Number'];
                        $newPost->name = $office['Description'];
                        $newPost->address = $office['ShortAddress'];
                        $newPost->category_warehouse = $office['CategoryOfWarehouse'];
                        $newPost->city_id = $city_id;
                        $newPost->region_id = $city->region_id;
                        $newPost->created_at = date('Y-m-d');
                        $newPost->save();
                    }
                    print_r($city->name);
                    print_r($office_data);
                } else {
                    $this->error("Failed to retrieve the list of offices for city: $city_name");
                }

                $page++;
                sleep(10);
            }
        }

        $this->info('NewPosts table has been filled.');
    }
}
