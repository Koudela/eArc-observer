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

namespace eArc\Observer\Interfaces;

use Psr\EventDispatcher\ListenerProviderInterface;

/**
 * Observer defines the listenable nature of an object.
 */
interface ObserverInterface extends ListenerProviderInterface
{
    /**
     * Registers a listener by its fully qualified class name. (This way the listener
     * does not need to get initialized before it actually get called.) There may
     * be passed a float as second argument representing the patience of the listener.
     * The higher the patience the later the listener is called by the dispatcher.
     *
     * @param string $fQCN
     * @param float  $patience
     */
    public function registerListener(string $fQCN, float $patience=0): void;

    /**
     * Unregisters a listener by its fully qualified class name.
     *
     * @param string $fQCN
     */
    public function unregisterListener(string $fQCN): void;
}
