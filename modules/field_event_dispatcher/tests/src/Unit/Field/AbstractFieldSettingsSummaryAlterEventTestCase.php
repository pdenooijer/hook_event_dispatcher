<?php

namespace Drupal\Tests\field_event_dispatcher\Unit\Field;

use Drupal;
use Drupal\Component\Utility\NestedArray;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Form\FormStateInterface;
use Drupal\core_event_dispatcher\Event\Form\FormIdAlterEvent;
use Drupal\field_event_dispatcher\Event\Field\AbstractFieldSettingsSummaryFormEvent;
use Drupal\field_event_dispatcher\EventSubscriber\Form\FormEntityDisplayEditAlterEventSubscriber;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\Tests\UnitTestCase;

/**
 * Class AbstractFieldSettingsSummaryAlterEventTestCase.
 *
 * @group field_event_dispatcher
 */
abstract class AbstractFieldSettingsSummaryAlterEventTestCase extends UnitTestCase {

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
    $this->getProceduralHookName()($summary, []);

    /** @var \Drupal\field_event_dispatcher\Event\Field\AbstractFieldSettingsSummaryFormEvent $event */
    $event = $this->manager->getRegisteredEvent($eventName);

    $this->assertSame($summary, $event->getSummary());

    $expectedSummary[] = 'Test';

    $this->assertSame($expectedSummary, $summary);
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
    $this->getProceduralHookName()($summary, $context);

    /** @var \Drupal\field_event_dispatcher\Event\Field\AbstractFieldSettingsSummaryFormEvent $event */
    $event = $this->manager->getRegisteredEvent($this->getEventName());

    $this->assertSame($expectedContext, $event->getContext());
  }

}
