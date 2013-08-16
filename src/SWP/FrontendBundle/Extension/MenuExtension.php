<?php

namespace SWP\FrontendBundle\Extension;

class MenuExtension extends \Twig_Extension
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function getFunctions()
    {
        return array(
            'menuIsActive' => new \Twig_Function_Method($this, 'isActive'),
        );
    }

    protected function listBundle()
    {
        $listBundle = array();

        return $listBundle;
    }

    public function isActive($item)
    {
        $request = $this->request;
        $route   = $request->getRequest()->attributes->get('_route');

        if ($item === $route) {
            return true;
        }

        $listBundle = $this->listBundle();

        if (isset($listBundle[$item])) {
            foreach ($listBundle[$item] as $list => $listItem) {
                if ($route === $listItem) {
                    return true;
                }
            }
        }

        return false;
    }

    public function getName()
    {
        return 'swp_menu_extension';
    }
}