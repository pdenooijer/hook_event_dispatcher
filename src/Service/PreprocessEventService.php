<?php

namespace Drupal\hook_event_dispatcher\Service;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Drupal\Core\Entity\ContentEntityInterface;

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

  /**
   * Create and dispatch the entity events.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   The entity object.
   * @param array $variables
   *   Variables.
   */
  public function createAndDispatchEntityTypeEvent(ContentEntityInterface $entity, array &$variables) {
    $factory = $this->mapper->getFactory('entity');
    if ($factory) {
      $event = $factory->createEvent($variables);
      $this->dispatcher->dispatch($event::name() . '.' . $entity->getEntityTypeId(), $event);
    }
  }

  /**
   * Create and dispatch the entity events.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   The entity object.
   * @param array $variables
   *   Variables.
   */
  public function createAndDispatchEntityTypeBundleEvent(ContentEntityInterface $entity, array &$variables) {
    $factory = $this->mapper->getFactory('entity');
    if ($factory) {
      $event = $factory->createEvent($variables);
      $this->dispatcher->dispatch($event::name() . '.' . $entity->getEntityTypeId() . '.' . $entity->bundle(), $event);
    }
  }

  /**
   * Check if the hook being called is one for an Entity.
   *
   * We check the fixed keys in an entity hook are present
   * and also validate they contain an object implementing the
   * entity interface. This way we are sure an entity hook is being called.
   *
   * @param string $hook
   *   The hook being called.
   * @param array $variables
   *   The variables array.
   *
   * @return \Drupal\Core\Entity\ContentEntityInterface|null
   *   An entity or null when no entity is found in variables.
   */
  public function getEntity($hook, array &$variables) {
    return isset($variables['elements']['#entity_type']) && isset($variables['elements']['#' . $hook]) && ($variables['elements']['#' . $hook] instanceof EntityInterface) ? $variables['elements']['#' . $hook] : NULL;
  }

}
