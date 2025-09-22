/**
 * @file
 * Range slider behavior using range-slider-element.
 */
(function (Drupal, once) {

  'use strict';

  /**
   * Process range_slider elements.
   *
   * @type {Drupal~behavior}
   */
  Drupal.behaviors.rangeSlider = {
    attach: function attach(context, settings) {
      const elements = settings.range_slider && settings.range_slider.elements ? settings.range_slider.elements : null;

      // Find range-slider elements that need enhancement
      once('rangeSlider', 'range-slider', context).forEach(function (rangeSlider) {
        const elementId = '#' + rangeSlider.id;
        const config = elements && elements[elementId] ? elements[elementId] : {};

        // Get output configuration
        const outputType = config.output || false;
        const outputPrefix = config.prefix || '';
        const outputSuffix = config.suffix || '';

        // Create output element if configured
        let outputElement = null;
        if (outputType && ['below', 'above', 'left', 'right'].includes(outputType)) {
          outputElement = document.createElement('output');
          outputElement.className = 'js-output';
          outputElement.textContent = outputPrefix + (rangeSlider.value || '50') + outputSuffix;

          // Position the output element
          if (outputType === 'below') {
            rangeSlider.parentNode.insertBefore(outputElement, rangeSlider.nextSibling);
          } else if (outputType === 'above') {
            rangeSlider.parentNode.insertBefore(outputElement, rangeSlider);
          }
        }

        // Sync values on input and change events
        const updateOutput = function() {
          // Update output if present
          if (outputElement) {
            outputElement.textContent = outputPrefix + rangeSlider.value + outputSuffix;
          }
        };

        // Listen for both input (drag) and change (keyboard/navigation) events
        rangeSlider.addEventListener('input', updateOutput);
        rangeSlider.addEventListener('change', updateOutput);
      });
    },

    detach: function detach(context, settings, trigger) {
      if (trigger === 'unload') {
        // Clean up once data when elements are removed
        once.remove('rangeSlider', 'range-slider', context);
      }
    }
  };

}(Drupal, once));
