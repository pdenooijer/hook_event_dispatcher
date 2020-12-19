<?php

namespace Drupal\Tests\field_event_dispatcher\Unit\Field;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\field_event_dispatcher\Event\Field\AbstractFieldSettingsSummaryFormEvent;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractFieldSettingsSummaryAlterEventTestCase.
 *
 * @group field_event_dispatcher
 */
abstract class AbstractFieldSettingsSummaryAlterEventTestCase extends TestCase {

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
   * Get the name of the procedural hook function for this test.
   *
   * @return string
   *   The name of the procedural hook function for this test.
   */
  abstract protected function getProceduralHookName(): string;

  /**
   * Get the name of the event to test.
   *
   * @return string
   *   The name of the event to test.
   */
  abstract protected function getEventName(): string;

  /**
   * Get the test context array.
   *
   * @param \Drupal\Core\Field\BaseFieldDefinition $fieldDefinition
   *   The field defition used in the test.
   *
   * @return array
   *   The test context array.
   */
  abstract protected function getTestContext(BaseFieldDefinition $fieldDefinition): array;

  /**
   * AbstractFieldSettingsSummaryAlterEventTestCase adding summary test.
   *
   * This tests adding an additional summary.
   */
  public function testAddSummary(): void {
    $summary = $expectedSummary = [];

    $eventName = $this->getEventName();

    $this->manager->setEventCallbacks([
      $eventName => static function (
        AbstractFieldSettingsSummaryFormEvent $event
      ) {
        $event->getSummary()[] = 'Test';
      },
    ]);

    // Run the procedural hook which should trigger the above handler.
    $hook = $this->getProceduralHookName();
    $hook($summary, []);

    /** @var \Drupal\field_event_dispatcher\Event\Field\AbstractFieldSettingsSummaryFormEvent $event */
    $event = $this->manager->getRegisteredEvent($eventName);

    self::assertSame($summary, $event->getSummary());

    $expectedSummary[] = 'Test';

    self::assertSame($expectedSummary, $summary);
  }

  /**
   * AbstractFieldSettingsSummaryAlterEventTestCase context test.
   *
   * This tests that the context parameter returns expected values.
   */
  public function testContext(): void {
    $fieldDefinition = new BaseFieldDefinition();

    $context = $this->getTestContext($fieldDefinition);

    $context['field_definition'] = $fieldDefinition;

    $expectedContext = $context;

    $summary = [];

    // Run the procedural hook which should trigger the event.
    $hook = $this->getProceduralHookName();
    $hook($summary, $context);

    /** @var \Drupal\field_event_dispatcher\Event\Field\AbstractFieldSettingsSummaryFormEvent $event */
    $event = $this->manager->getRegisteredEvent($this->getEventName());

    self::assertSame($expectedContext, $event->getContext());
  }

}
