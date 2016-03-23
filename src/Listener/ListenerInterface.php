<?php

namespace TomWright\Eventing\Listener;

use TomWright\Eventing\Event\EventInterface;

interface ListenerInterface
{

    /**
     * @param EventInterface $event
     * @return mixed
     */
    public function handle(EventInterface $event);

}