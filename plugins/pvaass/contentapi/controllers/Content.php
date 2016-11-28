<?php
namespace Pvaass\ContentApi\Controllers;

use Illuminate\Http\JsonResponse;

class Content
{

    public function get()
    {
        $fileName = \Request::get('name') . '.htm';

        $data = \Cms\Classes\Content::query()->find($fileName)->toArray();


        return new JsonResponse([
            'data' => $data['content']
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