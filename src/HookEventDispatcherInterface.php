<?php

namespace Drupal\hook_event_dispatcher;

/**
 * Interface HookEventDispatcherInterface.
 */
interface HookEventDispatcherInterface {

  /**
   * Event name prefix to prevent name collision.
   */
  public const PREFIX = 'hook_event_dispatcher.';

  // ENTITY EVENTS.
  /**
   * Respond to creation of a new entity.
   *
   * @Event
   *
   * @see core_event_dispatcher_entity_insert()
   * @see hook_entity_insert()
   *
   * @var string
   */
  public const ENTITY_INSERT = self::PREFIX . 'entity.insert';

  /**
   * Respond to updates to an entity.
   *
   * @Event
   *
   * @see core_event_dispatcher_entity_update()
   * @see hook_entity_update()
   *
   * @var string
   */
  public const ENTITY_UPDATE = self::PREFIX . 'entity.update';

  /**
   * Act before entity deletion.
   *
   * @Event
   *
   * @see core_event_dispatcher_entity_predelete()
   * @see hook_entity_predelete()
   *
   * @var string
   */
  public const ENTITY_PRE_DELETE = self::PREFIX . 'entity.predelete';

  /**
   * Respond to entity deletion.
   *
   * @Event
   *
   * @see core_event_dispatcher_entity_delete()
   * @see hook_entity_delete()
   *
   * @var string
   */
  public const ENTITY_DELETE = self::PREFIX . 'entity.delete';

  /**
   * Act on an entity before it is created or updated.
   *
   * @Event
   *
   * @see core_event_dispatcher_entity_presave()
   * @see hook_entity_presave()
   *
   * @var string
   */
  public const ENTITY_PRE_SAVE = self::PREFIX . 'entity.presave';

  /**
   * Alter entity renderable values before cache checking in drupal_render().
   *
   * @Event
   *
   * @see core_event_dispatcher_entity_build_defaults_alter()
   * @see hook_entity_build_defaults_alter()
   *
   * @var string
   */
  public const ENTITY_BUILD_DEFAULTS_ALTER = self::PREFIX . 'entity.build_defaults_alter';

  /**
   * Act on entities being assembled before rendering.
   *
   * @Event
   *
   * @see core_event_dispatcher_entity_view()
   * @see hook_entity_view()
   *
   * @var string
   */
  public const ENTITY_VIEW = self::PREFIX . 'entity.view';

  /**
   * Alter a entity being assembled right before rendering.
   *
   * @Event
   *
   * @see core_event_dispatcher_entity_view_alter()
   * @see hook_entity_view_alter()
   *
   * @var string
   */
  public const ENTITY_VIEW_ALTER = self::PREFIX . 'entity.view_alter';


  /**
   * Control entity operation access.
   *
   * @Event
   *
   * @see core_event_dispatcher_entity_access()
   * @see hook_entity_access()
   *
   * @var string
   */
  public const ENTITY_ACCESS = self::PREFIX . 'entity.access';

  /**
   * Acts when creating a new entity.
   *
   * @Event
   *
   * @see core_event_dispatcher_entity_create()
   * @see hook_entity_create()
   *
   * @var string
   */
  public const ENTITY_CREATE = self::PREFIX . 'entity.create';

  /**
   * Act on entities when loaded.
   *
   * @Event
   *
   * @see core_event_dispatcher_entity_load()
   * @see hook_entity_load()
   *
   * @var string
   */
  public const ENTITY_LOAD = self::PREFIX . 'entity.load';

  /**
   * Respond to creation of a new entity translation.
   *
   * @Event
   *
   * @see core_event_dispatcher_entity_translation_insert()
   * @see hook_entity_translation_insert()
   *
   * @var string
   */
  public const ENTITY_TRANSLATION_INSERT = self::PREFIX . 'entity.translation_insert';

  /**
   * Respond to deletion of a new entity translation.
   *
   * @Event
   *
   * @see core_event_dispatcher_entity_translation_delete()
   * @see hook_entity_translation_delete()
   *
   * @var string
   */
  public const ENTITY_TRANSLATION_DELETE = self::PREFIX . 'entity.translation_delete';

  /**
   * Alter forms for field widgets provided by other modules.
   *
   * @Event
   *
   * @see field_event_dispatcher_field_widget_form_alter()
   * @see hook_field_widget_form_alter()
   *
   * @var string
   */
  public const WIDGET_FORM_ALTER = self::PREFIX . 'widget_form.alter';

