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
import ColumnRangePoint from './ColumnRangePoint.js';
import ColumnRangeSeriesDefaults from './ColumnRangeSeriesDefaults.js';
import H from '../../Core/Globals.js';
var noop = H.noop;
import SeriesRegistry from '../../Core/Series/SeriesRegistry.js';
var _a = SeriesRegistry.seriesTypes, AreaRangeSeries = _a.arearange, ColumnSeries = _a.column, columnProto = _a.column.prototype;
import { addEvent, clamp, extend, isNumber, merge } from '../../Shared/Utilities.js';
/* *
 *
 *  Class
 *
 * */
/**
 * The ColumnRangeSeries class
 *
 * @internal
 * @class
 * @name Highcharts.seriesTypes.columnrange
 *
 * @augments Highcharts.Series
 */
var ColumnRangeSeries = /** @class */ (function (_super) {
    __extends(ColumnRangeSeries, _super);
    function ColumnRangeSeries() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    /* *
     *
     *  Functions
     *
     * */
    ColumnRangeSeries.prototype.setOptions = function () {
        // #14359 Prevent side-effect from stacking.
        merge(true, arguments[0], { stacking: void 0 });
        return AreaRangeSeries.prototype.setOptions.apply(this, arguments);
    };
    // Overrides from modules that may be loaded after this module
    // @todo move to compositions
    ColumnRangeSeries.prototype.translate = function () {
        return columnProto.translate.apply(this);
    };
    // Public crispCol(): BBoxObject {
    //     return columnProto.crispCol.apply(this, arguments as any);
    // }
    // public drawPoints(): void {
    //     return columnProto.drawPoints.apply(this, arguments as any);
    // }
    // public drawTracker(): void {
    //     return columnProto.drawTracker.apply(this, arguments as any);
    // }
    // public getColumnMetrics(): ColumnMetricsObject {
    //     return columnProto.getColumnMetrics.apply(this, arguments as any);
    // }
    ColumnRangeSeries.prototype.pointAttribs = function () {
        return columnProto.pointAttribs.apply(this, arguments);
    };
    // Public adjustForMissingColumns(): number {
    //     return columnProto.adjustForMissingColumns.apply(this, arguments);
    // }
    // public animate(): void {
    //     return columnProto.animate.apply(this, arguments as any);
    // }
    ColumnRangeSeries.prototype.translate3dPoints = function () {
        return columnProto.translate3dPoints.apply(this, arguments);
    };
    ColumnRangeSeries.prototype.translate3dShapes = function () {
        return columnProto.translate3dShapes.apply(this, arguments);
    };
    /**
     * Translate data points from raw values x and y to plotX and plotY
     * @internal
     */
    ColumnRangeSeries.prototype.afterColumnTranslate = function () {
        var _this = this;
        var yAxis = this.yAxis, xAxis = this.xAxis, startAngleRad = xAxis.startAngleRad, chart = this.chart, isRadial = this.xAxis.isRadial, safeDistance = Math.max(chart.chartWidth, chart.chartHeight) + 999;
        var height, heightDifference, start, y;
        // eslint-disable-next-line valid-jsdoc
        /**
         * Don't draw too far outside plot area (#6835)
         * @internal
         */
        function safeBounds(pixelPos) {
            return clamp(pixelPos, -safeDistance, safeDistance);
        }
        // Set plotLow and plotHigh
        this.points.forEach(function (point) {
            var _a;
            var shapeArgs = point.shapeArgs || {}, minPointLength = _this.options.minPointLength, plotY = point.plotY, plotHigh = yAxis.translate(point.high, 0, 1, 0, 1);
            if (isNumber(plotHigh) && isNumber(plotY)) {
                point.plotHigh = safeBounds(plotHigh);
                point.plotLow = safeBounds(plotY);
                // Adjust shape
                y = point.plotHigh;
                height =
                    ((_a = point.rectPlotY) !== null && _a !== void 0 ? _a : point.plotY) -
                        point.plotHigh;
                // Adjust for minPointLength
                if (Math.abs(height) < minPointLength) {
                    heightDifference = (minPointLength - height);
                    height += heightDifference;
                    y -= heightDifference / 2;
                    // Adjust for negative ranges or reversed Y axis (#1457)
                }
                else if (height < 0) {
                    height *= -1;
                    y -= height;
                }
                if (isRadial && _this.polar) {
                    start = point.barX + startAngleRad;
                    point.shapeType = 'arc';
                    point.shapeArgs = _this.polar.arc(y + height, y, start, start + (point.pointWidth || 0));
                }
                else {
                    shapeArgs.height = height;
                    shapeArgs.y = y;
                    var _b = shapeArgs.x, x = _b === void 0 ? 0 : _b, _c = shapeArgs.width, width = _c === void 0 ? 0 : _c;
                    // #17912, aligning column range points
                    // merge if shapeArgs contains more properties e.g. for 3d
                    point.shapeArgs = merge(point.shapeArgs, _this.crispCol(x, y, width, height));
                    point.tooltipPos = chart.inverted ?
                        [
                            yAxis.len + yAxis.pos - chart.plotLeft - y -
                                height / 2,
                            xAxis.len + xAxis.pos - chart.plotTop - x -
                                width / 2,
                            height
                        ] : [
                        xAxis.left - chart.plotLeft + x + width / 2,
                        yAxis.pos - chart.plotTop + y + height / 2,
                        height
                    ]; // Don't inherit from column tooltip position - #3372
                }
            }
        });
    };
    /* *
     *
     *  Static Properties
     *
     * */
    ColumnRangeSeries.defaultOptions = merge(ColumnSeries.defaultOptions, AreaRangeSeries.defaultOptions, ColumnRangeSeriesDefaults);
    return ColumnRangeSeries;
}(AreaRangeSeries));
addEvent(ColumnRangeSeries, 'afterColumnTranslate', function () {
    ColumnRangeSeries.prototype.afterColumnTranslate.apply(this);
}, { order: 5 });
extend(ColumnRangeSeries.prototype, {
    directTouch: true,
    pointClass: ColumnRangePoint,
    trackerGroups: ['group', 'dataLabelsGroup'],
    adjustForMissingColumns: columnProto.adjustForMissingColumns,
    animate: columnProto.animate,
    crispCol: columnProto.crispCol,
    drawGraph: noop,
    drawPoints: columnProto.drawPoints,
    getSymbol: noop,
    drawTracker: columnProto.drawTracker,
    getColumnMetrics: columnProto.getColumnMetrics
});
SeriesRegistry.registerSeriesType('columnrange', ColumnRangeSeries);
/* *
 *
 *  Default Export
 *
 * */
/** @internal */
export default ColumnRangeSeries;
