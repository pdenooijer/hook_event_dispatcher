<?php

namespace Drupal\webform_event_dispatcher\Event\WebformElement;

use Drupal\Core\Form\FormStateInterface;
use Drupal\hook_event_dispatcher\Event\EventInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class WebformElementAlterEvent.
 *
 * @package Drupal\webform_event_dispatcher\Event\Element
 */
class WebformElementAlterEvent extends Event implements EventInterface {

  /**
   * The webform element.
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
   * WebformElementAlterEvent constructor.
   *
   * @param array $element
   *   The webform element.
   * @param \Drupal\Core\Form\FormStateInterface $formState
   *   The current state of the form.
   * @param array $context
   *   An associative array containing the following key-value pairs:
   *   - form: The form structure to which elements is being attached.
   */
  public function __construct(array &$element, FormStateInterface $formState, array $context) {
    $this->element = &$element;
    $this->formState = $formState;
    $this->context = $context;
  }

  /**
   * Get the webform element.
   *
   * @return array
   *   The element.
   */
  public function &getElement() {
    return $this->element;
  }

  /**
   * Get the webform element type.
   *
   * @return string
   *   The webform element type.
   */
  public function getElementType() {
    return $this->getElement()['#type'];
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
  public function getDispatcherType() {
    return 'hook_event_dispatcher.webform.element.alter';
  }

}
