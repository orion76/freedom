<?php

namespace Drupal\gpb_commands\Generator;

use Drupal\Console\Core\Generator\Generator;
use Drupal\Console\Core\Generator\GeneratorInterface;
use const FILE_APPEND;

/**
 * Class GenerateViewsGenerator.
 *
 * @package Drupal\Console\Generator
 */
class GenerateViewsGenerator extends Generator implements GeneratorInterface {

  /**
   * {@inheritdoc}
   */
  public function generate(array $parameters) {
    $this->renderFile(
      'core/sites/alias.yml.twig',
      $parameters['directory'] . '/sites/' . $parameters['name'] . '.yml',
      $parameters,
      FILE_APPEND
    );
  }

}
