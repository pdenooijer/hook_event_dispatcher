<?php

namespace Drupal\webform_event_dispatcher\Event\WebformElement;

/**
 * Class WebformElementTypeAlterEvent.
 *
 * @package Drupal\webform_event_dispatcher\Event\Element
 */
class WebformElementTypeAlterEvent extends WebformElementAlterEvent {

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType() {
    $type = $this->getElementType();
    return 'hook_event_dispatcher.webform.element_' . $type . '.alter';
  }

}
