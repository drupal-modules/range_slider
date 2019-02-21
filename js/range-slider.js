(function ($, Drupal) {
  Drupal.behaviors.rangeSliderRange = {

    attach: function attach(context, settings) {
      var $context = $(context);
      $context.find('.form-type-rangeslider-range > input').once('rangeSliderRange').each(function () {
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
        $(context).find('.form-type-rangeslider-range > input').findOnce('rangeSliderRange').rangeslider('destroy');
      }
    }

  };
})(jQuery, Drupal);
