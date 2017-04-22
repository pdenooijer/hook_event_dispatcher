<?php

namespace Drupal\hook_event_dispatcher\Service;

use Drupal\hook_event_dispatcher\Event\Preprocess\Factory\PreprocessEventFactoryInterface;

/**
 * Class PreprocessEventFactoryMapper.
 */
final class PreprocessEventFactoryMapper {

  /**
   * Map that binds a hook to a factory.
   *
   * @var \Drupal\hook_event_dispatcher\Event\Preprocess\Factory\PreprocessEventFactoryInterface[]
   */
  private $hookToFactoryMap = [];

  /**
   * Add Factory to the mapper.
   *
   * @param \Drupal\hook_event_dispatcher\Event\Preprocess\Factory\PreprocessEventFactoryInterface $factory
   *   Provided factory to add.
   */
  public function addFactory(PreprocessEventFactoryInterface $factory) {
    $hook = $factory->getEventHook();
    $this->hookToFactoryMap[$hook] = $factory;
  }

  /**
   * Get a factory with the provided hook or the default factory.
   *
   * @param string $hook
   *   The hook name.
   *
   * @return \Drupal\hook_event_dispatcher\Event\Preprocess\Factory\PreprocessEventFactoryInterface|null
   *   PreprocessEventFactory.
   */
  public function getFactory($hook) {
    if (isset($this->hookToFactoryMap[$hook])) {
      return $this->hookToFactoryMap[$hook];
    }

    return NULL;
  }

}
