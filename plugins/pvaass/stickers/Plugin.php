<?php namespace pvaass\Stickers;

use Backend;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name' => 'Stickers!',
            'description' => 'Want wie houdt er niet van stickers',
            'author' => 'pvaass',
            'icon' => 'icon-space-shuttle'
        ];
    }

    public function registerPermissions()
    {
        return [
            'pvaass.stickers.create' => [
                'label' => 'Stickers maken',
                'tab' => 'Stickers'
            ],
            'pvaass.stickers.update' => [
                'label' => 'Stickers aanpassen',
                'tab' => 'Stickers'
            ],
            'pvaass.stickers.delete' => [
                'label' => 'Stickers verwijderen',
                'tab' => 'Stickers'
            ]
        ];
    }

    public function registerNavigation()
    {
        return [
            'stickers' => [
                'label' => 'Stickers',
                'url' => Backend::url('pvaass/stickers/stickers'),
                'icon' => 'icon-space-shuttle',
                'permissions' => ['pvaass.stickers.*'],
                'order' => 30,
                'sideMenu' => [
                    'all_stickers' => [
                        'label'       => 'Sticker overzicht',
                        'icon'        => 'icon-list',
                        'url'         => Backend::url('pvaass/stickers/stickers'),
                        'permissions' => ['pvaass.stickers.*'],
                    ],
                    'new_sticker' => [
                        'label'       => 'Nieuwe sticker',
                        'icon'        => 'icon-plus',
                        'url'         => Backend::url('pvaass/stickers/stickers/create'),
                        'permissions' => ['pvaass.stickers.create'],
                    ]
                ]
            ]
        ];
    }

    public function registerComponents()
    {
        return [
            'pvaass\Stickers\Components\Sticker' => 'sticker'
        ];
    }
}