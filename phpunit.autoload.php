<?php

/**
 * @file
 * PHPUnit autoload.
 */

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/hook_event_dispatcher.module';
require __DIR__ . '/modules/core_event_dispatcher/core_event_dispatcher.module';
require __DIR__ . '/modules/field_event_dispatcher/field_event_dispatcher.module';
require __DIR__ . '/modules/media_event_dispatcher/media_event_dispatcher.module';
require __DIR__ . '/modules/path_event_dispatcher/path_event_dispatcher.module';
require __DIR__ . '/modules/preprocess_event_dispatcher/preprocess_event_dispatcher.module';
require __DIR__ . '/modules/toolbar_event_dispatcher/toolbar_event_dispatcher.module';
require __DIR__ . '/modules/user_event_dispatcher/user_event_dispatcher.module';
require __DIR__ . '/modules/views_event_dispatcher/views_event_dispatcher.module';
require __DIR__ . '/modules/webform_event_dispatcher/webform_event_dispatcher.module';
