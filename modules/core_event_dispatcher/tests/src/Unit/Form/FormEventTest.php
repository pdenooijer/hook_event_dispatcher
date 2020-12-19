<?php

namespace Drupal\Tests\core_event_dispatcher\Unit\Form;

use Drupal;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Form\FormStateInterface;
use Drupal\core_event_dispatcher\Event\Form\FormAlterEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy;
use PHPUnit\Framework\TestCase;
use function core_event_dispatcher_form_alter;

/**
 * Class FormEventTest.
 *
 * @group core_event_dispatcher
 */
class FormEventTest extends TestCase {

  /**
   * The manager.
   *
   * @var \Drupal\Tests\hook_event_dispatcher\Unit\HookEventDispatcherManagerSpy
   */
  private $manager;

  /**
   * {@inheritdoc}
   */
  public function setUp(): void {
    $builder = new ContainerBuilder();
    $this->manager = new HookEventDispatcherManagerSpy();
    $builder->set('hook_event_dispatcher.manager', $this->manager);
    $builder->compile();
    Drupal::setContainer($builder);
  }

  /**
   * Test FormAlterEvent.
   */
  public function testFormAlterEvent(): void {
    $form = $expectedForm = ['test' => 'form'];
    $formState = $this->createMock(FormStateInterface::class);
    $formId = 'test_form';

    $this->manager->setEventCallbacks([
      HookEventDispatcherInterface::FORM_ALTER => static function (FormAlterEvent $event) {
        $form = &$event->getForm();
        $form['test2'] = 'test_altered';
      },
    ]);
    $this->manager->setMaxEventCount(2);

    core_event_dispatcher_form_alter($form, $formState, $formId);

    $expectedForm['test2'] = 'test_altered';
    self::assertSame($expectedForm, $form);

    /** @var \Drupal\core_event_dispatcher\Event\Form\FormAlterEvent $event */
    $event = $this->manager->getRegisteredEvent(HookEventDispatcherInterface::FORM_ALTER);
    self::assertSame($form, $event->getForm());
    self::assertSame($formState, $event->getFormState());
    self::assertSame($formId, $event->getFormId());
  }

  /**
   * Test FormBaseAlterEvent.
   */
  public function testFormBaseAlterEvent(): void {
    $baseFormId = 'test_base_form';
    $form = ['test' => 'form'];
    $buildInfo = ['base_form_id' => $baseFormId];
    $formState = $this->createMock(FormStateInterface::class);
    $formState->method('getBuildInfo')
      ->willReturn($buildInfo);
    $formId = 'test_form';

    $this->manager->setMaxEventCount(3);

    core_event_dispatcher_form_alter($form, $formState, $formId);

    /** @var \Drupal\core_event_dispatcher\Event\Form\FormBaseAlterEvent $event */
    $event = $this->manager->getRegisteredEvent("hook_event_dispatcher.form_base_$baseFormId.alter");
    self::assertEquals($form, $event->getForm());
    self::assertEquals($formState, $event->getFormState());
    self::assertEquals($formId, $event->getFormId());
    self::assertEquals($baseFormId, $event->getBaseFormId());
  }

  /**
   * Test FormIdAlterEvent.
   */
  public function testFormIdAlterEvent(): void {
    $form = ['test' => 'form'];
    $formState = $this->createMock(FormStateInterface::class);
    $formId = 'test_form';

    $this->manager->setMaxEventCount(2);

    core_event_dispatcher_form_alter($form, $formState, $formId);

    /** @var \Drupal\core_event_dispatcher\Event\Form\FormAlterEvent $event */
    $event = $this->manager->getRegisteredEvent("hook_event_dispatcher.form_$formId.alter");
    self::assertEquals($form, $event->getForm());
    self::assertEquals($formState, $event->getFormState());
    self::assertEquals($formId, $event->getFormId());
  }

}
