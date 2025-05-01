/**
 * @author Cristhian Andrade
 * @copyright 2025 GPL3
 * @license GPL-3.0
 */

define([
    'jquery',
    'mage/url',
    'mage/translate',
    'CrimsonAgility_ProductsInRange/js/range-builder-response'
], function ($,urlBuilder,$t, ContentBuilder) {
    'use strict';

    let RequestModel = function (options) {
        this.options = $.extend(
            {
                url: null,
                method: 'GET',
                data: {},
                dataType: 'json',
                contentTarget: null,
                extraData: {},
            },
            options
        );
    }

    RequestModel.prototype.execute = function () {
        $('body').trigger('processStart');
        let self = this;

        $.ajax({
            url: self.options.url,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                let responseBuilder = new ContentBuilder({
                    data: response,
                    contentTarget: self.options.contentTarget,
                    extraData: self.options.extraData,
                    defaultProductImage:  self.options.defaultProductImage
                });

                responseBuilder.build();

                console.log('Success:', response);
            },
            error: function (error) {
                console.error('Error:', error);
            },
            complete: function () {
                $('body').trigger('processStop');
            }
        });
    };

    return RequestModel;

});
