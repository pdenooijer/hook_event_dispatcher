<?php

namespace Drupal\hook_event_dispatcher\Example;

use Drupal\hook_event_dispatcher\Event\Token\TokensInfoEvent;
use Drupal\hook_event_dispatcher\Event\Token\TokensReplacementEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\hook_event_dispatcher\Value\Token;
use Drupal\hook_event_dispatcher\Value\TokenType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ExampleTokenEventSubscriber.
 */
final class ExampleTokenEventSubscriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      HookEventDispatcherInterface::TOKEN_REPLACEMENT => 'tokenReplacement',
      HookEventDispatcherInterface::TOKEN_INFO => 'tokenInfo',
    ];
  }

  /**
   * Provides new token types and tokens.
   *
   * @param \Drupal\hook_event_dispatcher\Event\Token\TokensInfoEvent $event
   *   The token info event.
   */
  public function tokenInfo(TokensInfoEvent $event) {
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
   * @param \Drupal\hook_event_dispatcher\Event\Token\TokensReplacementEvent $event
   *   The token replacement event.
   */
  public function tokenReplacement(TokensReplacementEvent $event) {
    if ($event->forToken('node', 'serialized')) {
      $event->setReplacementValue('node', 'serialized',
        serialize($event->getData('node')));
    }
  }

}
