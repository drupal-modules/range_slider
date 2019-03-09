/**
 * @file
 * Range slider behavior.
 */
(function ($, Drupal) {

  'use strict';

  /**
   * Process ranges_slider elements.
   *
   * @type {Drupal~behavior}
   */
  Drupal.behaviors.rangeSlider = {
    attach: function attach(context, settings) {
      var elements = settings.range_slider && settings.range_slider.elements ? settings.range_slider.elements : null;
      $(context).find('.form-type-range-slider > input').once('rangeSlider').each(function () {
        var outputType = false;
        if (typeof elements['#' + $(this).attr('id')] !== 'undefined') {
          outputType = elements['#' + $(this).attr('id')].output;
        }
        var rangesliderSettings = {
          polyfill : false,
          onInit : function () {
            if (outputType === 'below') {
              this.output = $('<output class="js-output" />').insertAfter(this.$range).html(this.$element.val());
            }
            else if (outputType === 'above') {
              this.output = $('<output class="js-output" />').insertBefore(this.$range).html(this.$element.val());
            }
          },
          onSlide : function (position, value) {
            if (!outputType) {
              return;
            }
            this.output.html(value);
          }
        };
        $(this).rangeslider(rangesliderSettings);
      });
    },
    detach: function detach(context, settings, trigger) {
      if (trigger === 'unload') {
        $(context).find('.form-type-range-slider > input').findOnce('rangeSlider').rangeslider('destroy');
      }
    }
  };

})(jQuery, Drupal);
