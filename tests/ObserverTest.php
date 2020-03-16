<?php declare(strict_types=1);
/**
 * e-Arc Framework - the explicit Architecture Framework
 * psr-14 compatible observer blueprint
 *
 * @package earc/observer
 * @link https://github.com/Koudela/eArc-observer/
 * @copyright Copyright (c) 2018-2020 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\ObserverTest;

use eArc\DI\DI;
use eArc\DI\Exceptions\InvalidArgumentException;
use eArc\Observer\Dispatcher;
use eArc\Observer\Interfaces\ObserverInterface;
use eArc\Observer\Observer;
use eArc\ObserverTests\Event;
use eArc\ObserverTests\Listener;
use PHPUnit\Framework\TestCase;

/**
 * This is no unit test. It is an integration test.
 */
class ObserverTest extends TestCase
{
    public function testObserver()
    {
        $this->bootstrap();
        $observer = di_get(Observer::class);
        $this->assertInstanceOf(Observer::class, $observer);
        $this->assertInstanceOf(ObserverInterface::class, $observer);
    }

    public function testRegisterListenerDirect()
    {
        $this->bootstrap();
        /** @var ObserverInterface $observer */
        $observer = di_get(Observer::class);
        $observer->registerListener(Listener::class);
        /** @var Event $event */
        $event = di_make(Event::class);
        /** @var Dispatcher $dispatcher */
        $dispatcher = di_get(Dispatcher::class);
        $event = $dispatcher->dispatch($event);
        $this->assertEquals(Listener::class, $event->isTouchedByListener);
    }

    public function testUnregisterListenerDirect()
    {
        $this->bootstrap();
        /** @var ObserverInterface $observer */
        $observer = di_get(Observer::class);
        $observer->registerListener(Listener::class);
        /** @var Event $event */
        $event = di_make(Event::class);
        /** @var Dispatcher $dispatcher */
        $dispatcher = di_get(Dispatcher::class);

        $observer->unregisterListener(Listener::class);
        $event = $dispatcher->dispatch($event);

        $this->assertEquals(null, $event->isTouchedByListener);
    }

    public function testRegisterListenerByTag()
    {

    }

    public function testUnregisterListenerByTag()
    {

    }

    public function testPatience()
    {

    }

    public function testIntegration()
    {

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
}