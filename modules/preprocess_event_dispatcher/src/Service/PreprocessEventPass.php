<?php

namespace Drupal\preprocess_event_dispatcher\Service;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use function array_keys;

/**
 * Class PreprocessEventPass.
 */
final class PreprocessEventPass implements CompilerPassInterface {

  /**
   * Add the PreprocessEventFactories to the PreprocessEventFactoryMapper.
   *
   * First get the factory defaults and then append the new/overrides to them.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
   *   Drupal container.
   */
  public function process(ContainerBuilder $container): void {
    $factoryMapper = $container->getDefinition('preprocess_event.factory_mapper');

    $factoryIds = $container->findTaggedServiceIds('preprocess_event_default_factory');
    $factoryIds += $container->findTaggedServiceIds('preprocess_event_factory');

    foreach (array_keys($factoryIds) as $id) {
      $factoryMapper->addMethodCall(
        'addFactory',
        [new Reference($id)]
      );
    }
  }

}
