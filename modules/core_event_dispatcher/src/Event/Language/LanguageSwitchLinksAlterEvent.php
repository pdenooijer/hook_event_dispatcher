<?php

namespace Drupal\core_event_dispatcher\Event\Language;

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
  public function __construct(array &$links, string $type, Url $path) {
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
  public function &getLinks(): array {
    return $this->links;
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
  public function getType(): string {
    return $this->type;
  }

  /**
   * Get the request path.
   *
   * @return \Drupal\Core\Url
   *   The link path.
   */
  public function getPath(): Url {
    return $this->path;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::LANGUAGE_SWITCH_LINKS_ALTER;
  }

}
