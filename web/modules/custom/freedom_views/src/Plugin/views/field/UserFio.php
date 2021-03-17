<?php


namespace Drupal\freedom_views\Plugin\views\field;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityMalformedException;
use Drupal\Core\Entity\Exception\UndefinedLinkTemplateException;
use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;
use function array_filter;
use function implode;
use function ucfirst;

/**
 * Field handler to flag the node type.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("user_fio")
 */
class UserFio extends FieldPluginBase {

    const FIO_TYPE_FULL = 'full';

    const FIO_TYPE_INITIALS = 'initials';

    const FIO_TYPE_NAME_SURNAME = 'name_surname';

    /**
     * {@inheritdoc}
     */
    protected function defineOptions() {
        $options = parent::defineOptions();
        $options['link_to_entity'] = ['default' => FALSE];
        $options['fio_type'] = ['default' => self::FIO_TYPE_NAME_SURNAME];
        return $options;
    }

    /**
     * {@inheritdoc}
     */
    public function buildOptionsForm(&$form, FormStateInterface $form_state) {
        $form['link_to_entity'] = [
            '#title' => $this->t('Link to entity'),
            '#description' => $this->t('Make entity label a link to entity page.'),
            '#type' => 'checkbox',
            '#default_value' => !empty($this->options['link_to_entity']),
        ];

        $options = [
            self::FIO_TYPE_FULL => $this->t('Full FIO'),
            self::FIO_TYPE_INITIALS => $this->t('With initials'),
            self::FIO_TYPE_NAME_SURNAME => $this->t('Only name and surname'),
        ];

        $form['fio_type'] = [
            '#title' => $this->t('FIO type'),
            '#type' => 'select',
            '#options' => $options,
            '#default_value' => $this->options['fio_type'],
        ];
        parent::buildOptionsForm($form, $form_state);
    }

    public function query() {
    }

    static function ucfirst($str) {
        return mb_strtoupper(mb_substr($str, 0, 1));
    }

    private function createFIO($fields, $type) {
        $parts = [];
        switch ($type) {
            case self::FIO_TYPE_FULL;
                $parts = array_map('ucfirst', array_filter($fields));
                break;
            case self::FIO_TYPE_INITIALS;
                if (isset($fields[2])) {
                    $parts[] = ucfirst($fields[2]);
                }
                if (isset($fields[0])) {
                    $parts[] = mb_strtoupper(mb_substr($fields[0], 0, 1)) . ".";
                }
                if (isset($fields[1])) {
                    $parts[] = mb_strtoupper(mb_substr($fields[1], 0, 1)) . ".";
                }


                break;
            case self::FIO_TYPE_NAME_SURNAME;
                if (isset($fields[0])) {
                    $parts[] = ucfirst($fields[0]);
                }
                if (isset($fields[2])) {
                    $parts[] = ucfirst($fields[2]);
                }
                break;
        }
        return implode(' ', $parts);
    }

    private function getFIOFields() {
        return [
            'field_fio_name',
            'field_fio_patronymic',
            'field_fio_surname',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function render(ResultRow $values) {
        /** @var $user \Drupal\Core\Entity\EntityInterface */
        $user = $values->_relationship_entities['uid'];


        if (!empty($this->options['link_to_entity'])) {
            try {
                $this->options['alter']['url'] = $user->toUrl();
                $this->options['alter']['make_link'] = TRUE;
            } catch (UndefinedLinkTemplateException $e) {
                $this->options['alter']['make_link'] = FALSE;
            } catch (EntityMalformedException $e) {
                $this->options['alter']['make_link'] = FALSE;
            }
        }

        return $this->sanitizeValue($this->getUserLabel($user, $this->options['fio_type']));
    }

    private function getUserLabel(EntityInterface $user, $type) {

        $user_fio = [];
        foreach ($this->getFIOFields() as $fio_field) {
            $user_fio[] = $user->get($fio_field)->value;
        }
        $fio = $this->createFIO($user_fio, $type);
        return empty($fio) ? $user->label() : $fio;
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldsListOptions() {
        $field_map = \Drupal::service('entity_field.manager')->getFieldMap();


        $options = [];
        foreach ($field_map['user'] as $field_name => $field_info) {

            $options[$field_name] = $field_name;

        }
        return $options;
    }
}
