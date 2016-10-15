<?php

namespace pvaass\ExtraTwig;

use System\Classes\PluginBase;
use Twig_Extensions_Extension_Intl;

class Plugin extends PluginBase{

    /**
     * Returns information about this plugin, including plugin name and developer name.
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Extra Twig',
            'description' => 'Extra twig filters',
            'author'      => 'pvaass',
            'icon'        => 'icon-leaf'
        ];
    }
    public function registerMarkupTags()
    {
        $filters = [];
        $twig = $this->app->make('twig.environment');

        // add Time extensions
        $filters = $this->getIntl($twig);
        return [
            'filters'   => $filters
        ];
    }

    private function getIntl($twig)
    {
        $intlExtension = new Twig_Extensions_Extension_Intl();
        $intlFilters = $intlExtension->getFilters();
        return [
            'localizeddate' => function($date, $dateFormat = 'medium', $timeFormat = 'medium', $locale = null, $timezone = null, $format = null) use ($twig, $intlFilters) {
                $callable = $intlFilters[0]->getCallable();
                return $callable($twig, $date, $dateFormat, $timeFormat, $locale, $timezone, $format);
            }
        ];
    }
}
