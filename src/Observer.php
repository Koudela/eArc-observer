<?php declare(strict_types=1);
/**
 * e-Arc Framework - the explicit Architecture Framework
 * observer component
 *
 * @package earc/observer
 * @link https://github.com/Koudela/eArc-observer/
 * @copyright Copyright (c) 2018-2019 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\Observer;

use eArc\Observer\Interfaces\ObserverInterface;
use eArc\Tree\Traits\ObserverTrait;

/**
 * Observer implements the listenable nature of the observer interface.
 */
class Observer implements ObserverInterface
{
    use ObserverTrait;
}
