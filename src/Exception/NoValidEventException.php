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

namespace eArc\Observer\Exception;

/**
 * Supplied argument does not implement the event interface.
 */
class NoValidEventException extends BaseException
{
}
