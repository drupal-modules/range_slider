<?php

namespace Drupal\range_slider\Element;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element;
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
 *   '#data-orientation' => 'vertical',
 *   '#output' => 'below',
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
    return [
      '#process' => [
        [get_class($this), 'processRangeSlider'],
      ],
      '#data-orientation' => 'horizontal',
      '#output' => FALSE,
    ] + parent::getInfo();
  }

  /**
   * {@inheritdoc}
   */
  public static function preRenderRange($element) {
    $element = parent::preRenderRange($element);
    Element::setAttributes($element, ['data-orientation']);
    return $element;
  }

  /**
   * Processes a rangeslider form element.
   */
  public static function processRangeSlider(&$element, FormStateInterface $form_state, &$complete_form) {
    if (isset($element['#output']) && in_array($element['#output'], self::getOutputTypes())) {
      $element['#attached']['drupalSettings']['range_slider']['elements']['#' . $element['#id']]['output'] = $element['#output'];
    }
    $element['#attached']['library'][] = 'range_slider/element.rangeslider';
    return $element;
  }

  /**
   * Get output types.
   */
  private static function getOutputTypes() {
    return ['below', 'above', 'left', 'right'];
  }

}
