<?php

namespace Drupal\d8_custom\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the d8_custom module.
 */
class D8CustomControllerTest extends WebTestBase {
  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return array(
      'name' => "d8_custom D8CustomController's controller functionality",
      'description' => 'Test Unit for module d8_custom and controller D8CustomController.',
      'group' => 'Other',
    );
  }

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
  }

  /**
   * Tests d8_custom functionality.
   */
  public function testD8CustomController() {
    // Check that the basic functions of module d8_custom.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via App Console.');
  }

}
