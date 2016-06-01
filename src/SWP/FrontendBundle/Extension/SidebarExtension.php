<?php

namespace SWP\FrontendBundle\Extension;

use SWP\FrontendBundle\Service;

class SidebarExtension extends \Twig_Extension
{
    protected $meetupService;

    /**
     * SidebarExtension constructor.
     *
     * @param Service\MeetupService $meetupService
     */
    public function __construct(Service\MeetupService $meetupService)
    {
        $this->meetupService = $meetupService;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'getUpcomingEvents' => new \Twig_Function_Method($this, 'upcomingEvents'),
        );
    }

    /**
     * @return array
     */
    public function upcomingEvents()
    {
        return $this->meetupService->getUpcomingEvents();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'swp_sidebar_extension';
    }
}
