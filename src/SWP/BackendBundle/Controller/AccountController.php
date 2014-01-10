<?php

namespace SWP\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use SWP\BackendBundle\Form\Type;
use Symfony\Component\Form\FormError;

/**
 * @Route("/account")
 */
class AccountController extends Controller
{
    /**
     * @Route("/", name="account.index")
     * @Template()
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $user = $this->getUser();

        $accountForm = $this->createForm(new Type\AccountType(), $user);

        if ($request->getMethod() === "POST") {
            $account     = $request->request->get('account');
            $userService = $this->get('swp_backend.useerService');

            if (false === $userService->checkPassword($user, $account['currentPassword'])) {
                $accountForm->get('currentPassword')->addError(new FormError('account.password.invalid'));
            }

            $accountForm->bind($request);

            if ($accountForm->isValid()) {
                $userService->changePassword($user, $user->getPassword());

                $this->get('session')->getFlashBag()->add('success', 'account.edit.success');
                return $this->redirect($this->generateUrl('account.index'));
            }
        }

        return array(
            'form' => $accountForm->createView()
        );
    }
}
