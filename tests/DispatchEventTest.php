<?php

namespace Testing\DispatchEventTest {

    class UserWasRegistered extends \TomWright\Eventing\Event\Event
    {

        protected $userId;

        protected $notified;


        /**
         * @return mixed
         */
        public function getUserId()
        {
            return $this->userId;
        }


        /**
         * @param mixed $userId
         */
        public function setUserId($userId)
        {
            $this->userId = $userId;
        }


        /**
         * @return mixed
         */
        public function getNotified()
        {
            return $this->notified;
        }


        /**
         * @param mixed $notified
         */
        public function setNotified($notified)
        {
            $this->notified = $notified;
        }

    }

    class UserWasRegisteredHandler implements \TomWright\Eventing\Listener\ListenerInterface
    {

        /**
         * @param \TomWright\Eventing\Event\EventInterface $event
         * @return mixed|void
         */
        public function handle(\TomWright\Eventing\Event\EventInterface $event)
        {
            $event->setNotified(true);
        }
    }

}

namespace {

    class DispatchEventTest extends PHPUnit_Framework_TestCase
    {

        public function testGetEventName()
        {
            $event = new \Testing\DispatchEventTest\UserWasRegistered();
            $name = $event->getEventName();
            $this->assertEquals('UserWasRegistered', $name);
        }

        public function testEventIsHandled()
        {
            $bus = \TomWright\Eventing\EventBus::getInstance();
            $bus->addListenerNamespace('\\Testing\\DispatchEventTest\\');

            $event = new \Testing\DispatchEventTest\UserWasRegistered();
            $event->setUserId(123);
            $event->setNotified(false);

            $this->assertFalse($event->getNotified());

            $bus->dispatch($event);

            $this->assertTrue($event->getNotified());
        }

    }

}