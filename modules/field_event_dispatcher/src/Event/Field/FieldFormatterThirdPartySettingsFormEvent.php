<?php

namespace Drupal\field_event_dispatcher\Event\Field;

use Drupal\Core\Field\FormatterInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;

/**
 * Class FieldFormatterThirdPartySettingsFormEvent.
 */
class FieldFormatterThirdPartySettingsFormEvent extends AbstractFieldThirdPartySettingsFormEvent {

  /**
   * The instantiated field formatter plugin.
   *
   * @var \Drupal\Core\Field\FormatterInterface
   */
  private $plugin;

  /**
   * The entity view mode.
   *
   * @var string
   */
  private $viewMode;

  /**
   * FieldFormatterThirdPartySettingsFormEvent constructor.
   *
   * @param \Drupal\Core\Field\FormatterInterface $plugin
   *   The instantiated field formatter plugin.
   * @param \Drupal\Core\Field\FieldDefinitionInterface $fieldDefinition
   *   The field definition.
   * @param string $viewMode
   *   The entity view mode.
   * @param array $form
   *   The (entire) configuration form array.
   * @param \Drupal\Core\Form\FormStateInterface $formState
   *   The form state.
   */
  public function __construct(
    FormatterInterface $plugin,
    FieldDefinitionInterface $fieldDefinition,
    string $viewMode,
    array $form,
    FormStateInterface $formState
  ) {
    $this->plugin = $plugin;
    $this->fieldDefinition = $fieldDefinition;
    $this->viewMode = $viewMode;
    $this->form = $form;
    $this->formState = $formState;
  }

  /**
   * Get the instantiated field formatter plugin.
   *
   * @return \Drupal\Core\Field\FormatterInterface
   *   A field formatter plugin.
   */
  public function getPlugin(): FormatterInterface {
    return $this->plugin;
  }

  /**
   * Get the entity view mode.
   *
   * @return string
   *   The current view mode.
   */
  public function getViewMode(): string {
    return $this->viewMode;
  }

  /**
   * {@inheritdoc}
   */
  public function getDispatcherType(): string {
    return HookEventDispatcherInterface::FIELD_FORMATTER_THIRD_PARTY_SETTINGS_FORM;
  }

}
