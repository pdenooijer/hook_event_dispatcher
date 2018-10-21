<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Preprocess\Helpers;

use Drupal\hook_event_dispatcher\Service\PreprocessEventFactoryMapper;
use Symfony\Component\Yaml\Parser;

/**
 * Class YamlDefinitionsLoader.
 *
 * @package Drupal\Tests\hook_event_dispatcher\Preprocess\Helpers
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
   * @var \Drupal\hook_event_dispatcher\Service\PreprocessEventFactoryMapper
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
  private function loadDefinitionsFromServicesYaml() {
    $yaml = new Parser();
    $content = file_get_contents(dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/hook_event_dispatcher.services.yml');
    $services = $yaml->parse($content)['services'];

    // Remove the Manager.
    unset($services['hook_event_dispatcher.manager']);
    $factories = $this->services = $services;

    // Remove the Service and Factory Mapper.
    unset($factories['preprocess_event.service'], $factories['preprocess_event.factory_mapper']);
    $this->factories = $factories;
  }

  /**
   * Set up Factories Mapper.
   */
  private function setUpFactoriesMapper() {
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
   * @return \Drupal\Tests\hook_event_dispatcher\Unit\Preprocess\Helpers\YamlDefinitionsLoader
   *   Existing or new YamlDefinitionsLoader instance.
   */
  public static function getInstance() {
    if (static::$instance === NULL) {
      static::$instance = new static();
    }
    return static::$instance;
  }

  /**
   * Get the FactoryMapper.
   *
   * @return \Drupal\hook_event_dispatcher\Service\PreprocessEventFactoryMapper
   *   Factory mapper.
   */
  public function getMapper() {
    return $this->mapper;
  }

  /**
   * Get the Services.
   *
   * @return array
   *   Service definitions.
   */
  public function getServices() {
    return $this->services;
  }

  /**
   * Get the Factories.
   *
   * @return array
   *   Factory definitions.
   */
  public function getFactories() {
    return $this->factories;
  }

}
