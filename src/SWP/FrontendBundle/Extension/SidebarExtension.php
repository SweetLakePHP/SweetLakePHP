<?php

namespace SWP\FrontendBundle\Extension;

use SWP\FrontendBundle\Service;

class SidebarExtension extends \Twig_Extension
{
    protected $meetupService;

    public function __construct(Service\MeetupService $meetupService)
    {
        $this->meetupService = $meetupService;
    }

    public function getFunctions()
    {
        return array(
            'getUpcomingEvents' => new \Twig_Function_Method($this, 'upcomingEvents'),
        );
    }

    public function upcomingEvents()
    {
        return $this->meetupService->getUpcomingEvents();
    }

    public function getName()
    {
        return 'swp_sidebar_extension';
    }
}
