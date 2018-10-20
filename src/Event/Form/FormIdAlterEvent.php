<?php

namespace Drupal\hook_event_dispatcher\Event\Form;

/**
 * Class FormIdAlterEvent.
 */
class FormIdAlterEvent extends BaseFormEvent {

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType() {
    return 'hook_event_dispatcher.form_' . $this->getFormId() . '.alter';
  }

}
