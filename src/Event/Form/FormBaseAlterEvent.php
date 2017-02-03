<?php

namespace Drupal\hook_event_dispatcher\Event\Form;

use Drupal\Core\Form\FormStateInterface;

/**
 * Class FormBaserAlterEvent
 * @package Drupal\hook_event_dispatcher\Event\Form
 */
class FormBaseAlterEvent extends BaseFormEvent {

  protected $baseFormId;

  /**
   * FormBaseAlterEvent constructor.
   * @param array $form
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   * @param $form_id
   * @param $base_form_id
   */
  public function __construct(array $form, FormStateInterface $form_state, $form_id, $base_form_id) {
    parent::__construct($form, $form_state, $form_id);
    $this->baseFormId = $base_form_id;
  }

  /**
   * @inheritdoc
   */
  public function getDispatcherType() {
    return 'hook_event_dispatcher.form_base_' . $this->getBaseFormId() . '.alter';
  }

  /**
   * @return mixed
   */
  public function getBaseFormId() {
    return $this->baseFormId;
  }



}