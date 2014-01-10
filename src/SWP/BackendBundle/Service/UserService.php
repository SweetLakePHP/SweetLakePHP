<?php

namespace SWP\BackendBundle\Service;

use SWP\BackendBundle\Entity\User;

class UserService
{
    protected $securityEncoderFactory;

    public function __construct($securityEncoderFactory)
    {
        $this->securityEncoderFactory = $securityEncoderFactory;
    }

    public function checkPassword(User $user, $password)
    {
        $factory         = $this->securityEncoderFactory;
        $encoder         = $factory->getEncoder($user);
        $encodedPassword = $encoder->encodePassword($password, $user->getSalt());

        if ($encodedPassword === $user->getPassword()) {
            return true;
        }

        return false;
    }

    public function changePassword(User $user, $password)
    {
        $factory         = $this->securityEncoderFactory;
        $encoder         = $factory->getEncoder($user);
        $encodedPassword = $encoder->encodePassword($password, $user->getSalt());

        $user->setPassword($encodedPassword);

        return $this;
    }
}