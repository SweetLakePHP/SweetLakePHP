<?php

namespace SWP\FrontendBundle\Service;

class MeetupService
{
    protected $client ;

    public function __construct($meetupClientFactory)
    {
        $this->client = $meetupClientFactory->getKeyAuthClient();
    }

    /**
     * Get one or more events
     *
     * @return array
     */
    public function getUpcomingEvents()
    {
        $events = $this->client->getEvents(
            array(
                'group_urlname' => 'SweetlakePHP',
                'status'        => 'upcoming',
                'desc'          => 'desc'
            )
        )->toArray();

        $this->eventsFiller($events);

        return $events;
    }

    /**
     * Get one or more events
     *
     * @return array
     */
    public function getPastEvents()
    {
        $events = $this->client->getEvents(
            array(
                'group_urlname' => 'SweetlakePHP',
                'status'        => 'past',
                'desc'          => 'desc'
            )
        )->toArray();

        $this->eventsFiller($events);

        return $events;
    }

    /**
     * Returns one event
     *
     * @param integer $id identifier of event
     * @return array
     */
    public function find($id)
    {
        $event = $this->client->getEvent(
            array(
                'id' => $id,
            )
        )->toArray();

        $this->eventFiller($event);

        return $event;
    }

    /**
     * Adds extra fields on an array of events
     *
     * @param array $events Array of events
     * @return MeetupService
     */
    protected function eventsFiller(array &$events)
    {
        // inject datetime to the events
        foreach ($events as $key => &$event) {
            $this->eventFiller($event);
        }

        return $this;
    }

    /**
     * Adds extra fields on an event
     *
     * @param array $event Single event
     * @return MeetupService
     */
    protected function eventFiller(array &$event)
    {
        $datetime = new \DateTime();
        $datetime->setTimestamp(substr($event['time'], 0, 10));

        $event['datetime'] = $datetime;
        $event['type']     = 'meetup';

        return $this;
    }
}