<?php

namespace Drupal\d8_custom\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class D8CustomController.
 *
 * @package Drupal\d8_custom\Controller
 */
class D8CustomController extends ControllerBase {
  /**
   * Controller_method_name.
   *
   * @return string
   *   Return Hello string.
   */
  public function controller_method_name() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: controller_method_name')
    ];
  }

}
