<?php

namespace Drupal\range_slider\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\range_slider\RangeSliderTrait;

/**
 * Plugin implementation of the 'range' widget.
 *
 * @FieldWidget(
 *   id = "range_slider",
 *   label = @Translation("Range Slider"),
 *   field_types = {
 *     "integer",
 *     "decimal",
 *     "float"
 *   }
 * )
 */
class RangeSliderWidget extends WidgetBase {

  use RangeSliderTrait;

  /**
   * Range Slider option none key.
   */
  public const OPTION_NONE = '_none_';

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'orientation' => 'horizontal',
      'output' => self::OPTION_NONE,
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $element['orientation'] = [
      '#type' => 'select',
      '#options' => $this->getOrientationOptions(),
      '#title' => $this->t('Orientation'),
      '#default_value' => $this->getSetting('orientation'),
      '#required' => TRUE,
    ];

    $element['output'] = [
      '#type' => 'select',
      '#options' => [
        self::OPTION_NONE => $this->t('None'),
      ] + $this->getOutputOptions(),
      '#title' => $this->t('Output'),
      '#default_value' => $this->getSetting('output'),
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $widget_settings = $this->getSettings();

    if (!empty($widget_settings['orientation'])) {
      $summary[] = $this->t('Orientation: @orientation', [
        '@orientation' => ucfirst($widget_settings['orientation']),
      ]);
    }
    else {
      $summary[] = $this->t('No orientation');
    }

    if (!empty($widget_settings['output']) && $widget_settings['output'] !== self::OPTION_NONE) {
      $summary[] = $this->t('Output: @output', [
        '@output' => ucfirst($widget_settings['output']),
      ]);
    }
    else {
      $summary[] = $this->t('No output');
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $field_settings = $this->getFieldSettings();
    $widget_settings = $this->getSettings();

    $element['value'] = $element + [
      '#type' => 'range_slider',
      '#default_value' => $items[$delta]->value ?? NULL,
      '#data-orientation' => $widget_settings['orientation'] ?? 'horizontal',
      '#output' => $widget_settings['output'] === self::OPTION_NONE ? FALSE : $widget_settings['output'],
    ];

    // Set minimum and maximum.
    if (is_numeric($field_settings['min'])) {
      $element['value']['#min'] = $field_settings['min'];
    }
    if (is_numeric($field_settings['max'])) {
      $element['value']['#max'] = $field_settings['max'];
    }

    return $element;
  }

}
