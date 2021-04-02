<?php

namespace Drupal\site_events\Plugin\SiteEvent;

use Drupal\site_events\Plugin\SiteEventPluginBase;

/**
 * Class EntityCreate
 *
 * @SiteEvent(
 *     id = "node.update",
 *     label = "Node::update",
 *     event = "update",
 *     source = "node"
 * )
 * @package Drupal\entity_event\Plugin\EntityAction
 */
class NodeUpdate extends SiteEventPluginBase {



}
