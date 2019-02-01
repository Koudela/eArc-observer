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

/**
 * Interface a class must implement to become an listener.
 */
interface ListenerInterface
{
    /**
     * Only if the types of the listener matches the type of the listener stack
     * call it gets called. A type must be the power of 2. Null matches all
     * types. (For example 11 would match the types 1, 2 and 8.)
     *
     * @return int|null
     */
    public static function getTypes();

    /**
     * The higher the patience the later it is positioned in the listener stack
     * of the observer.
     *
     * @return float
     */
    public static function getPatience();

    /**
     * Method which is called by the Observer the EventListener is attached to.
     *
     * @param mixed[] $payload
     *
     * @return mixed|void
     */
    public function process(...$payload);
}