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

/**
 * Events MUST implement this interface.
 */
interface EventInterface
{
    /**
     * Returns an array of fully qualified class names of listener interfaces or
     * base objects that are able to process the event.
     *
     * @return string[]
     */
    public static function getApplicableListener(): array;
}
