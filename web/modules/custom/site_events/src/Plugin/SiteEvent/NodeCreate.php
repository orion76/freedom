<?php

namespace Drupal\site_events\Plugin\SiteEvent;

use Drupal\site_events\Plugin\SiteEventPluginBase;

/**
 * Class EntityCreate
 *
 * @SiteEvent(
 *     id = "node.create",
 *     label = "Node::create",
 *     event = "create",
 *     source = "node"
 * )
 * @package Drupal\entity_event\Plugin\EntityAction
 */
class NodeCreate extends SiteEventPluginBase {


}
