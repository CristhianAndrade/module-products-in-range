/**
 * @author Cristhian Andrade
 * @copyright 2025 GPL3
 * @license GPL-3.0
 */

define([
    'jquery',
    'mage/translate',
    'mage/url',
    'CrimsonAgility_ProductsInRange/js/range-model-request',
    'mage/validation'
], function ($,$t,urlBuilder, RangeRequest) {
    'use strict';

    return function (config, element) {
        let form = $(config.formSelector);
        let messages = $(config.messagesSelector);
        let contentTarget = $(config.contentSelector);
        let symbol = $(config.symbol).text();
        let defaultProductImage = config.defaultProductImage;

        form.on('submit', function (e) {
            e.preventDefault();

            if (!form.validation('isValid')) {
                return false;
            }

            let lowRange = form.find('#low-range').val();
            let highRange = form.find('#high-range').val();
            let sortBy = form.find('#sort-by-price').val();

            let url = form.attr('action');
            let currentUrl = urlBuilder.build('customer/products/range/');
            let params = 'low_range/' + lowRange + '/high_range/' + highRange + '/sort_by/' + sortBy;
            url = url + params;
            currentUrl = currentUrl + params;
            window.history.pushState('', '', currentUrl);

            let requestModel = new RangeRequest({
                url: url,
                contentTarget: contentTarget,
                extraData: {
                    symbol: symbol,
                    messages : messages,
                    defaultProductImage: defaultProductImage
                }
            });

            requestModel.execute();
        });
    };
});
