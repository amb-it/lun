<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

class CalculatePricesInCurrencies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prices:calculate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculates prices from advertisements table in currencies';

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
        $currencies_coefficients = DB::table('currencies_coefficients')->get();

        $usd_to_uah_coefficient = $currencies_coefficients[1]->coefficient;
        $uah_to_usd_coefficient = $currencies_coefficients[2]->coefficient;

        DB::table('advertisements')
            ->where('currency_id', 1)
            ->update([
                'price_uah' => DB::raw("`price`*".$usd_to_uah_coefficient),
                'price_usd' => DB::raw("`price`")
            ]);


        DB::table('advertisements')
            ->where('currency_id', 2)
            ->update([
                'price_uah' => DB::raw("`price`"),
                'price_usd' => DB::raw("`price`*".$uah_to_usd_coefficient)
            ]);

        $this->info('success');
    }
}
