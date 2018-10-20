<?php

namespace Drupal\ib_references\EventSubscriber;

use Drupal\hook_event_dispatcher\Event\Preprocess\BlockPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\PagePreprocessEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ExamplePreprocessorEventSubscriber.
 */
final class ExamplePreprocessorEventSubscriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      PagePreprocessEvent::name() => 'preprocessPage',
      BlockPreprocessEvent::name() => 'preprocessBlock',
    ];
  }

  /**
   * Preprocess a node page to set the node title as page title.
   *
   * @param \Drupal\hook_event_dispatcher\Event\Preprocess\PagePreprocessEvent $event
   *   Event.
   */
  public function preprocessPage(PagePreprocessEvent $event) {
    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\PageEventVariables $variables */
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
   * @param \Drupal\hook_event_dispatcher\Event\Preprocess\BlockPreprocessEvent $event
   *   Event.
   */
  public function preprocessBlock(BlockPreprocessEvent $event) {
    /* @var \Drupal\hook_event_dispatcher\Event\Preprocess\Variables\BlockEventVariables $variables */
    $variables = $event->getVariables();

    if ($variables->get('field_contact_form') === NULL) {
      return;
    }

    $variables->getByReference('attributes')['id'] = 'contact-form-wrapper';
  }

}
