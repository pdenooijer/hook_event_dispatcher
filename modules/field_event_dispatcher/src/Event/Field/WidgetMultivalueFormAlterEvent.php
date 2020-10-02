<?php

namespace Drupal\field_event_dispatcher\Event\Field;

use Drupal\Core\Form\FormStateInterface;
use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class WidgetMultivalueFormAlterEvent.
 */
class WidgetMultivalueFormAlterEvent extends Event implements EventInterface {

  /**
   * The field widget form elements.
   *
   * @var array
   */
  private $elements;

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
   * WidgetMultivalueFormAlterEvent constructor.
   *
   * @param array $elements
   *   The field widget form elements as constructed by
   *   \Drupal\Core\Field\WidgetBase::formMultipleElements().
   * @param \Drupal\Core\Form\FormStateInterface $formState
   *   The current state of the form.
   * @param array $context
   *   An associative array containing the following key-value pairs:
   *   - form: The form structure to which widgets are being attached. This may
   *     be a full form structure, or a sub-element of a larger form.
   *   - widget: The widget plugin instance.
   *   - items: The field values, as a
   *     \Drupal\Core\Field\FieldItemListInterface object.
   *   - default: A boolean indicating whether the form is being shown as a
   *     dummy form to set default values.
   */
  public function __construct(array &$elements, FormStateInterface $formState, array $context) {
    $this->elements = &$elements;
    $this->formState = $formState;
    $this->context = $context;
  }

  /**
   * Get the elements.
   *
   * @return array
   *   The elements.
   */
  public function &getElements() {
    return $this->elements;
  }

  /**
   * Get the form state.
   *
   * @return \Drupal\Core\Form\FormStateInterface
   *   The form state.
   */
  public function getFormState() {
    return $this->formState;
  }

  /**
   * Get the context.
   *
   * @return array
   *   The context.
   */
  public function getContext() {
    return $this->context;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::WIDGET_MULTIVALUE_FORM_ALTER;
  }

}
