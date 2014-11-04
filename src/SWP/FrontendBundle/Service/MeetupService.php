<?php

namespace SWP\FrontendBundle\Service;

class MeetupService
{
    protected $client;
    protected $groupUrlName;

    public function __construct($meetupClientFactory, $groupUrlName)
    {
        $this->client       = $meetupClientFactory->getKeyAuthClient();
        $this->groupUrlName = $groupUrlName;
    }

    /**
     * Get all the events
     */
    public function findAll($sortOrder = 'desc')
    {
        $aAllowedSortOrderValues = array(
            'asc',
            'desc'
        );

        if(!in_array($sortOrder, $aAllowedSortOrderValues)){
           $sortOrder = 'desc';
        }

        $events = $this->client->getEvents(
            array(
                'group_urlname' => $this->groupUrlName,
                'status'        => 'upcoming,past',
                $sortOrder      => $sortOrder
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
    public function getUpcomingEvents($sortOrder = 'desc')
    {

        $aAllowedSortOrderValues = array(
            'asc',
            'desc'
        );

        if(!in_array($sortOrder, $aAllowedSortOrderValues)){
           $sortOrder = 'desc';
        }

        $events = $this->client->getEvents(
            array(
                'group_urlname' => $this->groupUrlName,
                'status'        => 'upcoming',
                $sortOrder      => $sortOrder
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
                'group_urlname' => $this->groupUrlName,
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

    public function sendMessage($subject, $message, array $members)
    {
//        $this->client->PostMessage(array(
//                'dryrun' => true,
//                'group_id' =>
//            ))->toArray();
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
        // add target _blank to all the links
        $event['description'] = preg_replace("/<a(.*?)>/", "<a$1 target=\"_blank\">", $event['description']);

        $datetime = new \DateTime();
        $datetime->setTimestamp(substr($event['time'], 0, 10));

        $event['datetime'] = $datetime;
        $event['type']     = 'meetup';

        return $this;
    }
}
