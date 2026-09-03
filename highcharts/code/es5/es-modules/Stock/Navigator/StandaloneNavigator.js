/* *
 *
 *  (c) 2010-2026 Highsoft AS
 *  Author: Mateusz Bernacik
 *
 *  Integration of this software requires a license.
 *  - For commercial use, see www.highcharts.com/license
 *  - For non-commercial, see www.highcharts.com/license-eula
 *
 *
 * */
'use strict';
import Chart from '../../Core/Chart/Chart.js';
import Navigator from './Navigator.js';
import G from '../../Core/Globals.js';
import Axis from '../../Core/Axis/Axis.js';
import standaloneNavigatorDefaults from './StandaloneNavigatorDefaults.js';
import { addEvent, fireEvent, merge } from '../../Shared/Utilities.js';
/* *
 *
 *  Class
 *
 * */
/**
 * The StandaloneNavigator class. The StandaloneNavigator class allows for
 * creating a standalone navigator component that synchronizes the extremes
 * across multiple bound charts.
 *
 * @internal
 * @class
 * @name Highcharts.StandaloneNavigator
 *
 * @param {string|Highcharts.HTMLDOMElement} [renderTo]
 * The DOM element to render to, or its id.
 *
 * @param {StandaloneNavigatorOptions} userOptions
 * The standalone navigator options.
 */
