<?php

namespace Drupal\hook_event_dispatcher\Event\Form;


use Drupal\Core\Form\FormStateInterface;
use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherEvents;
use Symfony\Component\EventDispatcher\Event;

class WidgetFormAlterEvent extends Event implements EventInterface {

  protected $element;
  protected $formState;
  protected $context;

  /**
   * WidgetFormAlterEvent constructor.
   * @param array $element
   * @param \Drupal\Core\Form\FormStateInterface $formState
   * @param array $context
   */
  public function __construct(array $element, FormStateInterface $formState, array $context) {
    $this->element = $element;
    $this->formState = $formState;
    $this->context = $context;
  }

  /**
   * @return array
   */
  public function getElement() {
    return $this->element;
  }

  /**
   * @param array $element
   */
  public function setElement($element) {
    $this->element = $element;
  }

  /**
   * @return \Drupal\Core\Form\FormStateInterface
   */
  public function getFormState() {
    return $this->formState;
  }

  /**
   * @return array
   */
  public function getContext() {
    return $this->context;
  }

  /**
   * @inheritdoc
   */
  public function getDispatcherType() {
    return HookEventDispatcherEvents::WIDGET_FORM_ALTER;
  }

}