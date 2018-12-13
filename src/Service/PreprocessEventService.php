<?php

namespace Drupal\hook_event_dispatcher\Service;

use Drupal\hook_event_dispatcher\Event\Preprocess\PreprocessEntityEventInterface;
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
  public function createAndDispatchKnownEvents($hook, array &$variables) {
    $factory = $this->mapper->getFactory($hook);
    if ($factory === NULL) {
      return;
    }

    $event = $factory->createEvent($variables);
    $this->dispatcher->dispatch($event::name(), $event);

    if ($event instanceof PreprocessEntityEventInterface) {
      $this->dispatchEntitySpecificEvents($event);
    }
  }

  /**
   * Dispatch the entity events.
   *
   * @param \Drupal\hook_event_dispatcher\Event\Preprocess\PreprocessEntityEventInterface $event
   *   The event to dispatch.
   */
  private function dispatchEntitySpecificEvents(PreprocessEntityEventInterface $event) {
    $variables = $event->getVariables();

    $withBundle = $event::name($variables->getEntityBundle());
    $this->dispatcher->dispatch($withBundle, $event);

    $withViewMode = $event::name($variables->getEntityBundle(), $variables->getViewMode());
    $this->dispatcher->dispatch($withViewMode, $event);
  }

}
