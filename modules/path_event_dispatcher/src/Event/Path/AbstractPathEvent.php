<?php

namespace Drupal\path_event_dispatcher\Event\Path;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class AbstractPathEvent.
 */
abstract class AbstractPathEvent extends Event implements EventInterface {

  /**
   * The source like '/node/1'.
   *
   * @var string
   */
  private $source;
  /**
   * The alias for the source.
   *
   * @var string
   */
  private $alias;
  /**
   * Lang code.
   *
   * @var string
   */
  private $langcode;
  /**
   * The path id.
   *
   * @var int
   */
  private $pid;

  /**
   * AbstractPathEvent constructor.
   *
   * @param array $path
   *   The array structure is identical to that of the return value of
   *   \Drupal\Core\Path\AliasStorageInterface::save().
   */
  public function __construct(array $path) {
    $this->source = $path['source'];
    $this->alias = $path['alias'];
    $this->langcode = $path['langcode'];
    $this->pid = (int) $path['pid'];
  }

  /**
   * Getter.
   *
   * @return int
   *   The path id.
   */
  public function getPid(): int {
    return $this->pid;
  }

  /**
   * Getter.
   *
   * @return string
   *   The source like '/node/1'.
   */
  public function getSource(): string {
    return $this->source;
  }

  /**
   * Getter.
   *
   * @return string
   *   The alias.
   */
  public function getAlias(): string {
    return $this->alias;
  }

  /**
   * Getter.
   *
   * @return string
   *   The langcode like 'nl'.
   */
  public function getLangcode(): string {
    return $this->langcode;
  }

}
