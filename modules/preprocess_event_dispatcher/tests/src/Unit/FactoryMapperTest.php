<?php

namespace Drupal\Tests\preprocess_event_dispatcher\Unit;

use Drupal\Tests\preprocess_event_dispatcher\Unit\Helpers\YamlDefinitionsLoader;
use PHPUnit\Framework\TestCase;
use function array_filter;
use function count;
use function dirname;
use function in_array;
use function scandir;
use function substr;

/**
 * Class FactoryMapperTest.
 *
 * @group preprocess_event_dispatcher
 */
final class FactoryMapperTest extends TestCase {

  /**
   * Factory mapper.
   *
   * @var \Drupal\preprocess_event_dispatcher\Service\PreprocessEventFactoryMapper
   */
  private $mapper;

  /**
   * {@inheritdoc}
   */
  public function setUp(): void {
    $this->mapper = YamlDefinitionsLoader::getInstance()->getMapper();
  }

  /**
   * Test if all factories are in the YAML file.
   */
  public function testYamlHasAllFactories(): void {
    $factoriesYaml = YamlDefinitionsLoader::getInstance()->getFactories();
    $classNames = $this->getFactoryClassNamesFromFilesystem();

    self::assertCount(count($factoriesYaml), $classNames);

    foreach ($factoriesYaml as $entry) {
      self::assertContains($entry['class'], $classNames);
    }
  }

  /**
   * Get the Factory class names from the filesystems directory.
   *
   * @return array
   *   Class names array.
   */
  private function getFactoryClassNamesFromFilesystem(): array {
    $files = scandir(
      // Go to the project root directory.
      dirname(__DIR__, 3) . '/src/Factory',
      SCANDIR_SORT_NONE
    );

    $invalidFactories = [
      '.',
      '..',
      'PreprocessEventFactoryInterface.php',
    ];
    $files = array_filter($files, static function ($file) use ($invalidFactories) {
      return !in_array($file, $invalidFactories, TRUE);
    });

    $classNames = [];
    foreach ($files as $file) {
      $classNames[] = 'Drupal\\preprocess_event_dispatcher\\Factory\\' . substr($file, 0, -4);
    }
    return $classNames;
  }

  /**
   * Test a none existing hook.
   */
  public function testNoneExistingHook(): void {
    $factory = $this->mapper->getFactory('NoneExistingHook');
    self::assertNull($factory);
  }

}
