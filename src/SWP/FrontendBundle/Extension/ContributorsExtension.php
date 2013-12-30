<?php

namespace SWP\FrontendBundle\Extension;

class ContributorsExtension extends \Twig_Extension
{
    protected $githubService;

    public function __construct($githubService)
    {
        $this->githubService = $githubService;
    }

    public function getFunctions()
    {
        return array(
            'getContributors' => new \Twig_Function_Method($this, 'getContributers'),
        );
    }

    public function getContributers()
    {
        $contributors = $this->githubService->getAllContributors();
        $result       = $contributors->__toString();

        $decodedResult = array();
        if ($result) {
            $decodedResult = json_decode($result, true);
        }

        return $decodedResult;
    }

    public function getName()
    {
        return 'swp_contributors_extension';
    }
}