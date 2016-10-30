<?php namespace pvaass\Faq;

use Backend;
use System\Classes\PluginBase;

/**
 * Editable Plugin Information File
 */
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
            'name' => 'F.A.Q.',
            'description' => 'Frequently Asked Questions',
            'author' => 'pvaass',
            'icon' => 'icon-leaf'
        ];
    }

    public function registerNavigation()
    {
        return [
            'faq' => [
                'label' => 'F.A.Q.',
                'url' => Backend::url('pvaass/faq/questions'),
                'icon' => 'icon-question',
                'permissions' => ['pvaass.faq.*'],
                'order' => 30,
                'sideMenu' => [
                    'all_questions' => [
                        'label'       => 'Overzicht',
                        'icon'        => 'icon-list',
                        'url'         => Backend::url('pvaass/faq/questions'),
                        'permissions' => ['pvaass.faq.*'],
                    ],
                    'new_question' => [
                        'label'       => 'Nieuwe vraag',
                        'icon'        => 'icon-plus',
                        'url'         => Backend::url('pvaass/faq/questions/create'),
                        'permissions' => ['pvaass.faq.create'],
                    ]
                ]
            ]
        ];
    }

    public function registerComponents()
    {
        return [
            'pvaass\Faq\Components\Faq' => 'faq'
        ];
    }
}