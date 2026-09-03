/* *
 *
 *  (c) 2010-2026 Highsoft AS
 *  Author: Torstein Hønsi
 *
 *  Integration of this software requires a license.
 *  - For commercial use, see www.highcharts.com/license
 *  - For non-commercial, see www.highcharts.com/license-eula
 *
 *
 * */
'use strict';
var __extends = (this && this.__extends) || (function () {
    var extendStatics = function (d, b) {
        extendStatics = Object.setPrototypeOf ||
            ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
            function (d, b) { for (var p in b) if (Object.prototype.hasOwnProperty.call(b, p)) d[p] = b[p]; };
        return extendStatics(d, b);
    };
    return function (d, b) {
        if (typeof b !== "function" && b !== null)
            throw new TypeError("Class extends value " + String(b) + " is not a constructor or null");
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
import AreaRangePoint from './AreaRangePoint.js';
import H from '../../Core/Globals.js';
var noop = H.noop;
import RangeDataLabel from '../RangeDataLabel.js';
import SeriesRegistry from '../../Core/Series/SeriesRegistry.js';
var _a = SeriesRegistry.seriesTypes, AreaSeries = _a.area, areaProto = _a.area.prototype;
import { addEvent, defined, extend, isArray, isNumber, merge } from '../../Shared/Utilities.js';
/* *
 *
 *  Constants
 *
 * */
/**
 * The area range series is a cartesian series with higher and lower values for
 * each point along an X axis, where the area between the values is shaded.
 *
 * @sample {highcharts} highcharts/demo/arearange/
 *         Area range chart
 * @sample {highstock} stock/demo/arearange/
 *         Area range chart
 *
 * @extends      plotOptions.area
 * @product      highcharts highstock
 * @excluding    stack, stacking
 * @requires     highcharts-more
 * @optionparent plotOptions.arearange
 *
 * @internal
 */
var areaRangeSeriesOptions = {
    /**
     * @see [fillColor](#plotOptions.arearange.fillColor)
     * @see [fillOpacity](#plotOptions.arearange.fillOpacity)
     *
     * @apioption plotOptions.arearange.color
     */
    /**
     * @default   low
     * @apioption plotOptions.arearange.colorKey
     */
    /**
     * @see [color](#plotOptions.arearange.color)
     * @see [fillOpacity](#plotOptions.arearange.fillOpacity)
     *
     * @apioption plotOptions.arearange.fillColor
     */
    /**
     * @see [color](#plotOptions.arearange.color)
     * @see [fillColor](#plotOptions.arearange.fillColor)
     *
     * @default   {highcharts} 0.75
     * @default   {highstock} 0.75
     * @apioption plotOptions.arearange.fillOpacity
     */
    /**
     * Whether to apply a drop shadow to the graph line. Since 2.3 the
     * shadow can be an object configuration containing `color`, `offsetX`,
     * `offsetY`, `opacity` and `width`.
     *
     * @type      {boolean|Highcharts.ShadowOptionsObject}
     * @product   highcharts
     * @apioption plotOptions.arearange.shadow
     */
    /**
     * Pixel width of the arearange graph line.
     *
     * @since 2.3.0
     *
     * @internal
     */
    lineWidth: 1,
    /**
     * @type {number|null}
     */
    threshold: null,
    tooltip: {
        pointFormat: '<span style="color:{series.color}">\u25CF</span> ' +
            '{series.name}: <b>{point.low}</b> - <b>{point.high}</b><br/>'
    },
    /**
     * Whether the whole area or just the line should respond to mouseover
     * tooltips and other mouse or touch events.
     *
     * @since 2.3.0
     *
     * @internal
     */
    trackByArea: true,
    /**
     * Extended data labels for range series types. Range series data
     * labels can be positioned individually by defining them as an array
     * and setting `alignToKey` to `high` or `low`.
     *
     * @declare Highcharts.SeriesAreaRangeDataLabelsOptionsObject
     * @since   2.3.0
     * @product highcharts highstock
     *
     * @internal
     */
    dataLabels: {
        align: void 0,
        formatter: RangeDataLabel.formatter,
        verticalAlign: void 0,
        /**
         * X offset of the lower data labels relative to the point value.
         *
         * Deprecated. Use a data labels array with `alignToKey: 'low'` and
         * the regular `x` option instead.
         *
         * @sample highcharts/plotoptions/arearange-datalabels/
         *         Data labels on range series
         * @sample highcharts/plotoptions/arearange-datalabels/
         *         Data labels on range series
         * @deprecated 13.0.1
         */
        xLow: 0,
        /**
         * X offset of the higher data labels relative to the point value.
         *
         * Deprecated. Use a data labels array with `alignToKey: 'high'` and
         * the regular `x` option instead.
         *
         * @sample highcharts/plotoptions/arearange-datalabels/
         *         Data labels on range series
         * @deprecated 13.0.1
         */
        xHigh: 0,
        /**
         * Y offset of the lower data labels relative to the point value.
         *
         * Deprecated. Use a data labels array with `alignToKey: 'low'` and
         * the regular `y` option instead.
         *
         * @sample highcharts/plotoptions/arearange-datalabels/
         *         Data labels on range series
         * @deprecated 13.0.1
         */
        yLow: 0,
        /**
         * Y offset of the higher data labels relative to the point value.
         *
         * Deprecated. Use a data labels array with `alignToKey: 'high'` and
         * the regular `y` option instead.
         *
         * @sample highcharts/plotoptions/arearange-datalabels/
         *         Data labels on range series
         * @deprecated 13.0.1
         */
        yHigh: 0
    }
};
/* *
 *
 *  Functions
 *
 * */
/**
 * Normalize the dataLabels config into a per-label array. Resolves the
 * `alignToKey` default (`high` for the first label, `low` for the second) and
 * maps the deprecated `xLow/xHigh/yLow/yHigh` offsets onto each label's `x/y`.
 * @internal
 */
function getRangeDataLabelOptions(series) {
    var dataLabels = series.options.dataLabels;
    if (isArray(dataLabels)) {
        return Array.from({
            length: Math.max(dataLabels.length, 2)
        }, function (_, index) {
            var _a;
            var options = dataLabels[index], defaultAlignToKey = index === 0 ? 'high' :
                index === 1 ? 'low' :
                    series.pointValKey, alignToKey = (_a = options === null || options === void 0 ? void 0 : options.alignToKey) !== null && _a !== void 0 ? _a : defaultAlignToKey;
            return merge(options !== null && options !== void 0 ? options : { enabled: false }, { alignToKey: alignToKey });
        });
    }
    if (dataLabels === null || dataLabels === void 0 ? void 0 : dataLabels.alignToKey) {
        return [
            merge(dataLabels, dataLabels.alignToKey === 'high' ? {
                x: dataLabels.xHigh,
                y: dataLabels.yHigh
            } : dataLabels.alignToKey === 'low' ? {
                x: dataLabels.xLow,
                y: dataLabels.yLow
            } : {})
        ];
    }
    return [
        merge(dataLabels, {
            alignToKey: 'high',
            x: dataLabels === null || dataLabels === void 0 ? void 0 : dataLabels.xHigh,
            y: dataLabels === null || dataLabels === void 0 ? void 0 : dataLabels.yHigh
        }),
        merge(dataLabels, {
            alignToKey: 'low',
            x: dataLabels === null || dataLabels === void 0 ? void 0 : dataLabels.xLow,
            y: dataLabels === null || dataLabels === void 0 ? void 0 : dataLabels.yLow
        })
    ];
}
/* *
 *
 *  Class
 *
 * */
/**
 * The AreaRange series type.
 *
 * @internal
 * @class
 * @name Highcharts.seriesTypes.arearange
 *
 * @augments Highcharts.Series
 */
var AreaRangeSeries = /** @class */ (function (_super) {
    __extends(AreaRangeSeries, _super);
    function AreaRangeSeries() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    /* *
     *
     *  Functions
     *
     * */
    AreaRangeSeries.prototype.toYData = function (point) {
        return [point.low, point.high];
    };
    /**
     * Translate a point's plotHigh from the internal angle and radius measures
     * to true plotHigh coordinates. This is an addition of the toXY method
     * found in Polar.js, because it runs too early for arearange to be
     * considered (#3419).
     * @internal
     */
    AreaRangeSeries.prototype.highToXY = function (point) {
        // Find the polar plotX and plotY
        var chart = this.chart, xy = this.xAxis.postTranslate(point.rectPlotX || 0, this.yAxis.len - (point.plotHigh || 0));
        point.plotHighX = xy.x - chart.plotLeft;
        point.plotHigh = xy.y - chart.plotTop;
        point.plotLowX = point.plotX;
    };
    /**
     * Extend the line series' getSegmentPath method by applying the segment
     * path to both lower and higher values of the range.
     * @internal
     */
    AreaRangeSeries.prototype.getGraphPath = function (points) {
        var _a;
        var highPoints = [], highAreaPoints = [], getGraphPath = areaProto.getGraphPath, options = this.options, polar = this.chart.polar, connectEnds = polar && options.connectEnds !== false, connectNulls = options.connectNulls;
        var i, point, pointShim, step = options.step;
        points = points || this.points;
        // Create the top line and the top part of the area fill. The area fill
        // compensates for null points by drawing down to the lower graph,
        // moving across the null gap and starting again at the lower graph.
        i = points.length;
        while (i--) {
            point = points[i];
            // Support for polar
            var highAreaPoint = polar ? {
                plotX: point.rectPlotX,
                plotY: point.yBottom,
                doCurve: false // #5186, gaps in areasplinerange fill
            } : {
                plotX: point.plotX,
                plotY: point.plotY,
                doCurve: false // #5186, gaps in areasplinerange fill
            };
            if (!point.isNull &&
                !connectEnds &&
                !connectNulls &&
                (!points[i + 1] || points[i + 1].isNull)) {
                highAreaPoints.push(highAreaPoint);
            }
            pointShim = {
                polarPlotY: point.polarPlotY,
                rectPlotX: point.rectPlotX,
                yBottom: point.yBottom,
                // `plotHighX` is for polar charts
                plotX: (_a = point.plotHighX) !== null && _a !== void 0 ? _a : point.plotX,
                plotY: point.plotHigh,
                isNull: point.isNull
            };
            highAreaPoints.push(pointShim);
            highPoints.push(pointShim);
            if (!point.isNull &&
                !connectEnds &&
                !connectNulls &&
                (!points[i - 1] || points[i - 1].isNull)) {
                highAreaPoints.push(highAreaPoint);
            }
        }
        // Get the paths
        var lowerPath = getGraphPath.call(this, points);
        if (step) {
            if (step === true) {
                step = 'left';
            }
            options.step = {
                left: 'right',
                center: 'center',
                right: 'left'
            }[step]; // Swap for reading in getGraphPath
        }
        var higherPath = getGraphPath.call(this, highPoints);
        var higherAreaPath = getGraphPath.call(this, highAreaPoints);
        options.step = step;
        // Create a line on both top and bottom of the range
        var linePath = [].concat(lowerPath, higherPath);
        // For the area path, we need to change the 'move' statement into
        // 'lineTo'
        if (!this.chart.polar &&
            higherAreaPath[0] &&
            higherAreaPath[0][0] === 'M') {
            // This probably doesn't work for spline
            higherAreaPath[0] = [
                'L',
                higherAreaPath[0][1],
                higherAreaPath[0][2]
            ];
        }
        this.graphPath = linePath;
        this.areaPath = lowerPath.concat(higherAreaPath);
        // Prepare for sideways animation
        linePath.isArea = true;
        linePath.xMap = lowerPath.xMap;
        this.areaPath.xMap = lowerPath.xMap;
        return linePath;
    };
    AreaRangeSeries.prototype.drawDataLabels = function () {
        var _a;
        var series = this, dataLabelOptions = series.options.dataLabels;
        if (dataLabelOptions) {
            var rangeOptions = getRangeDataLabelOptions(series);
            // Resolve value references like `{y}` against the aligned key
            rangeOptions.forEach(RangeDataLabel.applyAlignToKeyValue);
            series.options.dataLabels = rangeOptions;
            if (areaProto.drawDataLabels) {
                // #1209
                areaProto.drawDataLabels.call(series);
            }
            series.options.dataLabels = dataLabelOptions;
            for (var _i = 0, _b = series.points; _i < _b.length; _i++) {
                var point = _b[_i];
                var labels = (_a = point.dataLabels) !== null && _a !== void 0 ? _a : [];
                point.dataLabelUpper = labels.find(function (label) {
                    var _a;
                    return (RangeDataLabel.resolveAlignToKey(series, (_a = label.options) === null || _a === void 0 ? void 0 : _a.alignToKey) === 'high');
                });
                point.dataLabel = labels.find(function (label) {
                    var _a;
                    return (RangeDataLabel.resolveAlignToKey(series, (_a = label.options) === null || _a === void 0 ? void 0 : _a.alignToKey) === 'low');
                });
            }
        }
    };
    AreaRangeSeries.prototype.modifyMarkerSettings = function () {
        var series = this, originalMarkerSettings = {
            marker: series.options.marker,
            symbol: series.symbol
        };
        if (series.options.lowMarker) {
            var _a = series.options, marker = _a.marker, lowMarker = _a.lowMarker;
            series.options.marker = merge(marker, lowMarker);
            if (lowMarker.symbol) {
                series.symbol = lowMarker.symbol;
            }
        }
        return originalMarkerSettings;
    };
    AreaRangeSeries.prototype.restoreMarkerSettings = function (originalSettings) {
        var series = this;
        series.options.marker = originalSettings.marker;
        series.symbol = originalSettings.symbol;
    };
    AreaRangeSeries.prototype.drawPoints = function () {
        var _a;
        var series = this, pointLength = series.points.length;
        var i, point;
        var originalSettings = series.modifyMarkerSettings();
        // Draw bottom points
        areaProto.drawPoints.apply(series, arguments);
        // Restore previous state
        series.restoreMarkerSettings(originalSettings);
        // Prepare drawing top points
        i = 0;
        while (i < pointLength) {
            point = series.points[i];
            point.graphics = point.graphics || [];
            // Save original props to be overridden by temporary props for top
            // points
            point.origProps = {
                plotY: point.plotY,
                plotX: point.plotX,
                isInside: point.isInside,
                negative: point.negative,
                zone: point.zone,
                y: point.y
            };
            if (point.graphic || point.graphics[0]) {
                point.graphics[0] = point.graphic;
            }
            point.graphic = point.graphics[1];
            point.plotY = point.plotHigh;
            if (defined(point.plotHighX)) {
                point.plotX = point.plotHighX;
            }
            point.y = (_a = point.high) !== null && _a !== void 0 ? _a : point.origProps.y; // #15523
            point.negative = point.y < (series.options.threshold || 0);
            if (series.zones.length) {
                point.zone = point.getZone();
            }
            if (!series.chart.polar) {
                point.isInside = point.isTopInside = (typeof point.plotY !== 'undefined' &&
                    point.plotY >= 0 &&
                    point.plotY <= series.yAxis.len && // #3519
                    point.plotX >= 0 &&
                    point.plotX <= series.xAxis.len);
            }
            i++;
        }
        // Draw top points
        areaProto.drawPoints.apply(series, arguments);
        // Reset top points preliminary modifications
        i = 0;
        while (i < pointLength) {
            point = series.points[i];
            point.graphics = point.graphics || [];
            if (point.graphic || point.graphics[1]) {
                point.graphics[1] = point.graphic;
            }
            point.graphic = point.graphics[0];
            if (point.origProps) {
                extend(point, point.origProps);
                delete point.origProps;
            }
            i++;
        }
    };
    AreaRangeSeries.prototype.hasMarkerChanged = function (options, oldOptions) {
        var lowMarker = options.lowMarker, oldMarker = oldOptions.lowMarker || {};
        return (lowMarker && (lowMarker.enabled === false ||
            oldMarker.symbol !== lowMarker.symbol || // #10870, #15946
            oldMarker.height !== lowMarker.height || // #16274
            oldMarker.width !== lowMarker.width // #16274
        )) || _super.prototype.hasMarkerChanged.call(this, options, oldOptions);
    };
    /**
     *
     *  Static Properties
     *
     */
    AreaRangeSeries.defaultOptions = merge(AreaSeries.defaultOptions, areaRangeSeriesOptions);
    return AreaRangeSeries;
}(AreaSeries));
addEvent(AreaRangeSeries, 'afterTranslate', function () {
    // Set plotLow and plotHigh
    var _this = this;
    // Rules out lollipop, but lollipop should not inherit range series in the
    // first place
    if (this.pointArrayMap.join(',') === 'low,high') {
        this.points.forEach(function (point) {
            var high = point.high, plotY = point.plotY;
            if (point.isNull) {
                point.plotY = void 0;
            }
            else {
                point.plotLow = plotY;
                // Calculate plotHigh value based on each yAxis scale (#15752)
                point.plotHigh = isNumber(high) ? _this.yAxis.translate(_this.dataModify ?
                    _this.dataModify.modifyValue(high) : high, false, true, void 0, true) : void 0;
                if (_this.dataModify) {
                    point.yBottom = point.plotHigh;
                }
            }
        });
    }
}, { order: 0 });
addEvent(AreaRangeSeries, 'afterTranslate', function () {
    var _this = this;
    this.points.forEach(function (point) {
        // Postprocessing after the PolarComposition's afterTranslate
        if (_this.chart.polar) {
            _this.highToXY(point);
            point.plotLow = point.plotY;
            point.tooltipPos = [
                ((point.plotHighX || 0) + (point.plotLowX || 0)) / 2,
                ((point.plotHigh || 0) + (point.plotLow || 0)) / 2
            ];
            // Put the tooltip in the middle of the range
        }
        else {
            var tooltipPos = point.pos(false, void 0, point.plotLow), posHigh = point.pos(false, void 0, point.plotHigh);
            if (tooltipPos && posHigh) {
                tooltipPos[0] = (tooltipPos[0] + posHigh[0]) / 2;
                tooltipPos[1] = (tooltipPos[1] + posHigh[1]) / 2;
            }
            point.tooltipPos = tooltipPos;
        }
    });
}, { order: 3 });
extend(AreaRangeSeries.prototype, {
    deferTranslatePolar: true,
    pointArrayMap: ['low', 'high'],
    pointClass: AreaRangePoint,
    pointValKey: 'low',
    setStackedPoints: noop
});
RangeDataLabel.compose(AreaRangeSeries);
SeriesRegistry.registerSeriesType('arearange', AreaRangeSeries);
/* *
 *
 *  Default Export
 *
 * */
/** @internal */
export default AreaRangeSeries;
