<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddressesAd extends Model
{
    public static function getSuggestions(string $address) :\Illuminate\Support\Collection
    {
        $address = trim($address);

        $street = self::getStreetFromRequest($address);
        $house = self::getHouseFromRequest($address);

        $sql = \DB::table('addresses_ads')
            ->where('title', 'like', '%'.$street.'%');

        if (!empty($house)) {
            $sql->where('house', $house);
        }

        $suggestions = $sql->orderBy('ads_number', 'desc')
            ->limit(10)
            ->get();

        return $suggestions;
    }

    protected static function getStreetFromRequest(string $address) :string
    {
        $array = explode(' ', $address);

        if (count($array) > 1 && is_numeric(end($array))) {
            unset($array[key($array)]);
        }

        return implode($array);
    }

    protected static function getHouseFromRequest(string $address) : string
    {
        $array = explode(' ', $address);

        $house = '';

        if (count($array) > 1 && is_numeric(end($array))) {
            $house = end($array);
        }

        return $house;
    }
}
