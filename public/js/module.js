(function(window, $) {
    'use strict';

    var Web = function () {
    };

    Web.prototype = {
        initialize: function (icinga) {
            this.icinga = icinga;
            $(document).on('focus', 'form input, form textarea, form select', this.formElementFocus);
        },

        formElementFocus: function (ev) {
            var $input = $(ev.currentTarget);
            if ($input.closest('form.editor').length) {
                return;
            }
            var $set = $input.closest('.extensible-set');
            if ($set.length) {
                var $textInputs = $('input[type=text]', $set);
                if ($textInputs.length > 1) {
                    $textInputs.not(':first').attr('tabIndex', '-1');
                }
            }

            var $dd = $input.closest('dd');
            if ($dd.attr('id') && $dd.attr('id').match(/button/)) {
                return;
            }
            var $li = $input.closest('li');
            var $dt = $dd.prev();
            var $form = $dd.closest('form');

            $form.find('dt, dd, dl, li').removeClass('active');
            $li.addClass('active');
            $dt.addClass('active');
            $dd.addClass('active');
            $dt.closest('dl').addClass('active');
        },

        highlightFormErrors: function ($container) {
            $container.find('dd ul.errors').each(function (idx, ul) {
                var $ul = $(ul);
                var $dd = $ul.closest('dd');
                var $dt = $dd.prev();

                $dt.addClass('errors');
                $dd.addClass('errors');
            });
        },

        toggleFieldset: function (ev) {
            ev.stopPropagation();
            var $fieldset = $(ev.currentTarget).closest('fieldset');
            $fieldset.toggleClass('collapsed');
            this.fixFieldsetInfo($fieldset);
            this.openedFieldsets[$fieldset.attr('id')] = ! $fieldset.hasClass('collapsed');
        }
    };

    w.incubator.addComponent(new Web());
})(window, jQuery);
