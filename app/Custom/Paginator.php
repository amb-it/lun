<?php

namespace App\Custom;

class Paginator
{
    public static function getPages(int $current_page, int $pages_number) :array
    {
        $pages = [
            $current_page-2, $current_page-1, $current_page, $current_page+1, $current_page+2
        ];

        if ($current_page == 1) {
            $pages = array_map(function ($el) { return $el + 2 ;}, $pages);
        }
        if ($current_page == 2) {
            $pages = array_map(function ($el) { return $el + 1 ;}, $pages);
        }

        if ($pages_number > 5) {
            if ($current_page == $pages_number) {
                $pages = array_map(function ($el) { return $el - 2 ;}, $pages);
            }
            if ($current_page == $pages_number - 1) {
                $pages = array_map(function ($el) { return $el - 1 ;}, $pages);
            }
        }

        if ($pages_number < 5) {
            foreach ($pages as $key => $item) {
                if ($key >= $pages_number) {
                    unset($pages[$key]);
                }
            }
        }

        return $pages;
    }
}