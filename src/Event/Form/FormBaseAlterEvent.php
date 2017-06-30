<?php

namespace Drupal\hook_event_dispatcher\Event\Form;

use Drupal\Core\Form\FormStateInterface;

/**
 * Class FormBaserAlterEvent.
 *
 * @package Drupal\hook_event_dispatcher\Event\Form
 */
class FormBaseAlterEvent extends BaseFormEvent {

  /**
   * The base form id.
   *
   * @var string
   */
  protected $baseFormId;

  /**
   * FormBaseAlterEvent constructor.
   *
   * @param array $form
   *   Nested array of form elements that comprise the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form. The arguments that
   *   \Drupal::formBuilder()->getForm() was originally called with are
   *   available in the array $form_state->getBuildInfo()['args'].
   * @param string $form_id
   *   String representing the name of the form itself. Typically this is the
   *   name of the function that generated the form.
   * @param string $base_form_id
   *   The base form id.
   */
  public function __construct(array &$form, FormStateInterface $form_state, $form_id, $base_form_id) {
    parent::__construct($form, $form_state, $form_id);
    $this->baseFormId = $base_form_id;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType() {
    return 'hook_event_dispatcher.form_base_' . $this->getBaseFormId() . '.alter';
  }

  /**
   * Get the base form id.
   *
   * @return string
   *   The base form id.
   */
  public function getBaseFormId() {
    return $this->baseFormId;
  }

}
