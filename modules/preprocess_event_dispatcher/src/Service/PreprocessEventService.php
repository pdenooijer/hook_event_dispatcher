<?php

namespace Drupal\preprocess_event_dispatcher\Service;

use Drupal\preprocess_event_dispatcher\Event\PreprocessEntityEventInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class PreprocessEventService.
 */
final class PreprocessEventService implements PreprocessEventServiceInterface {

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
   * {@inheritdoc}
   */
  public function createAndDispatchKnownEvents(string $hook, array &$variables): void {
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
   * @param \Drupal\preprocess_event_dispatcher\Event\PreprocessEntityEventInterface $event
   *   The event to dispatch.
   */
  private function dispatchEntitySpecificEvents(PreprocessEntityEventInterface $event): void {
    $variables = $event->getVariables();

    $withBundle = $event::name($variables->getEntityBundle());
    $this->dispatcher->dispatch($withBundle, $event);

    $withViewMode = $event::name($variables->getEntityBundle(), $variables->getViewMode());
    $this->dispatcher->dispatch($withViewMode, $event);
  }

}
