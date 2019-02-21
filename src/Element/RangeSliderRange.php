<?php

namespace Drupal\range_slider\Element;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element\Range;

/**
 * Provides a slider for input of a number within a specific range.
 *
 * Provides an HTML5 input element with type of "range".
 *
 * Properties:
 * - #min: Minimum value (defaults to 0).
 * - #max: Maximum value (defaults to 100).
 * Refer to \Drupal\Core\Render\Element\Number for additional properties.
 *
 * Usage example:
 * @code
 * $form['quantity'] = array(
 *   '#type' => 'rangeslider_range',
 *   '#title' => $this->t('Quantity'),
 * );
 * @endcode
 *
 * @see \Drupal\Core\Render\Element\Range
 *
 * @FormElement("rangeslider_range")
 */
class RangeSliderRange extends Range {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $info = parent::getInfo();
    $class = get_class($this);
    return [
      '#process' => [
        [$class, 'processRangeSliderRange'],
      ],
    ] + $info;
  }

  /**
   * Processes a rangeslider range form element.
   */
  public static function processRangeSliderRange(&$element, FormStateInterface $form_state, &$complete_form) {
    $element['#attached']['library'][] = 'range_slider/range_slider';
    return $element;
  }

}
