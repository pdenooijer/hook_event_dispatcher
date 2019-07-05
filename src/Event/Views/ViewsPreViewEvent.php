<?php

namespace Drupal\hook_event_dispatcher\Event\Views;

use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\views\ViewExecutable;

/**
 * Class ViewsPreRenderEvent.
 */
class ViewsPreViewEvent extends BaseViewsEvent {

  /**
   * Array of arguments passed into the view.
   *
   * @var array
   */
  protected $args;

  /**
   * The machine name of the active display.
   *
   * @var string
   */
  private $displayId;

  /**
   * ViewsPreExecuteEevent constructor.
   *
   * @param \Drupal\views\ViewExecutable $view
   *   The view object about to be processed.
   * @param string $display_id
   *   The machine name of the active display.
   * @param array $args
   *   An array of arguments passed into the view.
   */
  public function __construct(ViewExecutable $view, $display_id, array &$args) {
    parent::__construct($view);
    $this->displayId = $display_id;
    $this->args = &$args;
  }

  /**
   * Get the machine name of the active display.
   *
   * @return string
   *   The machine name of the active display.
   */
  public function getDisplayId() {
    return $this->displayId;
  }

  /**
   * Get the array of view arguments.
   *
   * @return array
   *   The array of arguments passed into the view.
   */
  public function &getArgs() {
    return $this->args;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType() {
    return HookEventDispatcherInterface::VIEWS_PRE_VIEW;
  }

}
