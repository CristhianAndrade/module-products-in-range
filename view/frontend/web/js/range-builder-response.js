/**
 * @author Cristhian Andrade
 * @copyright 2025 GPL3
 * @license GPL-3.0
 */

define([
    'jquery',
    'mage/translate'
], function ($, $t) {
    'use strict';

    let Response = function (options) {
        this.options = $.extend(
            {
                contentTarget: null,
                data: null,
                extraData: {}
            },
            options
        );
    }

    Response.prototype.build = function () {
        let data = this.options.data;
        let extraData = this.options.extraData;
        let messagesTarget = extraData.messages;

        if(data.request.success === 'true') {
            let html = '' ;

            data.products.forEach(function (item) {
                html += '<div class="table-row">';
                html += '<div class="table-cell id">' + item.entity_id +'</div>';
                let thumbnail = ((item.thumbnail) ? item.thumbnail : extraData.defaultProductImage);
                html += '<div class="table-cell thumbnail">';
                html += '<img src="' + thumbnail + '" alt="' + item.name + '" />';
                html += '</div>';
                html += '<div class="table-cell">' + item.name +'</div>';
                html += '<div class="table-cell sku">' + item.sku +'</div>';
                html += '<div class="table-cell">' + extraData.symbol + item.price +'</div>';
                html += '<div class="table-cell">' + item.qty +'</div>';
                html += '<div class="table-cell">';
                html += '<a href="' + item.link +'" target="_blank">' + $t('Open') +'</a>';
                html += '</div>';
                html += '</div>';
            });

            $(this.options.contentTarget).html(html);
            $(messagesTarget).html("");
        } else {

            let messages = data.request.messages
            let html = '';

            messages.forEach(function (item) {

                html += '<div class="message-error error message" data-ui-id="message-error">';
                html += '<div>' + item + '</div>';
                html += '</div>';
            });

            $(messagesTarget).html(html);
        }

    }

    return Response;
});
