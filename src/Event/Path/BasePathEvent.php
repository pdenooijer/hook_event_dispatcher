<?php

namespace Drupal\hook_event_dispatcher\Event\Path;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class BasePathEvent.
 */
abstract class BasePathEvent extends Event implements EventInterface {

  /**
   * The source like '/node/1'.
   *
   * @var string
   */
  protected $source;
  /**
   * The alias for the source.
   *
   * @var string
   */
  protected $alias;
  /**
   * Lang code.
   *
   * @var string
   */
  protected $langcode;
  /**
   * The path id.
   *
   * @var int
   */
  protected $pid;

  /**
   * BaseEntityEvent constructor.
   *
   * @param array $fields
   *   The Entity.
   */
  public function __construct(array $fields) {
    $this->source = $fields['source'];
    $this->alias = $fields['alias'];
    $this->langcode = $fields['langcode'];
    $this->pid = (int) $fields['pid'];
  }

  /**
   * Getter.
   *
   * @return int
   *   The path id.
   */
  public function getPid() {
    return $this->pid;
  }

  /**
   * Getter.
   *
   * @return string
   *   The source like '/node/1'.
   */
  public function getSource() {
    return $this->source;
  }

  /**
   * Getter.
   *
   * @return string
   *   The alias.
   */
  public function getAlias() {
    return $this->alias;
  }

  /**
   * Getter.
   *
   * @return string
   *   The langcode like 'nl'.
   */
  public function getLangcode() {
    return $this->langcode;
  }

}
