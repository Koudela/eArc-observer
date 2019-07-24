<?php declare(strict_types=1);
/**
 * e-Arc Framework - the explicit Architecture Framework
 * psr-14 compatible observer blueprint
 *
 * @package earc/observer
 * @link https://github.com/Koudela/eArc-observer/
 * @copyright Copyright (c) 2018-2019 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\Observer;

use eArc\Observer\Interfaces\ObserverInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\StoppableEventInterface;

class Dispatcher implements EventDispatcherInterface
{
    /** @var ObserverInterface */
    protected $observer;

    public function __construct()
    {
        $this->observer = class_exists(di_static(ObserverInterface::class))
            ? di_get(ObserverInterface::class)
            : di_get(Observer::class);
    }

    public function dispatch(object $event)
    {
        foreach($this->observer->getListenersForEvent($event) as $callable) {
            if (is_subclass_of($event, StoppableEventInterface::class)) {
                if ($event->isPropagationStopped()) {
                    break;
                }
            }
            call_user_func($callable, $event);
        }

        return $event;
    }
}
