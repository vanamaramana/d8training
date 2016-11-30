<?php

namespace Drupal\d8_training\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormInterface;
use Drupal\Core\Form\ConfigFormBase;
/*use Drupal\Core\Database\Driver\mysql\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\d8_training\FormManager;*/

/**
 * Class D8CustomController.
 *
 * @package Drupal\d8_custom\Controller
 */
class ConfigForm extends ConfigFormBase {
  
  protected function getEditableConfigNames() {
    return [
      'd8_training.configform'
    ];
  }
  public function getFormId() {
    return 'training_config_form';
  
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $app_id = $this->config('d8_training.configform')
      ->get('app_id');
    $form['app_id'] = array(
      '#type' => 'textfield',
      '#title' => t('App ID'),
      '#default_value' => $app_id,
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Submit'),
    );
    return $form;
  }

/*  public function validateForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $first_name = $values['first_name'];
    if (strlen($first_name) < 5) {
      //$form_state->setErrorByName('first_name', t('First Name should be alteast 5 chars.'));
      $form_state->setError($form['first_name'], t('First Name should be alteast 5 chars.'));
    }
  }*/

  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('d8_training.configform')
      ->set('app_id', $form_state->getValue('app_id'))
      ->save();
  }

  
}
