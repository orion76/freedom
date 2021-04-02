<?php

namespace Drupal\site_events\Entity\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\site_events\Plugin\SiteEventPluginManagerInterface;
use Drupal\site_events\Plugin\SiteSubscriberPluginManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class SiteEventSubscriberForm.
 */
class SiteEventSubscriberForm extends EntityForm {

    /** @var SiteEventPluginManagerInterface */
    private $eventPlugins;

    /** @var SiteSubscriberPluginManagerInterface */
    private $subscriberPlugins;

    public function __construct(SiteEventPluginManagerInterface $eventPlugins, SiteSubscriberPluginManagerInterface $subscriberPlugins) {
        $this->eventPlugins = $eventPlugins;
        $this->subscriberPlugins = $subscriberPlugins;
    }

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container) {
        return new static(
            $container->get('plugin.manager.site_event'),
            $container->get('plugin.manager.site_subscriber')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function form(array $form, FormStateInterface $form_state) {
        $form = parent::form($form, $form_state);
        /** @var $event_subscriber \Drupal\site_events\Entity\SiteEventSubscriberInterface */
        $event_subscriber = $this->entity;
        $form['label'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Label'),
            '#maxlength' => 255,
            '#default_value' => $event_subscriber->label(),
            '#description' => $this->t("Label for the Event subscriber."),
            '#required' => TRUE,
        ];

        $form['id'] = [
            '#type' => 'machine_name',
            '#default_value' => $event_subscriber->id(),
            '#machine_name' => [
                'exists' => '\Drupal\site_events\Entity\SiteEventSubscriber::load',
            ],
            '#disabled' => !$event_subscriber->isNew(),
        ];

        /** @var $group_storage \Drupal\site_events\SiteEventSubscriberGroupStorageInterface */
        $group_storage = $this->entityTypeManager->getStorage('site_event_subscriber_group');
        $group_options = $group_storage->createOptionsList();


        $form['group_id'] = [
            '#type' => 'select',
            '#title' => $this->t(' Group'),
            '#default_value' => $event_subscriber->getGroupId(),
            '#options' => $group_options,
        ];

        $event_options=$this->eventPlugins->getOptionsList();
        
        $form['event_id'] = [
            '#type' => 'select',
            '#title' => $this->t(' Event'),
            '#default_value' => $event_subscriber->getEventId(),
            '#options' => $event_options,
        ];

        $subscriber_options=$this->subscriberPlugins->getOptionsList();
        $form['subscriber_id'] = [
            '#type' => 'select',
            '#title' => $this->t('Subscriber'),
            '#default_value' => $event_subscriber->getSubscriberId(),
            '#options' => $subscriber_options,
        ];
        
        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function save(array $form, FormStateInterface $form_state) {
        $event_subscriber = $this->entity;
        $status = $event_subscriber->save();

        switch ($status) {
            case SAVED_NEW:
                $this->messenger()->addMessage($this->t('Created the %label Event subscriber.', [
                    '%label' => $event_subscriber->label(),
                ]));
                break;

            default:
                $this->messenger()->addMessage($this->t('Saved the %label Event subscriber.', [
                    '%label' => $event_subscriber->label(),
                ]));
        }
        $form_state->setRedirectUrl($event_subscriber->toUrl('collection'));
    }

}
