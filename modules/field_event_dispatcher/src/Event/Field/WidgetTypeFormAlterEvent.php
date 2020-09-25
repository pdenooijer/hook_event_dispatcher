<?php

namespace Drupal\field_event_dispatcher\Event\Field;

/**
 * Class WidgetTypeFormAlterEvent.
 */
class WidgetTypeFormAlterEvent extends WidgetFormAlterEvent {

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    /** @var \Drupal\Core\Field\FieldItemListInterface $items */
    $items = $this->getContext()['items'];
    $fieldDefinition = $items->getFieldDefinition();
    return 'hook_event_dispatcher.widget_' . $fieldDefinition->getType() . '.alter';
  }

}
