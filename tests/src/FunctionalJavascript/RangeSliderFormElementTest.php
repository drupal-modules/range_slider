<?php

namespace Drupal\Tests\range_slider\FunctionalJavascript;

use Drupal\FunctionalJavascriptTests\WebDriverTestBase;

/**
 * Range Slider form element tests.
 *
 * @group range_slider
 */
class RangeSliderFormElementTest extends WebDriverTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  protected static $modules = [
    'range_slider_test',
  ];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * A user with permissions to access content.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $user;

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();

    // Create a user with the necessary permissions.
    $this->user = $this->drupalCreateUser(['access content']);
    $this->drupalLogin($this->user);
  }

  /**
   * Test range slider form element library attachment.
   */
  public function testRangeSliderFormElementLibrary() {
    // Visit the test form page.
    $this->drupalGet('/range-slider-test');
    $this->assertSession()->waitForText('This form tests the range slider element functionality.');

    // Testing the attached library actually runs.
    $this->assertSession()->elementExists('css', 'range-slider .rangeslider__track');
    $this->assertSession()->elementExists('css', 'range-slider .rangeslider__handle[role="slider"]');

    // Test that the dir attribute is set to 'rtl'.
    $rangeSlider = $this->assertSession()->elementExists('css', 'range-slider[name="example"]');
    $this->assertEquals('rtl', $rangeSlider->getAttribute('dir'));

    // Test that the orientation attribute is set to 'horizontal'.
    $this->assertEquals('vertical', $rangeSlider->getAttribute('orientation'));
  }

  /**
   * Test range slider form element values.
   */
  public function testRangeSliderFormElementValues() {
    // Visit the test form page.
    $this->drupalGet('/range-slider-test');
    $this->assertSession()->waitForText('This form tests the range slider element functionality.');

    // Test submitting a valid step value (10).
    // Valid: (10-0) % 2 = 10 % 2 = 0.
    // Workaround for non-native Selenium elements targeting.
    $this->getSession()->executeScript("
      document.querySelector('range-slider[name=\"example\"]').value = 10;
    ");
    $this->submitForm([], 'Submit');
    $this->assertSession()->pageTextContains('The range slider value is: 10');
  }

  /**
   * Test range slider form element output features.
   */
  public function testRangeSliderFormElementOutput() {
    // Visit the test form page.
    $this->drupalGet('/range-slider-test');

    // Test that prefix and suffix are initially displayed.
    $this->assertSession()->waitForText('€8EUR');
  }

}
