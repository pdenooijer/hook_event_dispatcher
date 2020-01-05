<?php

namespace Drupal\webform_event_dispatcher\Event\WebformElement;

/**
 * Class WebformElementTypeAlterEvent.
 */
class WebformElementTypeAlterEvent extends WebformElementAlterEvent {

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    $type = $this->getElementType();
    return 'hook_event_dispatcher.webform.element_' . $type . '.alter';
  }

}
