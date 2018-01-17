<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 *
 *  Table addresses_ads have entities with precalculated number of ads per every address
 *
 */
class AddressesAd extends Model
{
    /**
     * Search addresses and order it by number of ads per address
     *
     * @param string $address
     * @return \Illuminate\Support\Collection
     */
    public static function getAutocompleteAddresses(string $address) :\Illuminate\Support\Collection
    {
        $address = trim($address);

        $street = self::getStreetFromRequest($address);
        $house = self::getHouseFromRequest($address);

        $sql = \DB::table('addresses_ads')
            ->where('title', 'like', '%'.$street.'%');

        if (!empty($house)) {
            $sql->where('house', $house);
        }

        $addresses = $sql->orderBy('ads_number', 'desc')
            ->limit(10)
            ->get();

        return $addresses;
    }

    /**
     * Parse address and returns street title
     *
     * @param string $address
     * @return string
     */
    protected static function getStreetFromRequest(string $address) :string
    {
        $array = explode(' ', $address);

        if (count($array) > 1 && is_numeric(end($array))) {
            unset($array[key($array)]);
        }

        return implode(" ", $array);
    }

    /**
     * Parse address and returns house
     *
     * @param string $address
     * @return string
     */
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
