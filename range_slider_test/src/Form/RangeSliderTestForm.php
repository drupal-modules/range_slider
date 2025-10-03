<?php

namespace Drupal\range_slider_test\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a test form for the range slider element.
 */
class RangeSliderTestForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'range_slider_test_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['description'] = [
      '#markup' => $this->t('<p>This form tests the range slider element functionality.</p>'),
    ];

    $form['example'] = [
      '#type' => 'range_slider',
      '#title' => 'Rangeslider element test',
      '#min' => 0,
      '#max' => 50,
      '#step' => 2,
      '#default_value' => 8,
      '#orientation' => 'vertical',
      '#dir' => 'rtl',
      '#output' => 'below',
      '#output__field_prefix' => '€',
      '#output__field_suffix' => 'EUR',
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->messenger()->addStatus($this->t('The range slider value is: @value', [
      '@value' => $form_state->getValue('example'),
    ]));
  }

}
