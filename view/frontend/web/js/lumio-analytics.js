/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
/* jscs:disable */
/* eslint-disable */
define([
    'jquery',
    'mage/cookies'
], function ($) {
    'use strict';

    /**
     * @param {Object} config
     */
    return function (config) {
            (function (i, s, o, g, r, k, a, m, t) {
                i.LumioAnalyticsObject = r;
                i[r] = i[r] || function () {
                        (i[r].q = i[r].q || []).push(arguments)
                    }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                t = s.createAttribute("key");
                t.value = config.key;
                a.setAttributeNode(t);
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//widgets.lumio-analytics.com/lumio-analytics.js.gz', 'la', config.key);
    }
});
