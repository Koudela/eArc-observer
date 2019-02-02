<?php
/**
 * e-Arc Framework - the explicit Architecture Framework
 * observer blueprint
 *
 * @package earc/observer
 * @link https://github.com/Koudela/eArc-observer/
 * @copyright Copyright (c) 2018-2019 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\Observer\Interfaces;

use eArc\PayloadContainer\Interfaces\PayloadContainerInterface;
use eArc\Tree\Interfaces\NodeInterface;

/**
 * Events can build an inheritance tree via the node interface, have a payload
 * container and can be dispatched at an observer.
 */
interface BaseEventInterface extends PayloadContainerInterface, NodeInterface
{
    /**
     * Get a new child event or factory which inherits from the current event.
     */
    public function fork();
}