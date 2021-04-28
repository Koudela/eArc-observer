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

use eArc\DI\DI;
use eArc\DI\Exceptions\InvalidArgumentException;
use eArc\Observer\Dispatcher;
use eArc\Observer\Interfaces\ObserverInterface;
use eArc\Observer\Observer;
use eArc\ObserverTest\Event;
use eArc\ObserverTest\Listener;
use eArc\ObserverTest\SecondListener;
use eArc\ObserverTest\ThirdListener;
use PHPUnit\Framework\TestCase;

/**
 * This is no unit test. It is an integration test.
 */
class ObserverTest extends TestCase
{
    public function testIntegration()
    {
        $this->bootstrap();
        $this->runObserverAssertions();
        $this->runRegisterListenerDirectAssertions();
        $this->runUnregisterListenerDirectAssertions();
        $this->runRegisterListenerByTagAssertions();
        $this->runUnregisterListenerByTagAssertions();
        $this->runDirectPatienceAssertions();
        $this->runTaggedPatienceAssertions();
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function bootstrap()
    {
        $vendorDir = __DIR__.'/../vendor';

        if (!is_dir($vendorDir)) {
            $vendorDir = __DIR__.'/../../..';
        }

        require_once $vendorDir.'/autoload.php';

        DI::init();
    }

    protected function runObserverAssertions()
    {
        di_clear_cache();
        /** @var Observer $observer */
        $observer = di_get(Observer::class);
        $this->assertInstanceOf(Observer::class, $observer);
        $this->assertInstanceOf(ObserverInterface::class, $observer);
    }

    protected function runRegisterListenerDirectAssertions()
    {
        di_clear_cache();
        /** @var Observer $observer */
        $observer = di_get(Observer::class);
        $observer->registerListener(Listener::class);
        $event = $this->dispatchEvent();
        $this->assertEquals(Listener::class, $event->isTouchedByListener[0]);
    }

    protected function runUnregisterListenerDirectAssertions()
    {
        di_clear_cache();
        /** @var Observer $observer */
        $observer = di_get(Observer::class);
        $observer->unregisterListener(Listener::class);
        $event = $this->dispatchEvent();
        $this->assertTrue(empty($event->isTouchedByListener));
    }

    protected function runRegisterListenerByTagAssertions()
    {
        di_clear_cache();
        di_tag(Observer::class, Listener::class);
        $event = $this->dispatchEvent();
        $this->assertEquals(Listener::class, $event->isTouchedByListener[0]);
    }

    protected function runUnregisterListenerByTagAssertions()
    {
        di_clear_cache();
        di_tag(Observer::class, Listener::class);
        di_clear_tags(Observer::class, Listener::class);
        $event = $this->dispatchEvent();
        $this->assertTrue(empty($event->isTouchedByListener));
    }

    protected function runDirectPatienceAssertions()
    {
        di_clear_cache();
        /** @var Observer $observer */
        $observer = di_get(Observer::class);
        $observer->registerListener(Listener::class, 2.2);
        $observer->registerListener(SecondListener::class, -2.8);
        $observer->registerListener(ThirdListener::class, 2.1);
        $event = $this->dispatchEvent();
        $this->assertEquals(SecondListener::class, $event->isTouchedByListener[0]);
        $this->assertEquals(ThirdListener::class, $event->isTouchedByListener[1]);
        $this->assertEquals(Listener::class, $event->isTouchedByListener[2]);
    }

    protected function runTaggedPatienceAssertions()
    {
        di_clear_cache();
        di_tag(Observer::class, Listener::class, 2.2);
        di_tag(Observer::class, SecondListener::class,-2.8);
        di_tag(Observer::class, ThirdListener::class,2.1);
        $event = $this->dispatchEvent();
        $this->assertEquals(SecondListener::class, $event->isTouchedByListener[0]);
        $this->assertEquals(ThirdListener::class, $event->isTouchedByListener[1]);
        $this->assertEquals(Listener::class, $event->isTouchedByListener[2]);
    }

    /**
     * @return Event
     */
    protected function dispatchEvent(): Event
    {
        /** @var Event $event */
        $event = di_make(Event::class);
        /** @var Dispatcher $dispatcher */
        $dispatcher = di_get(Dispatcher::class);
        $event = $dispatcher->dispatch($event);

        return $event;
    }
}
