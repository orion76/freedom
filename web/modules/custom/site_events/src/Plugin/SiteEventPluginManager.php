<?php

namespace Drupal\site_events\Plugin;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use function array_filter;

/**
 * Provides the Event plugin plugin manager.
 */
class SiteEventPluginManager extends DefaultPluginManager implements SiteEventPluginManagerInterface {

    use StringTranslationTrait;

    /**
     * Constructs a new SiteEventPluginManager object.
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
        parent::__construct('Plugin/SiteEvent', $namespaces, $module_handler, 'Drupal\site_events\Plugin\SiteEventPluginInterface', 'Drupal\site_events\Annotation\SiteEvent');

        $this->alterInfo('site_events_plugin_info');
        $this->setCacheBackend($cache_backend, 'site_events_plugins');
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


    public function getEvent($source, $event) {
        $candidates = array_filter($this->getDefinitions(), function ($definition) use ($source, $event) {
            return $definition['source'] === $source && $definition['event'] === $event;
        });
        if (count($candidates) === 1) {
            $definition = reset($candidates);
            return $this->createInstance($definition['id']);
        }
    }
}
