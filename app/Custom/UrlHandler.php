<?php

namespace App\Custom;

class UrlHandler
{
    public static function getPagesLinks(array $pages) :array
    {
        $url = static::getUrlWithout('page');

        $links = [];

        foreach ($pages as $page) {
            $links[] = $url . 'page=' . $page;
        }

        return $links;
    }

    public static function getPreviousPageLink(int $current_page) :string
    {
        $url = static::getUrlWithout('page');

        $link = $url . 'page=' . ($current_page - 1);

        return $link;
    }

    public static function getNextPageLink(int $current_page) :string
    {
        $url = static::getUrlWithout('page');

        $link = $url . 'page=' . ($current_page + 1);

        return $link;
    }

    protected static function getUrlWithout(string $parameter_to_delete) :string
    {
        $url_parts = explode("?", url()->full());

        if (count($url_parts) == 1) {
            $url = url()->full() . '/?';
        } else {
            $base = $url_parts[0];
            $parameters_string = $url_parts[1];

            $parameters = explode("&", $parameters_string);

            foreach ($parameters as $key => $parameter) {
                if (strpos($parameter, $parameter_to_delete) !== false) {
                    unset($parameters[$key]);
                }
            }

            if (empty($parameters)) {
                $url = $base . '?' . implode("&", $parameters);
            } else {
                $url = $base . '?' . implode("&", $parameters) . '&';
            }
        }

        return $url;
    }
}