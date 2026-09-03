!/**
 * Highstock JS v13.0.2 (2026-08-27)
 * @module highcharts/indicators/natr
 * @requires highcharts
 * @requires highcharts/modules/stock
 *
 * Indicator series type for Highcharts Stock
 *
 * (c) 2010-2026 Highsoft AS
 * Author: Paweł Dalek
 *
 * A commercial license may be required depending on use,
 * see www.highcharts.com/license
 */function(t,e){"object"==typeof exports&&"object"==typeof module?module.exports=e(t._Highcharts,t._Highcharts.SeriesRegistry):"function"==typeof define&&define.amd?define("highcharts/indicators/natr",["highcharts/highcharts"],function(t){return e(t,t.SeriesRegistry)}):"object"==typeof exports?exports["highcharts/indicators/natr"]=e(t._Highcharts,t._Highcharts.SeriesRegistry):t.Highcharts=e(t.Highcharts,t.Highcharts.SeriesRegistry)}("u"<typeof window?this:window,function(t,e){return function(){"use strict";var r,n={512:function(t){t.exports=e},944:function(e){e.exports=t}},o={};function i(t){var e=o[t];if(void 0!==e)return e.exports;var r=o[t]={exports:{}};return n[t](r,r.exports,i),r.exports}i.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return i.d(e,{a:e}),e},i.d=function(t,e){if(Array.isArray(e))for(var r=0;r<e.length;){var n=e[r++],o=e[r++];i.o(t,n)?0===o&&r++:0===o?Object.defineProperty(t,n,{enumerable:!0,value:e[r++]}):Object.defineProperty(t,n,{enumerable:!0,get:o})}else for(var n in e)i.o(e,n)&&!i.o(t,n)&&Object.defineProperty(t,n,{enumerable:!0,get:e[n]})},i.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)};var a={};i.d(a,{default:function(){return l}});var u=i(944),s=i.n(u),c=i(512),f=i.n(c),p=(r=function(t,e){return(r=Object.setPrototypeOf||({__proto__:[]})instanceof Array&&function(t,e){t.__proto__=e}||function(t,e){for(var r in e)e.hasOwnProperty(r)&&(t[r]=e[r])})(t,e)},function(t,e){function n(){this.constructor=t}r(t,e),t.prototype=null===e?Object.create(e):(n.prototype=e.prototype,new n)}),h=f().seriesTypes.atr,y=function(t){function e(){return null!==t&&t.apply(this,arguments)||this}return p(e,t),e.prototype.getValues=function(e,r){var n=t.prototype.getValues.apply(this,arguments),o=n.values.length,i=e.yData,a=0,u=r.period-1;if(n){for(;a<o;a++)n.yData[a]=n.values[a][1]/i[u][3]*100,n.values[a][1]=n.yData[a],u++;return n}},e.defaultOptions=(0,u.merge)(h.defaultOptions,{tooltip:{valueSuffix:"%"}}),e}(h);f().registerSeriesType("natr",y);var l=s();return a.default}()});