  /**
   * Alter forms for multi-value field widgets provided by other modules.
   *
   * @Event
   *
   * @see field_event_dispatcher_field_widget_multivalue_form_alter()
   * @see hook_field_widget_multivalue_form_alter()
   *
   * @var string
   */
  public const WIDGET_MULTIVALUE_FORM_ALTER = self::PREFIX . 'widget_multivalue_form.alter';

  /**
   * Control access to fields.
   *
   * @Event
   *
   * @see core_event_dispatcher_entity_field_access()
   * @see hook_entity_field_access()
   *
   * @var string
   */
  public const ENTITY_FIELD_ACCESS = self::PREFIX . 'entity_field.access';

  /**
   * Exposes "pseudo-field" components on content entities.
   *
   * @Event
   *
   * @see core_event_dispatcher_entity_extra_field_info()
   * @see hook_entity_extra_field_info()
   *
   * @var string
   */
  public const ENTITY_EXTRA_FIELD_INFO = self::PREFIX . 'entity_extra_field.info';

  /**
   * Alter "pseudo-field" components on content entities.
   *
   * @Event
   *
   * @see core_event_dispatcher_entity_extra_field_info_alter()
   * @see hook_entity_extra_field_info_alter()
   *
   * @var string
   */
  public const ENTITY_EXTRA_FIELD_INFO_ALTER = self::PREFIX . 'entity_extra_field.info_alter';

  /**
   * Provides custom base field definitions for a content entity type.
   *
   * @Event
   *
   * @see core_event_dispatcher_entity_base_field_info()
   * @see hook_entity_base_field_info()
   *
   * @var string
   */
  public const ENTITY_BASE_FIELD_INFO = self::PREFIX . 'entity_base.field_info';

  /**
   * Alter base field definitions for a content entity type.
   *
   * @Event
   *
   * @see core_event_dispatcher_entity_base_field_info_alter()
   * @see hook_entity_base_field_info_alter()
   *
   * @var string
   */
  public const ENTITY_BASE_FIELD_INFO_ALTER = self::PREFIX . 'entity_base.field_info_alter';

  /**
   * Alter bundle field definitions.
   *
   * @Event
   *
   * @see core_event_dispatcher_entity_bundle_field_info_alter()
   * @see hook_entity_bundle_field_info_alter()
   *
   * @var string
   */
  public const ENTITY_BUNDLE_FIELD_INFO_ALTER = self::PREFIX . 'entity_bundle.field_info_alter';

  /**
   * Entity operation.
   *
   * @Event
   *
   * @see core_event_dispatcher_entity_operation()
   * @see hook_entity_operation()
   *
   * @var string
   */
  public const ENTITY_OPERATION = self::PREFIX . 'entity.operation';

  /**
   * Entity operation alter.
   *
   * @Event
   *
   * @see core_event_dispatcher_entity_operation_alter()
   * @see hook_entity_operation_alter()
   *
   * @var string
   */
  public const ENTITY_OPERATION_ALTER = self::PREFIX . 'entity.operation_alter';

  /**
   * Add to entity type definitions..
   *
   * @Event
   *
   * @see core_event_dispatcher_entity_type_alter()
   * @see hook_entity_type_alter()
   *
   * @var string
   */
  public const ENTITY_TYPE_ALTER = self::PREFIX . 'entity_type.alter';

  /**
   * Add to entity type definitions..
   *
   * @Event
   *
   * @see core_event_dispatcher_entity_type_build()
   * @see hook_entity_type_build()
   *
   * @var string
   */
  public const ENTITY_TYPE_BUILD = self::PREFIX . 'entity_type.build';

  // FIELD EVENTS.
  /**
   * Perform alterations on Field API formatter types.
   *
   * @Event
   *
   * @see field_event_dispatcher_field_formatter_info_alter()
   * @see hook_field_formatter_info_alter()
   *
   * @var string
   */
  public const FIELD_FORMATTER_INFO_ALTER = self::PREFIX . 'field_formatter.info.alter';

  /**
   * Alters the field formatter settings summary.
   *
   * @Event
   *
   * @see field_event_dispatcher_field_formatter_settings_summary_alter()
   * @see hook_field_formatter_settings_summary_alter()
   *
   * @var string
   */
  public const FIELD_FORMATTER_SETTINGS_SUMMARY_ALTER = self::PREFIX . 'field_formatter.settings_summary.alter';

  /**
   * Allow modules to add field formatter settings provided by other modules.
   *
   * @Event
   *
   * @see field_event_dispatcher_field_formatter_third_party_settings_form()
   * @see hook_field_formatter_third_party_settings_form()
   *
   * @var string
   */
  public const FIELD_FORMATTER_THIRD_PARTY_SETTINGS_FORM = self::PREFIX . 'field_formatter.third_party.settings_form';

