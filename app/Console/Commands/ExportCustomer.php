<?php

namespace App\Console\Commands;

use App\Models\Customer;
use Illuminate\Console\Command;
use Rap2hpoutre\FastExcel\FastExcel;

class ExportCustomer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:customer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        //Gio store o dau
        $fileName = 'customer'.time() . '.csv';
        $filePath = 'storage/app/public/'.$fileName;
        $file = (new FastExcel(Customer::all()))->export($filePath);
        $this->info("export file ". $fileName. " to ".$filePath. " successfully!");
    }
}
