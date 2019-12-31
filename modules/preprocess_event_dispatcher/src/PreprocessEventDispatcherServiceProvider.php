<?php

namespace Drupal\preprocess_event_dispatcher;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderInterface;
use Drupal\preprocess_event_dispatcher\Service\PreprocessEventPass;

/**
 * Class PreprocessEventServiceProvider.
 */
final class PreprocessEventDispatcherServiceProvider implements ServiceProviderInterface {

  /**
   * {@inheritdoc}
   */
  public function register(ContainerBuilder $container): void {
    $container->addCompilerPass(new PreprocessEventPass());
  }

}
