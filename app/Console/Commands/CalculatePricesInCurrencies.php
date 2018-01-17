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
    protected $signature = 'ads:calculate-prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculates prices from ads table in currencies';

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
     * Calculate prices in uah and usd and store it in a ads table
     *
     * @return mixed
     */
    public function handle()
    {
        $currencies_rates = DB::table('currencies_rates')->get();

        $usd_to_uah_coefficient = $currencies_rates[1]->rate;
        $uah_to_usd_coefficient = $currencies_rates[2]->rate;

        DB::table('ads')
            ->where('currency_id', 1)
            ->update([
                'price_uah' => DB::raw("`price`*".$usd_to_uah_coefficient),
                'price_usd' => DB::raw("`price`")
            ]);


        DB::table('ads')
            ->where('currency_id', 2)
            ->update([
                'price_uah' => DB::raw("`price`"),
                'price_usd' => DB::raw("`price`*".$uah_to_usd_coefficient)
            ]);

        $this->info('success');
    }
}
