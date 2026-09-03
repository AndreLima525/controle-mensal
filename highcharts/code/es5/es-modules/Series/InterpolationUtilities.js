/* *
 *
 *  (c) 2010-2026 Highsoft AS
 *  Author: Hubert Kozik
 *
 *  Integration of this software requires a license.
 *  - For commercial use, see www.highcharts.com/license
 *  - For non-commercial, see www.highcharts.com/license-eula
 *
 *
 * */
'use strict';
import H from '../Core/Globals.js';
import { defined } from '../Shared/Utilities.js';
var doc = H.doc;
/* *
 *
 *  Functions
 *
 * */
/**
 * Find color of point based on color axis.
 *
 * @internal
 *
 * @param {number | null} value
 *        Value to find corresponding color on the color axis.
 *
 * @param {Highcharts.Point} point
 *        Point to find it's color from color axis.
 *
 * @return {number[]}
 *        Color in RGBa array.
 */
function colorFromPoint(value, point) {
    var _a;
    var colorAxis = point.series.colorAxis;
    if (colorAxis) {
        var rgba = (colorAxis.toColor(value || 0, point)
            .split(')')[0]
            .split('(')[1]
            .split(',')
            .map(function (s) { var _a; return ((_a = parseFloat(s)) !== null && _a !== void 0 ? _a : parseInt(s, 10)); }));
        rgba[3] = ((_a = rgba[3]) !== null && _a !== void 0 ? _a : 1.0) * 255;
        if (!defined(value) || !point.visible) {
            rgba[3] = 0;
        }
        return rgba;
    }
    return [0, 0, 0, 0];
}
/**
 * Method responsible for creating a canvas for interpolation image.
 * @internal
 */
function getContext(series) {
    var canvas = series.canvas, context = series.context;
    // We can trust that the context is canvas when clearRect is present.
    if (canvas && (context === null || context === void 0 ? void 0 : context.clearRect)) {
        context.clearRect(0, 0, canvas.width, canvas.height);
    }
    else {
        series.canvas = doc.createElement('canvas');
        series.context = series.canvas.getContext('2d', {
            willReadFrequently: true
        }) || void 0;
        return series.context;
    }
    return context;
}
var InterpolationUtilities = {
    colorFromPoint: colorFromPoint,
    getContext: getContext
};
export default InterpolationUtilities;
