<?php

namespace Drupal\core_event_dispatcher\Event\Form;

use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;

/**
 * Class FormAlterEvent.
 */
class FormAlterEvent extends AbstractFormEvent {

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::FORM_ALTER;
  }

}
