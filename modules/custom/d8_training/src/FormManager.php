<?php

namespace Drupal\d8_training;

use Drupal\Core\Database\Driver\mysql\Connection;

class FormManager {
  
  private $connection;
  public function __construct($connection) {
    $this->connection = $connection;
  }

  public function fetchData() {
    $query = $this->connection->select('training_form', 'tf');
    $query->fields('tf', array());
    $query->range(0, 1);
    $result = $query->execute()->fetchAll();
    return $result[0];
  }

  public function addData($record) {
    $query = $this->connection->insert('training_form')
      ->fields(array('first_name' => $record['first_name'], 'last_name' => $record['last_name']));
    $query->execute();
  }
}
