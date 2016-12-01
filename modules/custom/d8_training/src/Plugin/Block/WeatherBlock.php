<?php

namespace Drupal\d8_training\Plugin\Block;

/*use Drupal\Core\Database\Driver\mysql\Connection;*/
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\d8_training\OpenWeatherForecaster;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;

/*use Drupal\Core\Config\ConfigFactory;*/

/**
 * Provides a 'WeatherBlock' block.
 * 
 * @Block(
 *  id = "weather_block",
 *  admin_label = @Translation("Weather block"),
 * )
 */
class WeatherBlock extends BlockBase implements ContainerFactoryPluginInterface {
  
  protected $weather_forecast;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, OpenWeatherForecaster $weather_forecast) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->weather_forecast = $weather_forecast;
  }

  public function blockForm($form, FormStateInterface $form_state) {
    $form['city_name'] = array(
      '#type' => 'textfield',
      '#title' => t('City Name'),
      '#default_value' => $this->configuration['city_name'],
    );

    return $form;
  }
  
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['city_name'] = $form_state->getValue('city_name');
  }

  public function build() {
    
    $weather_data = $this->weather_forecast->fetchWeatherData($this->configuration['city_name']);
    return [
      '#theme' => 'weather_data',
      '#weather_data' => $weather_data,
      '#cache' => array(
        'max-age' => 0
      ),
      '#attached' => [
        'library' => ['d8_training/weather_widget']
      ]
    ];
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('d8_training.weather_report')
    );
  }
}