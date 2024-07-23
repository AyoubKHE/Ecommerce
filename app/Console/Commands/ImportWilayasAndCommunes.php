<?php

namespace App\Console\Commands;

use App\Models\Wilaya;

use League\Csv\Reader;
use App\Models\Commune;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportWilayasAndCommunes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-wilayas-and-communes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import wilayas and communes from CSV';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if(Wilaya::count() > 0) {
            $this->alert('Les wilayas et les communes sont déja ajoutés à la base de données');
        }
        else {
            $wilayas_csv_path = storage_path('CSV/wilayas.csv');
            $communes_csv_path = storage_path('CSV/communes.csv');

            $wilayas_csv = Reader::createFromPath($wilayas_csv_path, 'r');
            $wilayas_csv->setHeaderOffset(null);

            $communes_csv = Reader::createFromPath($communes_csv_path, 'r');
            $communes_csv->setHeaderOffset(null);

            DB::transaction(function () use ($wilayas_csv, $communes_csv) {

                foreach ($wilayas_csv->getRecords() as $wilaya) {

                    $wilaya_code = $wilaya[1];
                    $wilaya_name = $wilaya[2];

                    $wilaya = Wilaya::create(
                        [
                            'code' => $wilaya_code,
                            'name' => $wilaya_name
                        ],
                    );
                }

                foreach ($communes_csv->getRecords() as $wilaya) {

                    $commune_postal_code = $wilaya[1];
                    $commune_name = $wilaya[2];
                    $commune_wilaya_id = $wilaya[3];

                    $wilaya = Commune::create(
                        [
                            'postal_code' => $commune_postal_code,
                            'name' => $commune_name,
                            "wilaya_id" => $commune_wilaya_id
                        ],
                    );
                }
            });
        }



    }
}
