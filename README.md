# Eventing

[![Build Status](https://travis-ci.org/TomWright/Eventing.svg?branch=master)](https://travis-ci.org/TomWright/Eventing)
[![Total Downloads](https://poser.pugx.org/tomwright/eventing/d/total.svg)](https://packagist.org/packages/tomwright/eventing)
[![Latest Stable Version](https://poser.pugx.org/tomwright/eventing/v/stable.svg)](https://packagist.org/packages/tomwright/eventing)
[![Latest Unstable Version](https://poser.pugx.org/tomwright/eventing/v/unstable.svg)](https://packagist.org/packages/tomwright/eventing)
[![License](https://poser.pugx.org/tomwright/eventing/license.svg)](https://packagist.org/packages/tomwright/eventing)

## Usage

    
You need an Event and an EventHandler.

Let's say we have an event class stored in app/eventing/event/UserWasRegistered.php.
```php
namespace App\Eventing\Event;

class UserWasRegistered extends \TomWright\Eventing\Event\Event
{
	protected $userId;
    
    public function setUserId($userId)
    {
    	$this->userId = $userId;
    }
    
    public function getUserId()
    {
    	return $this->userId;
    }
}
```

Let's also assume we have an event handler class stored in app/eventing/handler/UserWasRegisteredHandler.php.
```php
namespace App\Eventing\Handler;

class UserWasRegisteredHandler implements \TomWright\Eventing\Listener\ListenerInterface
{   
    public function handle(\TomWright\Eventing\Event\EventInterface $event)
    {
    	echo "User #{$event->getUserId()} has been registered.";
    }
}
```

Now we need to add an Event Handler/Listener namespace so as the EventBus knows where to look for the handlers.
```php
$bus = \TomWright\Eventing\EventBus::getInstance();
$bus->addListenerNamespace('\\App\\Eventing\\Handler');
```

Now whenever we register a new user, all we have to do is the following:
```php
$bus = \TomWright\Eventing\EventBus::getInstance();
$event = new \App\Eventing\Event\UserWasRegistered();
$event->setUserId(123);
$bus->dispatch($event);
```