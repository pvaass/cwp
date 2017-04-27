<?php

namespace Pvaass\ContentApi\Controllers;

use Illuminate\Http\JsonResponse;

class Ipsen
{

    public function post()
    {
        $neus = \Request::get('neus');
        $long = \Request::get('long');
        $oog = \Request::get('oog');

        $count = \Cache::get('ipsen.count', 0);
        $id = $count + 1;

        $allItems = \Cache::get('ipsen.items', []);
        $allItems[] = [
            'id' => $id,
            'neus' => $neus,
            'long' => $long,
            'oog' => $oog
        ];

        \Cache::forever('ipsen.items', $allItems);
        \Cache::forever('ipsen.count', $count + 1);

        return new JsonResponse([
            'id' => $id
        ]);
    }

    public function get()
    {
        return new JsonResponse([
           'data' => \Cache::get('ipsen.items', [])
        ]);
    }

    public function getAfterFilters()
    {
        return [];
    }

    public function getBeforeFilters()
    {
        return [];
    }

    public function getMiddleware()
    {
        return [];
    }

    public function callAction($action)
    {
        return $this->{$action}();
    }
}