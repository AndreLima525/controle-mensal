!/**
 * Highstock JS v13.0.2 (2026-08-27)
 * @module highcharts/indicators/trix
 * @requires highcharts
 * @requires highcharts/modules/stock
 *
 * Indicator series type for Highcharts Stock
 *
 * (c) 2010-2026 Highsoft AS
 * Author: Rafał Sebestjański
 *
 * A commercial license may be required depending on use,
 * see www.highcharts.com/license
 */function(e,t){"object"==typeof exports&&"object"==typeof module?module.exports=t(e._Highcharts,e._Highcharts.SeriesRegistry):"function"==typeof define&&define.amd?define("highcharts/indicators/trix",["highcharts/highcharts"],function(e){return t(e,e.SeriesRegistry)}):"object"==typeof exports?exports["highcharts/indicators/trix"]=t(e._Highcharts,e._Highcharts.SeriesRegistry):e.Highcharts=t(e.Highcharts,e.Highcharts.SeriesRegistry)}("u"<typeof window?this:window,function(e,t){return function(){"use strict";var r,n={512:function(e){e.exports=t},944:function(t){t.exports=e}},o={};function i(e){var t=o[e];if(void 0!==t)return t.exports;var r=o[e]={exports:{}};return n[e](r,r.exports,i),r.exports}i.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return i.d(t,{a:t}),t},i.d=function(e,t){if(Array.isArray(t))for(var r=0;r<t.length;){var n=t[r++],o=t[r++];i.o(e,n)?0===o&&r++:0===o?Object.defineProperty(e,n,{enumerable:!0,value:t[r++]}):Object.defineProperty(e,n,{enumerable:!0,get:o})}else for(var n in t)i.o(t,n)&&!i.o(e,n)&&Object.defineProperty(e,n,{enumerable:!0,get:t[n]})},i.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)};var u={};i.d(u,{default:function(){return y}});var c=i(944),s=i.n(c),a=i(512),f=i.n(a),p=(r=function(e,t){return(r=Object.setPrototypeOf||({__proto__:[]})instanceof Array&&function(e,t){e.__proto__=t}||function(e,t){for(var r in t)t.hasOwnProperty(r)&&(e[r]=t[r])})(e,t)},function(e,t){function n(){this.constructor=e}r(e,t),e.prototype=null===t?Object.create(t):(n.prototype=t.prototype,new n)}),h=f().seriesTypes.tema,l=function(e){function t(){return null!==e&&e.apply(this,arguments)||this}return p(t,e),t.prototype.getTemaPoint=function(e,t,r,n){if(n>t)return[e[n-3],0!==r.prevLevel3?(0,c.correctFloat)(r.level3-r.prevLevel3)/r.prevLevel3*100:null]},t.defaultOptions=(0,c.merge)(h.defaultOptions),t}(h);f().registerSeriesType("trix",l);var y=s();return u.default}()});