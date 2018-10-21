<?php

namespace Drupal\Tests\hook_event_dispatcher\Unit\Preprocess;

use Drupal\Tests\hook_event_dispatcher\Unit\Preprocess\Helpers\YamlDefinitionsLoader;
use Drupal\Tests\UnitTestCase;

/**
 * Class FactoryMapperTest.
 *
 * @group hook_event_dispatcher
 */
final class FactoryMapperTest extends UnitTestCase {

  /**
   * Factory mapper.
   *
   * @var \Drupal\hook_event_dispatcher\Service\PreprocessEventFactoryMapper
   */
  private $mapper;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->mapper = YamlDefinitionsLoader::getInstance()->getMapper();
  }

  /**
   * Test if all factories are in the YAML file.
   */
  public function testYamlHasAllFactories() {
    $factoriesYaml = YamlDefinitionsLoader::getInstance()->getFactories();
    $classNames = $this->getFactoryClassNamesFromFilesystem();

    $this->assertCount(\count($factoriesYaml), $classNames);

    foreach ($factoriesYaml as $entry) {
      $this->assertContains($entry['class'], $classNames);
    }
  }

  /**
   * Get the Factory class names from the filesystems directory.
   *
   * @return array
   *   Class names array.
   */
  private function getFactoryClassNamesFromFilesystem() {
    $files = \scandir(
      // Go to the project root directory.
      \dirname(\dirname(\dirname(\dirname(__DIR__)))) . '/src/Event/Preprocess/Factory',
      SCANDIR_SORT_NONE
    );

    $invalidFactories = [
      '.',
      '..',
      'PreprocessEventFactoryInterface.php',
    ];
    $files = \array_filter($files, function ($file) use ($invalidFactories) {
      return !\in_array($file, $invalidFactories, TRUE);
    });

    $classNames = [];
    foreach ($files as $file) {
      $classNames[] = 'Drupal\\hook_event_dispatcher\\Event\\Preprocess\\Factory\\' . \substr($file, 0, -4);
    }
    return $classNames;
  }

  /**
   * Test a none existing hook.
   */
  public function testNoneExistingHook() {
    $factory = $this->mapper->getFactory('NoneExistingHook');
    $this->assertEquals(NULL, $factory);
  }

}
