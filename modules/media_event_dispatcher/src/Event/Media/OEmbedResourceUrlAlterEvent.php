<?php

namespace Drupal\media_event_dispatcher\Event\Media;

use Drupal\media\OEmbed\Provider;
use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class OEmbedResourceUrlAlterEvent.
 */
class OEmbedResourceUrlAlterEvent extends Event implements EventInterface {

  /**
   * The oEmbed URL that data will be retrieved from.
   *
   * Note that this is an array as returned by
   * \Drupal\Component\Utility\UrlHelper::parse().
   *
   * @var array
   */
  private $parsedUrl;

  /**
   * The oEmbed provider for the resource to be retrieved.
   *
   * @var \Drupal\media\OEmbed\Provider
   */
  private $provider;

  /**
   * OEmbedResourceUrlAlterEvent constructor.
   *
   * @param array &$parsedUrl
   *   The oEmbed URL that data will be retrieved from, parsed into an array by
   *   \Drupal\Component\Utility\UrlHelper::parse().
   * @param \Drupal\media\OEmbed\Provider $provider
   *   The oEmbed provider for the resource to be retrieved.
   */
  public function __construct(array &$parsedUrl, Provider $provider) {
    $this->parsedUrl = &$parsedUrl;
    $this->provider = $provider;
  }

  /**
   * Get the URL that the oEmbed data will be retrieved from.
   *
   * Note that this is an array as returned by
   * \Drupal\Component\Utility\UrlHelper::parse().
   *
   * @return array
   *   The parsed URL for this oEmbed resource.
   */
  public function &getParsedUrl(): array {
    return $this->parsedUrl;
  }

  /**
   * Get the oEmbed provider for the resource to be retrieved.
   *
   * @return \Drupal\media\OEmbed\Provider
   *   The oEmbed provider for the resource.
   */
  public function getProvider(): Provider {
    return $this->provider;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::MEDIA_OEMBED_RESOURCE_DATA_ALTER;
  }

}
