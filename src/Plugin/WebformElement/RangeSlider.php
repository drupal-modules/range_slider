<?php

namespace Drupal\range_slider\Plugin\WebformElement;

use Drupal\webform\Plugin\WebformElement\Range;

/**
 * Provides a 'range' element.
 *
 * @WebformElement(
 *   id = "range_slider",
 *   api = "https://api.drupal.org/api/drupal/core!lib!Drupal!Core!Render!Element!Range.php/class/Range",
 *   label = @Translation("Range Slider"),
 *   description = @Translation("Provides a form element for input of a number within a specific range using a slider."),
 *   category = @Translation("Advanced elements"),
 * )
 */
class RangeSlider extends Range {}
