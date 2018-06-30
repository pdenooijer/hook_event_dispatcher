<?php

namespace Drupal\hook_event_dispatcher\Event\Theme;

use Drupal\Core\Asset\AttachedAssetsInterface;
use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class JsAlterEvent.
 *
 * @package Drupal\hook_event_dispatcher\Event\Theme
 */
final class JsAlterEvent extends Event implements EventInterface {

  /**
   * Javascript.
   *
   * @var array
   */
  private $javascript;

  /**
   * AttachedAssets.
   *
   * @var \Drupal\Core\Asset\AttachedAssetsInterface
   */
  private $attachedAssets;

  /**
   * JsAlterEvent constructor.
   *
   * @param array $javascript
   *   Javascript.
   * @param \Drupal\Core\Asset\AttachedAssetsInterface $attachedAssets
   *   AttachedAssets.
   */
  public function __construct(
    array &$javascript,
    AttachedAssetsInterface $attachedAssets
  ) {
    $this->javascript = &$javascript;
    $this->attachedAssets = $attachedAssets;
  }

  /**
   * Get the javascript.
   *
   * @return array
   *   Javascript.
   */
  public function &getJavascript() {
    return $this->javascript;
  }

  /**
   * Set the javascript.
   *
   * @param array $javascript
   *   Javascript.
   */
  public function setJavascript(array $javascript) {
    $this->javascript = $javascript;
  }

  /**
   * Get the attached assets.
   *
   * @return \Drupal\Core\Asset\AttachedAssetsInterface
   *   AttachedAssets.
   */
  public function getAttachedAssets() {
    return $this->attachedAssets;
  }

  /**
   * Get the dispatcher type.
   *
   * @return string
   *   The dispatcher type.
   */
  public function getDispatcherType() {
    return HookEventDispatcherInterface::JS_ALTER;
  }

}
