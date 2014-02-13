<?php

namespace SWP\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/admin")
 */
class EventController extends Controller
{
    /**
     * @Route("/events", name="event.list")
     * @Template()
     */
    public function indexAction()
    {
        $meetupService = $this->get('swp_frontend.meetupService');
        $meetups       = $meetupService->findAll();

        return array(
            'meetups' => $meetups
        );
    }
}
