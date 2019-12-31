<?php

/**
 * @file
 * PHPUnit autoload.
 */

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/hook_event_dispatcher.module';
require __DIR__ . '/modules/media_event_dispatcher/media_event_dispatcher.module';
require __DIR__ . '/modules/preprocess_event_dispatcher/preprocess_event_dispatcher.module';
require __DIR__ . '/modules/webform_event_dispatcher/webform_event_dispatcher.module';
