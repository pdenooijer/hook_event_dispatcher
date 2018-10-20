<?php

namespace Drupal\hook_event_dispatcher\Event\Views;

use Drupal\hook_event_dispatcher\Event\EventInterface;
use Drupal\views\ViewExecutable;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class BaseViewsEvent.
 */
abstract class BaseViewsEvent extends Event implements EventInterface {

  /**
   * The view.
   *
   * @var \Drupal\views\ViewExecutable
   */
  private $view;

  /**
   * ViewsPreExecuteEevent constructor.
   *
   * @param \Drupal\views\ViewExecutable $view
   *   The view.
   */
  public function __construct(ViewExecutable $view) {
    $this->view = $view;
  }

  /**
   * Get the view.
   *
   * @return \Drupal\views\ViewExecutable
   *   The view.
   */
  public function getView() {
    return $this->view;
  }

}
