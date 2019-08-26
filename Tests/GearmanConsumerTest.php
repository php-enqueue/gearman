<?php

namespace Enqueue\Gearman\Tests;

use Enqueue\Gearman\GearmanConsumer;
use Enqueue\Gearman\GearmanContext;
use Enqueue\Gearman\GearmanDestination;
use Enqueue\Test\ClassExtensionTrait;
use Interop\Queue\Message;
use PHPUnit\Framework\TestCase;

class GearmanConsumerTest extends TestCase
{
    use ClassExtensionTrait;
    use SkipIfGearmanExtensionIsNotInstalledTrait;

    public function testReceiveReturnsTwoMessages()
    {
        $message = $this->createMock(Message::class);

        $worker = $this->createMock(\GearmanWorker::class);
        $worker->expects($this->once())
            ->method('work')
            ->will($this->returnValue(true));

        $context = $this->createMock(GearmanContext::class);
        $context->expects($this->once())
            ->method('createWorker')
            ->will($this->returnValue($worker));

        $destination = new GearmanDestination('test');
        $consumer = new GearmanConsumer($context, $destination);
        $consumer->receive();
    }
}