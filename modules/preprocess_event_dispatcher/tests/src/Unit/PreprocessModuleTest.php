<?php

namespace Drupal\Tests\preprocess_event_dispatcher\Unit;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\preprocess_event_dispatcher\Service\PreprocessEventServiceInterface;
use PHPUnit\Framework\TestCase;
use Mockery;

/**
 * Class PreprocessModuleTest.
 *
 * @group preprocess_event_dispatcher
 */
final class PreprocessModuleTest extends TestCase {

  /**
   * PreprocessEventService.
   *
   * @var \Drupal\preprocess_event_dispatcher\Service\PreprocessEventService|\Mockery\MockInterface
   */
  private $service;

  /**
   * {@inheritdoc}
   */
  public function setUp(): void {
    $builder = new ContainerBuilder();
    $this->service = Mockery::mock(PreprocessEventServiceInterface::class);
    $builder->set('preprocess_event.service', $this->service);
    $builder->compile();
    Drupal::setContainer($builder);
  }

  /**
   * Preprocess hook test.
   */
  public function testPreprocessHook(): void {
    $hook = $expectedHook = 'test';
    $variables = ['some' => 'variables'];
    $this->service->expects('createAndDispatchKnownEvents')
      ->once()
      ->with($hook, $variables);

    preprocess_event_dispatcher_preprocess($variables, $hook);

    // Just test something so PHPUnit does not complain about no assertions,
    // while Mockery asserts the service being called.
    self::assertSame($expectedHook, $hook);
  }

  /**
   * {@inheritdoc}
   */
  public function tearDown(): void {
    Mockery::close();
  }

}
