<?php

namespace SWP\FrontendBundle\Controller;

use SWP\BackendBundle\Service\WriteupService;
use SWP\FrontendBundle\Service\MeetupService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class EventController extends Controller
{
    /**
     * @Route("/event/{id}", name="event.show")
     * @Template()
     */
    public function meetupAction($id)
    {
        /* @var $meetupService MeetupService */
        $meetupService = $this->get('swp_frontend.meetupService');
        $meetupService->getUpcomingEvents();

        $event = $meetupService->find($id);
        if (!$event) {
            throw new \LogicException("Meetup not found", 404);
        }

        return array(
            'event' => $event
        );
    }

    /**
     * @Route("/event/{id}/writeup", name="event.show-writeup")
     * @Template()
     */
    public function writeupAction($id)
    {
        /* @var $meetupService MeetupService */
        $meetupService = $this->get('swp_frontend.meetupService');
        $meetupService->getUpcomingEvents();

        $event = $meetupService->find($id);
        if (!$event) {
            throw new \LogicException("Meetup not found", 404);
        }

        /* @var $writeupService WriteupService */
        $writeupService = $this->get('swp_backend.writeupService');
        $writeup        = $writeupService->findByEventId($id);

        $markdownParser = $this->get('markdown.parser');
        $writeupContent = $markdownParser->transformMarkdown($writeup->getContent());

        return array(
            'event'          => $event,
            'writeupContent' => $writeupContent
        );
    }
}