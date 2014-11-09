<?php

namespace SWP\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class FeedController extends Controller
{
    /**
     * @Route("/meetups.ics", name="meetups-ics")
     * @Template()
     */
    public function indexAction()
    {
        $meetupService = $this->get('swp_frontend.meetupService');
        $events        = $meetupService->findAll();

        //echo '<pre>';print_r($events);exit;

        /** @var \BOMO\IcalBundle\Provider\IcsProvider $provider */
        $provider = $this->get('bomo_ical.ics_provider');

        $timezone = $provider->createTimezone();
        $timezone
            ->setTzid('Europe/Amsterdam')
            ->setProperty('X-LIC-LOCATION', $timezone->getTzid());

        $calendar = $provider->createCalendar($timezone);

        $calendar
            ->setName('SweetlakePHP Meetups')
            ->setDescription('A calendar service containing SweetlakePHP meetups');

        foreach($events as $event) {
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
            $venue = $event['venue'];
            $locationString = $venue['name'] . ', ' . $venue['address_1'] . ', ' . $venue['city'] . ', ' . $venue['country'];
            $calendarEvent->setLocation($locationString);
        }

        return new Response(
            $calendar->returnCalendar(),
            200,
            array(
                'Content-Type' => 'text/calendar; charset=utf-8',
                'Content-Disposition' => 'attachment; filename="calendar.ics"',
            )
        );
    }
}
