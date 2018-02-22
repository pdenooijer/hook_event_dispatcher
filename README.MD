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

Add a preprocess event
----------------------
You can find an example how to add a new preprocess event in
src/Example/preprocess_example_module. The event in this module will get
dispatched on the specified hook (example) when enabled.

To add your own preprocess event, you need the following three classes:
1. [hook]PreprocessEvent
2. [hook]EventVariables
3. [hook]PreprocessEventFactory

How you name them is of course up to you, but I suggest to name them like
the already existing ones for consistency.

#### [hook]PreprocessEvent
This is the event that will fire on the specified hook, which contains the
[hook]EventVariables that can be modified by the listener. It should
implement PreprocessEventInterface, but I suggest to extend the
AbstractPreprocessEvent as that will make your life easier.

#### [hook]EventVariables
Wrapper class for the event variables, with helper functions to add, modify
and delete values in the variables array with ease. It should extend the
AbstractEventVariables, as that is the base of all variable classes.

#### [hook]PreprocessEventFactory
This will create the event and the variables so it can be dispatched to the
registered listeners. It should implement the interface
PreprocessEventFactoryInterface. Furthermore the factory should be defined as a
service with the tag preprocess_event_factory.

### Extending already implemented event
It is possible to extend an existing event, to add extra wrapper functions to
the variables for instance. This works the same way as adding a new event. You
need to create a new variables class, which extends the old one and create a
factory that will create the existing event with the improved variables. If you
give the factory the tag preprocess_event_factory it will have precedence over
the default factory, so the old event will not be dispatched.
