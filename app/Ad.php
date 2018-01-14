<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Ad extends Model
{
    public static function getAds($request)
    {
        $ads = DB::table('advertisements');

        $ads = $ads->leftJoin('currencies', 'advertisements.currency_id', '=', 'currencies.currency_id');

        if (isset($request->currency)) {
            $ads = $ads->where('price', '>', $request->price_from);
        }

        if (isset($request->price_from)) {
           $ads = $ads->where('price', '>', $request->price_from);
        }

        if (isset($request->price_to)) {
            $ads = $ads->where('price', '<', $request->price_to);
        }

        if (isset($request->area_from)) {
            $ads = $ads->where('area_total', '>', $request->area_from);
        }

        if (isset($request->area_to)) {
            $ads = $ads->where('area_total', '<', $request->area_to);
        }

        if (isset($request->rooms)) {
            $rooms_array = explode(",", $request->rooms);

            for ($i = 0; $i < count($rooms_array); $i++) {
                if ($i == 0) {
                    $ads = $ads->where('room_count', '=', $rooms_array[$i]);
                } else {
                    $ads = $ads->orWhere('room_count', '=', $rooms_array[$i]);
                }
            }
        }

        $ads = $ads->paginate(15);

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
