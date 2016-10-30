<?php namespace pvaass\Calendar\Components;


use BackendAuth;
use Cache;
use Cms\Classes\ComponentBase;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use GuzzleHttp\Client;
use pvaass\Calendar\Models\CalendarSettings;

class Calendar extends ComponentBase
{

    /**
     * Returns information about this component, including name and description.
     */
    public function componentDetails()
    {
        return [
            'name' => 'Calendar',
            'description' => 'Does a thing'
        ];
    }

    protected function getClient()
    {
        $client = new Google_Client();
        $client->setApplicationName(CalendarSettings::get('application_name'));
        $client->setScopes(implode(' ', array(
                Google_Service_Calendar::CALENDAR_READONLY)
        ));
        $client->setAuthConfig(json_decode(CalendarSettings::get('config'), true));
        $client->setAccessType('offline');

//        die(CalendarSettings::get('token'));
        $token = json_decode(CalendarSettings::get('token'), true);
        $client->setAccessToken($token);

        // Refresh the token if it's expired.
        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            CalendarSettings::set('token', json_encode(array_merge(
                $client->getAccessToken(), ['refresh_token' => $token['refresh_token']]
            )));
        }
        return $client;
    }

    public function onRender()
    {
        try {
            $events = Cache::rememberForever('events', function () {
                // Get the API client and construct the service object.
                $client = $this->getClient();
                $service = new Google_Service_Calendar($client);

                // Print the next 10 events on the user's calendar.
                $calendarId = 'primary';
                $optParams = array(
                    'maxResults' => 10,
                    'orderBy' => 'startTime',
                    'singleEvents' => TRUE,
                    'timeMin' => date('c'),
                    'fields' => 'items(end%2Clocation%2Cstart%2Csummary)'
                );

                $rawEvents = $service->events->listEvents($calendarId, $optParams)['items'];
                $formattedEvents = [];
                /** @var Google_Service_Calendar_Event $rawEvent */
                foreach($rawEvents as $rawEvent) {
                    $formattedEvents[] = [
                        'name' => $rawEvent->getSummary(),
                        'location' => $rawEvent->getLocation(),
                        'start' => $rawEvent->getStart()->getDateTime(),
                        'end' => $rawEvent->getEnd()->getDateTime()
                    ];
                }
                return $formattedEvents;
            });

            $this->page['events'] =  $events;
        } catch (\Exception $e) {
            Cache::forget('events');
            return false;
        }
    }

    public function onRefresh(){
        Cache::forget('events');
        return \Redirect::refresh();
    }

    public function isEditor()
    {
        $backendUser = BackendAuth::getUser();
        return $backendUser && $backendUser->hasAccess('pvaass.calendar.refresh');
    }
}