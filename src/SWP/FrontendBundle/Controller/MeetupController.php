<?php

namespace SWP\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class MeetupController extends Controller
{
    /**
     * @Route("/meetup", name="meetup.list")
     * @Template()
     */
    public function listAction()
    {
        $meetupService    = $this->get('swp_frontend.meetupService');
        $upcommingMeetups = $meetupService->getUpcomingEvents();
        $pastMeetups      = $meetupService->getPastEvents();

        return array(
            'upcomming' => $upcommingMeetups,
            'past'      => $pastMeetups
        );
    }

}