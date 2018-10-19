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
  public function createAndDispatchKnownEvents($hook, array &$variables) {
    if ($this->isContentEntityHook($variables)) {
      $this->createAndDispatchEntityEvent($hook, $variables);
      $this->createAndDispatchEntityBundleEvent($variables);
      return;
    }
    $this->createAndDispatchKnownEvent($hook, $variables);
  }

  /**
   * Create and dispatch the entity events.
   *
   * @param string $hook
   *   The factory hook.
   * @param array $variables
   *   Variables.
   */
  private function createAndDispatchKnownEvent($hook, array &$variables) {
    $factory = $this->mapper->getFactory($hook);
    if ($factory) {
      $event = $factory->createEvent($variables);
      $this->dispatcher->dispatch($event::name(), $event);
    }
  }

  /**
   * Create and dispatch the entity events.
   *
   * @param string $hook
   *   The factory hook.
   * @param array $variables
   *   Variables.
   */
  private function createAndDispatchEntityEvent($hook, array &$variables) {
    // To support backwards compatibility we check for a specific
    // factory first before use the general entity factory.
    // This way the preprocess events that were already present before this
    // change can just override the getComposedName() function.
    $factory = $this->mapper->getFactory($hook) ?: $this->mapper->getFactory('entity');
    if ($factory) {
      $event = $factory->createEvent($variables);
      $this->dispatcher->dispatch($event->getComposedName(), $event);
    }
  }

  /**
   * Create and dispatch the entity bundle events.
   *
   * @param array $variables
   *   Variables.
   */
  private function createAndDispatchEntityBundleEvent(array &$variables) {
    $factory = $this->mapper->getFactory('entity_bundle');
    $event = $factory->createEvent($variables);
    $this->dispatcher->dispatch($event->getComposedName(), $event);
  }

  /**
   * Check if the hook being called is one for an Entity.
   *
   * We check the fixed keys in an entity hook are present
   * and also validate they contain an object implementing the
   * entity interface. This way we are sure an entity hook is being called.
   *
   * @param array $variables
   *   The variables array.
   *
   * @return bool
   *   A boolean indicating whether an entity hook is called.
   */
  private function isContentEntityHook(array &$variables) {
    if (
      isset($variables['elements']['#entity_type']) &&
      isset($variables[$variables['elements']['#entity_type']]) &&
      $variables[$variables['elements']['#entity_type']] instanceof ContentEntityInterface
    ) {
      return TRUE;
    }
    return FALSE;
  }

}
