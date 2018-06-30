<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Theme;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\hook_event_dispatcher\Event\Theme\TemplatePreprocessDefaultVariablesAlterEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\Tests\UnitTestCase;

/**
 * Class TemplatePreprocessDefaultVariablesAlterEventTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\Theme
 *
 * @group hook_event_dispatcher
 */
final class TemplatePreprocessDefaultVariablesAlterEventTest extends UnitTestCase {

  /**
   * The manager.
   *
   * @var \Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy
   */
  private $manager;

  /**
   * Sets up the test.
   */
  public function setUp() {
    $builder = new ContainerBuilder();
    $this->manager = new HookEventDispatcherManagerSpy();
    $builder->set('hook_event_dispatcher.manager', $this->manager);
    $builder->compile();
    \Drupal::setContainer($builder);
  }

  /**
   * TemplatePreprocessDefaultVariablesAlterEvent test.
   */
  public function testTemplatePreprocessDefaultVariablesAlterEvent() {
    $newVariable = [
      'test_variable' => TRUE
    ];
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::TEMPLATE_PREPROCESS_DEFAULT_VARIABLES_ALTER => function (TemplatePreprocessDefaultVariablesAlterEvent $event) use ($newVariable) {
        $variables = &$event->getVariables();
        $variables += $newVariable;
      },
    ]);

    $variables = [
      'attributes' => [],
      'title_attributes' => [],
      'content_attributes' => [],
      'title_prefix' => [],
      'title_suffix' => [],
      'db_is_active' => !defined('MAINTENANCE_MODE'),
      'is_admin' => FALSE,
      'logged_in' => FALSE,
    ];

    $expectedVariables = $variables + $newVariable;

    hook_event_dispatcher_template_preprocess_default_variables_alter($variables);

    /** @var \Drupal\hook_event_dispatcher\Event\Theme\TemplatePreprocessDefaultVariablesAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::TEMPLATE_PREPROCESS_DEFAULT_VARIABLES_ALTER);
    $this->assertSame($expectedVariables, $event->getVariables());
  }

  /**
   * TemplatePreprocessDefaultVariablesAlterEvent by set test.
   */
  public function testTemplatePreprocessDefaultVariablesAlterEventBySet() {
    $newVariable = [
      'test_variable' => TRUE
    ];
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::TEMPLATE_PREPROCESS_DEFAULT_VARIABLES_ALTER => function (TemplatePreprocessDefaultVariablesAlterEvent $event) use ($newVariable) {
        $variables = $event->getVariables();
        $variables += $newVariable;
        $event->setVariables($variables);
      },
    ]);

    $variables = [
      'attributes' => [],
      'title_attributes' => [],
      'content_attributes' => [],
      'title_prefix' => [],
      'title_suffix' => [],
      'db_is_active' => !defined('MAINTENANCE_MODE'),
      'is_admin' => FALSE,
      'logged_in' => FALSE,
    ];

    $expectedVariables = $variables + $newVariable;

    hook_event_dispatcher_template_preprocess_default_variables_alter($variables);

    /** @var \Drupal\hook_event_dispatcher\Event\Theme\TemplatePreprocessDefaultVariablesAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::TEMPLATE_PREPROCESS_DEFAULT_VARIABLES_ALTER);
    $this->assertSame($expectedVariables, $event->getVariables());
  }

}
