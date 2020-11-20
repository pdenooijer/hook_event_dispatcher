Description
-----------
This module dispatches events for several drupal core hooks. This allows you to
use the D8 Event Subscriber system instead of the outdated hook system to react
on certain events. The module includes events for the most common hooks.

If you want to see new events registered, open an issue in the issue queue and
we will try to add it. Hopefully, in the near future, D8 core will put this
into core.

Installation
------------
To install this module, do the following:

With composer:
1. ```composer require drupal/hook_event_dispatcher```

Manual installation:
1. Extract the tar ball that you downloaded from Drupal.org.
2. Upload the entire directory and all its contents to your modules directory.

Examples
--------
You can find an example on how to use each Event in src/Example

Upgrading from 1.x to 2.x
------------------------
The 2.x version has been refactored to include several submodules that will
need to be enabled in addition to the main hook_event_dispatcher modules, in
order to use the events they expose. These currently include:

 - core_event_dispatcher
 - field_event_dispatcher
 - media_event_dispatcher
 - path_event_dispatcher
 - preprocess_event_dispatcher
 - toolbar_event_dispatcher
 - user_event_dispatcher
 - views_event_dispatcher
 - webform_event_dispatcher

For example, for Core hooks like THEME, the submodule of
'core_event_dispatcher' has to be enabled for the site to continue working
properly and the namespace of the used event will need to be updated.
