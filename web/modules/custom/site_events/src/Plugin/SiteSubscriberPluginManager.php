<?php

namespace Drupal\site_events\Plugin;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Provides the Site subscriber plugin manager.
 */
class SiteSubscriberPluginManager extends DefaultPluginManager implements SiteSubscriberPluginManagerInterface {

    use StringTranslationTrait;

    /**
     * Constructs a new SiteSubscriberManager object.
     *
     * @param \Traversable $namespaces
     *   An object that implements \Traversable which contains the root paths
     *   keyed by the corresponding namespace to look for plugin implementations.
     * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
     *   Cache backend instance to use.
     * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
     *   The module handler to invoke the alter hook with.
     */
    public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
        parent::__construct('Plugin/SiteSubscriber', $namespaces, $module_handler, 'Drupal\site_events\Plugin\SiteSubscriberPluginInterface', 'Drupal\site_events\Annotation\SiteSubscriber');

        $this->alterInfo('site_events_site_subscriber_info');
        $this->setCacheBackend($cache_backend, 'site_events_site_subscriber_plugins');
    }

    public function getOptionsList() {
        $options = ['' => $this->t('-- Select --')];
        $definitions = $this->getDefinitions();
        foreach ($definitions as $definition) {
            $id = $definition['id'];
            /** @var $plugin SiteEventPluginInterface */
            $plugin = $this->createInstance($id);
            $options[$id] = $plugin->getLabel();
        }
        return $options;
    }
}
