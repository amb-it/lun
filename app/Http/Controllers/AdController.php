<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Support\Collection;

class AdController extends Controller
{
    public function __construct()
    {
//        \DB::listen(function ($query) {
//            dump([
//                $query->sql,
//                $query->bindings,
//                $query->time
//            ]);
//        });
    }

    public function getAds(Request $request) :\Illuminate\View\View
    {
        $ads = \App\Ad::getAds($request);

        return view('ads', compact('ads'));
    }

    public function getAutocompleteAddresses(Request $request) :array
    {
        $address = $request->term;

        if (empty($address)) {
            return [];
        }

        $addresses = \App\AddressesAd::getAutocompleteAddresses($address);

        $addresses = $this->normalizeAddresses($addresses);

        return $addresses;
    }

    protected function normalizeAddresses(Collection $addresses) :array
    {
        $array = [];

        foreach ($addresses as $address) {
            $array[] = [
                'value' => $address->title . ' ' . $address->house,
                'label' => $address->title . ' ' . $address->house . '    (' . $address->ads_number . ' ads)',
                'street_id' => $address->street_id,
                'house' => $address->house
            ];
        }

        return $array;
    }

    public function filterAds(Request $request) :\Illuminate\Http\RedirectResponse
    {
        $filters = $this->getFilters($request);

        if (empty($filters)) {
            $url = '';
        } else {
            if (array_key_exists('street_id', $filters)) {
                unset($filters['address']);
            }

            $url = '/?';

            foreach ($filters as $key => $value) {
                if ($key == 'rooms') {
                    $value = implode(",", $value);
                }

                $url .= $key . '=' . $value . '&';
            }

            $url = rtrim($url, "&");
        }

        return redirect($url);
    }

    protected function getFilters(Request $request) :array
    {
        $allowed_filters = ['address', 'street_id', 'house', 'price_from', 'price_to', 'currency', 'area_from', 'area_to', 'rooms'];

        $filters = [];

        foreach ($allowed_filters as $allowed_filter) {
            if (!empty($request->all()[$allowed_filter])) {
                $filters[$allowed_filter] = $request->all()[$allowed_filter];
            }
        }

        return $filters;
    }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function show(Ad $ad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function edit(Ad $ad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ad $ad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ad $ad)
    {
        //
    }
}
