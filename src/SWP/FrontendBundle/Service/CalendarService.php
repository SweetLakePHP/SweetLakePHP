<?php

/**
 * CalendarService.php
 *
 * @author Dennis de Greef <github@link0.net>
 */
namespace SWP\FrontendBundle\Service;

use BOMO\IcalBundle\Provider\IcsProvider;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CalendarService
 *
 * @package SWP\FrontendBundle\Service
 */
class CalendarService
{
    /**
     * @var ContainerInterface $container
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    private function createBaseCalendar(IcsProvider $provider)
    {
        $timezone = $provider->createTimezone();
        $timezone
            ->setTzid('Europe/Amsterdam')
            ->setProperty('X-LIC-LOCATION', $timezone->getTzid());

        return $provider->createCalendar($timezone);
    }

    /**
     * @return string $calendarForMeetups
     */
    public function getMeetups()
    {
        $meetupService = $this->getContainer()->get('swp_frontend.meetupService');
        $events        = $meetupService->findAll();

        /** @var IcsProvider $provider */
        $provider = $this->getContainer()->get('bomo_ical.ics_provider');
        $calendar = $this->createBaseCalendar($provider);

        $calendar
            ->setName('SweetlakePHP Meetups')
            ->setDescription('A calendar service containing SweetlakePHP meetups');

        foreach ($events as $event) {
            $dateTime = $event['datetime'];

            $description = $event['yes_rsvp_count'] . " Sweetlakers are attending the talk: " . $event['name'];

            $calendarEvent = $calendar->newEvent();
            $calendarEvent->setStartDate($dateTime);
            $calendarEvent->setEndDate($dateTime->modify('+4 hours'));
            $calendarEvent->setName('SweetlakePHP Meetup ' . $dateTime->format('F'));
            $calendarEvent->setDescription($description);
            $calendarEvent->setOrganizer('SweetlakePHP <info@sweetlakephp.nl>');
            $calendarEvent->getEvent()->setProperty('URL', $event['event_url']);

            // Perhaps we should like to a vCard here for locations and make those dynamic as well.
            // @see https://code.google.com/p/calagator/wiki/IcalLocation#iCal_LOCATION_property
            // LOCATION;ALTREP="http://xyzcorp.com/conf-rooms/f123.vcf":Conference Room - F123, Bldg. 002
            $venue          = $event['venue'];
            $locationString = $venue['name'] . ', ' . $venue['address_1'] . ', ' . $venue['city'] . ', ' . $venue['country'];
            $calendarEvent->setLocation($locationString);
        }

        return $calendar->returnCalendar();
    }

    public function getOrganiserCalendar()
    {
        $meetupService = $this->getContainer()->get('swp_frontend.meetupService');
        $events        = $meetupService->getUpcomingEvents('asc');

        /** @var IcsProvider $provider */
        $provider = $this->getContainer()->get('bomo_ical.ics_provider');
        $calendar = $this->createBaseCalendar($provider);

        $calendar
            ->setName('SweetlakePHP Organisers')
            ->setDescription('A calendar service containing SweetlakePHP organisational reminders');

        foreach ($events as $event) {
            $dateTime = $event['datetime'];

            // Calculate buns and cans
            // Usually there are 10 knaks per can, and everybody eats two buns (?)
            $people        = $event['yes_rsvp_count'];
            $bunsPerPerson = 2;
            $knaksPerCan   = 10;

            $buns = $people * $bunsPerPerson;
            $cans = 0;
            if ($buns !== 0) {
                $cans = ceil($buns / $knaksPerCan);
            }

            $reminder = "Hotdog reminder. Get {$buns} buns, {$cans} cans of knaks and some sauerkraut";

            $calendarEvent = $calendar->newEvent();
            $calendarEvent->setStartDate($dateTime);
            $calendarEvent->setEndDate($dateTime->modify('+4 hours'));
            $calendarEvent->setName('SweetlakePHP Hotdogs');
            $calendarEvent->setDescription($reminder);

            $firstAlarm = $provider->createAlarm();
            $firstAlarm->setAction('display');
            $firstAlarm->setDescription($reminder);
            $firstAlarm->setTrigger('-PT11H');

            $secondAlarm = $provider->createAlarm();
            $secondAlarm->setDescription($reminder);
            $secondAlarm->setTrigger('-PT4H');

            $calendarEvent->attachAlarm($firstAlarm);
            $calendarEvent->attachAlarm($secondAlarm);

            // Perhaps we should like to a vCard here for locations and make those dynamic as well.
            // @see https://code.google.com/p/calagator/wiki/IcalLocation#iCal_LOCATION_property
            // LOCATION;ALTREP="http://xyzcorp.com/conf-rooms/f123.vcf":Conference Room - F123, Bldg. 002
            $venue          = $event['venue'];
            $locationString = $venue['name'] . ', ' . $venue['address_1'] . ', ' . $venue['city'] . ', ' . $venue['country'];
            $calendarEvent->setLocation($locationString);
        }

        return $calendar->returnCalendar();
    }
}
