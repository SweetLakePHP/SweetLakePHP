<?php

namespace SWP\FrontendBundle\Service;

class RequestService
{
    protected $container;

    /**
     * RequestService constructor.
     *
     * @param $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->container->get('request');
    }
}
