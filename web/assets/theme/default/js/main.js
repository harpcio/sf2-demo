/**
 * Main namespace for our stuff.
 *
 * @namespace
 */
var Ace = Ace || {};

/**
 * @module
 * @param {jQuery} $
 */
Ace.Main = (function ($) {
    "use strict";

    return {
        init: function () {
            this.initBtnFile();
        },
        initBtnFile: function () {
            $('.btn-file :file').on('fileselect', function (event, numFiles, label) {
                var input = $(this).parents('.input-group').find(':text'),
                    log = numFiles > 1 ? numFiles + ' files selected' : label;

                input.val(log);
            });

            $(document).on('change', '.btn-file :file', function () {
                var input = $(this),
                    numFiles = input.get(0).files ? input.get(0).files.length : 1,
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [numFiles, label]);
            });
        }
    }
})(jQuery || $);

$(document).ready(function () {
    Ace.Main.init();
});