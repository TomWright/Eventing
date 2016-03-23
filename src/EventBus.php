<?php

namespace TomWright\Eventing;

use TomWright\Eventing\Event\EventInterface;
use TomWright\Eventing\Listener\ListenerInterface;
use TomWright\Singleton\SingletonTrait;

class EventBus
{

    use SingletonTrait;

    /**
     * @var string[]
     */
    protected $listenerNamespaces;


    /**
     * EventBus constructor.
     */
    protected function __construct()
    {
        $this->listenerNamespaces = [];
    }


    /**
     * Add a namespace in which to look for Event Handlers.
     * @param string $namespace
     */
    public function addListenerNamespace($namespace)
    {
        $namespace = rtrim($namespace, '\\');
        $namespace = "{$namespace}\\";

        if (! in_array($namespace, $this->listenerNamespaces)) {
            $this->listenerNamespaces[] = $namespace;
        }
    }


    /**
     * Dispatches the specified event.
     * @param EventInterface $event
     */
    public function dispatch(EventInterface $event)
    {
        $listenerName = $event->getEventName() . 'Handler';

        $handlers = $this->loadListeners($listenerName);

        foreach ($handlers as $handler) {
            $handler->handle($event);
        }
    }


    /**
     * Load the listeners by name.
     * @param string $listenerName
     * @return ListenerInterface[]
     */
    protected function loadListeners($listenerName)
    {
        $handlers = [];

        foreach ($this->listenerNamespaces as $namespace) {
            $className = "{$namespace}{$listenerName}";
            if (class_exists($className)) {
                $handler = new $className();
                $handlers[] = $handler;
            }
        }

        return $handlers;
    }

}