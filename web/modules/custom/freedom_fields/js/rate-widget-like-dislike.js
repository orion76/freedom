/**
 * @file
 * Modifies the Rate thumbsupdown rating.
 */

(function ($, Drupal) {

    'use strict';

    Drupal.behaviors.RateWidgetLikeDislike = {
        attach: function (context, settings) {
            $('.like-dislike--rating-wrapper')
                .filter(function () {
                    var $widget = $(this);
                    return !$widget.data('initialised');
                })
                .each(function () {
                    var $widget = $(this);
                    var isEdit = $widget.attr('can-edit');
                    if (isEdit === 'true') {
                        var input = $widget.find('input[type="number"]').get(0);
                        $widget.find('button.number-plus').click(function (event) {
                            event.preventDefault();
                            console.log('step UP');
                            input.stepUp();
                        });
                        $widget.find('button.number-minus').click(function (event) {
                            event.preventDefault();
                            console.log('step DOWN');
                            input.stepDown();
                        });
                        $(input).change(function (e) {
                            console.log('11111111111');
                            // $(this).closest('form').find('.thumbsupdown-rating-submit').trigger('click');
                        });
                        $widget.data('initialised', true);
                    } else {
                        // $(this).find('label').css('cursor', 'default'); // Cursor to arrow.
                    }
                });
        }
    };
})(jQuery, Drupal);
