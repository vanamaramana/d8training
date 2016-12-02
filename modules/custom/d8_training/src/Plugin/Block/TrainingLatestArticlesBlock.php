<?php

namespace Drupal\d8_training\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Driver\mysql\Connection;
use Drupal;
use Drupal\Core\Url;
use Drupal\Core\Session\AccountProxy;

/**
 * Provides a 'TrainingLatestArticlesBlock' block.
 *
 * @Block(
 *  id = "training_latest_articles_block",
 *  admin_label = @Translation("Latest Articles"),
 * )
 */
class TrainingLatestArticlesBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal\Core\Database\Driver\mysql\Connection definition.
   *
   * @var Drupal\Core\Database\Driver\mysql\Connection
   */
  protected $database;
  protected $account;
  /**
   * Construct.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   */
  public function __construct(
        array $configuration,
        $plugin_id,
        $plugin_definition,
        Connection $database
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->database = $database;
    $account = \Drupal::currentUser();
    $this->account = $account->getAccount();
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('database')
    );
  }


  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['no_of_articles'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('No of Articles'),
      '#description' => $this->t('Provide no. of articles to be shown on Latest Articles Block'),
      '#default_value' => isset($this->configuration['no_of_articles']) ? $this->configuration['no_of_articles'] : '3',
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '0',
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['no_of_articles'] = $form_state->getValue('no_of_articles');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];

    $query = $this->database->select('node', 'n');
    $query->join('node_field_data', 'nfd', 'nfd.nid = n.nid AND nfd.vid = n.vid');
    $query->condition('n.type', 'article');
    $query->addField('nfd', 'title');
    $query->addField('nfd', 'nid');
    $query->orderBy('nfd.created', 'DESC');
    $query->range(0, $this->configuration['no_of_articles']);
    $results = $query->execute()->fetchAll();

    $email = $this->account->getEmail();

    foreach ($results as $result) {
      $arguments = array('node' => $result->nid);
      $url = new Url('entity.node.canonical', array('node' => $result->nid));
      $items[] = Drupal::l($result->title, $url);
      //$node_tags[] = 'node:' . $result->nid;
    }
    $node_tags[] = 'node_list';
    $build['training_latest_articles_block_no_of_articles'] = array(
      '#theme' => 'item_list',
      '#items' => $items,
    );
    $build['training_latest_articles_block_no_of_articles']['#cache'] = array(
      'tags' => $node_tags,
    );
    $build['current_use_mail'] = array(
      '#type' => 'markup',
      '#markup' => 'Current user email is : ' . $email,
      '#cache' => array(
        'contexts' => array('user'),
        'tags' => $node_tags,
      ),
    );

    return $build;
  }

}
