<?php

namespace Drupal\Tests\media_event_dispatcher\Unit\Media;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\media_event_dispatcher\Event\Media\MediaSourceInfoAlterEvent;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use PHPUnit\Framework\TestCase;
use function media_event_dispatcher_media_source_info_alter;

/**
 * Class MediaSourceInfoAlterEventTest.
 *
 * @group media_event_dispatcher
 */
class MediaSourceInfoAlterEventTest extends TestCase {

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
   * MediaSourceInfoAlterEvent sources array alter test.
   *
   * This tests altering the media source plugin definitions array.
   */
  public function testMediaSourceInfoAlter() {
    $sources = $expectedSources = [
      'image' => [
        'id' => 'image',
        'label' => new TranslatableMarkup('Image'),
        'description' => new TranslatableMarkup('Use local images for reusable media.'),
        'class' => 'Drupal\media\Plugin\media\Source\Image',
        'allowed_field_types' => ['image'],
      ],
    ];

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::MEDIA_SOURCE_INFO_ALTER => static function (
        MediaSourceInfoAlterEvent $event
      ) {
        $sources = &$event->getSources();

        $sources['image']['allowed_field_types'][] = 'test';
      },
    ]);

    // Run the procedural hook which should trigger the above handler.
    media_event_dispatcher_media_source_info_alter($sources);

    /** @var \Drupal\media_event_dispatcher\Event\Media\MediaSourceInfoAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(
      HookEventDispatcherInterface::MEDIA_SOURCE_INFO_ALTER
    );

    self::assertSame($sources, $event->getSources());

    $expectedSources['image']['allowed_field_types'][] = 'test';

    self::assertSame($expectedSources, $sources);
  }

}
