<?php

namespace TomWright\Eventing\Event;

abstract class Event implements EventInterface
{

    /**
     * @return string
     */
    public function getEventName()
    {
        $className = static::class;

        // Strip any namespaces from the $className.
        $lastBackslash = strrpos($className, '\\');
        if ($lastBackslash !== false) {
            $className = substr($className, $lastBackslash);
        }
        $className = ltrim($className, '\\');

        return $className;
    }

}