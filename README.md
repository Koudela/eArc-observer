# eArc-observer

earc/observer is a ready to use and extendable psr-14 compatible observer blueprint.

## Install

```php
$ composer require earc/observer
```

## Bootstrap

earc/observer uses [earc/di](https://github.com/Koudela/eArc-di) for dependency
injection. 

```php
use eArc\DI\DI;

DI::init();
```

Place the above code in the section where your script/framework is 
bootstrapped.

## Configure

earc/observer does not need any configuration.

## Use

### The event

Your event has to implement the [EventInterface](https://github.com/Koudela/eArc-observer/blob/master/src/Interfaces/EventInterface.php) 
in order to be dispatchable by the dispatcher of earc/observer. 

```php
use eArc\Observer\Interfaces\EventInterface;
use eArc\Observer\Interfaces\ListenerInterface;

class SomeEvent implements EventInterface
{
    public static function getApplicableListener(): array
    {
        return [ListenerInterface::class];     
    }
}
```

Extend the ListenerInterface if you want to be more specific. 

### Register Listeners

You can either use the observer object to register your listener
  
```php
use eArc\Observer\Observer;

$observer = di_get(Observer::class);

$observer->registerListener(SomeListener::class); 
```

or use the tagging of earc/di (if the observer instance is not build yet)

```php
use eArc\Observer\Observer;

di_tag(Observer::class, SomeListener::class); 
```

Hint: Tagging does not initialize the observer nor does it autoload the observer class.
Both does not autoload the listener until it is called upon to process the event.

### Patience

If you pass a `float` as second or third argument respectively, it is interpreted as
patience. The more patience the listener has the later it is called.

```php
use eArc\Observer\Observer;

$observer = di_get(Observer::class);

$observer->registerListener(SomeListener::class, 0.2); 
```

or (if the observer instance is not build yet) 

```php
use eArc\Observer\Observer;

di_tag(Observer::class, SomeListener::class, -12.7);
```

### Unregister Listeners

You can unregister by 

```php
$observer->unregisterListener(SomeListener::class); 
```

or (if the observer instance is not build yet) 

```php
use eArc\Observer\Observer;

di_clear_tags(Observer::class, SomeListener::class); 
```

Note the different semantics of `di_tag()` and `di_clear_tags()`. 

### Dispatch the event

To dispatch your event use the dispatcher

```php
use eArc\Observer\Dispatcher;

$dispatcher = di_get(Dispatcher::class);
$event = $dispatcher->dispatch($event); 
```

It returns the event that may be modified by the listener.

## advanced usage

If you want to change the behaviour of the observer you can decorate it by any
class implementing the `ObserverInterface`.

```php
use \eArc\Observer\Interfaces\ObserverInterface;

di_decorate(ObserverInterface::class, TheNewObserver::class);
```

Please note that every library in your project, using earc/observer, uses the
decorating class thereafter. Therefore you might be forced to write your own 
dispatcher too. All you need to do is implementing the `DispatcherInterface`.  

## releases

### release 1.1

- PHP ^7.2 || ^8.0

### release 1.0.3

- fix patience via tag converts float to int
- documentation completed
- test coverage 100% of documented features

### release 1.0.2

- fix php does not recognise ['string' => $obj, 'method'] as callable.

### release 1.0.1

- added listener interface

### release 1.0
- rewrite to be psr-14 compatible

### release 0.0
- initial release
