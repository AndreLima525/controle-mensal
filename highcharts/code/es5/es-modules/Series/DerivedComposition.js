/* *
 *
 *
 * */
'use strict';
import H from '../Core/Globals.js';
var noop = H.noop;
import Series from '../Core/Series/Series.js';
import { addEvent, defined } from '../Shared/Utilities.js';
/* *
 *
 *  Composition
 *
 * */
/**
 * Provides methods for auto setting/updating series data based on the based
 * series data.
 * @internal
 */
var DerivedComposition;
(function (DerivedComposition) {
    /* *
     *
     *  Declarations
     *
     * */
    /* *
     *
     *  Constants
     *
     * */
    DerivedComposition.hasDerivedData = true;
    /**
     * Method to be implemented - inside the method the series has already
     * access to the base series via m `this.baseSeries` and the bases data is
     * initialised. It should return data in the format accepted by
     * `Series.setData()` method
     * @internal
     */
    DerivedComposition.setDerivedData = noop;
    /* *
     *
     *  Functions
     *
     * */
    /**
     * @internal
     */
    function compose(SeriesClass) {
        var seriesProto = SeriesClass.prototype;
        seriesProto.addBaseSeriesEvents = addBaseSeriesEvents;
        seriesProto.addEvents = addEvents;
        seriesProto.destroy = destroy;
        seriesProto.init = init;
        seriesProto.setBaseSeries = setBaseSeries;
        return SeriesClass;
    }
    DerivedComposition.compose = compose;
    /**
     * Initialise series
     * @internal
     */
    function init() {
        Series.prototype.init.apply(this, arguments);
        this.initialised = false;
        this.baseSeries = null;
        this.eventRemovers = [];
        this.addEvents();
    }
    DerivedComposition.init = init;
    /**
     * Sets base series for the series
     * @internal
     */
    function setBaseSeries() {
        var chart = this.chart, baseSeriesOptions = this.options.baseSeries, baseSeries = (defined(baseSeriesOptions) &&
            (chart.series[baseSeriesOptions] ||
                chart.get(baseSeriesOptions)));
        this.baseSeries = baseSeries || null;
    }
    DerivedComposition.setBaseSeries = setBaseSeries;
    /**
     * Adds events for the series
     * @internal
     */
    function addEvents() {
        var _this = this;
        this.eventRemovers.push(addEvent(this.chart, 'afterLinkSeries', function () {
            _this.setBaseSeries();
            if (_this.baseSeries && !_this.initialised) {
                _this.setDerivedData();
                _this.addBaseSeriesEvents();
                _this.initialised = true;
            }
        }));
    }
    DerivedComposition.addEvents = addEvents;
    /**
     * Adds events to the base series - it required for recalculating the data
     * in the series if the base series is updated / removed / etc.
     * @internal
     */
    function addBaseSeriesEvents() {
        var _this = this;
        this.eventRemovers.push(addEvent(this.baseSeries, 'updatedData', function () {
            _this.setDerivedData();
        }), addEvent(this.baseSeries, 'destroy', function () {
            _this.baseSeries = null;
            _this.initialised = false;
        }));
    }
    DerivedComposition.addBaseSeriesEvents = addBaseSeriesEvents;
    /**
     * Destroys the series
     * @internal
     */
    function destroy() {
        this.eventRemovers.forEach(function (remover) {
            remover();
        });
        Series.prototype.destroy.apply(this, arguments);
    }
    DerivedComposition.destroy = destroy;
})(DerivedComposition || (DerivedComposition = {}));
/* *
 *
 *  Default Export
 *
 * */
/** @internal */
export default DerivedComposition;
