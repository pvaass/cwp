<?php namespace Carlosrgzm\CookieConsent\Components;

use Cms\Classes\ComponentBase;

class CookieConsent extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name' => 'carlosrgzm.cookieconsent::lang.strings.plugin_name',
            'description' => 'carlosrgzm.cookieconsent::lang.strings.plugin_desc'
        ];
    }

    public function defineProperties()
    {
        return [
            'message' => [
                'title' => 'Message',
                'type' => 'string',
                'default' => 'This website uses cookies to ensure you get the best experience on our website.',
                'placeholder' => 'This website uses cookies to ensure you get the best experience on our website.',
                'validationMessage' => 'The Message field is required.'
            ],
            'dismiss' => [
                'title' => 'Dismiss button',
                'type' => 'string',
                'default' => 'Got it!',
                'validationMessage' => 'The Dismiss button text is required.'
            ],
            'learnMore' => [
                'title' => 'Learn more text link',
                'type' => 'string',
                'default' => 'More info',
                'validationMessage' => 'The Learn More link text is required.'
            ],
            'link' => [
                'title' => 'Link for more details',
                'type' => 'string',
                'default' => 'http://www.yourwebpage.com/cookies',
                'validationMessage' => 'The Learn More link text is required.'
            ],
            'theme' => [
                'title' => 'Theme',
                'type' => 'dropdown',
                'default' => 'light-bottom',
                'placeholder' => 'Select units',
                'options' => [
                    'light-bottom' => 'light-bottom',
                    'dark-bottom' => 'dark-bottom',
                    'light-top' => 'light-top',
                    'dark-top' => 'dark-top'
                ]
            ],
        ];
    }

    public function onRender()
    {
        $this->page['message'] = $this->property('message');
        $this->page['dismiss'] = $this->property('dismiss');
        $this->page['learnMore'] = $this->property('learnMore');
        $this->page['link'] = $this->property('link');
        $this->page['theme'] = $this->property('theme');
    }

}