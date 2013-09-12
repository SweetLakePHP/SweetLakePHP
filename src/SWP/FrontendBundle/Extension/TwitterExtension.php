<?php

namespace SWP\FrontendBundle\Extension;

use SWP\FrontendBundle\Service;

class TwitterExtension extends \Twig_Extension
{
    protected $twitterService;

    public function __construct(Service\twitterService $twitterService)
    {
        $this->twitterService = $twitterService;
    }

    public function getFunctions()
    {
        return array(
            'getTweets' => new \Twig_Function_Method($this, 'getTweets'),
        );
    }

    public function getTweets($user, $numberOfTweets = 5)
    {
        return $this->twitterService->getTweets($user, $numberOfTweets);
    }

    public function getName()
    {
        return 'swp_twitter_extension';
    }
}