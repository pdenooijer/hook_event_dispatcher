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
    /** @var \Drupal\Core\Field\FieldDefinitionInterface $field_definition */
    $context = $this->getContext();
    $field_definition = $context['items']->getFieldDefinition();
    return 'hook_event_dispatcher.widget_' . $field_definition->getType() . '.alter';
  }

}
