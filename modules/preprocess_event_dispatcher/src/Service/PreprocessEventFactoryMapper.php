<?php

namespace Drupal\preprocess_event_dispatcher\Service;

use Drupal\preprocess_event_dispatcher\Factory\PreprocessEventFactoryInterface;

/**
 * Class PreprocessEventFactoryMapper.
 */
final class PreprocessEventFactoryMapper {

  /**
   * Map that binds a hook to a factory.
   *
   * @var \Drupal\preprocess_event_dispatcher\Factory\PreprocessEventFactoryInterface[]
   */
  private $hookToFactoryMap = [];

  /**
   * Add Factory to the mapper.
   *
   * @param \Drupal\preprocess_event_dispatcher\Factory\PreprocessEventFactoryInterface $factory
   *   Provided factory to add.
   */
  public function addFactory(PreprocessEventFactoryInterface $factory): void {
    $hook = $factory->getEventHook();
    $this->hookToFactoryMap[$hook] = $factory;
  }

  /**
   * Get a factory with the provided hook or the default factory.
   *
   * @param string $hook
   *   The hook name.
   *
   * @return \Drupal\preprocess_event_dispatcher\Factory\PreprocessEventFactoryInterface|null
   *   PreprocessEventFactory.
   */
  public function getFactory(string $hook): ?PreprocessEventFactoryInterface {
    return $this->hookToFactoryMap[$hook] ?? NULL;
  }

}
