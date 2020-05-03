<?php

namespace Drupal\range_slider;

use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Class RangeSliderTrait.
 */
trait RangeSliderTrait {

  use StringTranslationTrait;

  /**
   * Get orientation options.
   */
  public function getOrientationOptions() {
    return [
      'horizontal' => $this->t('Horizontal'),
      'vertical' => $this->t('Vertical'),
    ];
  }

  /**
   * Get output options.
   */
  public function getOutputOptions() {
    return [
      'below' => $this->t('Below'),
      'above' => $this->t('Above'),
      'left' => $this->t('Left'),
      'right' => $this->t('Right'),
    ];
  }

}
