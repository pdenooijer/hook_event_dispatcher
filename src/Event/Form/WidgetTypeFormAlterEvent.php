<?php

namespace Drupal\hook_event_dispatcher\Event\Form;

/**
 * Class WidgetTypeFormAlterEvent.
 *
 * @package Drupal\hook_event_dispatcher\Event\Form
 */
class WidgetTypeFormAlterEvent extends WidgetFormAlterEvent {

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType() {
    /* @var \Drupal\Core\Field\FieldItemListInterface $items */
    $items = $this->getContext()['items'];
    $fieldDefinition = $items->getFieldDefinition();
    return 'hook_event_dispatcher.widget_' . $fieldDefinition->getType() . '.alter';
  }

}
