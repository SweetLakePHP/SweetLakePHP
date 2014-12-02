<?php

namespace SWP\FrontendBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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
        $calendarService = $this->get('swp_frontend.calendarService');

        return new Response(
            $calendarService->getMeetups(),
            200,
            array(
                'Content-Type'        => 'text/calendar; charset=utf-8',
                'Content-Disposition' => 'attachment; filename="calendar.ics"',
            )
        );
    }

    /**
     * @Route("/reminders.ics", name="feed")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function reminderAction()
    {
        $calendarService = $this->get('swp_frontend.calendarService');

        return new Response(
            $calendarService->getOrganiserCalendar(),
            200,
            array(
                'Content-Type'        => 'text/calendar; charset=utf-8',
                'Content-Disposition' => 'attachment; filename="reminders.ics"',
            )
        );
    }
}
