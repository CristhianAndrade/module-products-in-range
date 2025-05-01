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

    let times = 5;

    $.validator.addMethod(
        'validate-greater-than-field',
        function (value, element, params) {
            let targetField = $(params);

            return (
                parseFloat(value) > parseFloat(targetField.val()) &&
                parseFloat(value) <= (times * parseFloat(targetField.val()))
            );
        },
        $.mage.__('Please enter a value greater than the Low Range field and no more than ' + times + 'x higher')
    );
});
