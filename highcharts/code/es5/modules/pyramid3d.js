!/**
 * Highcharts JS v13.0.2 (2026-08-27)
 * @module highcharts/modules/pyramid3d
 * @requires highcharts
 * @requires highcharts/highcharts-3d
 * @requires highcharts/modules/cylinder
 * @requires highcharts/modules/funnel3d
 *
 * Highcharts 3D funnel module
 *
 * (c) 2010-2026 Highsoft AS
 * Author: Kacper Madej
 *
 * A commercial license may be required depending on use,
 * see www.highcharts.com/license
 */function(e,t){"object"==typeof exports&&"object"==typeof module?module.exports=t(e._Highcharts,e._Highcharts.SeriesRegistry):"function"==typeof define&&define.amd?define("highcharts/modules/pyramid3d",["highcharts/highcharts"],function(e){return t(e,e.SeriesRegistry)}):"object"==typeof exports?exports["highcharts/modules/pyramid3d"]=t(e._Highcharts,e._Highcharts.SeriesRegistry):e.Highcharts=t(e.Highcharts,e.Highcharts.SeriesRegistry)}("u"<typeof window?this:window,function(e,t){return function(){"use strict";var r,n={512:function(e){e.exports=t},944:function(t){t.exports=e}},o={};function i(e){var t=o[e];if(void 0!==t)return t.exports;var r=o[e]={exports:{}};return n[e](r,r.exports,i),r.exports}i.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return i.d(t,{a:t}),t},i.d=function(e,t){if(Array.isArray(t))for(var r=0;r<t.length;){var n=t[r++],o=t[r++];i.o(e,n)?0===o&&r++:0===o?Object.defineProperty(e,n,{enumerable:!0,value:t[r++]}):Object.defineProperty(e,n,{enumerable:!0,get:o})}else for(var n in t)i.o(t,n)&&!i.o(e,n)&&Object.defineProperty(e,n,{enumerable:!0,get:t[n]})},i.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)};var s={};i.d(s,{default:function(){return l}});var u=i(944),c=i.n(u),a={reversed:!0,neckHeight:0,neckWidth:0,dataLabels:{verticalAlign:"top"}},f=i(512),p=i.n(f),h=(r=function(e,t){return(r=Object.setPrototypeOf||({__proto__:[]})instanceof Array&&function(e,t){e.__proto__=t}||function(e,t){for(var r in t)t.hasOwnProperty(r)&&(e[r]=t[r])})(e,t)},function(e,t){function n(){this.constructor=e}r(e,t),e.prototype=null===t?Object.create(t):(n.prototype=t.prototype,new n)}),d=p().seriesTypes.funnel3d,y=function(e){function t(){return null!==e&&e.apply(this,arguments)||this}return h(t,e),t.defaultOptions=(0,u.merge)(d.defaultOptions,a),t}(d);p().registerSeriesType("pyramid3d",y);var l=c();return s.default}()});