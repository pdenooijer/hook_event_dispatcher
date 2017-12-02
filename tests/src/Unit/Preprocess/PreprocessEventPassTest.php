<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Preprocess;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\hook_event_dispatcher\Event\Preprocess\EckEntityPreprocessEvent;
use Drupal\hook_event_dispatcher\Event\Preprocess\HtmlPreprocessEvent;
use Drupal\hook_event_dispatcher\Service\PreprocessEventPass;
use Drupal\Tests\hook_event_dispatcher\Unit\Preprocess\Helpers\FakePreprocessEvent;
use Drupal\Tests\hook_event_dispatcher\Unit\Preprocess\Helpers\FakePreprocessEventFactory;
use Drupal\Tests\hook_event_dispatcher\Unit\Preprocess\Helpers\SpyEventDispatcher;
use Drupal\Tests\hook_event_dispatcher\Unit\Preprocess\Helpers\YamlDefinitionsLoader;
use Drupal\Tests\UnitTestCase;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class PreprocessEventPassTest.
 *
 * @group hook_event_dispatcher
 */
class PreprocessEventPassTest extends UnitTestCase {

  /**
   * The Drupal ContainerBuilder.
   *
   * @var \Drupal\Core\DependencyInjection\ContainerBuilder
   */
  private $builder;
  /**
   * The PreprocessEventPass.
   *
   * @var \Drupal\hook_event_dispatcher\Service\PreprocessEventPass
   */
  private $pass;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->builder = new ContainerBuilder();
    $locator = new FileLocator([dirname(dirname(dirname(dirname(__DIR__))))]);
    $loader = new YamlFileLoader($this->builder, $locator);
    $loader->load('hook_event_dispatcher.services.yml');
    $this->builder->set('event_dispatcher', new SpyEventDispatcher());

    $this->pass = new PreprocessEventPass();
  }

  /**
   * Test if the ContainerBuilder has all services from the YAML file.
   */
  public function testBuilderHasAllServices() {
    $this->pass->process($this->builder);
    $this->builder->compile();

    $services = YamlDefinitionsLoader::getInstance()->getServices();
    foreach (array_keys($services) as $id) {
      $this->assertTrue($this->builder->has($id));
    }
  }

  /**
   * Test if we can overwrite a default factory.
   *
   * Using the hook_event_dispatcher_factory tag.
   */
  public function testOverwritingDefaultFactory() {
    $fakeEckEntityFactory = new Definition(FakePreprocessEventFactory::class, [EckEntityPreprocessEvent::getHook()]);
    $fakeEckEntityFactory->addTag('preprocess_event_factory');
    $this->builder->setDefinition('preprocess_event.fake_factory.eck_entity', $fakeEckEntityFactory);

    $fakeHtmlFactory = new Definition(FakePreprocessEventFactory::class, [HtmlPreprocessEvent::getHook()]);
    $fakeHtmlFactory->addTag('preprocess_event_factory');
    $this->builder->setDefinition('preprocess_event.fake_factory.html', $fakeHtmlFactory);

    $this->pass->process($this->builder);
    $this->builder->compile();

    /* @var \Drupal\hook_event_dispatcher\Service\PreprocessEventFactoryMapper $mapper */
    $mapper = $this->builder->get('preprocess_event.factory_mapper');
    $variables = [];

    $eckMappedFactory = $mapper->getFactory(EckEntityPreprocessEvent::getHook());
    $this->assertInstanceOf(FakePreprocessEventFactory::class, $eckMappedFactory);
    $this->assertEquals(EckEntityPreprocessEvent::getHook(), $eckMappedFactory->getEventHook());
    $this->assertInstanceOf(FakePreprocessEvent::class, $eckMappedFactory->createEvent($variables));

    $htmlMappedFactory = $mapper->getFactory(HtmlPreprocessEvent::getHook());
    $this->assertInstanceOf(FakePreprocessEventFactory::class, $htmlMappedFactory);
    $this->assertEquals(HtmlPreprocessEvent::getHook(), $htmlMappedFactory->getEventHook());
    $this->assertInstanceOf(FakePreprocessEvent::class, $htmlMappedFactory->createEvent($variables));
  }

}
