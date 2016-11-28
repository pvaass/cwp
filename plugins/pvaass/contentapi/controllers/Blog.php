<?php
namespace Pvaass\ContentApi\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Router;
use RainLab\Blog\Models\Post;

class Blog
{

    public function get($params)
    {
        $post = Post::find($params['id']);

        return new JsonResponse([
            'data' => $post
        ]);
    }

    public function getList()
    {
        $posts = Post::query()
            ->select('id', 'title', 'excerpt')
            ->where('published', 1)
            ->orderBy('published_at')
            ->get();


        return new JsonResponse([
            'data' => array_map(function($item) {
                return array_intersect_key($item->toArray(), array_flip(['id', 'title', 'summary']));
            }, $posts->all())
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

    public function callAction($action, $params)
    {
        return $this->{$action}($params);
    }
}