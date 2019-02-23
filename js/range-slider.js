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
      $(context).find('.form-type-range-slider > input').once('rangeSlider').each(function () {
        var $input = $(this);
        var rangesliderSettings = {
          polyfill : false,
          onInit : function() {
            this.output = $('<output class="js-output" />').insertAfter(this.$range).html(this.$element.val());
          },
          onSlide : function(position, value) {
            this.output.html(value);
          }
        };
        $input.rangeslider(rangesliderSettings);
      });
    },
    detach: function detach(context, settings, trigger) {
      if (trigger === 'unload') {
        $(context).find('.form-type-range-slider > input').findOnce('rangeSlider').rangeslider('destroy');
      }
    }
  };

})(jQuery, Drupal);
