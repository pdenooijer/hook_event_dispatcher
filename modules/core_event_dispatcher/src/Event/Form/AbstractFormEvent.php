<?php

namespace Drupal\core_event_dispatcher\Event\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\hook_event_dispatcher\Event\EventInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class AbstractFormEvent.
 */
abstract class AbstractFormEvent extends Event implements EventInterface {

  /**
   * The form.
   *
   * @var array
   */
  private $form;
  /**
   * The form state.
   *
   * @var \Drupal\Core\Form\FormStateInterface
   */
  private $formState;
  /**
   * The form id.
   *
   * @var string
   */
  private $formId;

  /**
   * AbstractFormEvent constructor.
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
  public function __construct(array &$form, FormStateInterface $formState, string $formId) {
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
  public function &getForm(): array {
    return $this->form;
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
   * Get the form id.
   *
   * @return string
   *   The form id.
   */
  public function getFormId(): string {
    return $this->formId;
  }

}
