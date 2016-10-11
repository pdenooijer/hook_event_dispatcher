<?php

namespace Drupal\hook_event_dispatcher\Event\Form;

use Drupal\hook_event_dispatcher\HookEventDispatcherEvents;

/**
 * Class FormAlterEvent
 * @package Drupal\hook_event_dispatcher\Event\Form
 */
class FormAlterEvent extends BaseFormEvent {

  /**
   * @inheritdoc
   */
  public function getDispatcherType() {
    return HookEventDispatcherEvents::FORM_ALTER;
  }

}