var StandaloneNavigator = /** @class */ (function () {
    /* *
     *
     *  Constructor
     *
     * */
    function StandaloneNavigator(element, userOptions) {
        this.boundAxes = [];
        this.userOptions = userOptions;
        this.chartOptions = merge(G.getOptions(), standaloneNavigatorDefaults, userOptions.chart, { navigator: userOptions });
        if (this.chartOptions.chart && userOptions.height) {
            this.chartOptions.chart.height = userOptions.height;
        }
        var chart = new Chart(element, this.chartOptions);
        chart.options = merge(chart.options, { navigator: { enabled: true }, scrollbar: { enabled: true } });
        if (this.chartOptions.navigator && this.chartOptions.scrollbar) {
            this.chartOptions.navigator.enabled = true;
            this.chartOptions.scrollbar.enabled = true;
        }
        this.navigator = new Navigator(chart);
        chart.navigator = this.navigator;
        this.initNavigator();
    }
    /* *
     *
     *  Static Functions
     *
     * */
    /**
     * Factory function for standalone navigator.
     *
     * @function Highcharts.navigator
     *
     * @param {string|Highcharts.HTMLDOMElement} [renderTo]
     * The DOM element to render to, or its id.
     *
     * @param {StandaloneNavigatorOptions} options
     * The standalone navigator options with chart-like structure.
     *
     * Returns the navigator object.
     */
    StandaloneNavigator.navigator = function (renderTo, options) {
        var nav = new StandaloneNavigator(renderTo, options);
        if (!G.navigators) {
            G.navigators = [nav];
        }
        else {
            G.navigators.push(nav);
        }
        return nav;
    };
    /**
     * Binds an axis to the standalone navigator,
     * allowing the navigator to control the axis' range.
     *
     * @sample stock/standalone-navigator/bind/
     *         Bind chart with a button
     *
     * @function Highcharts.StandaloneNavigator#bind
     *
     * @param {Axis | Chart} axisOrChart
     *        The Axis or Chart to bind to the navigator.
     *
     * @param {boolean} [twoWay=true]
     *        Enables two-way binding between the navigator and the axis/chart.
     *        When true, changes in the navigator's range will update the axis
     *        and vice versa. When false, changes in the navigator's range will
     *        be reflected in the axis, but changes in the axis ranges won't be
     *        reflected on the navigator.
     */
    StandaloneNavigator.prototype.bind = function (axisOrChart, twoWay) {
        var _this = this;
        var _a, _b;
        if (twoWay === void 0) { twoWay = true; }
        var nav = this;
        // If the chart is passed, bind the first xAxis
        var axis = (axisOrChart instanceof Chart) ?
            axisOrChart.xAxis[0] :
            axisOrChart;
        if (!(axis instanceof Axis)) {
            return;
        }
        var navigator = this.navigator, _c = navigator.xAxis, min = _c.min, max = _c.max, removeEventCallbacks = [];
        if (twoWay) {
            var removeSetExtremesEvent = addEvent(axis, 'setExtremes', function (e) {
                if (e.trigger === 'pan' ||
                    e.trigger === 'zoom' ||
                    e.trigger === 'mousewheel' ||
                    e.trigger === 'rangeSelectorButton' ||
                    e.trigger === 'rangeSelectorInput') {
                    nav.setRange(e.min, e.max, true, e.trigger !== 'pan' && e.trigger !== 'mousewheel', { trigger: axis });
                }
            });
            removeEventCallbacks.push(removeSetExtremesEvent);
        }
        var removeSetRangeEvent = addEvent(navigator, 'setRange', function (e) {
            axis.setExtremes(e.min, e.max, e.redraw, e.animation);
        });
        removeEventCallbacks.push(removeSetRangeEvent);
        var boundAxis = this.boundAxes.filter(function (boundAxis) {
            return boundAxis.axis === axis;
        })[0];
        if (!boundAxis) {
            boundAxis = { axis: axis, callbacks: [] };
            // A navigator bound to a yAxis defines the full range the axis
            // should cover. Stash the axis' own bounds before overriding them,
            // so `unbind` can restore them, #24716
            if (axis.coll === 'yAxis') {
                boundAxis.oldMin = (_a = axis.options.min) !== null && _a !== void 0 ? _a : axis.min;
                boundAxis.oldMax = (_b = axis.options.max) !== null && _b !== void 0 ? _b : axis.max;
            }
            this.boundAxes.push(boundAxis);
        }
        boundAxis.callbacks = removeEventCallbacks;
        // Show axis' series in navigator based on showInNavigator property
        axis.series.forEach(function (series) {
            if (series.options.showInNavigator) {
                nav.addSeries(series.options);
            }
        });
        // Bind a yAxis to the navigator's full range so vertical panning isn't
        // capped at the series' data extremes, #24716
        if (axis.coll === 'yAxis') {
            var _d = navigator.xAxis.getExtremes(), dataMin = _d.dataMin, dataMax = _d.dataMax;
            axis.update({ min: dataMin, max: dataMax }, false);
        }
        // Set extremes to match the navigator's extremes
        axis.setExtremes(min, max);
        // Unbind the axis before it's destroyed
        addEvent(axis, 'destroy', function (e) {
            if (!e.keepEvents) {
                _this.unbind(axis);
            }
        });
    };
    /**
     * Unbinds a single axis or all bound axes from the standalone navigator.
     *
     * @sample stock/standalone-navigator/unbind/
     *         Unbind chart with a button
     *
     * @function Highcharts.StandaloneNavigator#unbind
     *
     * @param {Chart | Axis | undefined} axisOrChart
     *        Passing a Chart object unbinds the first X axis of the chart,
     *        an Axis object unbinds that specific axis,
     *        and undefined unbinds all axes bound to the navigator.
     * @param {boolean} restoreExtremes
     *        Whether to restore the axis' original min/max that were
     *        overridden when binding a yAxis.
     */
    StandaloneNavigator.prototype.unbind = function (axisOrChart, restoreExtremes) {
        var _this = this;
        // If no axis or chart is provided, unbind all bound axes
        if (!axisOrChart) {
            this.boundAxes.forEach(function (boundAxis) {
                _this.releaseAxis(boundAxis, restoreExtremes);
            });
            this.boundAxes.length = 0;
            return;
        }
        var axis = (axisOrChart instanceof Axis) ?
            axisOrChart :
            axisOrChart.xAxis[0];
        for (var i = this.boundAxes.length - 1; i >= 0; i--) {
            if (this.boundAxes[i].axis === axis) {
                this.releaseAxis(this.boundAxes[i], restoreExtremes);
                this.boundAxes.splice(i, 1);
            }
        }
    };
    /**
     * Disconnect a bound axis' events and restore the axis' own bounds that
     * were overridden when binding a yAxis.
     *
     * @internal
     *
     * @param {BoundAxis} boundAxis
     *        The bound axis entry to release.
     * @param {boolean} [restoreExtremes=false]
     *        Whether to restore the axis' original min/max that were
     *        overridden when binding a yAxis.
     */
    StandaloneNavigator.prototype.releaseAxis = function (boundAxis, restoreExtremes) {
        var _a, _b;
        if (restoreExtremes === void 0) { restoreExtremes = false; }
        // Disconnect events
        boundAxis.callbacks.forEach(function (removeCallback) { return removeCallback(); });
        // Restore the axis' original min/max that were overridden in `bind`
        if (boundAxis.axis.coll === 'yAxis' && restoreExtremes) {
            var min = (_a = boundAxis.oldMin) !== null && _a !== void 0 ? _a : void 0, max = (_b = boundAxis.oldMax) !== null && _b !== void 0 ? _b : void 0;
            boundAxis.axis.update({ min: min, max: max }, false);
            boundAxis.axis.setExtremes(min, max);
        }
    };
    /**
     * Destroys allocated standalone navigator elements.
     *
     * @function Highcharts.StandaloneNavigator#destroy
     *
     * @param {boolean} restoreExtremes
     *        Whether to restore the axis' original min/max that were
     *        overridden when binding a yAxis.
     */
    StandaloneNavigator.prototype.destroy = function (restoreExtremes) {
        var _this = this;
        this.boundAxes.forEach(function (boundAxis) {
            _this.releaseAxis(boundAxis, restoreExtremes);
        });
        this.boundAxes.length = 0;
        this.navigator.destroy();
        this.navigator.chart.destroy();
    };
    /**
     * Updates the standalone navigator's options with a new set of user
     * options.
     *
     * @sample stock/standalone-navigator/update/
     *         Bind chart with a button
     *
     * @function Highcharts.StandaloneNavigator#update
     *
     * @param  {StandaloneNavigatorOptions} newOptions
     *         Updates the standalone navigator's options with new user options.
     *
     * @param  {boolean | undefined} redraw
     *         Whether to redraw the standalone navigator. By default, if not
     *         specified, the standalone navigator will be redrawn.
     */
    StandaloneNavigator.prototype.update = function (newOptions, redraw) {
        this.chartOptions = merge(this.chartOptions, newOptions.height && { chart: { height: newOptions.height } }, newOptions.chart, { navigator: newOptions });
        this.navigator.chart.update(this.chartOptions, redraw);
    };
    /**
     * Redraws the standalone navigator.
     *
     * @function Highcharts.StandaloneNavigator#redraw
     */
    StandaloneNavigator.prototype.redraw = function () {
        this.navigator.chart.redraw();
    };
    /**
     * Adds a series to the standalone navigator.
     *
     * @internal
     *
     * @param {SeriesOptions} seriesOptions
     *        Options for the series to be added to the navigator.
     */
    StandaloneNavigator.prototype.addSeries = function (seriesOptions) {
        var _a;
        this.navigator.chart.addSeries(merge(seriesOptions, { showInNavigator: ((_a = seriesOptions.showInNavigator) !== null && _a !== void 0 ? _a : true) }));
        this.navigator.setBaseSeries();
    };
    /**
     * Initialize the standalone navigator.
     *
     * @internal
     */
    StandaloneNavigator.prototype.initNavigator = function () {
        var _a;
        var nav = this.navigator;
        nav.top = 1;
        nav.xAxis.setScale();
        nav.yAxis.setScale();
        nav.xAxis.render();
        nav.yAxis.render();
        (_a = nav.series) === null || _a === void 0 ? void 0 : _a.forEach(function (s) {
            s.translate();
            s.render();
            s.redraw();
        });
        var _b = this.getInitialExtremes(), min = _b.min, max = _b.max;
        nav.chart.xAxis[0].userMin = min;
        nav.chart.xAxis[0].userMax = max;
        nav.render(min, max);
    };
    /**
     * Get the current range of the standalone navigator.
     *
     * @sample stock/standalone-navigator/getrange/
     *         Report the standalone navigator's range by clicking on a button
     *
     * @function Highcharts.StandaloneNavigator#getRange
     *
     * @return {Highcharts.ExtremesObject}
     *         The current range of the standalone navigator.
     */
    StandaloneNavigator.prototype.getRange = function () {
        var _a = this.navigator.chart.xAxis[0].getExtremes(), min = _a.min, max = _a.max, _b = this.navigator.xAxis.getExtremes(), userMin = _b.userMin, userMax = _b.userMax, dataMin = _b.min, dataMax = _b.max;
        return {
            min: (min !== null && min !== void 0 ? min : dataMin),
            max: (max !== null && max !== void 0 ? max : dataMax),
            dataMin: dataMin,
            dataMax: dataMax,
            userMin: userMin,
            userMax: userMax
        };
    };
    /**
     * Set the range of the standalone navigator.
     *
     * @sample stock/standalone-navigator/setrange/
     *         Set range from a button
     *
     * @function Highcharts.StandaloneNavigator#setRange
     *
     * @param {number | undefined} min
     *        The new minimum value.
     *
     * @param {number | undefined} max
     *        The new maximum value.
     *
     * @emits Highcharts.StandaloneNavigator#event:setRange
     */
    StandaloneNavigator.prototype.setRange = function (min, max, redraw, animation, eventArguments) {
        fireEvent(this.navigator, 'setRange', {
            min: min,
            max: max,
            redraw: redraw,
            animation: animation,
            eventArguments: merge(eventArguments, { trigger: 'navigator' })
        });
    };
    /**
     * Get the initial, options based extremes for the standalone navigator.
     *
     * @internal
     *
     * @return {{ min: number, max: number }}
     *         The initial minimum and maximum extremes values.
     */
    StandaloneNavigator.prototype.getInitialExtremes = function () {
        var _a = this.navigator.xAxis.getExtremes(), min = _a.min, max = _a.max;
        return {
            min: min,
            max: max
        };
    };
    return StandaloneNavigator;
}());
/** @internal */
export default StandaloneNavigator;
/* *
 *
 *  API Declarations
 *
 * */
/**
 * Standalone Navigator options.
 *
 * @interface Highcharts.StandaloneNavigatorOptions
 */ /**
*/
''; // Detach doclets above
