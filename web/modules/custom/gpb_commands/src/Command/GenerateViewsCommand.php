<?php

namespace Drupal\gpb_commands\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Drupal\Console\Core\Command\Command;
use Drupal\Console\Core\Generator\GeneratorInterface;

/**
 * Class GenerateViewsCommand.
 *
 * Drupal\Console\Annotations\DrupalCommand (
 *     extension="gpb_commands",
 *     extensionType="module"
 * )
 */
class GenerateViewsCommand extends Command {

  /**
   * Drupal\Console\Core\Generator\GeneratorInterface definition.
   *
   * @var \Drupal\Console\Core\Generator\GeneratorInterface
   */
  protected $generator;


  /**
   * Constructs a new GenerateViewsCommand object.
   */
  public function __construct(GeneratorInterface $gpb_commands_generate_views_generator) {
    $this->generator = $gpb_commands_generate_views_generator;
    parent::__construct();
  }

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName('generate:views')
      ->setDescription($this->trans('commands.generate.views.description'));
  }

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $this->getIo()->info('interact');
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $this->getIo()->info('execute');
    $this->getIo()->info($this->trans('commands.generate.views.messages.success'));
    $this->generator->generate([]);
  }

}
