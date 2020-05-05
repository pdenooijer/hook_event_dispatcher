<?php

namespace Drupal\field_event_dispatcher\Event\Field;

use Drupal\Component\Utility\NestedArray;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\hook_event_dispatcher\Event\EventInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class AbstractFieldThirdPartySettingsFormEvent.
 */
abstract class AbstractFieldThirdPartySettingsFormEvent extends Event implements EventInterface {

  /**
   * The field definition.
   *
   * @var \Drupal\Core\Field\FieldDefinitionInterface
   */
  protected $fieldDefinition;

  /**
   * The (entire) configuration form array.
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
   * Third-party form elements to be added to the form.
   *
   * @var array
   */
  protected $elements = [];

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
        $moduleName => $newElements,
      ]
    );
  }

}
