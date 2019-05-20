<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CleanBoxImport;
use App\CleanBox;

class ImportCleanBox extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:cleanBox {--file_path= : csv or excel file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import file to CleanBox table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Start import...');

        $file_path = $this->option('file_path');


        $excel = Excel::toCollection(new CleanBoxImport(), $file_path);

        $filter_arr = [];

        if (!empty($excel)) {

            for ($i = 1; $i < count($excel[0]); $i++) {

                array_push($filter_arr, [
                    'region' => $excel[0][$i][0],
                    'road' => $excel[0][$i][1],
                    'location' => $excel[0][$i][2],
                    'latitude' => $excel[0][$i][3],
                    'longitude' => $excel[0][$i][4],
                    'remarks' => $excel[0][$i][5]
                ]);

            }

        } else {

            $this->error('Excel is no data.');

        }

        $data = collect($filter_arr);

        $bar = $this->output->createProgressBar(count($data));

        foreach ($data as $item) {

            if ($item['latitude'] != null && $item['longitude'] != null && $item['road'] != null && $item['location'] != null) {
                CleanBox::firstOrCreate([
                    'latitude' => $item['latitude'],
                    'longitude' => $item['longitude']
                ], [
                    'region' => $item['region'],
                    'road' => $item['road'],
                    'location' => $item['location'],
                    'remarks' => $item['remarks'],
                ]);
            }


            $bar->advance();
        }

        $bar->finish();

        $this->info(' Import is success.');

    }
}
