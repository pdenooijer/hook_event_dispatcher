<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Language;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Language\LanguageInterface;
use Drupal\Core\Url;
use Drupal\hook_event_dispatcher\Event\Language\LanguageSwitchLinksAlterEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use Drupal\Tests\UnitTestCase;

/**
 * Class LanguageSwitchLinksAlterEventTest.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Unit\Language
 *
 * @group hook_event_dispatcher
 */
class LanguageSwitchLinksAlterEventTest extends UnitTestCase {

  /**
   * The manager.
   *
   * @var \Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy
   */
  private $manager;

  /**
   * Sets up the test.
   */
  public function setUp() {
    $builder = new ContainerBuilder();
    $this->manager = new HookEventDispatcherManagerSpy();
    $builder->set('hook_event_dispatcher.manager', $this->manager);
    $builder->compile();
    Drupal::setContainer($builder);
  }

  /**
   * Test adding a new link by reference.
   */
  public function testAddLinksByReference() {
    $currentLinks = [
      'nl_nl' => [
        'url' => new Url('<current>'),
        'title' => 'Nederlands - Dutch',
        'language' => LanguageInterface::LANGCODE_NOT_SPECIFIED,
        'attributes' => [],
        'query' => [],
      ],
    ];
    $currentPath = new Url('<current>');
    $currentType = 'language_interface';

    $testLink = [
      'url' => new Url('<current>'),
      'title' => 'Deutsch - German',
      'language' => LanguageInterface::LANGCODE_NOT_SPECIFIED,
      'attributes' => [],
      'query' => [],
    ];

    $expectedLinks = $currentLinks;
    $expectedLinks['de_de'] = $testLink;
    $expectedLinks['nl_nl']['attributes'] = ['some attr'];

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::LANGUAGE_SWITCH_LINKS_ALTER => static function (LanguageSwitchLinksAlterEvent $event) use ($testLink) {
        $links = &$event->getLinks();
        $links['de_de'] = $testLink;
        $links['nl_nl']['attributes'] = ['some attr'];
      },
    ]);

    hook_event_dispatcher_language_switch_links_alter($currentLinks, $currentType, $currentPath);

    /** @var \Drupal\hook_event_dispatcher\Event\Language\LanguageSwitchLinksAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::LANGUAGE_SWITCH_LINKS_ALTER);
    self::assertSame($expectedLinks, $event->getLinks());
    self::assertSame($expectedLinks, $currentLinks);
    self::assertSame($currentType, $event->getType());
    self::assertSame($currentPath, $event->getPath());
  }

  /**
   * Test adding a new link by reference.
   */
  public function testAddLinksBySet() {
    $currentLinks = [
      'nl_nl' => [
        'url' => new Url('<current>'),
        'title' => 'Nederlands - Dutch',
        'language' => LanguageInterface::LANGCODE_NOT_SPECIFIED,
        'attributes' => [],
        'query' => [],
      ],
    ];
    $currentPath = new Url('<current>');
    $currentType = 'language_interface';

    $testLink = [
      'url' => new Url('<current>'),
      'title' => 'Deutsch - German',
      'language' => LanguageInterface::LANGCODE_NOT_SPECIFIED,
      'attributes' => [],
      'query' => [],
    ];

    $expectedLinks = $currentLinks;
    $expectedLinks['de_de'] = $testLink;

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::LANGUAGE_SWITCH_LINKS_ALTER => static function (LanguageSwitchLinksAlterEvent $event) use ($testLink) {
        $links = $event->getLinks();
        $links['de_de'] = $testLink;
        $event->setLinks($links);
      },
    ]);

    hook_event_dispatcher_language_switch_links_alter($currentLinks, $currentType, $currentPath);

    /** @var \Drupal\hook_event_dispatcher\Event\Language\LanguageSwitchLinksAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::LANGUAGE_SWITCH_LINKS_ALTER);
    self::assertSame($expectedLinks, $event->getLinks());
  }

  /**
   * Test adding a new language link.
   */
  public function testSetLinkForLanguage() {
    $currentLinks = $expectedLinks = [
      'nl_nl' => [
        'url' => new Url('<current>'),
        'title' => 'Nederlands - Dutch',
        'language' => LanguageInterface::LANGCODE_NOT_SPECIFIED,
        'attributes' => [],
        'query' => [],
      ],
    ];
    $currentPath = new Url('<current>');
    $currentType = 'language_interface';

    $newLink = [
      'url' => new Url('<current>'),
      'title' => 'Deutsch - German',
      'language' => LanguageInterface::LANGCODE_NOT_SPECIFIED,
      'attributes' => [],
      'query' => [],
    ];
    $expectedLinks['de_de'] = $newLink;

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::LANGUAGE_SWITCH_LINKS_ALTER => static function (LanguageSwitchLinksAlterEvent $event) use ($newLink) {
        $event->setLinkForLanguage('de_de', $newLink);
      },
    ]);

    hook_event_dispatcher_language_switch_links_alter($currentLinks, $currentType, $currentPath);

    /** @var \Drupal\hook_event_dispatcher\Event\Language\LanguageSwitchLinksAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::LANGUAGE_SWITCH_LINKS_ALTER);
    self::assertSame($expectedLinks, $event->getLinks());
  }

}
