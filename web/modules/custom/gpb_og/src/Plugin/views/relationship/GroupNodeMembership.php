<?php

namespace Drupal\gpb_og\Plugin\views\relationship;

use Drupal\Core\Database\Database;
use Drupal\views\Plugin\views\relationship\RelationshipPluginBase;

/**
 * Relationship handler to return the taxonomy terms of nodes.
 *
 * @ingroup views_relationship_handlers
 *
 * @ViewsRelationship("group_node_membership")
 */
class GroupNodeMembership extends RelationshipPluginBase {


  /**
   * Called to implement a relationship in a query.
   */
  public function query() {
    $this->ensureMyTable();

    $def = $this->definition;
    $def['table'] = 'taxonomy_term_field_data';

    if (!array_filter($this->options['vids'])) {
      $taxonomy_index = $this->query->addTable('taxonomy_index', $this->relationship);
      $def['left_table'] = $taxonomy_index;
      $def['left_field'] = 'tid';
      $def['field'] = 'tid';
      $def['type'] = empty($this->options['required']) ? 'LEFT' : 'INNER';
    }
    else {
      // If vocabularies are supplied join a subselect instead
      $def['left_table'] = $this->tableAlias;
      $def['left_field'] = 'nid';
      $def['field'] = 'nid';
      $def['type'] = empty($this->options['required']) ? 'LEFT' : 'INNER';
      $def['adjusted'] = TRUE;

      $query = Database::getConnection()->select('taxonomy_term_field_data', 'td');
      $query->addJoin($def['type'], 'taxonomy_index', 'tn', 'tn.tid = td.tid');
      $query->condition('td.vid', array_filter($this->options['vids']), 'IN');
      if (empty($this->query->options['disable_sql_rewrite'])) {
        $query->addTag('taxonomy_term_access');
      }
      $query->fields('td');
      $query->fields('tn', ['nid']);
      $def['table formula'] = $query;
    }

    $join = \Drupal::service('plugin.manager.views.join')->createInstance('standard', $def);

    // use a short alias for this:
    $alias = $def['table'] . '_' . $this->table;

    $this->alias = $this->query->addRelationship($alias, $join, 'taxonomy_term_field_data', $this->relationship);
  }

  /**
   * {@inheritdoc}
   */
  public function calculateDependencies() {
    $dependencies = parent::calculateDependencies();

    foreach ($this->options['vids'] as $vocabulary_id) {
      if ($vocabulary = $this->vocabularyStorage->load($vocabulary_id)) {
        $dependencies[$vocabulary->getConfigDependencyKey()][] = $vocabulary->getConfigDependencyName();
      }
    }

    return $dependencies;
  }

}
