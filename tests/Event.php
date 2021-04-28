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
 * Class Event.
 */
class Event implements EventInterface
{
    /** @var string[] the fully qualified class names */
    public $isTouchedByListener = [];

    /**
     * @inheritDoc
     */
    public static function getApplicableListener(): array
    {
        return [ListenerInterface::class];
    }
}
