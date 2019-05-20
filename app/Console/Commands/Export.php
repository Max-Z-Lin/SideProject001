<?php

namespace App\Console\Commands;

use App\Export\ImageExport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class Export extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:image';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export excel file to a directory';

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
        $this->info('Start export...');

        Excel::store(new ImageExport(), 'image.xlsx');

    }
}
