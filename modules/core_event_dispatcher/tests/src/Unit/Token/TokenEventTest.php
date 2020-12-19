<?php

namespace Drupal\Tests\core_event_dispatcher\Unit\Token;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Render\BubbleableMetadata;
use Drupal\core_event_dispatcher\Event\Token\TokensInfoEvent;
use Drupal\core_event_dispatcher\Event\Token\TokensReplacementEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\core_event_dispatcher\ValueObject\Token;
use Drupal\core_event_dispatcher\ValueObject\TokenType;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;
use function core_event_dispatcher_token_info;
use function core_event_dispatcher_tokens;

/**
 * Class TokenEventTest.
 *
 * @group hook_event_dispatcher
 */
class TokenEventTest extends TestCase {

  /**
   * The manager.
   *
   * @var \Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy
   */
  private $manager;

  /**
   * {@inheritdoc}
   */
  public function setUp(): void {
    $builder = new ContainerBuilder();
    $this->manager = new HookEventDispatcherManagerSpy();
    $builder->set('hook_event_dispatcher.manager', $this->manager);
    $builder->compile();
    Drupal::setContainer($builder);
  }

  /**
   * Test TokenInfoEvent.
   */
  public function testTokenInfoEvent(): void {
    $types = [
      TokenType::create('test_type', 'Test type')->setDescription('Test type desc'),
      TokenType::create('other_type', 'Other type')->setDescription('Other type!')->setNeedsData('test_data'),
    ];
    $tokens = [
      Token::create('test_type', 'test_token1', 'Test name 1')->setDescription('Test description 1'),
      Token::create('test_type', 'test_token2', 'Test name 2')->setDescription('Test description 2'),
      Token::create('other_type', 'test_token3', 'Test name 3'),
      Token::create('dynamic_type', 'test_token4', 'Test name 4')->setDynamic(TRUE),
    ];

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::TOKEN_INFO => static function (TokensInfoEvent $event) use ($types, $tokens) {
        foreach ($types as $type) {
          $event->addTokenType($type);
        }
        foreach ($tokens as $token) {
          $event->addToken($token);
        }
      },
    ]);

    $result = core_event_dispatcher_token_info();

    $expectedTypes = [
      'test_type' => [
        'name' => 'Test type',
        'description' => 'Test type desc',
        'needs-data' => NULL,
      ],
      'other_type' => [
        'name' => 'Other type',
        'description' => 'Other type!',
        'needs-data' => 'test_data',
      ],
    ];
    $expectedTokens = [
      'test_type' => [
        'test_token1' => [
          'name' => 'Test name 1',
          'description' => 'Test description 1',
          'dynamic' => FALSE,
        ],
        'test_token2' => [
          'name' => 'Test name 2',
          'description' => 'Test description 2',
          'dynamic' => FALSE,
        ],
      ],
      'other_type' => [
        'test_token3' => [
          'name' => 'Test name 3',
          'description' => NULL,
          'dynamic' => FALSE,
        ],
      ],
      'dynamic_type' => [
        'test_token4' => [
          'name' => 'Test name 4',
          'description' => NULL,
          'dynamic' => TRUE,
        ],
      ],
    ];
    /** @var \Drupal\core_event_dispatcher\Event\Token\TokensInfoEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::TOKEN_INFO);
    self::assertSame($expectedTypes, $result['types']);
    self::assertSame($expectedTokens, $result['tokens']);
    self::assertSame($expectedTypes, $event->getTokenTypes());
    self::assertSame($expectedTokens, $event->getTokens());
  }

  /**
   * Test TokenReplacementEvent.
   */
  public function testTokenReplacementEvent(): void {
    $replacement1 = 'Replacement value 1';
    $replacement2 = 'Replacement value 2';

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::TOKEN_REPLACEMENT => static function (TokensReplacementEvent $event) use ($replacement1, $replacement2) {
        $event->setReplacementValue('test_type', 'token1', $replacement1);
        $event->setReplacementValue('test_type', 'token2', $replacement2);
      },
    ]);

    $type = 'test_type';
    $tokens = [
      'token1' => '[test_type:token1]',
      'token2' => '[test_type:token2]',
      'token3' => '[test_type:token3]',
    ];
    $data = [
      'test_data' => 'test!',
    ];
    $options = [
      'test_options' => 'Option value',
    ];
    $metaData = $this->createMock(BubbleableMetadata::class);

    $result = core_event_dispatcher_tokens($type, $tokens, $data, $options, $metaData);

    $expectedResult = [
      '[test_type:token1]' => $replacement1,
      '[test_type:token2]' => $replacement2,
    ];
    /** @var \Drupal\core_event_dispatcher\Event\Token\TokensReplacementEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::TOKEN_REPLACEMENT);
    self::assertSame($expectedResult, $result);
    self::assertSame($type, $event->getType());
    self::assertSame($tokens, $event->getTokens());
    self::assertSame($data, $event->getRawData());
    self::assertSame($options, $event->getOptions());
    self::assertSame($metaData, $event->getBubbleableMetadata());
    self::assertSame('test!', $event->getData('test_data'));
    self::assertNull($event->getData('none_existing'));
    self::assertFalse($event->forToken('none_existing', 'token1'));
    self::assertFalse($event->forToken('test_type', 'none_existing'));
  }

  /**
   * Test TokenReplacementEvent wrong replacement exception.
   */
  public function testTokenReplacementEventWrongReplacementException(): void {
    $metaData = $this->createMock(BubbleableMetadata::class);
    $event = new TokensReplacementEvent('', [], [], [], $metaData);

    $this->expectException(UnexpectedValueException::class);
    $event->setReplacementValue('', '', '');
  }

  /**
   * Test TokenReplacementEvent invalid replacement Exception.
   */
  public function testTokenReplacementEventInvalidReplacementException(): void {
    $metaData = $this->createMock(BubbleableMetadata::class);
    $event = new TokensReplacementEvent('test', ['token' => '[test:token]'], [], [], $metaData);

    $this->expectException(UnexpectedValueException::class);
    $event->setReplacementValue('test', 'token', NULL);
  }

}
