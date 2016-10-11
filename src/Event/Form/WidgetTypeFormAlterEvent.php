<?php

namespace Drupal\hook_event_dispatcher\Event\Form;


use Drupal\Core\Form\FormStateInterface;
use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherEvents;

class WidgetTypeFormAlterEvent extends WidgetFormAlterEvent {

  /**
   * @inheritdoc
   */
  public function getDispatcherType() {
    /** @var \Drupal\Core\Field\FieldDefinitionInterface $field_definition */
    $context = $this->getContext();
    $field_definition = $context['items']->getFieldDefinition();
    return 'hook_event_dispatcher.widget_' . $field_definition->getType() . '.alter';
  }

}