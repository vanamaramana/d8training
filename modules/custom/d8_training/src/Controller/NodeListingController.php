<?php

namespace Drupal\d8_training\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\NodeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Driver\mysql\Connection;

/**
 * Class D8CustomController.
 *
 * @package Drupal\d8_custom\Controller
 */
class NodeListingController extends ControllerBase {
  
  //variables declaration.
  private $connection;

  public function __construct(Connection $connection) {
    $this->connection = $connection;
  }
  /**
   * Controller_method_name.
   *
   * @return string
   *   Return Hello string.
   */
  public function content() {
    $query = $this->connection->select('node', 'n')
      ->fields('n');
    $list = $query->execute()->fetchAll();

    foreach($list as $l) {
      $rows[] = array(
        $l->nid,
        $l->vid,
        $l->type,
        $l->uuid,
        $l->langcode
      );
    }
    $header = array('Nid', 'Vid', 'Type', 'UUID', 'Language Code');
    $output[] = array(
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
      '#empty' => t('No records found')
    );
    $output[] = array(
      '#theme' => 'pager',
      '#quantity' => 1,
    );
    return $output;




/*    return [
      '#theme' => 'item_list',
      '#items' => array('one', 'two')
    ];*/
  }
  
  public function content_entitytype() {
    return [
      '#theme' => 'markup',
      '#markup' => t('Hello '),
    ];
  }

  public static function create(ContainerInterface $container) {
    
    return new static(
      $container->get('database')
    );
  }

}
