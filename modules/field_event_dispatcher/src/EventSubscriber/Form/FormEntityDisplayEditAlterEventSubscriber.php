<?php

namespace Drupal\field_event_dispatcher\EventSubscriber\Form;

use Drupal\Component\Utility\NestedArray;
use Drupal\core_event_dispatcher\Event\Form\FormIdAlterEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event subscriber for 'entity_(view/form)_display_edit_form' form alters.
 */
class FormEntityDisplayEditAlterEventSubscriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
    return [
      'hook_event_dispatcher.form_entity_view_display_edit_form.alter' => 'formAlter',
      'hook_event_dispatcher.form_entity_form_display_edit_form.alter' => 'formAlter',
    ];
  }

  /**
   * Alter the entity edit form third-party elements structure.
   *
   * This works around the problem that Drupal core nests each invokation of
   * 'field_formatter_third_party_settings_form' and
   * 'field_widget_third_party_settings_form' under the machine name of the
   * module that implements it, which would be the name of this module and not
   * the modules that subscribe to our event.
   *
   * @param \Drupal\core_event_dispatcher\Event\Form\FormIdAlterEvent $event
   *   The event object.
   *
   * @see \Drupal\field_ui\Form\EntityViewDisplayEditForm::thirdPartySettingsForm()
   *   This is where Drupal core nests each invokation of
   *   'field_formatter_third_party_settings_form' under the machine name
   *   of the module that implements it.
   *
   * @see \Drupal\field_ui\Form\EntityFormDisplayEditForm::thirdPartySettingsForm()
   *   This is where Drupal core nests each invokation of
   *   'field_widget_third_party_settings_form' under the machine name of
   *   the module that implements it.
   *
   * @see \Drupal\field_event_dispatcher\Event\Field\AbstractFieldThirdPartySettingsFormEvent::addElements()
   *   This is where event subscribers add their third-party form elements.
   */
  public function formAlter(FormIdAlterEvent $event): void {
    $form = &$event->getForm();

    // $form['#fields'] lists all field name keys on this entity.
    foreach ($form['#fields'] as $fieldName) {
      // Skip any fields that have no field_event_dispatcher third-party
      // settings.
      if (!isset($form['fields'][$fieldName]['plugin']['settings_edit_form']['third_party_settings']['field_event_dispatcher'])) {
        continue;
      }

      $thirdPartySettings = &$form['fields'][$fieldName]['plugin']['settings_edit_form']['third_party_settings'];

      $thirdPartySettings = NestedArray::mergeDeep(
        $thirdPartySettings,
        $thirdPartySettings['field_event_dispatcher']
      );

      unset($thirdPartySettings['field_event_dispatcher']);
    }
  }

}
