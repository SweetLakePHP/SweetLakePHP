<?php

namespace SWP\FrontendBundle\Extension;

class ContributorsExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            'getContributors' => new \Twig_Function_Method($this, 'getContributers'),
        );
    }

    public function getContributers()
    {
        // create a new cURL resource
        $ch = curl_init();

        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, "https://api.github.com/repos/verschoof/SweetLakePHP/contributors");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'SweetLakePHP');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);

        // grab URL and pass it to the browser
        $result = curl_exec($ch);

        // close cURL resource, and free up system resources
        curl_close($ch);

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