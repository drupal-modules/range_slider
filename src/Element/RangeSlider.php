<?php

namespace Drupal\range_slider\Element;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element\Range;

/**
 * Provides a slider for input of a number within a specific range.
 *
 * Wraps rangeslider.js around HTML5 range input element.
 *
 * Properties:
 * - #min: Minimum value (defaults to 0).
 * - #max: Maximum value (defaults to 100).
 * Refer to \Drupal\Core\Render\Element\Number for additional properties.
 *
 * Usage example:
 * @code
 * $form['quantity'] = array(
 *   '#type' => 'range_slider',
 *   '#title' => $this->t('Quantity'),
 * );
 * @endcode
 *
 * @see \Drupal\Core\Render\Element\Range
 *
 * @FormElement("range_slider")
 */
class RangeSlider extends Range {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $info = parent::getInfo();
    $class = get_class($this);
    return [
      '#process' => [
        [$class, 'processRangeSlider'],
      ],
    ] + $info;
  }

  /**
   * Processes a rangeslider form element.
   */
  public static function processRangeSlider(&$element, FormStateInterface $form_state, &$complete_form) {
    $element['#attached']['library'][] = 'range_slider/element.rangeslider';
    return $element;
  }

}
