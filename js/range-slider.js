/**
 * @file
 * Range slider behavior.
 */
(function ($, Drupal, once) {

  'use strict';

  /**
   * Process ranges_slider elements.
   *
   * @type {Drupal~behavior}
   */
  Drupal.behaviors.rangeSlider = {
    attach: function attach(context, settings) {
      var elements = settings.range_slider && settings.range_slider.elements ? settings.range_slider.elements : null;
      $(once('rangeSlider', '.js-form-type-range-slider input', context)).each(function () {
        var outputType = false;
        var outputPrefix = '';
        var outputSuffix = '';
        if (elements && typeof elements['#' + $(this).attr('id')] !== 'undefined') {
          outputType = elements['#' + $(this).attr('id')].output;
          outputPrefix = elements['#' + $(this).attr('id')].prefix ? elements['#' + $(this).attr('id')].prefix : "";
          outputSuffix = elements['#' + $(this).attr('id')].suffix ? elements['#' + $(this).attr('id')].suffix : "";
        }
        var rangesliderSettings = {
          polyfill : false,
          onInit : function () {
            if (outputType === 'below') {
              this.output = $('<output class="js-output" />').insertAfter(this.$range).html(outputPrefix + this.$element.val() + outputSuffix);
            }
            else if (outputType === 'above') {
              this.output = $('<output class="js-output" />').insertBefore(this.$range).html(outputPrefix + this.$element.val() + outputSuffix);
            }
          },
          onSlide : function (position, value) {
            if ($.inArray(outputType, ['below', 'above']) !== -1) {
              this.output.html(outputPrefix + value + outputSuffix);
            }
          }
        };
        $(this).rangeslider(rangesliderSettings);
      });
    },
    detach: function detach(context, settings, trigger) {
      if (trigger === 'unload') {
        const filteredElements = once.filter('rangeSlider','.js-form-type-range-slider input');
        filteredElements.forEach(function () {
          $(this).rangeslider('destroy');
        })
      }
    }
  };

}(jQuery, Drupal, once));
