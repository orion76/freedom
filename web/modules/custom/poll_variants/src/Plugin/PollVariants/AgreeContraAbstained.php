<?php

namespace Drupal\poll_variants\Plugin\PollVariants;

use Drupal\Console\Command\Shared\TranslationTrait;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\PluginBase;
use Drupal\poll_variants\Plugin\PollVariantsPluginBase;
use Drupal\poll_variants\Plugin\PollVariantsPluginInterface;


/**
 *
 * @PollVariants(
 *   id = "agree_contra_abstained",
 *   title = @Translation("Agree,Contra,Abstained")
 * )
 */
class AgreeContraAbstained extends PollVariantsPluginBase implements PollVariantsPluginInterface {



    public function getVariants($settings=NULL) {
        return [
            ['id' => 'agree', 'label' => $this->t('Agree')],
            ['id' => 'contra', 'label' => $this->t('Contra')],
            ['id' => 'abstained', 'label' => $this->t('Abstained')],
        ];
    }

}
