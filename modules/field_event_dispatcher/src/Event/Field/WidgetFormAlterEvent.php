<?php

namespace Drupal\field_event_dispatcher\Event\Field;

use Drupal\Core\Form\FormStateInterface;
use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class WidgetFormAlterEvent.
 */
class WidgetFormAlterEvent extends Event implements EventInterface {

  /**
   * The field widget form element.
   *
   * @var array
   */
  private $element;
  /**
   * The form state.
   *
   * @var \Drupal\Core\Form\FormStateInterface
   */
  private $formState;
  /**
   * The context.
   *
   * @var array
   */
  private $context;

  /**
   * WidgetFormAlterEvent constructor.
   *
   * @param array $element
   *   The field widget form element as constructed by hook_field_widget_form().
   * @param \Drupal\Core\Form\FormStateInterface $formState
   *   The current state of the form.
   * @param array $context
   *   An associative array containing the following key-value pairs:
   *   - form: The form structure to which widgets are being attached. This may
   *     be a full form structure, or a sub-element of a larger form.
   *   - widget: The widget plugin instance.
   *   - items: The field values, as a
   *     \Drupal\Core\Field\FieldItemListInterface object.
   *   - delta: The order of this item in the array of subelements (0, 1, etc).
   *   - default: A boolean indicating whether the form is being shown as a
   *     dummy form to set default values.
   */
  public function __construct(array &$element, FormStateInterface $formState, array $context) {
    $this->element = &$element;
    $this->formState = $formState;
    $this->context = $context;
  }

  /**
   * Get the element.
   *
   * @return array
   *   The element.
   */
  public function &getElement(): array {
    return $this->element;
  }

  /**
   * Get the form state.
   *
   * @return \Drupal\Core\Form\FormStateInterface
   *   The form state.
   */
  public function getFormState(): FormStateInterface {
    return $this->formState;
  }

  /**
   * Get the context.
   *
   * @return array
   *   The context.
   */
  public function getContext(): array {
    return $this->context;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::WIDGET_FORM_ALTER;
  }

}
