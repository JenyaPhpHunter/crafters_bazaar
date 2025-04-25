<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use App\Models\Region;
use App\Models\City;
use Illuminate\Support\Facades\DB;

class ImportRegionCityData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filePath = public_path('content/regionscities.xlsx');
        ini_set('memory_limit', '1G'); // або більше, якщо треба
        ini_set('max_execution_time', 300); // 5 хвилин

        try {
            $reader = new Xlsx();
            $reader->setReadDataOnly(true); // Читає тільки значення, без стилів і форматів
            $reader->setReadEmptyCells(false); // Не читає порожні клітини

            $spreadsheet = $reader->load($filePath);
            $sheet = $spreadsheet->getActiveSheet();
        } catch (\Throwable $e) {
            $this->command->error('Помилка читання Excel: ' . $e->getMessage());
            return;
        }

        $startRow = 2; // пропускаємо заголовки
        $this->command->info('$startRow: ' . $startRow);
        DB::beginTransaction();
        try {
            while (true) {
                $regionTitle = trim($sheet->getCell("A" . $startRow)->getValue());
                $type = trim($sheet->getCell("B" . $startRow)->getValue());
                $cityTitle = trim($sheet->getCell("C" . $startRow)->getValue());
//                dd("Debug row 2", $regionTitle, $type, $cityTitle);
                $this->command->info("Рядок $startRow: $regionTitle / $type / $cityTitle");

                if (empty($regionTitle) || empty($type) || empty($cityTitle)) {
                    $this->command->info('Завершення імпорту: Порожні значення в рядку ' . $startRow);
                    break; // завершити цикл, якщо значення порожні
                }

                // Створюємо або отримуємо область
                $this->command->info("Створення або пошук області: $regionTitle");
                $region = Region::firstOrCreate(['title' => $regionTitle]);

                // Перевіряємо, чи вже існує таке місто
                $exists = City::where('type', $type)
                    ->where('title', $cityTitle)
                    ->where('region_id', $region->id)
                    ->exists();

                if (!$exists) {
                    $this->command->info("Створення міста: $cityTitle");
                    City::create([
                        'type' => $type,
                        'title' => $cityTitle,
                        'region_id' => $region->id,
                    ]);
                } else {
                    $this->command->info("Місто вже існує: $cityTitle");
                }

                $startRow++;
            }

            DB::commit();
            $this->command->info('Міста та області успішно імпортовано з Excel!');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Помилка при імпорті: ' . $e->getMessage());
        }
    }


}
