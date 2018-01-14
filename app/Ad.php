<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Ad extends Model
{
    public static function getAds()
    {
       $ads = DB::table('advertisements')
           ->paginate(15);

       $streets_ids = [];

       foreach ($ads as $ad) {
           $streets_ids[] = $ad->street_id;
       }

       $streets_ids = array_unique($streets_ids);

       $streets = DB::table('streets')->whereIn('street_id', $streets_ids)->get();

       $streets_array = [];

       foreach($streets as $street) {
           $streets_array[$street->street_id] = $street->nominative;
       }

       foreach ($ads as $ad) {
           $ad->street = $streets_array[$ad->street_id];
       }

       return $ads;
    }
}
