<?php

namespace Drupal\hook_event_dispatcher\Event\Views;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\views\ViewExecutable;
use Symfony\Component\EventDispatcher\Event;

abstract class BaseViewsEvent extends Event implements EventInterface {

  /**
   * @var \Drupal\views\ViewExecutable
   */
  private $view;

  /**
   * ViewsPreExecuteEevent constructor.
   *
   * @param \Drupal\views\ViewExecutable $view
   */
  public function __construct(ViewExecutable $view) {
    $this->view = $view;
  }

  /**
   * @return \Drupal\views\ViewExecutable
   */
  public function getView(): \Drupal\views\ViewExecutable {
    return $this->view;
  }

}
