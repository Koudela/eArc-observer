<?php
/**
 * e-Arc Framework - the explicit Architecture Framework
 * observer component
 *
 * @package earc/observer
 * @link https://github.com/Koudela/eArc-observer/
 * @copyright Copyright (c) 2018-2019 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\Observer\Interfaces;

use eArc\Observer\Exception\NoValidListenerException;

/**
 * Observer defines the listenable nature of an object.
 */
interface ObserverInterface
{
    const CALL_LISTENER_BREAK = 1;
    const CALL_LISTENER_CONTINUE = 2;

    /**
     * Calls all registered listeners that match the type sorted by their
     * patience until either all are called or a filter returns a
     * ObserverInterface::CALL_LISTENER_BREAK. If a filter returns a
     * ObserverInterface::CALL_LISTENER_CONTINUE the next listener will be
     * processed.
     *
     * @param $payload
     * @param int|null $type
     * @param callable|null $preInitFilter  supplied args $fQCN
     * @param callable|null $preCallFilter  supplied args $instance of listener
     * @param callable|null $postCallFilter supplied args $result of listener call
     */
    public function callListeners(
        $payload,
        ?int $type = null,
        ?callable $preInitFilter = null,
        ?callable $preCallFilter = null,
        ?callable $postCallFilter = null
    ): void;

    /**
     * Registers a listener by its fully qualified class name or its container
     * name. (This way the listener does not need to get initialized before it
     * actually get called.)
     *
     * @param string $fQCN
     *
     * @throws NoValidListenerException
     */
    public function registerListener(string $fQCN): void;

    /**
     * Unregisters a listener by its fully qualified class name or its container
     * name. (It must be the same name the listener was registered.)
     *
     * @param string $fQCN
     */
    public function unregisterListener(string $fQCN): void;
}