  /**
   * Alters the field widget settings summary.
   *
   * @Event
   *
   * @see field_event_dispatcher_field_widget_settings_summary_alter()
   * @see hook_field_widget_settings_summary_alter()
   *
   * @var string
   */
  public const FIELD_WIDGET_SETTINGS_SUMMARY_ALTER = self::PREFIX . 'field_widget.settings_summary.alter';

  /**
   * Allow modules to add settings to field widgets provided by other modules.
   *
   * @Event
   *
   * @see field_event_dispatcher_field_widget_third_party_settings_form()
   * @see hook_field_widget_third_party_settings_form()
   *
   * @var string
   */
  public const FIELD_WIDGET_THIRD_PARTY_SETTINGS_FORM = self::PREFIX . 'field_widget.third_party.settings_form';

  // FORM EVENTS.
  /**
   * Perform alterations before a form is rendered.
   *
   * @Event
   *
   * @see core_event_dispatcher_form_alter()
   * @see hook_form_alter()
   *
   * @var string
   */
  public const FORM_ALTER = self::PREFIX . 'form.alter';

  // BLOCK EVENTS.
  /**
   * Alter the result of \Drupal\Core\Block\BlockBase::build().
   *
   * @Event
   *
   * @see core_event_dispatcher_block_build_alter()
   * @see hook_block_build_alter()
   *
   * @var string
   */
  public const BLOCK_BUILD_ALTER = self::PREFIX . 'block_build.alter';

  // TOKEN EVENTS.
  /**
   * Provide replacement values for placeholder tokens.
   *
   * @Event
   *
   * @see core_event_dispatcher_tokens()
   * @see hook_tokens()
   *
   * @var string
   */
  public const TOKEN_REPLACEMENT = self::PREFIX . 'token.replacement';

  /**
   * Provide information about available placeholder tokens and token types.
   *
   * @Event
   *
   * @see core_event_dispatcher_token_info()
   * @see hook_token_info()
   *
   * @var string
   */
  public const TOKEN_INFO = self::PREFIX . 'token.info';

  // PATH EVENTS.
  /**
   * Respond to a path being inserted.
   *
   * @Event
   *
   * @see path_event_dispatcher_path_insert()
   * @see hook_path_insert()
   *
   * @var string
   */
  public const PATH_INSERT = self::PREFIX . 'path.insert';

  /**
   * Respond to a path being deleted.
   *
   * @Event
   *
   * @see path_event_dispatcher_path_delete()
   * @see hook_path_delete()
   *
   * @var string
   */
  public const PATH_DELETE = self::PREFIX . 'path.delete';

  /**
   * Respond to a path being updated.
   *
   * @Event
   *
   * @see path_event_dispatcher_path_update()
   * @see hook_path_update()
   *
   * @var string
   */
  public const PATH_UPDATE = self::PREFIX . 'path.update';

  // VIEWS EVENTS.
  /**
   * Describe data tables and fields (or the equivalent) to Views.
   *
   * @Event
   *
   * @see views_event_dispatcher_views_data()
   * @see hook_views_data()
   *
   * @var string
   */
  public const VIEWS_DATA = self::PREFIX . 'views.data';

  /**
   * Alter the table and field information from hook_views_data().
   *
   * @Event
   *
   * @see views_event_dispatcher_views_data_alter()
   * @see hook_views_data_alter()
   *
   * @var string
   */
  public const VIEWS_DATA_ALTER = self::PREFIX . 'views.data_alter';

  /**
   * Alter a view at the very beginning of Views processing.
   *
   * @Event
   *
   * @see views_event_dispatcher_views_pre_view()
   * @see hook_views_pre_view()
   *
   * @var string
   */
  public const VIEWS_PRE_VIEW = self::PREFIX . 'views.pre_view';

  /**
   * Act on the view after the query is built and just before it is executed.
   *
   * @Event
   *
   * @see views_event_dispatcher_views_pre_execute()
   * @see hook_views_pre_execute()
   *
   * @var string
   */
  public const VIEWS_PRE_EXECUTE = self::PREFIX . 'views.pre_execute';

  /**
   * Act on the view immediately before rendering it.
   *
   * @Event
   *
   * @see views_event_dispatcher_views_pre_render()
   * @see hook_views_pre_render()
   *
   * @var string
   */
  public const VIEWS_PRE_RENDER = self::PREFIX . 'views.pre_render';

