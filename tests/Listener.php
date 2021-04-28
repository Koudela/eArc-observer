<?php declare(strict_types=1);
/**
 * e-Arc Framework - the explicit Architecture Framework
 * psr-14 compatible observer blueprint
 *
 * @package earc/observer
 * @link https://github.com/Koudela/eArc-observer/
 * @copyright Copyright (c) 2018-2021 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\ObserverTest;

use eArc\Observer\Interfaces\EventInterface;
use eArc\Observer\Interfaces\ListenerInterface;

/**
 * Class Listener.
 */
class Listener implements ListenerInterface
{
    /**
     * @inheritDoc
     */
    public function process(EventInterface $event): void
    {
        if ($event instanceof Event) {
            $event->isTouchedByListener[] = get_class($this);
        }
    }
}
