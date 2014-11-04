<?php

namespace SWP\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use SWP\BackendBundle\Form\Type;

/**
 * @Route("/admin/event")
 */
class WriteupController extends Controller
{
    /**
     * @Route("/{eventId}/writeup", name="event.writeup", requirements={"eventId" = "\d+"})
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function indexAction(Request $request, $eventId)
    {
        $meetupService = $this->get('swp_frontend.meetupService');
        $meetup        = $meetupService->find($eventId);

        if (!$meetup['status'] == 'past') {
            $this->get('session')->getFlashBag()->add('failure', 'meetup.writeup.mustbepast');
            return $this->redirect($this->generateUrl('event.list'));
        }

        $writeupService = $this->get('swp_backend.writeupService');
        $writeup        = $writeupService->findOneBy(array('eventId' => $eventId));

        if (!$writeup) {
            $writeup = $writeupService->newInstance();
            $writeup->setEventId($eventId);
        }

        $writeupForm = $this->createForm(new Type\WriteupType(), $writeup);

        $markdownParser = $this->get('markdown.parser');
        $preview = $markdownParser->transformMarkdown($writeup->getContent());

        if ($request->getMethod() == "POST") {
            $writeupForm->handleRequest($request);

            if ($writeupForm->isvalid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($writeup);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'writeup.edit.success');
                return $this->redirect($this->generateUrl('event.writeup', array('eventId' => $eventId)));
            } else {
                $this->get('session')->getFlashBag()->add('error', 'writeup.edit.failed');
            }
        }

        return array(
            'meetup'  => $meetup,
            'form'    => $writeupForm->createView(),
            'preview' => $preview,
            'writeup' => $writeup
        );
    }

    /**
     * @Route("/{eventId}/writeup/autosave", name="event.writeup.autosave", requirements={"eventId" = "\d+"}, options={"expose"=true})
     */
    public function autosaveAction(Request $request, $eventId)
    {
        $meetupService = $this->get('swp_frontend.meetupService');
        $meetup        = $meetupService->find($eventId);

        $writeupService = $this->get('swp_backend.writeupService');
        $writeup        = $writeupService->findOneBy(array('eventId' => $eventId));

        if (!$writeup) {
            $writeup = $writeupService->newInstance();
            $writeup->setEventId($eventId);
        } else {
            $writeup->setUpdatedAt(new \DateTime());
        }

        $writeupPost = $request->request->get('writeup');

        $writeupForm = $this->createForm(new Type\WriteupType(), $writeup);
        $writeupForm->handleRequest($writeupPost);

        if ($writeupForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($writeup);
            $em->flush();

            return new Response(json_encode(array('success' => true)));
        } else {
            return new Response(json_encode(array('success' => false, 'errors' => $writeupForm->getErrorsAsString())));
        }
    }

    /**
     * @Route("/writeup/preview", name="event.writeup.preview", options={"expose"=true})
     * @Method({"POST"})
     */
    public function previewAction(Request $request)
    {
        $text = $request->request->get('text');

        $markdownParser = $this->get('markdown.parser');
        $result = $markdownParser->transformMarkdown($text);

        return new Response(json_encode($result));
    }
}
