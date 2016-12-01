<?php

namespace Drupal\d8_training\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use AntoineAugusti\Books\Fetcher;
use GuzzleHttp\Client;

/**
 * Provides a 'TrainingComposerBlock' block.
 *
 * @Block(
 *  id = "training_composer_block",
 *  admin_label = @Translation("Training composer block"),
 * )
 */
class TrainingComposerBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['isbn'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('ISBN'),
      '#description' => $this->t('Provide ISBN URL'),
      '#default_value' => isset($this->configuration['isbn']) ? $this->configuration['isbn'] : '',
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
    $this->configuration['isbn'] = $form_state->getValue('isbn');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $client = new Client(['base_uri' => 'https://www.googleapis.com/books/v1/']);
    $fetcher = new Fetcher($client);
    //$book = $fetcher->forISBN('9780142181119');
    $book = $fetcher->forISBN($this->configuration['isbn']);

    $build = [];
    $build['training_composer_block_isbn']['#markup'] = '<p>' . $book->title . '</p>';

    return $build;
  }

}
