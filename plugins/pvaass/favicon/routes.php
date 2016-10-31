<?php

use Cms\Classes\Theme;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

$rootRoutes = [
    'png' => [
        'android-chrome-144x144.png',
        'apple-touch-icon.png',
        'apple-touch-icon-57x57.png',
        'apple-touch-icon-60x60.png',
        'apple-touch-icon-72x72.png',
        'apple-touch-icon-76x76.png',
        'apple-touch-icon-114x114.png',
        'apple-touch-icon-120x120.png',
        'apple-touch-icon-144x144.png',
        'apple-touch-icon-152x152.png',

        'favicon-16x16.png',
        'favicon-32x32.png',

        'mstile-144x144.png'
    ],
    'ico' => [
        'favicon.ico',
    ],
    'xml' => [
        'browserconfig.xml'
    ],
    'json' => [
        'manifest.json',
    ],
    'svg' => [
        'safari-pinned-tab.svg'
    ]
];

$mime = [
    'json' => 'application/json',
    'xml' => 'application/xml',
    'ico' => 'image/x-icon',
    'png' => 'image/png',
    'svg' => 'image/svg+xml'
];

foreach ($rootRoutes as $type => $files) {
    foreach ($files as $fileName) {
        Route::get($fileName, function () use ($fileName, $mime, $type) {
            $themeActive = Theme::getActiveTheme();
            return new BinaryFileResponse(
                $themeActive->getPath() . '/assets/favicon/' . $fileName,
                200,
                [
                    'Content-Type' => $mime[$type],
                    'Content-Disposition' => 'inline; filename="' . $fileName . '"'
                ]
            );
        });
    }
}

