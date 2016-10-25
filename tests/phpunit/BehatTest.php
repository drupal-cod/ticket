<?php

namespace Drupal\Tests\PHPUnit;

/**
 * Class BehatTest.
 *
 * Verifies that behat configuration is as expected.
 */
class BehatTest extends TestBase {

  /**
   * Tests behat.yml exists.
   */
  public function testBehat() {

    // Assert that a behat.yml file exists.
    $this->assertFileExists($this->projectDirectory . '/tests/behat/behat.yml');
  }

}
