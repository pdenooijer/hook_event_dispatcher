<?php

namespace Drupal\hook_event_dispatcher\Example;

use Drupal\preprocess_event_dispatcher\Event\BlockPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\PagePreprocessEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ExamplePreprocessorEventSubscriber.
 */
final class ExamplePreprocessorEventSubscriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
    return [
      PagePreprocessEvent::name() => 'preprocessPage',
      BlockPreprocessEvent::name() => 'preprocessBlock',
    ];
  }

  /**
   * Preprocess a node page to set the node title as page title.
   *
   * @param \Drupal\preprocess_event_dispatcher\Event\PagePreprocessEvent $event
   *   Event.
   */
  public function preprocessPage(PagePreprocessEvent $event): void {
    /* @var \Drupal\preprocess_event_dispatcher\Variables\PageEventVariables $variables */
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
    /* @var \Drupal\preprocess_event_dispatcher\Variables\BlockEventVariables $variables */
    $variables = $event->getVariables();

    if ($variables->get('field_contact_form') === NULL) {
      return;
    }

    $variables->getByReference('attributes')['id'] = 'contact-form-wrapper';
  }

}
