<?php

namespace Drupal\Tests\media_event_dispatcher\Unit\Media;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\media\OEmbed\Provider;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\media_event_dispatcher\Event\Media\OEmbedResourceUrlAlterEvent;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use PHPUnit\Framework\TestCase;
use function media_event_dispatcher_oembed_resource_url_alter;

/**
 * Class OEmbedResourceUrlAlterEventTest.
 *
 * @group media_event_dispatcher
 */
class OEmbedResourceUrlAlterEventTest extends TestCase {

  /**
   * The manager.
   *
   * @var \Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy
   */
  private $manager;

  /**
   * Sets up the test.
   */
  public function setUp(): void {
    $builder = new ContainerBuilder();
    $this->manager = new HookEventDispatcherManagerSpy();
    $builder->set('hook_event_dispatcher.manager', $this->manager);
    $builder->compile();
    Drupal::setContainer($builder);
  }

  /**
   * Get a mock oEmbed provider.
   *
   * @return \Drupal\media\OEmbed\Provider
   *   A mock Vimeo oEmbed provider.
   */
  private function getMockProvider(): Provider {
    return new Provider('Vimeo', 'https://vimeo.com/', [
      [
        'url'     => 'https://vimeo.com/api/oembed.json',
        'schemes' => [
          'https://vimeo.com/*',
        ],
      ],
    ]);
  }

  /**
   * OEmbedResourceUrlAlterEvent parsed URL alter test.
   *
   * This tests altering the parsed URL array for an oEmbed data request.
   */
  public function testOembedResourceParsedUrlAlter() {
    // A mock URL array as would be provided in the real hook.
    $url = $expected = [
      'path'      => 'https://vimeo.com/api/oembed.json',
      'query'     => [
        'url' => 'https://vimeo.com/118146193',
      ],
      'fragment'  => '',
    ];

    /** @var \Drupal\media\OEmbed\Provider $provider */
    $provider = $this->getMockProvider();

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::MEDIA_OEMBED_RESOURCE_DATA_ALTER => function (
        OEmbedResourceUrlAlterEvent $event
      ) {
        $url = &$event->getParsedURL();

        $url['query']['width'] = '1280';
      },
    ]);

    // Run the procedural hook which should trigger the above handler.
    media_event_dispatcher_oembed_resource_url_alter($url, $provider);

    $expected['query']['width'] = '1280';

    self::assertSame($expected, $url);

    /** @var \Drupal\media_event_dispatcher\Event\Media\OEmbedResourceUrlAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(
      HookEventDispatcherInterface::MEDIA_OEMBED_RESOURCE_DATA_ALTER
    );

    self::assertSame($url, $event->getParsedURL());
  }

}
