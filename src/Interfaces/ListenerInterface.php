<?php declare(strict_types=1);
/**
 * e-Arc Framework - the explicit Architecture Framework
 * psr-14 compatible observer blueprint
 *
 * @package earc/observer
 * @link https://github.com/Koudela/eArc-observer/
 * @copyright Copyright (c) 2018-2020 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\Observer\Interfaces;

/**
 * Listener MUST implement this interface.
 */
interface ListenerInterface
{
    /**
     * Processes the event.
     *
     * @param EventInterface $event
     */
    public function process(EventInterface $event): void;
}