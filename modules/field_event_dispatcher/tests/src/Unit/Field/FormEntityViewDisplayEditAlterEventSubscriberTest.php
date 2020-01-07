<?php

namespace Drupal\Tests\field_event_dispatcher\Unit\Field;

use Drupal;
use Drupal\Component\Utility\NestedArray;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Form\FormStateInterface;
use Drupal\core_event_dispatcher\Event\Form\FormIdAlterEvent;
use Drupal\field_event_dispatcher\EventSubscriber\Form\FormEntityViewDisplayEditAlterEventSubscriber;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\Tests\UnitTestCase;

/**
 * Class FormEntityViewDisplayEditAlterEventSubscriberTest.
 *
 * @group field_event_dispatcher
 */
class FormEntityViewDisplayEditAlterEventSubscriberTest extends UnitTestCase {

  /**
   * The manager.
   *
   * @var \Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy
   */
  private $manager;

  /**
   * The form ID we're testing.
   *
   * @var string
   */
  private $formId = 'entity_view_display_edit_form';

  /**
   * Sets up the test.
   */
  public function setUp(): void {
    $builder = new ContainerBuilder();
    $this->manager = new HookEventDispatcherManagerSpy();
    $builder->set('hook_event_dispatcher.manager', $this->manager);
    $builder->compile();
    Drupal::setContainer($builder);
  }

  /**
   * Get a basic test form.
   *
   * The required structure for the $fields parameter array is:
   * @code
   *  'field_test1' => ['test_module' => ['test']],
   *  'field_test2' => ['test_module' => ['test']],
   * @endcode
   *
   * @param array $fields
   *   An array containing zero or more fields and their third-party settings to
   *   create and return as a form.
   *
   * @return array
   *   A basic form array with the field structure in $fields added.
   */
  private function getTestForm(array $fields): array {
    $form = [
      '#fields' => [],
    ];

    foreach ($fields as $fieldName => $thirdPartySettings) {
      $form['#fields'][] = $fieldName;

      $form['fields'][$fieldName]['plugin']['settings_edit_form']['third_party_settings']['field_event_dispatcher'] = $thirdPartySettings;
    }

    return $form;
  }

  /**
   * Alter both $form and $expectedForm for a test.
   *
   * @param array &$form
   *   This is the form array to be passed to
   *   FormEntityViewDisplayEditAlterEventSubscriber for it to alter.
   * @param array &$expectedForm
   *   This is a duplicate of $form that is altered here in this method to match
   *   the expected changes FormEntityViewDisplayEditAlterEventSubscriber
   *   performs on $form.
   *
   * @see \Drupal\field_event_dispatcher\EventSubscriber\Form\FormEntityViewDisplayEditAlterEventSubscriber::formAlter()
   */
  private function alterForm(array &$form, array &$expectedForm): void {
    $eventSubscriber = new FormEntityViewDisplayEditAlterEventSubscriber();
    $formState = $this->createMock(FormStateInterface::class);
    $event = new FormIdAlterEvent($form, $formState, $this->formId);

    $eventSubscriber->formAlter($event);

    foreach ($expectedForm['#fields'] as $fieldName) {
      // Skip any fields that have no field_event_dispatcher third-party
      // settings.
      if (!isset($expectedForm['fields'][$fieldName]['plugin']['settings_edit_form']['third_party_settings']['field_event_dispatcher'])) {
        continue;
      }

      $thirdPartySettings = &$expectedForm['fields'][$fieldName]['plugin']['settings_edit_form']['third_party_settings'];

      $thirdPartySettings = NestedArray::mergeDeep(
        $thirdPartySettings,
        $thirdPartySettings['field_event_dispatcher']
      );

      unset($thirdPartySettings['field_event_dispatcher']);
    }

    $form = $event->getForm();
  }

  /**
   * FormEntityViewDisplayEditAlterEventSubscriber test with no fields.
   *
   * This tests that FormEntityViewDisplayEditAlterEventSubscriber::formAlter()
   * handles forms with no fields it can alter correctly.
   */
  public function testFormAlterNoFields(): void {
    $form = $this->getTestForm([]);

    $expectedForm = $form;

    $this->alterForm($form, $expectedForm);

    $this->assertSame($expectedForm, $form);
  }

  /**
   * FormEntityViewDisplayEditAlterEventSubscriber test with one field.
   *
   * This tests that FormEntityViewDisplayEditAlterEventSubscriber::formAlter()
   * alters the $form array as expected when one field is provided.
   */
  public function testFormAlterOneField(): void {
    $form = $this->getTestForm(['field_test' => ['test_module' => ['test']]]);

    $expectedForm = $form;

    $this->alterForm($form, $expectedForm);

    $this->assertSame($expectedForm, $form);
  }

  /**
   * FormEntityViewDisplayEditAlterEventSubscriber test with two fields.
   *
   * This tests that FormEntityViewDisplayEditAlterEventSubscriber::formAlter()
   * alters the $form array as expected when two fields are provided.
   */
  public function testFormAlterTwoFields(): void {
    $form = $this->getTestForm([
      'field_test1' => ['test_module' => ['test']],
      'field_test2' => ['test_module' => ['test']],
    ]);

    $expectedForm = $form;

    $this->alterForm($form, $expectedForm);

    $this->assertSame($expectedForm, $form);
  }

  /**
   * FormEntityViewDisplayEditAlterEventSubscriber test with multiple merges.
   *
   * This tests that FormEntityViewDisplayEditAlterEventSubscriber::formAlter()
   * alters the $form array as expected when a field has third-party settings
   * merged in more than once.
   */
  public function testFormAlterMultipleMerges(): void {
    $form = $this->getTestForm(['field_test' => ['test_module1' => ['test']]]);

    $expectedForm = $form;

    // First merge.
    $this->alterForm($form, $expectedForm);

    $form = NestedArray::mergeDeep(
      $form,
      $this->getTestForm(['field_test' => ['test_module2' => ['test']]])
    );

    $expectedForm = $form;

    // Second merge.
    $this->alterForm($form, $expectedForm);

    $this->assertSame($expectedForm, $form);
  }

}
