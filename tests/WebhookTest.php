<?php

namespace TelegramBotTest;

use PHPUnit\Framework\TestCase;
use TelegramBot\Entities\Message;
use TelegramBot\Entities\Update;
use TelegramBot\Plugin;
use TelegramBot\UpdateHandler;

class WebhookTest extends \PHPUnit\Framework\TestCase {

   public function testAnonymousPlugins() {
      $plugin = new class($this) extends Plugin {

         private $testCase;

         public function __construct(TestCase $testCase) {
            $this->testCase = $testCase;
         }

         public function onMessage(int $update_id, Message $message): \Generator {
            $this->testCase->assertEquals(1, $update_id);
            $this->testCase->assertEquals('Hello World!', $message->getText());
            yield;
         }

      };

      $message = DummyUpdate::message();
      $message->set('text', 'Hello World!');

      (new UpdateHandler())->addPlugins($plugin)->resolve(new Update([
         'update_id' => 1,
         'message' => $message->getRawData(),
      ]));
   }

   public function testFilterIncomingUpdates() {

      $plugin = new class($this) extends Plugin {

         public function __construct(TestCase $testCase) {
            $this->testCase = $testCase;
         }

         public function __process(Update $update): void {
            $this->testCase->fail('This should not be called');
         }
      };

      $handler = (new UpdateHandler())->addPlugins($plugin);

      $handler->filterIncomingUpdates([
         Update::TYPE_MESSAGE
      ]);

      $handler->resolve(new Update([
         'update_id' => 1,
         'message' => DummyUpdate::message()->getRawData(),
      ]));

      $this->assertTrue(true);
   }

}