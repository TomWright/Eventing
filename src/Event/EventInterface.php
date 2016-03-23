<?php

namespace TomWright\Eventing\Event;

interface EventInterface
{

    /**
     * @return string
     */
    public function getEventName();

}