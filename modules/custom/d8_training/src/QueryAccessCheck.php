<?php

namespace Drupal\d8_training;

use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Access\AccessResult;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Request;

class QueryAccessCheck implements AccessInterface {
  /**
   * @inheritdoc
   */
  public function access(Request $request) {
  	$query = $request->getQueryString();	//TODO: identify the way to the get parameters in array
  	if ($query) {
  		return AccessResult::allowed()->cachePerPermissions();
  	} else {
  		return AccessResult::forbidden();
  	}
  }
}
