<?php declare(strict_types=1);
/**
 * e-Arc Framework - the explicit Architecture Framework
 * observer blueprint
 *
 * @package earc/observer
 * @link https://github.com/Koudela/eArc-observer/
 * @copyright Copyright (c) 2018-2021 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\Observer;

use eArc\Observer\Exception\NoValidEventException;
use eArc\Observer\Interfaces\EventInterface;
use eArc\Observer\Interfaces\ObserverInterface;

/**
 * Observer implements the listenable nature of the observer interface.
 */
class Observer implements ObserverInterface
{
    public function __construct()
    {
        foreach(di_get_tagged(static::class) as $fQCN => $patience) {
            $this->registerListener($fQCN, floatval($patience));
        }
    }

    /** @var string[] */
    protected $listener = [];

    public function getListenersForEvent(object $event): iterable
    {
        if (!is_subclass_of($event, EventInterface::class)) {
            throw new NoValidEventException(sprintf('{acd9a8dc-b222-4f68-9dfd-e23fce225505} Event %s has to implement the %s', get_class($event), EventInterface::class));
        }

        asort($this->listener, SORT_NUMERIC);

        foreach($this->listener as $fQCN => $patience) {
            foreach($event::getApplicableListener() as $base) {
                if (is_subclass_of($fQCN, $base)) {
                    yield [di_get($fQCN), 'process'];

                    break;
                };
            }
        }
    }

    public function registerListener(string $fQCN, float $patience=0): void
    {
        $this->listener[$fQCN] = $patience;
    }

    public function unregisterListener(string $fQCN): void
    {
        unset($this->listener[$fQCN]);
    }
}
