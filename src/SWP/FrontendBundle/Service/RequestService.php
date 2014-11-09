<?php

namespace SWP\FrontendBundle\Service;

class RequestService
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function getRequest()
    {
        return $this->container->get('request');
    }
}
