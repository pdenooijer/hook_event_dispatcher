<?php

namespace Drupal\Tests\core_event_dispatcher\Unit\Theme;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\core_event_dispatcher\Event\Theme\TemplatePreprocessDefaultVariablesAlterEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use PHPUnit\Framework\TestCase;
use function core_event_dispatcher_template_preprocess_default_variables_alter;

/**
 * Class TemplatePreprocessDefaultVariablesAlterEventTest.
 *
 * @group hook_event_dispatcher
 */
final class TemplatePreprocessDefaultVariablesAlterEventTest extends TestCase {

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
   * TemplatePreprocessDefaultVariablesAlterEvent test.
   */
  public function testTemplatePreprocessDefaultVariablesAlterEvent(): void {
    $newVariable = [
      'test_variable' => TRUE,
    ];
    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::TEMPLATE_PREPROCESS_DEFAULT_VARIABLES_ALTER => static function (TemplatePreprocessDefaultVariablesAlterEvent $event) use ($newVariable) {
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
      'db_is_active' => TRUE,
      'is_admin' => FALSE,
      'logged_in' => FALSE,
    ];
    $expectedVariables = $variables + $newVariable;

    core_event_dispatcher_template_preprocess_default_variables_alter($variables);

    /** @var \Drupal\core_event_dispatcher\Event\Theme\TemplatePreprocessDefaultVariablesAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::TEMPLATE_PREPROCESS_DEFAULT_VARIABLES_ALTER);
    self::assertSame($expectedVariables, $variables);
    self::assertSame($expectedVariables, $event->getVariables());
  }

}
