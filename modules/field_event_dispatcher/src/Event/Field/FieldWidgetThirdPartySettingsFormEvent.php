<?php

namespace Drupal\field_event_dispatcher\Event\Field;

use Drupal\Component\Utility\NestedArray;
use Drupal\Core\Field\WidgetInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class FieldWidgetThirdPartySettingsFormEvent.
 */
class FieldWidgetThirdPartySettingsFormEvent extends Event implements EventInterface {

  /**
   * The instantiated field widget plugin.
   *
   * @var \Drupal\Core\Field\WidgetInterface
   */
  private $plugin;

  /**
   * The field definition.
   *
   * @var \Drupal\Core\Field\FieldDefinitionInterface
   */
  private $fieldDefinition;

  /**
   * The entity form mode.
   *
   * @var string
   */
  private $formMode;

  /**
   * The (entire) configuration form array.
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
   * Third-party form elements to be added to the form.
   *
   * @var array
   */
  private $elements = [];

  /**
   * FieldWidgetThirdPartySettingsFormEvent constructor.
   *
   * @param \Drupal\Core\Field\WidgetInterface $plugin
   *   The instantiated field widget plugin.
   * @param \Drupal\Core\Field\FieldDefinitionInterface $fieldDefinition
   *   The field definition.
   * @param string $formMode
   *   The entity form mode.
   * @param array $form
   *   The (entire) configuration form array.
   * @param \Drupal\Core\Form\FormStateInterface $formState
   *   The form state.
   */
  public function __construct(
    WidgetInterface $plugin,
    FieldDefinitionInterface $fieldDefinition,
    string $formMode,
    array $form,
    FormStateInterface $formState
  ) {
    $this->plugin = $plugin;
    $this->fieldDefinition = $fieldDefinition;
    $this->formMode = $formMode;
    $this->form = $form;
    $this->formState = $formState;
  }

  /**
   * Get the instantiated field widget plugin.
   *
   * @return \Drupal\Core\Field\WidgetInterface
   *   A field widget plugin.
   */
  public function getPlugin(): WidgetInterface {
    return $this->plugin;
  }

  /**
   * Get the field definition.
   *
   * @return \Drupal\Core\Field\FieldDefinitionInterface
   *   The field definition.
   */
  public function getFieldDefintion(): FieldDefinitionInterface {
    return $this->fieldDefinition;
  }

  /**
   * Get the entity form mode.
   *
   * @return string
   *   The form mode.
   */
  public function getFormMode(): string {
    return $this->formMode;
  }

  /**
   * Get the (entire) configuration form array.
   *
   * @return array
   *   The entire form array.
   */
  public function getForm(): array {
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
   * Get the third-party form elements to be added to the form.
   *
   * @return array
   *   All third-party form elements that are to be added to this form.
   */
  public function getElements(): array {
    return $this->elements;
  }

  /**
   * Add third-party form elements to the form.
   *
   * @param string $moduleName
   *   The machine name of the module to add the third-party form elements for.
   * @param array $newElements
   *   An array containing the third-party form elements to add.
   *
   * @see \Drupal\field_event_dispatcher\EventSubscriber\Form\FormEntityViewDisplayEditAlterEventSubscriber::formAlter()
   *   Alters the form structure so that each module's third-party form elements
   *   are correctly nested only under their module machine names.
   */
  public function addElements(string $moduleName, array $newElements): void {
    $this->elements = NestedArray::mergeDeep(
      $this->elements,
      [
        // Nest the new elements under the module's machine name for our form
        // alter event subscriber.
        $moduleName => $newElements
      ]
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::FIELD_WIDGET_THIRD_PARTY_SETTINGS_FORM;
  }

}
