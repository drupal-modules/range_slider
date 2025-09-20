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
 * $form['quantity'] = [
 *   '#type' => 'range_slider',
 *   '#title' => $this->t('Quantity'),
 *   '#data-orientation' => 'vertical',
 *   '#output' => 'below',
 *   '#output__field_prefix' => '$',
 *   '#output__field_suffix' => 'USD',
 * ];
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
      '#output__field_prefix' => '',
      '#output__field_suffix' => '',
    ] + parent::getInfo();
  }

  /**
   * {@inheritdoc}
   */
  public static function preRenderRange($element) {
    $element = parent::preRenderRange($element);
    Element::setAttributes($element, ['data-orientation', 'data-direction']);

    // Add rangeslider classes for backward compatibility with v2.x.
    $classes = ['rangeslider'];

    // Add orientation class.
    if (!empty($element['#attributes']['data-orientation'])) {
      $orientation = $element['#attributes']['data-orientation'];
      $classes[] = 'rangeslider--' . $orientation;
    }

    // Add any existing classes.
    if (!empty($element['#attributes']['class'])) {
      if (is_array($element['#attributes']['class'])) {
        $classes = array_merge($classes, $element['#attributes']['class']);
      } else {
        $classes[] = $element['#attributes']['class'];
      }
    }

    // Set the classes on the element.
    $element['#attributes']['class'] = $classes;

    // Set dir attribute if not ltr
    if (!empty($element['#attributes']['data-direction']) && $element['#attributes']['data-direction'] !== 'ltr') {
      $element['#attributes']['dir'] = $element['#attributes']['data-direction'];
    }

    return $element;
  }

  /**
   * Processes a rangeslider form element.
   */
  public static function processRangeSlider(&$element, FormStateInterface $form_state, &$complete_form) {
    // Set basic attributes for the range-slider element with defaults.
    if (isset($element['#name'])) {
      $element['#attributes']['name'] = $element['#name'];
    }
    $element['#attributes']['min'] = $element['#attributes']['min'] ?? $element['#min'] ?? 0;
    $element['#attributes']['max'] = $element['#attributes']['max'] ?? $element['#max'] ?? 100;
    $element['#attributes']['step'] = $element['#attributes']['step'] ?? $element['#step'] ?? 1;
    $element['#attributes']['value'] = $element['#attributes']['value'] ?? $element['#value'] ?? 50;

    // Handle output configuration for potential future JavaScript enhancement.
    if (isset($element['#output']) && in_array($element['#output'], self::getOutputTypes())) {
      $element['#attached']['drupalSettings']['range_slider']['elements']['#' . $element['#id']]['output'] = $element['#output'];
    }
    if (isset($element['#output__field_prefix'])) {
      $element['#attached']['drupalSettings']['range_slider']['elements']['#' . $element['#id']]['prefix'] = $element['#output__field_prefix'];
    }
    if (isset($element['#output__field_suffix'])) {
      $element['#attached']['drupalSettings']['range_slider']['elements']['#' . $element['#id']]['suffix'] = $element['#output__field_suffix'];
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
