<?php

namespace SWP\FrontendBundle\Service;

class MeetupService
{
    protected $client ;

    public function __construct($meetupClientFactory)
    {
        $this->client = $meetupClientFactory->getKeyAuthClient();
    }

    public function getNewEvents()
    {
        $events = $this->client->getEvents(
            array(
                'group_urlname' => 'SweetlakePHP',
                'status'        => 'upcoming',
                'desc'          => 'desc'
            )
        )->toArray();

        // inject datetime to the events
        foreach ($events as $key => $event) {
            $datetime = new \DateTime();
            $datetime->setTimestamp(substr($event['time'], 0, 10));

            $events[$key]['datetime'] = $datetime;
        }

        return $events;
    }
}