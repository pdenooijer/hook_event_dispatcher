<?php

namespace Drupal\Tests\preprocess_event_dispatcher\Unit\Helpers;

use Drupal\preprocess_event_dispatcher\Service\PreprocessEventFactoryMapper;
use Symfony\Component\Yaml\Parser;
use function dirname;
use function file_get_contents;

/**
 * Class YamlDefinitionsLoader.
 */
final class YamlDefinitionsLoader {

  /**
   * Singleton instance of this class.
   *
   * @var YamlDefinitionsLoader
   */
  private static $instance;

  /**
   * Factory mapper.
   *
   * @var \Drupal\preprocess_event_dispatcher\Service\PreprocessEventFactoryMapper
   */
  private $mapper;

  /**
   * Service definitions loaded from the YAML services file.
   *
   * @var array
   */
  private $services;

  /**
   * Factory definitions loaded from the YAML services file.
   *
   * @var array
   */

  private $factories;

  /**
   * YamlDefinitionsLoader constructor.
   */
  private function __construct() {
    $this->loadDefinitionsFromServicesYaml();
    $this->setUpFactoriesMapper();
  }

  /**
   * Load the definitions from the services YAML.
   */
  private function loadDefinitionsFromServicesYaml(): void {
    $yaml = new Parser();
    $content = file_get_contents(dirname(__DIR__, 4) . '/preprocess_event_dispatcher.services.yml');
    $factories = $this->services = $yaml->parse($content)['services'];

    // Remove the Service and Factory Mapper.
    unset($factories['preprocess_event.service'], $factories['preprocess_event.factory_mapper']);
    $this->factories = $factories;
  }

  /**
   * Set up Factories Mapper.
   */
  private function setUpFactoriesMapper(): void {
    $this->mapper = new PreprocessEventFactoryMapper();
    foreach ($this->factories as $entry) {
      $factory = new $entry['class']();
      $this->mapper->addFactory($factory);
    }
  }

  /**
   * Singleton get instance function.
   *
   * Only need to load the files once from the filesystem.
   *
   * @return \Drupal\Tests\preprocess_event_dispatcher\Unit\Helpers\YamlDefinitionsLoader
   *   Existing or new YamlDefinitionsLoader instance.
   */
  public static function getInstance(): YamlDefinitionsLoader {
    if (static::$instance === NULL) {
      static::$instance = new static();
    }
    return static::$instance;
  }

  /**
   * Get the FactoryMapper.
   *
   * @return \Drupal\preprocess_event_dispatcher\Service\PreprocessEventFactoryMapper
   *   Factory mapper.
   */
  public function getMapper(): PreprocessEventFactoryMapper {
    return $this->mapper;
  }

  /**
   * Get the Services.
   *
   * @return array
   *   Service definitions.
   */
  public function getServices(): array {
    return $this->services;
  }

  /**
   * Get the Factories.
   *
   * @return array
   *   Factory definitions.
   */
  public function getFactories(): array {
    return $this->factories;
  }

}