  /**
   * Act on the view immediately after the query has been executed.
   *
   * @Event
   *
   * @see views_event_dispatcher_views_post_execute()
   * @see hook_views_post_execute()
   *
   * @var string
   */
  public const VIEWS_POST_EXECUTE = self::PREFIX . 'views.post_execute';

  /**
   * Post-process any rendered data.
   *
   * @Event
   *
   * @see views_event_dispatcher_views_post_render()
   * @see hook_views_post_render()
   *
   * @var string
   */
  public const VIEWS_POST_RENDER = self::PREFIX . 'views.post_render';

  /**
   * Act on the view before the query is built, but after displays are attached.
   *
   * @Event
   *
   * @see views_event_dispatcher_views_pre_build()
   * @see hook_views_pre_build()
   *
   * @var string
   */
  public const VIEWS_PRE_BUILD = self::PREFIX . 'views.pre_build';

  /**
   * Act on the view immediately after the query is built.
   *
   * @Event
   *
   * @see views_event_dispatcher_views_post_build()
   * @see hook_views_post_build()
   *
   * @var string
   */
  public const VIEWS_POST_BUILD = self::PREFIX . 'views.post_build';

  /**
   * Alter the query before it is executed.
   *
   * @Event
   *
   * @see views_event_dispatcher_views_query_alter()
   * @see hook_views_query_alter()
   */
  public const VIEWS_QUERY_ALTER = self::PREFIX . 'views.query_alter';

  /**
   * Replace special strings in the query before it is executed.
   *
   * @Event
   *
   * @see views_event_dispatcher_views_query_substitutions()
   * @see hook_views_query_substitutions()
   */
  public const VIEWS_QUERY_SUBSTITUTIONS = self::PREFIX . 'views.query_substitutions';

  // THEME EVENTS.
  /**
   * Register a module or theme's theme implementations.
   *
   * @Event
   *
   * @see core_event_dispatcher_theme()
   * @see hook_theme()
   *
   * @var string
   */
  public const THEME = self::PREFIX . 'theme';

  /**
   * Alter the theme registry information returned from hook_theme().
   *
   * @Event
   *
   * @see core_event_dispatcher_theme_registry_alter()
   * @see hook_theme_registry_alter()
   *
   * @var string
   */
  public const THEME_REGISTRY_ALTER = self::PREFIX . 'theme.registry_alter';

  /**
   * Alters named suggestions for all theme hooks.
   *
   * @Event
   *
   * @see core_event_dispatcher_theme_suggestions_alter()
   * @see hook_theme_suggestions_alter()
   *
   * @var string
   */
  public const THEME_SUGGESTIONS_ALTER = self::PREFIX . 'theme.suggestions_alter';

  /**
   * Respond to themes being installed.
   *
   * @Event
   *
   * @see core_event_dispatcher_themes_installed()
   * @see hook_themes_installed()
   *
   * @var string
   */
  public const THEMES_INSTALLED = self::PREFIX . 'theme.installed';

  /**
   * Alter the default, hook-independent variables for all templates.
   *
   * @Event
   *
   * @see core_event_dispatcher_template_preprocess_default_variables_alter()
   * @see hook_template_preprocess_default_variables_alter()
   *
   * @var string
   */
  public const TEMPLATE_PREPROCESS_DEFAULT_VARIABLES_ALTER = self::PREFIX . 'theme.template_preprocess_default_variables_alter';

  /**
   * Perform necessary alterations to the JS before it is presented on the page.
   *
   * @Event
   *
   * @see core_event_dispatcher_js_alter()
   * @see hook_js_alter()
   *
   * @var string
   */
  public const JS_ALTER = self::PREFIX . 'js.alter';

  /**
   * Alter the library info provided by an extension.
   *
   * @Event
   *
   * @see core_event_dispatcher_library_info_alter()
   * @see hook_library_info_alter()
   *
   * @var string
   */
  public const LIBRARY_INFO_ALTER = self::PREFIX . 'library.info_alter';

  // USER EVENTS.
  /**
   * Act on user account cancellations.
   *
   * @Event
   *
   * @see user_event_dispatcher_user_cancel()
   * @see hook_user_cancel()
   *
   * @var string
   */
  public const USER_CANCEL = self::PREFIX . 'user.cancel';

  /**
   * Modify account cancellation methods.
   *
   * @Event
   *
   * @see user_event_dispatcher_user_cancel_methods_alter()
   * @see hook_user_cancel_methods_alter()
   *
   * @var string
   */
  public const USER_CANCEL_METHODS_ALTER = self::PREFIX . 'user.cancel_methods_alter';

