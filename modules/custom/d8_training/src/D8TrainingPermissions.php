<?php

namespace Drupal\d8_training;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\NodeInterface;
Use Drupal\node\Entity\NodeType;

/**
 * Class D8CustomController.
 *
 * @package Drupal\d8_custom
 */
class D8TrainingPermissions extends ControllerBase {
  public function d8TrainingNoodeLisingPermissions() {
    $types = NodeType::loadMultiple();
    foreach ($types as $machine_name => $type) {
    	$permissions['access training programme for ' . $machine_name] = array(
    		'title' => 'Access training programme for :: ' . $type->get('name'),
    	);
    }

    return $permissions;
  }
}
