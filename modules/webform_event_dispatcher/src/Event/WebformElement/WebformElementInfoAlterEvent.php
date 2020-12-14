<?php

namespace Drupal\webform_event_dispatcher\Event\WebformElement;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class WebformElementInfoAlterEvent.
 *
 * @package Drupal\webform_event_dispatcher\Event\Element
 */
class WebformElementInfoAlterEvent extends Event implements EventInterface {

  /**
   * The webform element.
   *
   * @var array
   *   Array of webform handlers, keyed on the machine-readable element name.
   */
  private $definitions;

  /**
   * WidgetFormAlterEvent constructor.
   *
   * @param array $definitions
   *   Array of webform handlers, keyed on the machine-readable element name.
   */
  public function __construct(array &$definitions) {
    $this->definitions = &$definitions;
  }

  /**
   * Get the definitions.
   *
   * @return array
   *   Array of webform handlers, keyed on the machine-readable element name.
   */
  public function &getDefinitions() {
    return $this->definitions;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType() {
    return HookEventDispatcherInterface::WEBFORM_ELEMENT_INFO_ALTER;
  }

}
