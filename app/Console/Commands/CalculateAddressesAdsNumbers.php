<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class CalculateAddressesAdsNumbers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ads:calculate-addresses-ads-numbers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate numbers of ads for every street and every pair (street + house) and store it in a db';

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
        DB::table('addresses_ads')->truncate();

        $streets = DB::table('ads')
            ->select(
                'street_id',
                'title',
                DB::raw('count(ads.id) as ads_number')
            )
            ->leftJoin('streets', 'ads.street_id', '=', 'streets.id')
            ->groupBy('street_id')
            ->get()
            ->toArray();

        $addresses = DB::table('ads')
            ->select(
                'street_id',
                'title',
                'house',
                \DB::raw('count(ads.id) as ads_number')
            )
            ->leftJoin('streets', 'ads.street_id', '=', 'streets.id')
            ->groupBy('street_id', 'house')
            ->get()
            ->toArray();

        $streets = json_decode(json_encode((array) $streets), true);
        $addresses = json_decode(json_encode((array) $addresses), true);

        DB::table('addresses_ads')->insert($streets);
        DB::table('addresses_ads')->insert($addresses);

        $this->info('success');
    }
}
