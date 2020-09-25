<?php

namespace Drupal\hook_event_dispatcher;

use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\core_event_dispatcher\Event\Token\TokensInfoEvent;
use Drupal\core_event_dispatcher\Event\Token\TokensReplacementEvent;
use Drupal\core_event_dispatcher\ValueObject\Token;
use Drupal\core_event_dispatcher\ValueObject\TokenType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ExampleTokenEventSubscriber.
 *
 * Don't forget to define your class as a service and tag it as
 * an "event_subscriber":
 *
 * services:
 *  hook_event_dispatcher.example_token_subscribers:
 *   class: Drupal\hook_event_dispatcher\ExampleTokenEventSubscribers
 *   tags:
 *     - { name: event_subscriber }
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
    $type = TokenType::create('node', 'Node')
      ->setDescription('Node tokens')
      ->setNeedsData('node');
    $event->addTokenType($type);

    // Add node token.
    $name = new TranslatableMarkup('Serialized string of the node');
    $token = Token::create('node', 'serialized', $name)->setDescription('Node serialized');
    $event->addToken($token);
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
