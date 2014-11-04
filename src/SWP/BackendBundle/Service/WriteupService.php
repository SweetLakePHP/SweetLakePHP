<?php

namespace SWP\BackendBundle\Service;

class WriteupService extends EntityBaseService
{
    public function findByEventId($eventId)
    {
        return $this->findOneBy(array('eventId' => $eventId));
    }
}
