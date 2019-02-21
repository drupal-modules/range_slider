<?php

namespace Drupal\range_slider\Plugin\WebformElement;

use Drupal\webform\Plugin\WebformElement\Range;

/**
 * Provides a 'range' element.
 *
 * @WebformElement(
 *   id = "rangeslider_range",
 *   api = "https://api.drupal.org/api/drupal/core!lib!Drupal!Core!Render!Element!Range.php/class/Range",
 *   label = @Translation("Rangeslider Range"),
 *   description = @Translation("Provides a form element for input of a number within a specific range using a slider."),
 *   category = @Translation("Advanced elements"),
 * )
 */
class RangeSliderRange extends Range {}
