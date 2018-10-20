<?php

namespace Drupal\hook_event_dispatcher\Event\Form;

use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;

/**
 * Class FormAlterEvent.
 */
class FormAlterEvent extends BaseFormEvent {

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType() {
    return HookEventDispatcherInterface::FORM_ALTER;
  }

}
