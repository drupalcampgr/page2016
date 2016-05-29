<?php
/**
 * Created by PhpStorm.
 * User: nkostop
 * Date: 27/05/16
 * Time: 22:41
 */

namespace Drupal\drupalcamp\Form;


use Drupal\Component\Plugin\Context\ContextInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Config\ConfigFactory;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CodeofconductConfigForm extends ConfigFormBase
{

    protected function getEditableConfigNames()
    {
        return [
            'drupalcamp.settings'
        ];
    }

    public function getFormID() {
        return 'drupalcamp.settings_form';
    }


    public function buildForm(array $form, FormStateInterface $form_state) {
        $config = $this->config('drupalcamp.settings');
        $body = $config->get('body');

        $form['conduct_body'] = [
            '#type' => 'textarea',
            '#title' => $this->t('Code of Conduct'),
            '#default_value' => $body,
            '#description' => $this->t('Code of conduct main body.'),
        ];

        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = [
            '#type' => 'button',
            '#value' => $this->t('Submit'),
        ];

        return parent::buildForm($form, $form_state);
    }


    public function submitForm(array &$form, FormStateInterface $form_state) {
        $nikos =3;
        $this->config('drupalcamp.settings')
            ->set('body', $form_state->getValue('conduct_body'))
            ->save();

    }
}