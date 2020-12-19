<?php

namespace Drupal\Tests\preprocess_event_dispatcher\Unit;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\preprocess_event_dispatcher\Event\EckEntityPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Event\HtmlPreprocessEvent;
use Drupal\preprocess_event_dispatcher\Service\PreprocessEventPass;
use Drupal\Tests\preprocess_event_dispatcher\Unit\Helpers\FakePreprocessEvent;
use Drupal\Tests\preprocess_event_dispatcher\Unit\Helpers\FakePreprocessEventFactory;
use Drupal\Tests\preprocess_event_dispatcher\Unit\Helpers\SpyEventDispatcher;
use Drupal\Tests\preprocess_event_dispatcher\Unit\Helpers\YamlDefinitionsLoader;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use function array_keys;
use function dirname;

/**
 * Class PreprocessEventPassTest.
 *
 * @group preprocess_event_dispatcher
 */
class PreprocessEventPassTest extends TestCase {

  /**
   * The Drupal ContainerBuilder.
   *
   * @var \Drupal\Core\DependencyInjection\ContainerBuilder
   */
  private $builder;
  /**
   * The PreprocessEventPass.
   *
   * @var \Drupal\preprocess_event_dispatcher\Service\PreprocessEventPass
   */
  private $pass;

  /**
   * {@inheritdoc}
   */
  public function setUp(): void {
    $this->builder = new ContainerBuilder();
    $locator = new FileLocator([dirname(__DIR__, 3)]);
    $loader = new YamlFileLoader($this->builder, $locator);
    $loader->load('preprocess_event_dispatcher.services.yml');
    $this->builder->set('event_dispatcher', new SpyEventDispatcher());

    $this->pass = new PreprocessEventPass();
  }

  /**
   * Test if the ContainerBuilder has all services from the YAML file.
   */
  public function testBuilderHasAllServices(): void {
    $this->pass->process($this->builder);
    $this->builder->compile();

    $services = YamlDefinitionsLoader::getInstance()->getServices();
    foreach (array_keys($services) as $id) {
      self::assertTrue($this->builder->has($id));
    }
  }

  /**
   * Test if we can overwrite a default factory.
   *
   * Using the preprocess_event_dispatcher_factory tag.
   */
  public function testOverwritingDefaultFactory(): void {
    $fakeEckEntityFactory = new Definition(FakePreprocessEventFactory::class, [EckEntityPreprocessEvent::getHook()]);
    $fakeEckEntityFactory->addTag('preprocess_event_factory');
    $this->builder->setDefinition('preprocess_event.fake_factory.eck_entity', $fakeEckEntityFactory);

    $fakeHtmlFactory = new Definition(FakePreprocessEventFactory::class, [HtmlPreprocessEvent::getHook()]);
    $fakeHtmlFactory->addTag('preprocess_event_factory');
    $this->builder->setDefinition('preprocess_event.fake_factory.html', $fakeHtmlFactory);

    $this->pass->process($this->builder);
    $this->builder->compile();

    /** @var \Drupal\preprocess_event_dispatcher\Service\PreprocessEventFactoryMapper $mapper */
    $mapper = $this->builder->get('preprocess_event.factory_mapper');
    $variables = [];

    $eckMappedFactory = $mapper->getFactory(EckEntityPreprocessEvent::getHook());
    self::assertInstanceOf(FakePreprocessEventFactory::class, $eckMappedFactory);
    self::assertSame(EckEntityPreprocessEvent::getHook(), $eckMappedFactory->getEventHook());
    self::assertInstanceOf(FakePreprocessEvent::class, $eckMappedFactory->createEvent($variables));

    $htmlMappedFactory = $mapper->getFactory(HtmlPreprocessEvent::getHook());
    self::assertInstanceOf(FakePreprocessEventFactory::class, $htmlMappedFactory);
    self::assertSame(HtmlPreprocessEvent::getHook(), $htmlMappedFactory->getEventHook());
    self::assertInstanceOf(FakePreprocessEvent::class, $htmlMappedFactory->createEvent($variables));
  }

}
