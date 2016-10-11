<?php

namespace Drupal\hook_event_dispatcher\Event\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\hook_event_dispatcher\Event\EventInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class BaseFormEvent
 * @package Drupal\hook_event_dispatcher\Event\Form
 */
abstract class BaseFormEvent extends Event implements EventInterface {

  protected $form;
  protected $formState;
  protected $formId;

  /**
   * BaseFormEvent constructor.
   * @param array $form
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   * @param $form_id
   */
  public function __construct(array $form, FormStateInterface $form_state, $form_id) {
    $this->form = $form;
    $this->formState = $form_state;
    $this->formId = $form_id;
  }

  /**
   * @return array
   */
  public function getForm() {
    return $this->form;
  }

  /**
   * @param array $form
   */
  public function setForm($form) {
    $this->form = $form;
  }

  /**
   * @return \Drupal\Core\Form\FormStateInterface
   */
  public function getFormState() {
    return $this->formState;
  }

  /**
   * @return mixed
   */
  public function getFormId() {
    return $this->formId;
  }
}