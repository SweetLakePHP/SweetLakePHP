<?php

namespace SWP\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use SWP\FrontendBundle\Form\Type\ContactType;

class IndexController extends Controller
{
    /**
     * @Route( "/", name="index" )
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route( "/about", name="about" )
     * @Template()
     */
    public function aboutAction()
    {
        return array();
    }

    /**
     * @Route( "/contact", name="contact" )
     * @Template()
     * @Method({"GET","POST"})
     */
    public function contactAction()
    {
        $contactForm = $this->createForm(new ContactType());


        return array(
            'contactForm' => $contactForm->createView()
        );
    }
}
