<?php

namespace Drupal\Tests\field_event_dispatcher\Unit\Field;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\BasicStringFormatter;
use Drupal\Core\Form\FormState;
use Drupal\field_event_dispatcher\Event\Field\FieldFormatterThirdPartySettingsFormEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use PHPUnit\Framework\TestCase;
use function field_event_dispatcher_field_formatter_third_party_settings_form;

/**
 * Class FieldFormatterThirdPartySettingsFormEventTest.
 *
 * @group field_event_dispatcher
 */
class FieldFormatterThirdPartySettingsFormEventTest extends TestCase {

  /**
   * The manager.
   *
   * @var \Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy
   */
  private $manager;

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
   * FieldFormatterThirdPartySettingsFormEvent get method return type test.
   *
   * This tests that the various methods for getting event properties return
   * correct types. We don't actually have to do the comparisons ourselves,
   * because all the methods have explicit return types defined so PHP will
   * throw an exception if there's a mismatch when we call them.
   */
  public function testGetMethodReturnTypes(): void {
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::FIELD_FORMATTER_THIRD_PARTY_SETTINGS_FORM => static function (
        FieldFormatterThirdPartySettingsFormEvent $event
      ) {
        $event->getPlugin();
        $event->getFieldDefintion();
        $event->getViewMode();
        $event->getForm();
        $event->getFormState();
        $event->getElements();
      },
    ]);

    $testFieldDefinition = new BaseFieldDefinition();

    $testPlugin = new BasicStringFormatter(
      'test_formatter', [], $testFieldDefinition, [], 'label', 'view_mode', []
    );

    $testFormState = new FormState();

    // Run the procedural hook which should trigger the above handler.
    field_event_dispatcher_field_formatter_third_party_settings_form(
      $testPlugin, $testFieldDefinition, 'view_mode', [], $testFormState
    );

    // So that PHPUnit doesn't mark this as a "risky test" because of no
    // assertions.
    self::assertTrue(TRUE);
  }

  /**
   * FieldFormatterThirdPartySettingsFormEvent adding elements test.
   *
   * This tests adding third-party form elements.
   */
  public function testAddingElements(): void {
    $elements = $expectedElements = [];

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::FIELD_FORMATTER_THIRD_PARTY_SETTINGS_FORM => static function (
        FieldFormatterThirdPartySettingsFormEvent $event
      ) {
        $event->addElements('test_module', [
          'test' => [],
        ]);
      },
    ]);

    $testFieldDefinition = new BaseFieldDefinition();

    $testPlugin = new BasicStringFormatter(
      'test_formatter', [], $testFieldDefinition, [], 'label', 'view_mode', []
    );

    $testFormState = new FormState();

    // Run the procedural hook which should trigger the above handler.
    $elements = field_event_dispatcher_field_formatter_third_party_settings_form(
      $testPlugin, $testFieldDefinition, 'view_mode', [], $testFormState
    );

    /** @var \Drupal\field_event_dispatcher\Event\Field\FieldFormatterThirdPartySettingsFormEvent $event */
    $event = $this->manager->getRegisteredEvent(
      HookEventDispatcherInterface::FIELD_FORMATTER_THIRD_PARTY_SETTINGS_FORM
    );

    self::assertSame($elements, $event->getElements());

    $expectedElements['test_module']['test'] = [];

    self::assertSame($expectedElements, $elements);
  }

}
