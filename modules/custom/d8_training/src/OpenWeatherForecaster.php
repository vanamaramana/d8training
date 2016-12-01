<?php

namespace Drupal\d8_training;

use Drupal\Core\Config\ConfigFactory;
use GuzzleHttp\Client;
use Drupal\Component\Serialization\Json;


/**
 * Class ControlDemoService.
 *
 * @package Drupal\d8_training
 */
class OpenWeatherForecaster {

  protected $app_id;
  /**
   * Drupal\Core\Config\ConfigFactory definition.
   *
   * @var Drupal\Core\Config\ConfigFactory
   */
  protected $config_factory;

  protected $guzzle_client;
  
  /**
   * Constructor.
   */
  public function __construct(ConfigFactory $config_factory, Client $guzzle_client) {
    $this->config_factory = $config_factory;
    $this->guzzle_client = $guzzle_client;
  }

  public function fetchWeatherData($city) {
    $this->app_id = $this->config_factory->get('d8_training.configform')->get('app_id');

    //$args[] = 'http://api.openweathermap.org/data/2.5/weather?q=' . $city .'&appid=' . $this->app_id;
    $args[] = 'http://api.openweathermap.org/data/2.5/weather?q=' . $city . '&appid=' . $this->app_id;
    $method = 'GET';

    $request = $this->guzzle_client->__call($method, $args);

    //$request = $this->guzzle_client->request($method, $url);
    $response = $request->getBody();
    $data = $response->getContents();
    $weather_data = Json::decode($data);
    return $weather_data;
  }

}
