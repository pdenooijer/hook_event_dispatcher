<?php

namespace Drupal\hook_event_dispatcher\Event\Language;

use Drupal\Core\Url;
use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class LanguageSwitchLinksAlterEvent.
 */
class LanguageSwitchLinksAlterEvent extends Event implements EventInterface {

  /**
   * The links array.
   *
   * @var array
   */
  private $links;

  /**
   * The language type.
   *
   * @var string
   */
  private $type;

  /**
   * The request path.
   *
   * @var \Drupal\Core\Url
   */
  private $path;

  /**
   * LanguageSwitchLinksAlterEvent constructor.
   *
   * @param array $links
   *   The links array.
   * @param string $type
   *   The language type.
   * @param \Drupal\Core\Url $path
   *   The request path.
   */
  public function __construct(array &$links, $type, Url $path) {
    $this->links = &$links;
    $this->type = $type;
    $this->path = $path;
  }

  /**
   * Get the links array.
   *
   * @return array
   *   The links array.
   */
  public function &getLinks() {
    return $this->links;
  }

  /**
   * Set the links.
   *
   * @param array $links
   *   The links array.
   */
  public function setLinks(array $links) {
    $this->links = $links;
  }

  /**
   * Set the link for a specific language code.
   *
   * @param string $langcode
   *   The link language code.
   * @param array $link
   *   The link path.
   */
  public function setLinkForLanguage($langcode, array $link) {
    $this->links[$langcode] = $link;
  }

  /**
   * Get the language type.
   *
   * @return string
   *   The language type.
   */
  public function getType() {
    return $this->type;
  }

  /**
   * Get the request path.
   *
   * @return \Drupal\Core\Url
   *   The link path.
   */
  public function getPath() {
    return $this->path;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType() {
    return HookEventDispatcherInterface::LANGUAGE_SWITCH_LINKS_ALTER;
  }

}
