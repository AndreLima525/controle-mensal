/* *
 *
 *  (c) 2010-2026 Highsoft AS
 *  Author: Sebastian Bochan, Rafał Sebestjański
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
import DumbbellPoint from './DumbbellPoint.js';
import DumbbellSeriesDefaults from './DumbbellSeriesDefaults.js';
import H from '../../Core/Globals.js';
var noop = H.noop;
import SeriesRegistry from '../../Core/Series/SeriesRegistry.js';
var _a = SeriesRegistry.seriesTypes, AreaRangeSeries = _a.arearange, ColumnSeries = _a.column, ColumnRangeSeries = _a.columnrange;
import SVGRenderer from '../../Core/Renderer/SVG/SVGRenderer.js';
import { extend, merge } from '../../Shared/Utilities.js';
/* *
 *
 *  Class
 *
 * */
/**
 * The dumbbell series type
 *
 * @internal
 * @class
 * @name Highcharts.seriesTypes.dumbbell
 *
 * @augments Highcharts.Series
 */
var DumbbellSeries = /** @class */ (function (_super) {
    __extends(DumbbellSeries, _super);
    function DumbbellSeries() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    /* *
     *
     *  Functions
     *
     * */
    /**
     * Get connector line path and styles that connects dumbbell point's low and
     * high values.
     * @internal
     *
     * @param {Highcharts.Point} point The point to inspect.
     *
     * @return {Highcharts.SVGAttributes} attribs The path and styles.
     */
    DumbbellSeries.prototype.getConnectorAttribs = function (point) {
        var _a, _b, _c, _d, _e, _f, _g, _h, _j, _k, _l, _m, _o;
        var series = this, chart = series.chart, pointOptions = point.options, seriesOptions = series.options, xAxis = series.xAxis, yAxis = series.yAxis, connectorWidthPlus = (_a = (seriesOptions.states &&
            seriesOptions.states.hover &&
            seriesOptions.states.hover.connectorWidthPlus)) !== null && _a !== void 0 ? _a : 1, dashStyle = ((_b = pointOptions.dashStyle) !== null && _b !== void 0 ? _b : seriesOptions.dashStyle), pxThreshold = yAxis.toPixels(seriesOptions.threshold || 0, true), pointHeight = chart.inverted ?
            yAxis.len - pxThreshold : pxThreshold;
        var connectorWidth = (_c = pointOptions.connectorWidth) !== null && _c !== void 0 ? _c : seriesOptions.connectorWidth, connectorColor = (_g = (_f = (_e = (_d = pointOptions.connectorColor) !== null && _d !== void 0 ? _d : seriesOptions.connectorColor) !== null && _e !== void 0 ? _e : pointOptions.color) !== null && _f !== void 0 ? _f : (point.zone ? point.zone.color : void 0)) !== null && _g !== void 0 ? _g : point.color, pointTop = ((_h = point.plotLow) !== null && _h !== void 0 ? _h : point.plotY), pointBottom = ((_j = point.plotHigh) !== null && _j !== void 0 ? _j : pointHeight), origProps;
        if (typeof pointTop !== 'number') {
            return {};
        }
        if (point.state) {
            connectorWidth = connectorWidth + connectorWidthPlus;
        }
        if (pointTop < 0) {
            pointTop = 0;
        }
        else if (pointTop >= yAxis.len) {
            pointTop = yAxis.len;
        }
        if (pointBottom < 0) {
            pointBottom = 0;
        }
        else if (pointBottom >= yAxis.len) {
            pointBottom = yAxis.len;
        }
        if (point.plotX < 0 || point.plotX > xAxis.len) {
            connectorWidth = 0;
        }
        // Connector should reflect upper marker's zone color
        if (point.graphics && point.graphics[1]) {
            origProps = {
                y: point.y,
                zone: point.zone
            };
            point.y = point.high;
            point.zone = point.zone ? point.getZone() : void 0;
            connectorColor =
                (_o = (_m = (_l = (_k = pointOptions.connectorColor) !== null && _k !== void 0 ? _k : seriesOptions.connectorColor) !== null && _l !== void 0 ? _l : pointOptions.color) !== null && _m !== void 0 ? _m : (point.zone ? point.zone.color : void 0)) !== null && _o !== void 0 ? _o : point.color;
            extend(point, origProps);
        }
        var attribs = {
            d: SVGRenderer.prototype.crispLine([[
                    'M',
                    point.plotX,
                    pointTop
                ], [
                    'L',
                    point.plotX,
                    pointBottom
                ]], connectorWidth)
        };
        if (!chart.styledMode) {
            attribs.stroke = connectorColor;
            attribs['stroke-width'] = connectorWidth;
            if (dashStyle) {
                attribs.dashstyle = dashStyle;
            }
        }
        return attribs;
    };
    /**
     * Draw connector line that connects dumbbell point's low and high values.
     * @internal
     * @param {Highcharts.Point} point
     *        The point to inspect.
     */
    DumbbellSeries.prototype.drawConnector = function (point) {
        var _a;
        var series = this, animationLimit = ((_a = series.options.animationLimit) !== null && _a !== void 0 ? _a : 250), verb = point.connector && series.chart.pointCount < animationLimit ?
            'animate' : 'attr';
        if (!point.connector) {
            point.connector = series.chart.renderer.path()
                .addClass('highcharts-lollipop-stem')
                .attr({
                zIndex: -1
            })
                .add(series.group);
        }
        point.connector[verb](this.getConnectorAttribs(point));
    };
    /**
     * Return the width and x offset of the dumbbell adjusted for grouping,
     * groupPadding, pointPadding, pointWidth etc.
     * @internal
     */
    DumbbellSeries.prototype.getColumnMetrics = function () {
        var metrics = ColumnSeries.prototype
            .getColumnMetrics.apply(this, arguments);
        metrics.offset += metrics.width / 2;
        return metrics;
    };
    /**
     * Translate each point to the plot area coordinate system and find
     * shape positions
     * @internal
     */
    DumbbellSeries.prototype.translate = function () {
        var series = this, inverted = series.chart.inverted;
        // Calculate shapeargs
        this.setShapeArgs.apply(series);
        // Calculate point low / high values
        this.translatePoint.apply(series, arguments);
        // Correct x position
        for (var _i = 0, _a = series.points; _i < _a.length; _i++) {
            var point = _a[_i];
            var pointWidth = point.pointWidth, _b = point.shapeArgs, shapeArgs = _b === void 0 ? {} : _b, tooltipPos = point.tooltipPos;
            point.plotX = shapeArgs.x || 0;
            shapeArgs.x = point.plotX - pointWidth / 2;
            if (tooltipPos) {
                if (inverted) {
                    tooltipPos[1] = series.xAxis.len - point.plotX;
                }
                else {
                    tooltipPos[0] = point.plotX;
                }
            }
        }
        series.columnMetrics.offset -= series.columnMetrics.width / 2;
    };
    /**
     * Extend the arearange series' drawPoints method by applying a connector
     * and coloring markers.
     * @internal
     */
    DumbbellSeries.prototype.drawPoints = function () {
        var _a, _b, _c, _d, _e, _f;
        var series = this, chart = series.chart, pointLength = series.points.length, seriesLowColor = series.lowColor = series.options.lowColor, seriesLowMarker = series.options.lowMarker;
        var i = 0, lowerGraphicColor, point, zoneColor;
        this.seriesDrawPoints.apply(series, arguments);
        // Draw connectors and color upper markers
        while (i < pointLength) {
            point = series.points[i];
            var _g = point.graphics || [], lowerGraphic = _g[0], upperGraphic = _g[1];
            series.drawConnector(point);
            if (upperGraphic) {
                upperGraphic.element.point = point;
                upperGraphic.addClass('highcharts-lollipop-high');
            }
            if (point.connector) {
                point.connector.element.point = point;
            }
            if (lowerGraphic) {
                zoneColor = point.zone && point.zone.color;
                lowerGraphicColor =
                    (_f = (_e = (_d = (_c = (_b = (_a = point.options.lowColor) !== null && _a !== void 0 ? _a : seriesLowMarker === null || seriesLowMarker === void 0 ? void 0 : seriesLowMarker.fillColor) !== null && _b !== void 0 ? _b : seriesLowColor) !== null && _c !== void 0 ? _c : point.options.color) !== null && _d !== void 0 ? _d : zoneColor) !== null && _e !== void 0 ? _e : point.color) !== null && _f !== void 0 ? _f : series.color;
                if (!chart.styledMode) {
                    lowerGraphic.attr({
                        fill: lowerGraphicColor
                    });
                }
                lowerGraphic.addClass('highcharts-lollipop-low');
            }
            i++;
        }
    };
    /**
     * Get presentational attributes.
     *
     * @internal
     * @function Highcharts.seriesTypes.column#pointAttribs
     *
     * @param {Highcharts.Point} point
     *        The point to inspect.
     *
     * @param {string} state
     *        Current state of point (normal, hover, select).
     *
     * @return {Highcharts.SVGAttributes}
     *         Presentational attributes.
     */
    DumbbellSeries.prototype.pointAttribs = function (point, state) {
        var pointAttribs = _super.prototype.pointAttribs.apply(this, arguments);
        if (state === 'hover') {
            delete pointAttribs.fill;
        }
        return pointAttribs;
    };
    /**
     * Set the shape arguments for dumbbells.
     * @internal
     */
    DumbbellSeries.prototype.setShapeArgs = function () {
        ColumnSeries.prototype.translate.apply(this);
        ColumnRangeSeries.prototype.afterColumnTranslate.apply(this);
    };
    /* *
     *
     *  Static Properties
     *
     * */
    DumbbellSeries.defaultOptions = merge(AreaRangeSeries.defaultOptions, DumbbellSeriesDefaults);
    return DumbbellSeries;
}(AreaRangeSeries));
extend(DumbbellSeries.prototype, {
    crispCol: ColumnSeries.prototype.crispCol,
    drawGraph: noop,
    drawTracker: ColumnSeries.prototype.drawTracker,
    pointClass: DumbbellPoint,
    seriesDrawPoints: AreaRangeSeries.prototype.drawPoints,
    trackerGroups: ['group', 'markerGroup', 'dataLabelsGroup'],
    translatePoint: AreaRangeSeries.prototype.translate
});
SeriesRegistry.registerSeriesType('dumbbell', DumbbellSeries);
/* *
 *
 *  Default Export
 *
 * */
/** @internal */
export default DumbbellSeries;
