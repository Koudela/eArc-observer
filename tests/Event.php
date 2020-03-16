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

namespace eArc\ObserverTests;

use eArc\Observer\Interfaces\EventInterface;
use eArc\Observer\Interfaces\ListenerInterface;

/**
 * Class Event.
 */
class Event implements EventInterface
{
    /** @var string|null the fully qualified class name */
    public $isTouchedByListener = null;

    /**
     * @inheritDoc
     */
    public static function getApplicableListener(): array
    {
        return [ListenerInterface::class];
    }
}