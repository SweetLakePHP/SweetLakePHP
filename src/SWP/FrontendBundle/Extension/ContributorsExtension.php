<?php

namespace SWP\FrontendBundle\Extension;

class ContributorsExtension extends \Twig_Extension
{
    protected $githubService;

    /**
     * ContributorsExtension constructor.
     *
     * @param $githubService
     */
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

    /**
     * @return array|mixed
     */
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

    /**
     * @return string
     */
    public function getName()
    {
        return 'swp_contributors_extension';
    }
}
