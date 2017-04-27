<?php

Route::post('/api/v1/content', ['uses' => 'Pvaass\ContentApi\Controllers\Content@get']);

Route::get('/api/v1/posts', ['uses' => 'Pvaass\ContentApi\Controllers\Blog@getList']);
Route::get('/api/v1/posts/{id}', ['uses' => 'Pvaass\ContentApi\Controllers\Blog@get']);


Route::get('/ipsen/api/v1/klacht/post', ['uses' => 'Pvaass\ContentApi\Controllers\Ipsen@post']);
Route::get('/ipsen/api/v1/klacht/get', ['uses' => 'Pvaass\ContentApi\Controllers\Ipsen@get']);