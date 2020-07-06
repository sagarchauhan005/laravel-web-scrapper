<?php

namespace App\Console\Commands;

use App\CompanyCategories;
use App\CompanyCategoriesList;
use App\SingleCompanyData;
use Illuminate\Console\Command;

class ResetDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:tables';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resets all the tables';

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
     * @return int
     */
    public function handle()
    {
        CompanyCategories::truncate();
        CompanyCategoriesList::truncate();
        SingleCompanyData::truncate();
    }
}
