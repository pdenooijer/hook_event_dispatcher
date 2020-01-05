<?php

namespace Drupal\Tests\preprocess_event_dispatcher\Unit\Helpers;

use Drupal\preprocess_event_dispatcher\Event\AbstractPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Factory\PreprocessEventFactoryInterface;

/**
 * Class FakePreprocessEventFactory.
 */
final class FakePreprocessEventFactory implements PreprocessEventFactoryInterface {

  /**
   * Fake hook.
   *
   * @var string
   */
  private $hook;

  /**
   * FakePreprocessEventFactory constructor.
   *
   * @param string $hook
   *   Fake hook.
   */
  public function __construct(string $hook) {
    $this->hook = $hook;
  }

  /**
   * Create the PreprocessEvent with the Variables object embedded.
   *
   * @param array $variables
   *   Variables.
   *
   * @return FakePreprocessEvent
   *   Created event.
   */
  public function createEvent(array &$variables): AbstractPreprocessEvent {
    return new FakePreprocessEvent(new FakeEventVariables($variables));
  }

  /**
   * {@inheritdoc}
   */
  public function getEventHook(): string {
    return $this->hook;
  }

}
