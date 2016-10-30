<?php namespace pvaass\Faq\Components;


use Cache;
use Cms\Classes\ComponentBase;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use GuzzleHttp\Client;
use pvaass\Calendar\Models\CalendarSettings;
use pvaass\Faq\Models\Question;

class Faq extends ComponentBase
{

    /**
     * Returns information about this component, including name and description.
     */
    public function componentDetails()
    {
        return [
            'name' => 'Faq',
            'description' => 'Does a thing'
        ];
    }

    public function onRun()
    {
        $this->addJs('assets/js/jquery.accordion.js');
    }

    public function onRender()
    {
        $categories = ['Algemeen', 'Na je zwemdiploma', 'Veiligheid'];

        $faq = [];
        foreach ($categories as $category) {
            $questions = Question::where('category', $category)
                ->orderBy('position')->get()->toArray();
            $faq[$category] = $questions;
        }
        $this->page['faq'] = $faq;
    }
}