<?php

namespace Drupal\core_event_dispatcher\Event\Form;

/**
 * Class FormIdAlterEvent.
 */
class FormIdAlterEvent extends AbstractFormEvent {

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    return 'hook_event_dispatcher.form_' . $this->getFormId() . '.alter';
  }

}
