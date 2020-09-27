<?php

namespace Drupal\hook_event_dispatcher;

use Drupal\preprocess_event_dispatcher\Event\BlockPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\NodePreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\PagePreprocessEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ExamplePreprocessorEventSubscriber.
 *
 * Don't forget to define your class as a service and tag it as
 * an "event_subscriber":
 *
 * services:
 *  hook_event_dispatcher.example_preprocess_subscribers:
 *   class: Drupal\hook_event_dispatcher\ExamplePreprocessEventSubscribers
 *   tags:
 *     - { name: event_subscriber }
 */
final class ExamplePreprocessEventSubscriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
    return [
      NodePreprocessEvent::name('article', 'full') => 'preprocessArticleFull',
      PagePreprocessEvent::name() => 'preprocessPage',
      BlockPreprocessEvent::name() => 'preprocessBlock',
    ];
  }

  /**
   * Preprocess a node with bundle type article in view mode full.
   *
   * @param \Drupal\preprocess_event_dispatcher\Event\NodePreprocessEvent $event
   *   Event.
   */
  public function preprocessArticleFull(NodePreprocessEvent $event): void {
    /** @var \Drupal\preprocess_event_dispatcher\Variables\NodeEventVariables $variables */
    $variables = $event->getVariables();
    $node = $variables->getNode();
    $someField = $node->get('field_some_field')->view();
    $variables->set('some_field', $someField);
  }

  /**
   * Preprocess a node page to set the node title as page title.
   *
   * @param \Drupal\preprocess_event_dispatcher\Event\PagePreprocessEvent $event
   *   Event.
   */
  public function preprocessPage(PagePreprocessEvent $event): void {
    /** @var \Drupal\preprocess_event_dispatcher\Variables\PageEventVariables $variables */
    $variables = $event->getVariables();
    $node = $variables->getNode();

    if ($node === NULL) {
      return;
    }

    $variables->set('title', $node->getTitle());
  }

  /**
   * Preprocess blocks with field_contact_form and add contact-form-wrapper id.
   *
   * @param \Drupal\preprocess_event_dispatcher\Event\BlockPreprocessEvent $event
   *   Event.
   */
  public function preprocessBlock(BlockPreprocessEvent $event): void {
    /** @var \Drupal\preprocess_event_dispatcher\Variables\BlockEventVariables $variables */
    $variables = $event->getVariables();

    if ($variables->get('field_contact_form') === NULL) {
      return;
    }

    $variables->getByReference('attributes')['id'] = 'contact-form-wrapper';
  }

}
