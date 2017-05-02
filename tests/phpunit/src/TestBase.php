<?php

namespace Drupal\Tests\PHPUnit;

/**
 * Class TestBase.
 *
 * Verifies that behat configuration is as expected.
 */
abstract class TestBase extends \PHPUnit_Framework_TestCase {

  protected $projectDirectory;
  protected $drupalRoot;

  /**
   * Class constructor.
   */
  public function __construct($name = NULL, array $data = [], $data_name = '') {

    parent::__construct($name, $data, $data_name);
    $this->projectDirectory = dirname(dirname(dirname(__DIR__)));
    $this->drupalRoot = $this->projectDirectory . '/docroot';
  }

}