  /**
   * The user just logged in.
   *
   * @Event
   *
   * @see user_event_dispatcher_user_login()
   * @see hook_user_login()
   *
   * @var string
   */
  public const USER_LOGIN = self::PREFIX . 'user.login';

  /**
   * The user just logged out.
   *
   * @Event
   *
   * @see user_event_dispatcher_user_logout()
   * @see hook_user_logout()
   *
   * @var string
   */
  public const USER_LOGOUT = self::PREFIX . 'user.logout';

  /**
   * Alter the username that is displayed for a user.
   *
   * @Event
   *
   * @see user_event_dispatcher_user_format_name_alter()
   * @see hook_user_format_name_alter()
   *
   * @var string
   */
  public const USER_FORMAT_NAME_ALTER = self::PREFIX . 'user.format_name_alter';

  // TOOLBAR EVENTS.
  /**
   * Alter the toolbar menu after hook_toolbar() is invoked.
   *
   * @Event
   *
   * @see toolbar_event_dispatcher_toolbar()
   * @see hook_toolbar()
   *
   * @var string
   */
  public const TOOLBAR = self::PREFIX . 'toolbar';

  /**
   * Alter the toolbar menu after hook_toolbar() is invoked.
   *
   * @Event
   *
   * @see toolbar_event_dispatcher_toolbar_alter()
   * @see hook_toolbar_alter()
   *
   * @var string
   */
  public const TOOLBAR_ALTER = self::PREFIX . 'toolbar.alter';

  // PAGE EVENTS.
  /**
   * Add a renderable array to the top of the page.
   *
   * @Event
   *
   * @see core_event_dispatcher_page_top()
   * @see hook_page_top()
   *
   * @var string
   */
  public const PAGE_TOP = self::PREFIX . 'page.top';

  /**
   * Add a renderable array to the bottom of the page.
   *
   * @Event
   *
   * @see core_event_dispatcher_page_bottom()
   * @see hook_page_bottom()
   *
   * @var string
   */
  public const PAGE_BOTTOM = self::PREFIX . 'page.bottom';

  /**
   * Add attachments (typically assets) to a page before it is rendered.
   *
   * Attachments should be added to individual element render arrays whenever
   * possible, as per Drupal best practices, so only use this when that isn't
   * practical or you need to target the page itself.
   *
   * @Event
   *
   * @see core_event_dispatcher_page_attachments()
   * @see hook_page_attachments()
   *
   * @var string
   */
  public const PAGE_ATTACHMENTS = self::PREFIX . 'page.attachments';

  // CORE EVENTS.
  /**
   * Perform periodic actions.
   *
   * @Event
   *
   * @see core_event_dispatcher_cron()
   * @see hook_cron()
   *
   * @var string
   */
  public const CRON = self::PREFIX . 'cron';

  // LANGUAGE EVENTS.
  /**
   * Alter the links generated to switch languages.
   *
   * @Event
   *
   * @see core_event_dispatcher_language_switch_links_alter()
   * @see hook_language_switch_links_alter()
   *
   * @var string
   */
  public const LANGUAGE_SWITCH_LINKS_ALTER = self::PREFIX . 'language.switch_links_alter';

  // WEBFORM EVENTS.
  /**
   * Respond to webform elements being rendered.
   *
   * @Event
   *
   * @see webform_event_dispatcher_webform_element_alter()
   * @see hook_webform_element_alter()
   *
   * @var string
   */
  public const WEBFORM_ELEMENT_ALTER = self::PREFIX . 'webform.element.alter';

  /**
   * Respond to webform element info being initialized.
   *
   * @Event
   *
   * @see webform_event_dispatcher_webform_element_info_alter()
   * @see hook_webform_element_info_alter()
   *
   * @var string
   */
  public const WEBFORM_ELEMENT_INFO_ALTER = self::PREFIX . 'webform.element.info.alter';

  // MEDIA EVENTS.
  /**
   * Alters the information provided in \Drupal\media\Annotation\MediaSource.
   *
   * @Event
   *
   * @see media_event_dispatcher_media_source_info_alter()
   * @see hook_media_source_info_alter()
   *
   * @var string
   */
  public const MEDIA_SOURCE_INFO_ALTER = self::PREFIX . 'media.source_info_alter';

  /**
   * Alters an oEmbed resource URL before it is fetched.
   *
   * @Event
   *
   * @see media_event_dispatcher_oembed_resource_url_alter()
   * @see hook_oembed_resource_url_alter()
   *
   * @var string
   */
  public const MEDIA_OEMBED_RESOURCE_DATA_ALTER = self::PREFIX . 'media.oembed_url_alter';

}
