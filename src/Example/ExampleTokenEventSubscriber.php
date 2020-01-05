<?php

namespace Drupal\hook_event_dispatcher\Example;

use Drupal\core_event_dispatcher\Event\Token\TokensInfoEvent;
use Drupal\core_event_dispatcher\Event\Token\TokensReplacementEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\core_event_dispatcher\ValueObject\Token;
use Drupal\core_event_dispatcher\ValueObject\TokenType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ExampleTokenEventSubscriber.
 */
final class ExampleTokenEventSubscriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
    return [
      HookEventDispatcherInterface::TOKEN_REPLACEMENT => 'tokenReplacement',
      HookEventDispatcherInterface::TOKEN_INFO => 'tokenInfo',
    ];
  }

  /**
   * Provides new token types and tokens.
   *
   * @param \Drupal\core_event_dispatcher\Event\Token\TokensInfoEvent $event
   *   The token info event.
   *
   * @throws \UnexpectedValueException
   */
  public function tokenInfo(TokensInfoEvent $event): void {
    // The node type already exists, but it's just an example how to add a type.
    $type = TokenType::create('node', t('Node'))
      ->setDescription('Node tokens')
      ->setNeedsData('node');
    $event->addTokenType($type);

    // Add node token.
    $event->addToken(Token::create('node', 'serialized',
      t('Serialized string of the node'))->setDescription('Node serialized'));
  }

  /**
   * Replace tokens.
   *
   * @param \Drupal\core_event_dispatcher\Event\Token\TokensReplacementEvent $event
   *   The token replacement event.
   *
   * @throws \UnexpectedValueException
   */
  public function tokenReplacement(TokensReplacementEvent $event): void {
    if ($event->forToken('node', 'serialized')) {
      $event->setReplacementValue('node', 'serialized',
        serialize($event->getData('node')));
    }
  }

}
