<?php

namespace Drupal\d8_training\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormInterface;
use Drupal\Core\Database\Driver\mysql\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\d8_training\FormManager;

/**
 * Class D8CustomController.
 *
 * @package Drupal\d8_custom\Controller
 */
class SimpleForm extends FormBase {
  
  private $form_manager;
  public function __construct(FormManager $form_manager) {
    $this->form_manager = $form_manager;
  }
  public function getFormId() {
    return 'training_form';
  
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $record = $this->form_manager->fetchData();
    $form['first_name'] = array(
      '#type' => 'textfield',
      '#title' => t('First Name'),
      '#default_value' => $record->first_name,
    );
    $form['last_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Last Name'),
      '#default_value' => $record->last_name,
    );
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Submit'),
    );
    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $first_name = $values['first_name'];
    if (strlen($first_name) < 5) {
      //$form_state->setErrorByName('first_name', t('First Name should be alteast 5 chars.'));
      $form_state->setError($form['first_name'], t('First Name should be alteast 5 chars.'));
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    /*$query = $this->connection->insert('training_form')
      ->fields(array('first_name' => $values['first_name'], 'last_name' => $values['last_name']));
    //, array('first_name' => $values['first_name'], 'last_name' => $values['last_name']));
    $query->execute();*/
    $record = array('first_name' => $values['first_name'], 'last_name' => $values['last_name']);
    $this->form_manager->addData($record);
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('d8_training.form_manager')
    );
  }
}
