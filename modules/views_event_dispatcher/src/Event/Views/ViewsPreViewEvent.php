<?php

namespace Drupal\views_event_dispatcher\Event\Views;

use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\views\ViewExecutable;

/**
 * Class ViewsPreRenderEvent.
 */
class ViewsPreViewEvent extends AbstractViewsEvent {

  /**
   * Array of arguments passed into the view.
   *
   * @var array
   */
  private $arguments;
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
   * @param string $displayId
   *   The machine name of the active display.
   * @param array $arguments
   *   An array of arguments passed into the view.
   */
  public function __construct(ViewExecutable $view, $displayId, array &$arguments) {
    parent::__construct($view);
    $this->displayId = $displayId;
    $this->arguments = &$arguments;
  }

  /**
   * Get the machine name of the active display.
   *
   * @return string
   *   The machine name of the active display.
   */
  public function getDisplayId(): string {
    return $this->displayId;
  }

  /**
   * Get the array of view arguments.
   *
   * @return array
   *   The array of arguments passed into the view.
   */
  public function &getArguments(): array {
    return $this->arguments;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::VIEWS_PRE_VIEW;
  }

}
