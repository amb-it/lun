<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use DB;

class Ad extends Model
{
    public static function getAds(array $filters, $currency) :\Illuminate\Pagination\LengthAwarePaginator
    {
        $sql = DB::table('ads')
            ->select(
                'ads.*',
                'currencies.title as currency',
                'streets.title as street'
            );

        $sql->leftJoin('currencies', 'ads.currency_id', '=', 'currencies.id');
        $sql->leftJoin('streets', 'ads.street_id', '=', 'streets.id');

        self::addPriceFilter($sql, $filters, $currency);
        self::addAreaFilter($sql, $filters);
        self::addRoomsFilter($sql, $filters);
        self::addAddressFilter($sql, $filters);

        $ads = $sql->paginate(5);

        return $ads;
    }

    protected static function addPriceFilter(Builder $sql, array $filters, string $currency)
    {
        if (isset($filters['price_from'])) {
            $sql->where('price_'.$currency, '>', $filters['price_from']);
        }

        if (isset($filters['price_to'])) {
            $sql->where('price_'.$currency, '<', $filters['price_to']);
        }
    }

    protected static function addAreaFilter(Builder $sql, array $filters)
    {
        if (isset($filters['area_from'])) {
            $sql->where('area', '>', $filters['area_from']);
        }

        if (isset($filters['area_to'])) {
            $sql->where('area', '<', $filters['area_to']);
        }
    }

    protected static function addRoomsFilter(Builder $sql, array $filters)
    {
        if (isset($filters['rooms'])) {
            $rooms_array = explode(",", $filters['rooms']);

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

    protected static function addAddressFilter(Builder $sql, array $filters)
    {
        if (isset($filters['street_id'])) {
            $sql->where('street_id', '=', $filters['street_id']);

            if (isset($filters['house'])) {
                $sql->where('house', '=', $filters['house']);
            }
        } elseif (isset($filters['address'])) {
            $sql->where('description', 'like', '%'.$filters['address'].'%');
        }
    }
}
