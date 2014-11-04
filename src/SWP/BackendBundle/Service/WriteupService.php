<?php

namespace SWP\BackendBundle\Service;

use SWP\BackendBundle\Entity\User;

class WriteupService extends EntityBaseService
{
    public function findByEventId($eventId)
    {
        return $this->findOneBy(array('eventId' => $eventId));
    }
}
