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
var __spreadArray = (this && this.__spreadArray) || function (to, from, pack) {
    if (pack || arguments.length === 2) for (var i = 0, l = from.length, ar; i < l; i++) {
        if (ar || !(i in from)) {
            if (!ar) ar = Array.prototype.slice.call(from, 0, i);
            ar[i] = from[i];
        }
    }
    return to.concat(ar || Array.prototype.slice.call(from));
};
import { borderRadiusObject } from '../../Extensions/BorderRadius.js';
import BoxPlotSeriesDefaults from './BoxPlotSeriesDefaults.js';
import ColumnSeries from '../Column/ColumnSeries.js';
import H from '../../Core/Globals.js';
var noop = H.noop;
import RangeDataLabel from '../RangeDataLabel.js';
import SeriesRegistry from '../../Core/Series/SeriesRegistry.js';
import { crisp, extend, merge, relativeLength } from '../../Shared/Utilities.js';
/* *
 *
 *  Class
 *
 * */
/**
 * The boxplot series type.
 *
 * @internal
 * @class
 * @name Highcharts.seriesTypes#boxplot
 *
 * @augments Highcharts.Series
 */
var BoxPlotSeries = /** @class */ (function (_super) {
    __extends(BoxPlotSeries, _super);
    function BoxPlotSeries() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    /* *
     *
     *  Functions
     *
     * */
    // Get presentational attributes
    BoxPlotSeries.prototype.pointAttribs = function () {
        // No attributes should be set on point.graphic which is the group. The
        // returned fill is for legend symbols.
        return { fill: this.color };
    };
    // Get an SVGPath object for both whiskers
    BoxPlotSeries.prototype.getWhiskerPair = function (halfWidth, stemX, upperWhiskerLength, lowerWhiskerLength, point) {
        var strokeWidth = point.whiskers.strokeWidth(), getWhisker = function (xLen, yPos) {
            var halfLen = relativeLength(xLen, 2 * halfWidth) / 2, crispedYPos = crisp(yPos, strokeWidth);
            return [
                [
                    'M',
                    crisp(stemX - halfLen),
                    crispedYPos
                ],
                [
                    'L',
                    crisp(stemX + halfLen),
                    crispedYPos
                ]
            ];
        };
        return __spreadArray(__spreadArray([], getWhisker(upperWhiskerLength, point.highPlot), true), getWhisker(lowerWhiskerLength, point.lowPlot), true);
    };
    // Translate data points from raw values x and y to plotX and plotY
    BoxPlotSeries.prototype.translate = function () {
        var series = this, yAxis = series.yAxis, pointArrayMap = series.pointArrayMap;
        _super.prototype.translate.apply(series);
        // Do the translation on each point dimension
        series.points.forEach(function (point) {
            pointArrayMap.forEach(function (key) {
                var value = point[key];
                if (value !== null) {
                    point["".concat(key, "Plot")] = yAxis.translate(value, false, true, false, true);
                }
            });
            point.plotHigh = point.highPlot; // For data label validation
        });
    };
    /**
     * Draw the data points
     * @internal
     */
    BoxPlotSeries.prototype.drawPoints = function () {
        var _a, _b, _c, _d, _e, _f, _g, _h, _j, _k;
        var series = this, points = series.points, options = series.options, chart = series.chart, renderer = chart.renderer, 
        // Error bar inherits this series type but doesn't do quartiles
        doQuartiles = series.doQuartiles !== false, whiskerLength = series.options.whiskerLength;
        var q1Plot, q3Plot, highPlot, lowPlot, medianPlot, medianPath, boxPath, graphic, width, x, right;
        for (var _i = 0, points_1 = points; _i < points_1.length; _i++) {
            var point = points_1[_i];
            graphic = point.graphic;
            var verb = graphic ? 'animate' : 'attr', shapeArgs = point.shapeArgs, boxAttr = {}, stemAttr = {}, whiskersAttr = {}, medianAttr = {}, color = point.color || series.color, pointWhiskerLength = (point.options.whiskerLength ||
                whiskerLength);
            if (typeof point.plotY !== 'undefined') {
                // Vector coordinates
                width = shapeArgs.width;
                x = shapeArgs.x;
                right = x + width;
                q1Plot = doQuartiles ? point.q1Plot : point.lowPlot;
                q3Plot = doQuartiles ? point.q3Plot : point.lowPlot;
                highPlot = point.highPlot;
                lowPlot = point.lowPlot;
                if (!graphic) {
                    point.graphic = graphic = renderer.g('point')
                        .add(series.group);
                    point.stem = renderer.path()
                        .addClass('highcharts-boxplot-stem')
                        .add(graphic);
                    if (whiskerLength) {
                        point.whiskers = renderer.path()
                            .addClass('highcharts-boxplot-whisker')
                            .add(graphic);
                    }
                    if (doQuartiles) {
                        point.box = renderer.path(boxPath)
                            .addClass('highcharts-boxplot-box')
                            .add(graphic);
                    }
                    point.medianShape = renderer.path(medianPath)
                        .addClass('highcharts-boxplot-median')
                        .add(graphic);
                }
                if (!chart.styledMode) {
                    // Stem attributes
                    stemAttr.stroke =
                        point.stemColor || options.stemColor || color;
                    stemAttr['stroke-width'] =
                        (_b = (_a = point.stemWidth) !== null && _a !== void 0 ? _a : options.stemWidth) !== null && _b !== void 0 ? _b : options.lineWidth;
                    stemAttr.dashstyle = (point.stemDashStyle ||
                        options.stemDashStyle ||
                        options.dashStyle);
                    point.stem.attr(stemAttr);
                    // Whiskers attributes
                    if (pointWhiskerLength) {
                        whiskersAttr.stroke = (point.whiskerColor ||
                            options.whiskerColor ||
                            color);
                        whiskersAttr['stroke-width'] =
                            (_d = (_c = point.whiskerWidth) !== null && _c !== void 0 ? _c : options.whiskerWidth) !== null && _d !== void 0 ? _d : options.lineWidth;
                        whiskersAttr.dashstyle = (point.whiskerDashStyle ||
                            options.whiskerDashStyle ||
                            options.dashStyle);
                        point.whiskers.attr(whiskersAttr);
                    }
                    if (doQuartiles) {
                        boxAttr.fill = (point.fillColor ||
                            options.fillColor ||
                            color);
                        boxAttr.stroke = options.lineColor || color;
                        boxAttr['stroke-width'] = options.lineWidth || 0;
                        boxAttr.dashstyle = (point.boxDashStyle ||
                            options.boxDashStyle ||
                            options.dashStyle);
                        point.box.attr(boxAttr);
                    }
                    // Median attributes
                    medianAttr.stroke = (point.medianColor ||
                        options.medianColor ||
                        color);
                    medianAttr['stroke-width'] =
                        (_f = (_e = point.medianWidth) !== null && _e !== void 0 ? _e : options.medianWidth) !== null && _f !== void 0 ? _f : options.lineWidth;
                    medianAttr.dashstyle = (point.medianDashStyle ||
                        options.medianDashStyle ||
                        options.dashStyle);
                    point.medianShape.attr(medianAttr);
                }
                // The stem
                var stemX = crisp((point.plotX || 0) + (series.pointXOffset || 0) +
                    ((series.barW || 0) / 2), point.stem.strokeWidth());
                point.stem[verb]({
                    d: [
                        // Stem up
                        ['M', stemX, q3Plot],
                        ['L', stemX, highPlot],
                        // Stem down
                        ['M', stemX, q1Plot],
                        ['L', stemX, lowPlot]
                    ]
                });
                // The box
                if (doQuartiles) {
                    var boxStrokeWidth = point.box.strokeWidth();
                    q1Plot = crisp(q1Plot, boxStrokeWidth);
                    q3Plot = crisp(q3Plot, boxStrokeWidth);
                    x = crisp(x, boxStrokeWidth);
                    right = crisp(right, boxStrokeWidth);
                    // Optionally round the corners of the box
                    var r = Math.min(relativeLength(borderRadiusObject(options.borderRadius).radius, right - x), (right - x) / 2, Math.abs(q1Plot - q3Plot) / 2);
                    point.box[verb]({
                        d: renderer.symbols.roundedRect(x, Math.min(q1Plot, q3Plot), right - x, Math.abs(q1Plot - q3Plot), { r: r })
                    });
                }
                // The whiskers
                if (pointWhiskerLength) {
                    var halfWidth = width / 2, whiskers = this.getWhiskerPair(halfWidth, stemX, ((_h = (_g = point.upperWhiskerLength) !== null && _g !== void 0 ? _g : options.upperWhiskerLength) !== null && _h !== void 0 ? _h : pointWhiskerLength), ((_k = (_j = point.lowerWhiskerLength) !== null && _j !== void 0 ? _j : options.lowerWhiskerLength) !== null && _k !== void 0 ? _k : pointWhiskerLength), point);
                    point.whiskers[verb]({ d: whiskers });
                }
                // The median
                medianPlot = crisp(point.medianPlot, point.medianShape.strokeWidth());
                point.medianShape[verb]({
                    d: [
                        ['M', x, medianPlot],
                        ['L', right, medianPlot]
                    ]
                });
            }
        }
    };
    // Return a plain array for speedy calculation
    BoxPlotSeries.prototype.toYData = function (point) {
        return [point.low, point.q1, point.median, point.q3, point.high];
    };
    /* *
     *
     *  Static Properties
     *
     * */
    BoxPlotSeries.defaultOptions = merge(ColumnSeries.defaultOptions, BoxPlotSeriesDefaults);
    return BoxPlotSeries;
}(ColumnSeries));
extend(BoxPlotSeries.prototype, {
    // Array point configs are mapped to this
    pointArrayMap: ['low', 'q1', 'median', 'q3', 'high'],
    // Defines the top of the tracker
    pointValKey: 'high',
    setStackedPoints: noop // #3890
});
RangeDataLabel.compose(BoxPlotSeries);
SeriesRegistry.registerSeriesType('boxplot', BoxPlotSeries);
/* *
 *
 *  Default Export
 *
 * */
/**
 * @internal
 */
export default BoxPlotSeries;
