/**
 * @author Cristhian Andrade
 * @copyright 2025 GPL3
 * @license GPL-3.0
 */

define([
    'jquery',
    'mage/translate',
    'jquery/validate'
], function ($, $t) {
    'use strict';

    $.validator.addMethod(
        'validate-greater-than-field',
        function (value, element, params) {
            var targetField = $(params);
            return (
                parseFloat(value) > parseFloat(targetField.val()) &&
                parseFloat(value) <= (5 * parseFloat(targetField.val()))
            );
        },
        $.mage.__('Please enter a value greater than the Low Range field and no more than 5x higher')
    );
});
