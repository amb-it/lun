<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AdController extends Controller
{
    /**
     * Show list of ads with filters and pagination
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function getAds(Request $request) :\Illuminate\View\View
    {
        $filters = $this->getFilters($request);

        $request->curency ? $currency = 'uah' : $currency = 'usd';

        $ads = \App\Ad::getAds($filters, $currency);

        $ads->pages = \App\Custom\Paginator::getPages($ads->currentPage(), $ads->lastPage());
        $ads->pages_links['pages'] = \App\Custom\UrlHandler::getPagesLinks($ads->pages);
        $ads->pages_links['previous'] = \App\Custom\UrlHandler::getPreviousPageLink($ads->currentPage());
        $ads->pages_links['next'] = \App\Custom\UrlHandler::getNextPageLink($ads->currentPage());

        // if we have street_id we show street and a house in the view address field (required by task)
        if (isset($filters['street_id'])) {
            $filters['address'] = \App\Street::find($filters['street_id'])->title;

            if (isset($filters['house'])) {
                $filters['address'] .= ' ' . $filters['house'];
            }
        }

        return view('ads', compact('ads', 'filters'));
    }

    /**
     * Get as a json autocomplete streets or pairs street + house
     *
     * @param Request $request
     * @return array
     */
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

    /**
     * Make addresses array appropriate for jQuery autocomplete plugin
     *
     * @param Collection $addresses
     * @return array
     */
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

    /**
     * Gets post request with filters and redirect to ads list
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Gets all request fields and leave only allowed filters
     *
     * @param Request $request
     * @return array
     */
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
}
