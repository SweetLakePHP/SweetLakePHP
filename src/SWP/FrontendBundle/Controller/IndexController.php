<?php

namespace SWP\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use SWP\FrontendBundle\Form\Type\ContactType;

class IndexController extends Controller
{
    /**
     * @Route("/", name="index")
     * @Template()
     */
    public function indexAction()
    {
        $meetupService = $this->get('swp_frontend.meetupService');
        $events        = $meetupService->getUpcomingEvents();

        return array(
            'events' => $events
        );
    }

    /**
     * @Route("/about", name="about")
     * @Template()
     */
    public function aboutAction()
    {
        return array();
    }

    /**
     * @Route("/contact", name="contact")
     * @Template()
     * @Method({"GET","POST"})
     */
    public function contactAction(Request $request)
    {
        $contactForm = $this->createForm(new ContactType());

        if ($request->getMethod() === "POST") {
            $contactForm->bind($request);

            if ($contactForm->isValid()) {
                $contactEmailsString = $this->container->getParameter('contact_receivers');
                $contactEmails       = explode(', ', $contactEmailsString);

                $email   = $this->container->getParameter('contact_email');
                $contact = $request->request->get('contact');


                $message = \Swift_Message::newInstance()
                    ->setSubject($contact['subject'])
                    ->setFrom($email)
                    ->setReplyTo($contact['email'])
                    ->setBody($contact['content'])
                ;

                foreach ($contactEmails as $key => $email) {
                    $message->addTo($email);
                }

                $this->get('mailer')->send($message);

                $this->get('session')->getFlashBag()->add('success', 'contact.sent.success');
                return $this->redirect($this->generateUrl('contact'));
            }
        }

        return array(
            'contactForm' => $contactForm->createView()
        );
    }

    /**
     * @Route("/community/tweets", name="community.tweets")
     * @Template()
     */
    public function TweetsAction()
    {
        return array();
    }

    /**
     * @Route("/tweets/{user}/{numberOfTweets}", name="tweet.list", options={"expose"=true})
     */
    public function getTweets($user, $numberOfTweets)
    {
        $twitterService = $this->get('swp_frontend.twitterService');
        $tweets         = $twitterService->getTweets($user, $numberOfTweets);

        return new JsonResponse($tweets);
    }

    /**
     * @Route("/tweets/{user}/{numberOfTweets}/friends", name="tweet.friends", options={"expose"=true})
     */
    public function getTweetsFriends($user, $numberOfTweets)
    {
        $twitterService = $this->get('swp_frontend.twitterService');
        $tweets         = $twitterService->getTweetsFriends($user, $numberOfTweets);

        return new JsonResponse($tweets);
    }
}
