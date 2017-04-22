<?php

namespace Drupal\hook_event_dispatcher\Service;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class PreprocessEventService.
 */
final class PreprocessEventService {

  /**
   * Event dispatcher.
   *
   * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
   */
  private $dispatcher;

  /**
   * Factory mapper.
   *
   * @var PreprocessEventFactoryMapper
   */
  private $mapper;

  /**
   * PreprocessEventService constructor.
   *
   * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $dispatcher
   *   Event dispatcher.
   * @param PreprocessEventFactoryMapper $mapper
   *   Factory mapper.
   */
  public function __construct(EventDispatcherInterface $dispatcher, PreprocessEventFactoryMapper $mapper) {
    $this->dispatcher = $dispatcher;
    $this->mapper = $mapper;
  }

  /**
   * Create and dispatch the event.
   *
   * @param string $hook
   *   The hook name.
   * @param array $variables
   *   Variables.
   */
  public function createAndDispatchKnownEvent($hook, array &$variables) {
    $factory = $this->mapper->getFactory($hook);
    if ($factory) {
      $event = $factory->createEvent($variables);
      $this->dispatcher->dispatch($event::name(), $event);
    }
  }

}
