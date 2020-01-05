<?php

namespace Drupal\core_event_dispatcher\Event\Form;

use Drupal\Core\Form\FormStateInterface;

/**
 * Class FormBaserAlterEvent.
 */
class FormBaseAlterEvent extends AbstractFormEvent {

  /**
   * The base form id.
   *
   * @var string
   */
  private $baseFormId;

  /**
   * FormBaseAlterEvent constructor.
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
   * @param string $baseFormId
   *   The base form id.
   */
  public function __construct(
    array &$form,
    FormStateInterface $formState,
    string $formId,
    string $baseFormId
  ) {
    parent::__construct($form, $formState, $formId);
    $this->baseFormId = $baseFormId;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    return 'hook_event_dispatcher.form_base_' . $this->getBaseFormId() . '.alter';
  }

  /**
   * Get the base form id.
   *
   * @return string
   *   The base form id.
   */
  public function getBaseFormId(): string {
    return $this->baseFormId;
  }

}
