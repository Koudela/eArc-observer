<?php
/**
 * e-Arc Framework - the explicit Architecture Framework
 * observer component
 *
 * @package earc/observer
 * @link https://github.com/Koudela/eArc-observer/
 * @copyright Copyright (c) 2018-2019 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\Observer\Traits;

use eArc\Observer\Exception\NoValidListenerException;
use eArc\Observer\Interfaces\ListenerInterface;
use eArc\Observer\Interfaces\ObserverInterface;

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
        $payload,
        ?int $type = null,
        ?callable $preInitFilter = null,
        ?callable $preCallFilter = null,
        ?callable $postCallFilter = null
    ): void
    {
        asort($this->listenerPatience, SORT_NUMERIC);

        foreach($this->listenerPatience as $fQCN => $patience) {

            /** @noinspection PhpUndefinedMethodInspection */
            if (null !== $type && 0 === ($fQCN::getTypes() & $type)) {
                continue;
            }

            if (null !== $preInitFilter && $return = $preInitFilter($fQCN)) {
                if ($return === ObserverInterface::CALL_LISTENER_BREAK) {
                    break;
                }

                if ($return === ObserverInterface::CALL_LISTENER_CONTINUE) {
                    continue;
                }
            }

            $listener = $this->getListener($fQCN);

            if (null !== $preCallFilter && $return = $preCallFilter($listener)) {
                if ($return === ObserverInterface::CALL_LISTENER_BREAK) {
                    break;
                }

                if ($return === ObserverInterface::CALL_LISTENER_CONTINUE) {
                    continue;
                }
            }

            $result = $listener->process($payload);

            if (null !== $postCallFilter && $return = $postCallFilter($result)) {
                if ($return === ObserverInterface::CALL_LISTENER_BREAK) {
                    break;
                }
            }
        }
    }

    /**
     * Get the listener from the instances or if it fails try to build the
     * class. (A class not part of the container is saved to a stack and thus
     * never build a second time by this function.)
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
            /** @noinspection PhpUnhandledExceptionInspection */
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
