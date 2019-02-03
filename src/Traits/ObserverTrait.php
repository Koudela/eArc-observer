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

namespace eArc\Observer\Traits;

use eArc\Event\Interfaces\EventInterface;
use eArc\Observer\Exception\NoValidListenerException;
use eArc\Observer\Interfaces\ListenerInterface;
use eArc\Observer\Interfaces\ObserverInterface;

/**
 * Generic observer trait. Always use the observer interface, too.
 */
trait ObserverTrait
{
    /** @var float[] */
    protected $listenerPatience = [];

    /** @var ListenerInterface[] */
    protected $listenerInstance = [];

    /**
     * @inheritdoc
     */
    public function callListeners(
        EventInterface $event,
        ?int $type = null,
        ?callable $preInitLCH = null,
        ?callable $preCallLCH = null,
        ?callable $postCallLCH = null
    ): void
    {
        asort($this->listenerPatience, SORT_NUMERIC);

        foreach($this->listenerPatience as $fQCN => $patience) {

            /** @noinspection PhpUndefinedMethodInspection */
            if (null !== $type && 0 === ($fQCN::getTypes() & $type)) {
                continue;
            }

            if (null !== $preInitLCH && $return = $preInitLCH($fQCN)) {
                if ($return === ObserverInterface::CALL_LISTENER_BREAK) {
                    break;
                }

                if ($return === ObserverInterface::CALL_LISTENER_CONTINUE) {
                    continue;
                }
            }

            $listener = $this->getListener($fQCN);

            if (null !== $preCallLCH && $return = $preCallLCH($listener)) {
                if ($return === ObserverInterface::CALL_LISTENER_BREAK) {
                    break;
                }

                if ($return === ObserverInterface::CALL_LISTENER_CONTINUE) {
                    continue;
                }
            }

            $result = $listener->process($event);

            if (null !== $postCallLCH && $return = $postCallLCH($result)) {
                if ($return === ObserverInterface::CALL_LISTENER_BREAK) {
                    break;
                }
            }
        }
    }

    /**
     * Get the listener from the instances or if it fails try to build the
     * class.
     *
     * @param string $fQCN
     *
     * @return ListenerInterface
     */
    protected function getListener(string $fQCN): ListenerInterface
    {
        if (!isset($this->listenerInstance[$fQCN]))
        {
            $this->listenerInstance[$fQCN] = new $fQCN();
        }

        return $this->listenerInstance[$fQCN];
    }

    /**
     * @inheritdoc
     */
    public function registerListener(string $fQCN): void
    {
        if (!is_subclass_of($fQCN, ListenerInterface::class)) {
            throw new NoValidListenerException();
        }

        /** @noinspection PhpUndefinedMethodInspection */
        $this->listenerPatience[$fQCN] = $fQCN::getPatience();
    }

    /**
     * @inheritdoc
     */
    public function unregisterListener(string $fQCN): void
    {
        unset($this->listenerPatience[$fQCN]);
        unset($this->listenerInstance[$fQCN]);
    }
}
