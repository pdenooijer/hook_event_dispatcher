<?php

namespace Drupal\webform_event_dispatcher\Event\WebformElement;

use Drupal\hook_event_dispatcher\Event\EventInterface;
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
   *   The array of webform handlers, keyed on the machine-readable element name.
   */
  private $definitions;

  /**
   * WidgetFormAlterEvent constructor.
   *
   * @param array $definitions
   *   The array of webform handlers, keyed on the machine-readable element name.
   */
  public function __construct(array &$definitions) {
    $this->definitions = &$definitions;
  }

  /**
   * Get the definitions.
   *
   * @return array
   *   The array of webform handlers, keyed on the machine-readable element name.
   */
  public function &getDefinitions() {
    return $this->definitions;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType() {
    return 'hook_event_dispatcher.webform.element.info.alter';
  }

}
