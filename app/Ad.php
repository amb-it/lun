<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use DB;

class Ad extends Model
{
    public static function getAds(Request $request) :\Illuminate\Pagination\LengthAwarePaginator
    {
        $sql = DB::table('ads')
            ->select(
                'ads.*',
                'currencies.title as currency',
                'streets.title as street'
            );

        $sql->leftJoin('currencies', 'ads.currency_id', '=', 'currencies.id');
        $sql->leftJoin('streets', 'ads.street_id', '=', 'streets.id');

        self::addPriceFilter($sql, $request);
        self::addAreaFilter($sql, $request);
        self::addRoomsFilter($sql, $request);
        self::addAddressFilter($sql, $request);

        $ads = $sql->paginate(5);

        return $ads;
    }

    protected static function addPriceFilter(Builder $sql, Request $request)
    {
        if ($request->currency && ($request->currency == 'usd')) {
            $currency = 'usd';
        } else {
            $currency = 'uah';
        }

        if ($request->price_from) {
            $sql->where('price_'.$currency, '>', $request->price_from);
        }

        if ($request->price_to) {
            $sql->where('price_'.$currency, '<', $request->price_to);
        }
    }

    protected static function addAreaFilter(Builder $sql, Request $request)
    {
        if ($request->area_from) {
            $sql->where('area', '>', $request->area_from);
        }

        if ($request->area_to) {
            $sql->where('area', '<', $request->area_to);
        }
    }

    protected static function addRoomsFilter(Builder $sql, Request $request)
    {
        if ($request->rooms) {
            $rooms_array = explode(",", $request->rooms);

            if (count($rooms_array) <= 1) {
                $sql->where('rooms_number', '=', $rooms_array[0]);
            } else {
                $sql->where(function ($query) use ($rooms_array) {
                    for ($i = 0; $i < count($rooms_array); $i++) {
                        $query->orWhere('rooms_number', '=', $rooms_array[$i]);
                    }
                });
            }
        }
    }

    protected static function addAddressFilter(Builder $sql, Request $request)
    {
        if ($request->street_id) {
            $sql->where('street_id', '=', $request->street_id);

            if ($request->house) {
                $sql->where('house', '=', $request->house);
            }
        } elseif ($request->address) {
            $sql->where('text', 'like', '%'.$request->address.'%');
        }
    }
}
