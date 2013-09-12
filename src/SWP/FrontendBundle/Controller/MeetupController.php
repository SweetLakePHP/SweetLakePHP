<?php

namespace SWP\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use SWP\FrontendBundle\Form\Type\ContactType;

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