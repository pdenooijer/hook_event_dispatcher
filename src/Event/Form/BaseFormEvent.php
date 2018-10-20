<?php

namespace Drupal\hook_event_dispatcher\Event\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\hook_event_dispatcher\Event\EventInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class BaseFormEvent.
 */
abstract class BaseFormEvent extends Event implements EventInterface {

  /**
   * The form.
   *
   * @var array
   */
  protected $form;
  /**
   * The form state.
   *
   * @var \Drupal\Core\Form\FormStateInterface
   */
  protected $formState;
  /**
   * The form id.
   *
   * @var string
   */
  protected $formId;

  /**
   * BaseFormEvent constructor.
   *
   * @param array $form
   *   Nested array of form elements that comprise the form.
   * @param \Drupal\Core\Form\FormStateInterface $formState
   *   The current state of the form. The arguments that
   *   \Drupal::formBuilder()->getForm() was originally called with are
   *   available in the array $form_state->getBuildInfo()['args'].
   * @param string $formId
   *   String representing the name of the form itself. Typically this is the
   *   name of the function that generated the form.
   */
  public function __construct(array &$form, FormStateInterface $formState, $formId) {
    $this->form = &$form;
    $this->formState = $formState;
    $this->formId = $formId;
  }

  /**
   * Get the form.
   *
   * @return array
   *   The form.
   */
  public function &getForm() {
    return $this->form;
  }

  /**
   * Set the form.
   *
   * @param array $form
   *   The form.
   *
   * @deprecated This is not needed, the form is passed by reference.
   */
  public function setForm(array $form) {
    $this->form = $form;
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
   * Get the form id.
   *
   * @return string
   *   The form id.
   */
  public function getFormId() {
    return $this->formId;
  }

}
