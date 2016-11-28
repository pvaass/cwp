<?php

Route::post('/api/v1/content', ['uses' => 'Pvaass\ContentApi\Controllers\Content@get']);

Route::get('/api/v1/posts', ['uses' => 'Pvaass\ContentApi\Controllers\Blog@getList']);
Route::get('/api/v1/posts/{id}', ['uses' => 'Pvaass\ContentApi\Controllers\Blog@get']);