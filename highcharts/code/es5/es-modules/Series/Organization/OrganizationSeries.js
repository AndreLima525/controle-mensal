/* *
 *
 *  Organization chart module
 *
 *  (c) 2018-2026 Highsoft AS
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
import OrganizationPoint from './OrganizationPoint.js';
import OrganizationSeriesDefaults from './OrganizationSeriesDefaults.js';
import SeriesRegistry from '../../Core/Series/SeriesRegistry.js';
import PathUtilities from '../PathUtilities.js';
var SankeySeries = SeriesRegistry.seriesTypes.sankey;
import SVGElement from '../../Core/Renderer/SVG/SVGElement.js';
import { crisp, css, extend, isNumber, merge, splat } from '../../Shared/Utilities.js';
import { composeTextPath } from '../../Extensions/TextPath.js';
composeTextPath(SVGElement);
/* *
 *
 *  Class
 *
 * */
/**
 * @private
 * @class
 * @name Highcharts.seriesTypes.organization
 *
 * @augments Highcharts.seriesTypes.sankey
 */
var OrganizationSeries = /** @class */ (function (_super) {
    __extends(OrganizationSeries, _super);
    function OrganizationSeries() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    /* *
     *
     *  Functions
     *
     * */
    OrganizationSeries.prototype.alignDataLabel = function (point, dataLabel, options) {
        var _a;
        // Align the data label to the point graphic
        var shapeArgs = point.shapeArgs, text = dataLabel.text;
        if (options.useHTML && shapeArgs) {
            var padding = splat(this.options.dataLabels.padding || 0), borderWidth = this.options.borderWidth || 0, padjustX = borderWidth + 2 * padding[3 % padding.length], padjustY = borderWidth + 2 * padding[0 % padding.length];
            var width_1 = shapeArgs.width || 0, height_1 = shapeArgs.height || 0;
            if (this.chart.inverted) {
                width_1 = height_1;
                height_1 = shapeArgs.width || 0;
            }
            width_1 -= padjustX;
            height_1 -= padjustY;
            (_a = text.foreignObject) === null || _a === void 0 ? void 0 : _a.attr({
                x: 0,
                y: 0,
                width: width_1,
                height: height_1
            });
            // When foreign object, the parent node is the body. When parallel
            // HTML, it is the surrounding div emulating `g`
            css(text.element.parentNode, {
                width: width_1 + 'px',
                height: height_1 + 'px'
            });
            // Set properties for the span emulating `text`
            css(text.element, {
                left: 0,
                top: 0,
                width: '100%',
                height: '100%',
                overflow: 'hidden'
            });
            // The getBBox function is used in `alignDataLabel` to align
            // inside the box
            dataLabel.getBBox = function () { return ({ width: width_1, height: height_1, x: 0, y: 0 }); };
            // Overwrite dataLabel dimensions (#13100).
            dataLabel.width = width_1;
            dataLabel.height = height_1;
        }
        _super.prototype.alignDataLabel.apply(this, arguments);
    };
    OrganizationSeries.prototype.createNode = function (id) {
        var node = _super.prototype.createNode.call(this, id);
        // All nodes in an org chart are equal width
        node.getSum = function () { return 1; };
        return node;
    };
    OrganizationSeries.prototype.pointAttribs = function (point, state) {
        var _a, _b, _c, _d, _e, _f, _g, _h, _j, _k, _l, _m, _o, _p, _q, _r, _s, _t, _u, _v, _w, _x, _y, _z, _0, _1, _2, _3, _4, _5, _6, _7, _8, _9, _10, _11, _12;
        var series = this, attribs = SankeySeries.prototype.pointAttribs.call(series, point, state), level = point.isNode ? point.level : point.fromNode.level, levelOptions = series.mapOptionsToLevel[level || 0] || {}, options = point.options, stateOptions = ((_a = levelOptions.states) === null || _a === void 0 ? void 0 : _a[state || 'normal']) || {}, borderRadius = ((_d = (_c = (_b = stateOptions.borderRadius) !== null && _b !== void 0 ? _b : options.borderRadius) !== null && _c !== void 0 ? _c : levelOptions.borderRadius) !== null && _d !== void 0 ? _d : series.options.borderRadius), linkColor = ((_p = (_m = (_k = (_h = (_g = (_f = (_e = stateOptions.linkColor) !== null && _e !== void 0 ? _e : options.linkColor) !== null && _f !== void 0 ? _f : levelOptions.linkColor) !== null && _g !== void 0 ? _g : series.options.linkColor) !== null && _h !== void 0 ? _h : (_j = stateOptions.link) === null || _j === void 0 ? void 0 : _j.color) !== null && _k !== void 0 ? _k : (_l = options.link) === null || _l === void 0 ? void 0 : _l.color) !== null && _m !== void 0 ? _m : (_o = levelOptions.link) === null || _o === void 0 ? void 0 : _o.color) !== null && _p !== void 0 ? _p : (_q = series.options.link) === null || _q === void 0 ? void 0 : _q.color), linkLineWidth = ((_0 = (_y = (_w = (_u = (_t = (_s = (_r = stateOptions.linkLineWidth) !== null && _r !== void 0 ? _r : options.linkLineWidth) !== null && _s !== void 0 ? _s : levelOptions.linkLineWidth) !== null && _t !== void 0 ? _t : series.options.linkLineWidth) !== null && _u !== void 0 ? _u : (_v = stateOptions.link) === null || _v === void 0 ? void 0 : _v.lineWidth) !== null && _w !== void 0 ? _w : (_x = options.link) === null || _x === void 0 ? void 0 : _x.lineWidth) !== null && _y !== void 0 ? _y : (_z = levelOptions.link) === null || _z === void 0 ? void 0 : _z.lineWidth) !== null && _0 !== void 0 ? _0 : (_1 = series.options.link) === null || _1 === void 0 ? void 0 : _1.lineWidth), linkOpacity = ((_11 = (_9 = (_7 = (_5 = (_4 = (_3 = (_2 = stateOptions.linkOpacity) !== null && _2 !== void 0 ? _2 : options.linkOpacity) !== null && _3 !== void 0 ? _3 : levelOptions.linkOpacity) !== null && _4 !== void 0 ? _4 : series.options.linkOpacity) !== null && _5 !== void 0 ? _5 : (_6 = stateOptions.link) === null || _6 === void 0 ? void 0 : _6.linkOpacity) !== null && _7 !== void 0 ? _7 : (_8 = options.link) === null || _8 === void 0 ? void 0 : _8.linkOpacity) !== null && _9 !== void 0 ? _9 : (_10 = levelOptions.link) === null || _10 === void 0 ? void 0 : _10.linkOpacity) !== null && _11 !== void 0 ? _11 : (_12 = series.options.link) === null || _12 === void 0 ? void 0 : _12.linkOpacity);
        if (!point.isNode) {
            attribs.stroke = linkColor;
            attribs['stroke-width'] = linkLineWidth;
            attribs.opacity = linkOpacity;
            delete attribs.fill;
        }
        else {
            if (isNumber(borderRadius)) {
                attribs.r = borderRadius;
            }
        }
        return attribs;
    };
    OrganizationSeries.prototype.translateLink = function (point) {
        var _a, _b, _c, _d, _e, _f;
        var _g = this, chart = _g.chart, options = _g.options, fromNode = point.fromNode, toNode = point.toNode, linkWidth = (_b = (_a = options.linkLineWidth) !== null && _a !== void 0 ? _a : options.link.lineWidth) !== null && _b !== void 0 ? _b : 0, factor = (_c = options.link.offset) !== null && _c !== void 0 ? _c : 0.5, type = (_e = (_d = point.options.link) === null || _d === void 0 ? void 0 : _d.type) !== null && _e !== void 0 ? _e : options.link.type;
        if (fromNode.shapeArgs && toNode.shapeArgs) {
            var hangingIndent = options.hangingIndent || 0, hangingRight = options.hangingSide === 'right', toOffset = toNode.options.offset, percentOffset = /%$/.test(toOffset) && parseInt(toOffset, 10), inverted = chart.inverted;
            var x1 = crisp((fromNode.shapeArgs.x || 0) +
                (fromNode.shapeArgs.width || 0), linkWidth), y1 = crisp((fromNode.shapeArgs.y || 0) +
                (fromNode.shapeArgs.height || 0) / 2, linkWidth), x2 = crisp(toNode.shapeArgs.x || 0, linkWidth), y2 = crisp((toNode.shapeArgs.y || 0) +
                (toNode.shapeArgs.height || 0) / 2, linkWidth), xMiddle = void 0;
            if (inverted) {
                x1 -= (fromNode.shapeArgs.width || 0);
                x2 += (toNode.shapeArgs.width || 0);
            }
            xMiddle = this.colDistance ?
                crisp(x2 +
                    ((inverted ? 1 : -1) *
                        (this.colDistance - this.nodeWidth)) /
                        2, linkWidth) :
                crisp((x2 + x1) / 2, linkWidth);
            // Put the link on the side of the node when an offset is given. HR
            // node in the main demo.
            if (percentOffset &&
                (percentOffset >= 50 || percentOffset <= -50)) {
                xMiddle = x2 = crisp(x2 + (inverted ? -0.5 : 0.5) *
                    (toNode.shapeArgs.width || 0), linkWidth);
                y2 = toNode.shapeArgs.y || 0;
                if (percentOffset > 0) {
                    y2 += toNode.shapeArgs.height || 0;
                }
            }
            if (toNode.hangsFrom === fromNode) {
                if (chart.inverted) {
                    y1 = !hangingRight ?
                        crisp((fromNode.shapeArgs.y || 0) +
                            (fromNode.shapeArgs.height || 0) -
                            hangingIndent / 2, linkWidth) :
                        crisp((fromNode.shapeArgs.y || 0) + hangingIndent / 2, linkWidth);
                    y2 = !hangingRight ? ((toNode.shapeArgs.y || 0) +
                        (toNode.shapeArgs.height || 0)) : (toNode.shapeArgs.y || 0) + hangingIndent / 2;
                }
                else {
                    y1 = crisp((fromNode.shapeArgs.y || 0) + hangingIndent / 2, linkWidth);
                }
                xMiddle = x2 = crisp((toNode.shapeArgs.x || 0) +
                    (toNode.shapeArgs.width || 0) / 2, linkWidth);
            }
            point.plotX = xMiddle;
            point.plotY = (y1 + y2) / 2;
            point.shapeType = 'path';
            if (type === 'straight') {
                point.shapeArgs = {
                    d: [
                        ['M', x1, y1],
                        ['L', x2, y2]
                    ]
                };
            }
            else if (type === 'curved') {
                var offset = Math.abs(x2 - x1) * factor * (inverted ? -1 : 1);
                point.shapeArgs = {
                    d: [
                        ['M', x1, y1],
                        ['C', x1 + offset, y1, x2 - offset, y2, x2, y2]
                    ]
                };
            }
            else {
                point.shapeArgs = {
                    d: PathUtilities.applyRadius([
                        ['M', x1, y1],
                        ['L', xMiddle, y1],
                        ['L', xMiddle, y2],
                        ['L', x2, y2]
                    ], (_f = options.linkRadius) !== null && _f !== void 0 ? _f : options.link.radius)
                };
            }
            point.dlBox = {
                x: (x1 + x2) / 2,
                y: (y1 + y2) / 2,
                height: linkWidth,
                width: 0
            };
        }
    };
    OrganizationSeries.prototype.translateNode = function (node, column) {
        _super.prototype.translateNode.call(this, node, column);
        var chart = this.chart, options = this.options, sum = node.getSum(), translationFactor = this.translationFactor, nodeHeight = Math.max(Math.round(sum * translationFactor), options.minLinkWidth || 0), hangingRight = options.hangingSide === 'right', indent = options.hangingIndent || 0, indentLogic = options.hangingIndentTranslation, minLength = options.minNodeLength || 10, nodeWidth = Math.round(this.nodeWidth), shapeArgs = node.shapeArgs, sign = chart.inverted ? -1 : 1;
        var parentNode = node.hangsFrom;
        if (parentNode) {
            if (indentLogic === 'cumulative') {
                // Move to the right:
                shapeArgs.height -= indent;
                // If hanging right, first indent is handled by shrinking.
                if (chart.inverted && !hangingRight) {
                    shapeArgs.y -= sign * indent;
                }
                while (parentNode) {
                    // Hanging right is the same direction as non-inverted.
                    shapeArgs.y += (hangingRight ? 1 : sign) * indent;
                    parentNode = parentNode.hangsFrom;
                }
            }
            else if (indentLogic === 'shrink') {
                // Resize the node:
                while (parentNode &&
                    shapeArgs.height > indent + minLength) {
                    shapeArgs.height -= indent;
                    // Fixes nodes not dropping in non-inverted charts.
                    // Hanging right is the same as non-inverted.
                    if (!chart.inverted || hangingRight) {
                        shapeArgs.y += indent;
                    }
                    parentNode = parentNode.hangsFrom;
                }
            }
            else {
                // Option indentLogic === "inherit"
                // Do nothing (v9.3.2 and prev versions):
                shapeArgs.height -= indent;
                if (!chart.inverted || hangingRight) {
                    shapeArgs.y += indent;
                }
            }
        }
        node.nodeHeight = chart.inverted ?
            shapeArgs.width :
            shapeArgs.height;
        // Calculate shape args correctly to align nodes to center (#19946)
        if (node.shapeArgs && !node.hangsFrom) {
            node.shapeArgs = merge(node.shapeArgs, {
                x: (node.shapeArgs.x || 0) + (nodeWidth / 2) -
                    ((node.shapeArgs.width || 0) / 2),
                y: (node.shapeArgs.y || 0) + (nodeHeight / 2) -
                    ((node.shapeArgs.height || 0) / 2)
            });
        }
    };
    OrganizationSeries.prototype.drawDataLabels = function () {
        var dlOptions = this.options.dataLabels;
        if (dlOptions.linkTextPath && dlOptions.linkTextPath.enabled) {
            for (var _i = 0, _a = this.points; _i < _a.length; _i++) {
                var link = _a[_i];
                link.options.dataLabels = merge(link.options.dataLabels, { useHTML: false });
            }
        }
        _super.prototype.drawDataLabels.call(this);
    };
    /* *
     *
     *  Static Properties
     *
     * */
    OrganizationSeries.defaultOptions = merge(SankeySeries.defaultOptions, OrganizationSeriesDefaults);
    return OrganizationSeries;
}(SankeySeries));
extend(OrganizationSeries.prototype, {
    pointClass: OrganizationPoint
});
SeriesRegistry.registerSeriesType('organization', OrganizationSeries);
/* *
 *
 *  Default Export
 *
 * */
export default OrganizationSeries;
/* *
 *
 *  API Declarations
 *
 * */
/**
 * Layout value for the child nodes in an organization chart. If `hanging`, this
 * node's children will hang below their parent, allowing a tighter packing of
 * nodes in the diagram.
 *
 * @typedef {"normal"|"hanging"} Highcharts.SeriesOrganizationNodesLayoutValue
 */
/**
 * Indent translation value for the child nodes in an organization chart, when
 * parent has `hanging` layout. Option can shrink nodes (for tight charts),
 * translate children to the left, or render nodes directly under the parent.
 *
 * @typedef {"inherit"|"cumulative"|"shrink"} Highcharts.OrganizationHangingIndentTranslationValue
 */
''; // Detach doclets above
