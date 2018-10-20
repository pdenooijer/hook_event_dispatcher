<?php

namespace Drupal\hook_event_dispatcher;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderInterface;
use Drupal\hook_event_dispatcher\Service\PreprocessEventPass;

/**
 * Class PreprocessEventServiceProvider.
 */
final class HookEventDispatcherServiceProvider implements ServiceProviderInterface {

  /**
   * {@inheritdoc}
   */
  public function register(ContainerBuilder $container) {
    $container->addCompilerPass(new PreprocessEventPass());
  }

}
