(function($) {
    'use strict';

    /**
     * All of the code for your public-facing JavaScript source
     * should reside in this file.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * $ function reference has been prepared for usage within the scope
     * of this function.
     *
     * This enables you to define handlers, for when the DOM is ready:
     *
     * $(function() {
     *
     * });
     *
     * When the window is loaded:
     *
     * $( window ).load(function() {
     *
     * });
     *
     * ...and/or other possibilities.
     *
     * Ideally, it is not considered best practise to attach more than a
     * single DOM-ready or window-load handler for a particular page.
     * Although scripts in the WordPress core, Plugins and Themes may be
     * practising this, we should strive to set a better example in our own work.
     */

    $(window).on('load', function () {
        let ele = $('.chart-card');
        addRemoveClass(ele.find('h4'), 'graphina-chart-heading');
        addRemoveClass(ele.find('p'), 'graphina-chart-sub-heading');
    });


    // Graphina Feature Request For Elementor Panel
    document.addEventListener('DOMContentLoaded', function() {
        if (parent.document.querySelector('.elementor-editor-active') !== null) {
            let _graphina_get_help = '';
            let _graphina_get_help_url = "https://iqonic.design/feature-request/?for_product=graphina";
            setInterval(function() {
                if (parent.document.querySelector('[class*=elementor-control-iq]') != null) {
                    _graphina_get_help = parent.document.querySelector('#elementor-panel__editor__help__link');
                    if (_graphina_get_help != null) {
                        if (_graphina_get_help.getAttribute("href") !== _graphina_get_help_url) {
                            _graphina_get_help.setAttribute("href", _graphina_get_help_url);
                            _graphina_get_help.innerHTML = "<b> Graphina Feature Request <i class='eicon-editor-external-link'></i> </b>";
                        }
                    }
                }
            }, 3000)
        }
    });

})(jQuery);


/***********************
 * Variables
 */
if (typeof fadein == "undefined") {
    var fadein = {};
}
if (typeof fadeout == "undefined") {
    var fadeout = {};
}
if (typeof isInit == "undefined") {
    var isInit = {};
}

function graphinNumberWithCommas(x, separator, decimal = -1) {
    if (isNaN(x)) {
        return '';
    }
    var parts = x.toString().split(".");
    let val = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, separator);

    if (parts[1]) {
        if (decimal === -1) {
            val = val + '.' + parts[1]
        }else if (decimal !== 0) {
            val = val + '.' + parts[1].substring(0, decimal)
        }
    }

    return val;
}

function resetGraphinaVars() {
    if (typeof graphina_localize.graphinaAllGraphs == "undefined") {
        graphina_localize.graphinaAllGraphs = {};
    }
    if (typeof graphina_localize.graphinaAllGraphsOptions == "undefined") {
        graphina_localize.graphinaAllGraphsOptions = {};
    }
    if (typeof graphina_localize.graphinaBlockCharts == "undefined") {
        graphina_localize.graphinaBlockCharts = {};
    }
}
resetGraphinaVars();

/***************
 * Jquery Base
 * @param ele
 * @param add
 * @param remove
 */

function addRemoveClass(ele, add = '', remove = '') {
    if (remove !== '' && ele.hasClass(add)) ele.removeClass(remove);
    if (add !== '' && !ele.hasClass(add)) ele.addClass(add);
}

/************
 *
 * @param timestamp
 * @param isTime
 * @param isDate
 * @returns {string}
 */

function dateFormat(timestamp, isTime = false, isDate = false) {
    let dateSeparator = '-';
    let date = new Date(timestamp);
    let hours = date.getHours();
    let minutes = "0" + date.getMinutes();
    let day = date.getDate();
    let month = date.getMonth() + 1;
    let year = date.getFullYear()
    return (isDate ? (day + dateSeparator + month + dateSeparator + year) : '') + (isDate && isTime ? ' ' : '') + (isTime ? (hours + ':' + minutes.substr(-2)) : '');
}

/********************
 *
 * @param date1
 * @param date2
 * @returns {string}
 */
function timeDifference(date1, date2) {
    let difference = new Date(date2).getTime() - new Date(date1).getTime();

    let daysDifference = Math.floor(difference / 1000 / 60 / 60 / 24);
    difference -= daysDifference * 1000 * 60 * 60 * 24

    let hoursDifference = Math.floor(difference / 1000 / 60 / 60);
    difference -= hoursDifference * 1000 * 60 * 60

    let minutesDifference = Math.floor(difference / 1000 / 60);

    return getPostfix(daysDifference, 'day', 'days') +
        (daysDifference > 0 && hoursDifference > 0 ? ' ' : '') +
        getPostfix(hoursDifference, 'hour', 'hours') +
        (hoursDifference > 0 && minutesDifference > 0 ? ' ' : '') +
        getPostfix(minutesDifference, 'minute', 'minutes');
}

/*********************
 *
 * @param value
 * @param postfix1
 * @param postfix2
 * @returns {string}
 */
function getPostfix(value, postfix1, postfix2) {
    let result = ''
    switch (true) {
        case value === 0:
            break;
        case value === 1:
            result += value + ' ' + postfix1;
            break;
        case value > 1:
            result += value + ' ' + postfix2;
            break;
    }
    return result;
}


/*******************
 *
 * @param svg
 * @param mainId
 */

function adjustSize(svg, mainId) {
    const innerHeight = getInnerHeightWidth(document.querySelector('#animated-radial_' + mainId), 'height');
    const innerWidth = getInnerHeightWidth(document.querySelector('#animated-radial_' + mainId), 'width');
    svg[mainId].attr("width", innerWidth).attr("height", innerHeight);
}

/************************
 *
 * @param elm
 * @param type
 * @returns {number}
 */

function getInnerHeightWidth(elm, type) {
    let computed = getComputedStyle(elm);
    let padding = 0;
    let val = 0;
    switch (type) {
        case 'height':
            padding = parseInt(computed.paddingTop) + parseInt(computed.paddingBottom);
            val = elm.clientHeight - padding;
            break;
        case 'width':
            padding = parseInt(computed.paddingLeft) + parseInt(computed.paddingRight);
            val = elm.clientWidth - padding;
            break;
    }
    return val;
}

/**********************************
 *
 * @param main_id
 * @param n
 * @param g
 * @param interval
 * @param animeSpeed
 * @param bars
 * @param animatedRadialChartHeight
 */

function update(main_id, n = [], g = [], interval = [], animeSpeed = [], bars = [], animatedRadialChartHeight = []) {
    if (typeof g[main_id] === "undefined") {
        clearInterval(interval[main_id]);
    }

    n[main_id] += parseFloat(animeSpeed[main_id]);
    g[main_id].selectAll("rect")
        .data(bars[main_id])
        .attr("width", d => (parseFloat(animatedRadialChartHeight[main_id]) + noise.perlin3(d, 1, n[main_id]) * 160));
}

/****************************************
 *
 * @param main_id
 * @param svg
 * @param g
 * @param bars
 * @param radialGradient
 * @param animatedRadialChartColor
 * @param animatedRadialChartLineSpace
 */

function drawBars(main_id, svg, g, bars, radialGradient, animatedRadialChartColor, animatedRadialChartLineSpace) {
    if (typeof svg[main_id] !== "undefined") {
        d3.selectAll("#animated-radial_" + main_id + " svg > *").remove();
    }
    svg[main_id] = d3.select("#animated-radial_" + main_id + " svg");
    adjustSize(svg, main_id)

    g[main_id] = svg[main_id].append("g").attr("transform", `translate(${960 / 2},${560 / 2})`);

    bars[main_id] = d3.range(0, 120);

    radialGradient[main_id] = svg[main_id]
        .append("defs")
        .append("radialGradient")
        .attr("id", "radial-gradient-" + main_id)
        .attr("gradientUnits", "userSpaceOnUse")
        .attr("cx", 0)
        .attr("cy", 0)
        .attr("r", "30%");

    radialGradient[main_id]
        .append("stop")
        .attr("offset", "60%")
        .attr("stop-color", animatedRadialChartColor[main_id].gradient_1);

    radialGradient[main_id]
        .append("stop")
        .attr("offset", "100%")
        .attr("stop-color", animatedRadialChartColor[main_id].gradient_2);

    g[main_id].append("circle")
        .attr("cx", 0)
        .attr("cy", 0)
        .attr("r", 80)
        .attr("stroke", animatedRadialChartColor[main_id].stroke_color)
        .attr("fill", "none")
        .attr("text", "none");

    g[main_id].selectAll("rect")
        .data(bars[main_id])
        .enter()
        .append("rect")
        .attr("x", 100)
        .attr("y", 0)
        .attr("width", 100)
        .attr("height", 6)
        .attr("fill", "url(#radial-gradient-" + main_id + ")")
        .attr("transform", d => `rotate(${d * animatedRadialChartLineSpace[main_id]})`);
}

/************************************
 *
 * @param mainId
 * @param svg
 * @param g
 * @param bars
 * @param radialGradient
 * @param animatedRadialChartColor
 * @param animatedRadialChartLineSpace
 * @param n
 * @param interval
 * @param animeSpeed
 * @param animatedRadialChartHeight
 */

function initAnimatedRadial(mainId, svg, g, bars, radialGradient, animatedRadialChartColor, animatedRadialChartLineSpace, n, interval, animeSpeed, animatedRadialChartHeight) {
    window.addEventListener("resize", () => {
        adjustSize(svg, mainId)
    });
    drawBars(mainId, svg, g, bars, radialGradient, animatedRadialChartColor, animatedRadialChartLineSpace)
    update(mainId, n, g, interval, animeSpeed, bars, animatedRadialChartHeight);
    if (typeof interval !== undefined && typeof interval[mainId] !== undefined) {
        adjustSize(svg, mainId);
        drawBars(mainId, svg, g, bars, radialGradient, animatedRadialChartColor, animatedRadialChartLineSpace)
        clearInterval(interval[mainId]);
    }
    interval[mainId] = setInterval(function() {
        update(mainId, n, g, interval, animeSpeed, bars, animatedRadialChartHeight);
    }, 50);
}

function isInViewport(el) {
    if (graphina_localize.is_view_port_disable != undefined && graphina_localize.is_view_port_disable == 'on') {
        return true;
    }
    const rect = el.getBoundingClientRect();
    return (
        (
            (rect.top - ((window.innerHeight || document.documentElement.clientHeight) / 2.1)) >= 0 &&
            (rect.bottom - ((window.innerHeight || document.documentElement.clientHeight) / 1.9)) <= (window.innerHeight || document.documentElement.clientHeight)
        ) ||
        (
            rect.top >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight)
        )
    );
}

function initNowGraphina(myElement, chart, id) {
    resetGraphinaVars();
    if (id in graphina_localize.graphinaAllGraphs) {
        graphina_localize.graphinaAllGraphs[id].destroy();
        delete graphina_localize.graphinaAllGraphs[id];
        delete graphina_localize.graphinaBlockCharts[id];
    }
    graphina_localize.graphinaAllGraphsOptions[id] = chart;
    isInit[id] = false;
    getChart(graphina_localize.graphinaAllGraphsOptions[id].ele, id);
    //  old code
    // document.addEventListener('scroll', function () {
    //     getChart(graphina_localize.graphinaAllGraphsOptions[id].ele, id);
    // });
}

function getChart(myElement, id) {
    //  old code
    // if (typeof ApexCharts == 'function' && myElement !== null
    //     && isInViewport(myElement) && (id in isInit) && isInit[id] === false) {
    //     setTimeout(() => {
    //         if (isInit[id] === false) {
    //             initGraphinaCharts(id);
    //         }
    //     },1000);
    // }
    if (typeof ApexCharts == 'function' && myElement !== null &&
        (id in isInit) && isInit[id] === false) {
        if ((graphina_localize.is_view_port_disable != undefined && graphina_localize.is_view_port_disable == 'on') || (graphina_localize.graphinaAllGraphsOptions[id].type !== undefined && graphina_localize.graphinaAllGraphsOptions[id].type === 'brush')) {
            initGraphinaCharts(id);
        } else {
            const observer = new IntersectionObserver(enteries => {
                enteries.forEach(entry => {
                    if (entry.isIntersecting) {
                        if (isInit[id] === false) {
                            initGraphinaCharts(id);
                        }
                    }
                })
            })
            observer.observe(myElement);
        }
    }
}

function initGraphinaCharts(id, type = 'area') {
    if (Object.keys(graphina_localize.graphinaBlockCharts).includes(id)) {
        if (isInit[id] === true) {
            graphina_localize.graphinaAllGraphs[id].destroy();
        }
        graphina_localize.graphinaAllGraphsOptions[id].ele.innerHTML = '';
        graphina_localize.graphinaAllGraphsOptions[id].ele.innerHTML = graphina_localize.graphinaBlockCharts[id];
    } else {
        if (isInit[id] === true || graphina_localize.graphinaAllGraphs[id]) {
            let option = graphina_localize.graphinaAllGraphsOptions[id].options;
            let series = option.series;
            // delete option.series;
            if (type === 'mixed') {
                graphina_localize.graphinaAllGraphs[id].updateOptions({
                    series: option.series,
                    labels: graphina_localize.graphinaAllGraphsOptions[id].options.category
                });
            } else {
                graphina_localize.graphinaAllGraphs[id].updateOptions(option, true, graphina_localize.graphinaAllGraphsOptions[id].animation);
                graphina_localize.graphinaAllGraphs[id].updateSeries(series, graphina_localize.graphinaAllGraphsOptions[id].animation);
            }
        } else {
            graphina_localize.graphinaAllGraphs[id] = new ApexCharts(graphina_localize.graphinaAllGraphsOptions[id].ele, graphina_localize.graphinaAllGraphsOptions[id].options);
            graphina_localize.graphinaAllGraphs[id].render();
            isInit[id] = true;
        }
    }
}

function updateGoogleChartType(defaultType, select, id) {
    if (graphina_localize.graphinaAllGraphsOptions[id]) {
        let selectType = select.value;
        graphina_localize.graphinaAllGraphsOptions[id].renderType = selectType;
        graphinaGoogleChartRender(id, selectType)
    }
}

function updateChartType(defaultvalue, select, id) {
    var x = select.value;
    if (defaultvalue == x) {
        graphina_localize.graphinaAllGraphs[id].updateOptions(graphina_localize.graphinaAllGraphsOptions[id].options);
        return;
    }
    if (x == 'area') {
        graphina_localize.graphinaAllGraphs[id].updateOptions({
            chart: {
                type: x
            },
            fill: {
                opacity: 0.4,
                pattern: {
                    width: 6,
                    height: 6,
                    strokeWidth: 2
                }
            },
            dataLabels: {
                offsetY: 0,
                offsetX: 0
            },
            stroke: {
                show: true,
                colors: graphina_localize.graphinaAllGraphsOptions[id].options.colors,
                width: 2
            }
        })
    } else if (x == 'line') {
        graphina_localize.graphinaAllGraphs[id].updateOptions({
            chart: {
                type: x
            },
            dataLabels: {
                offsetY: 0,
                offsetX: 0
            },
            stroke: {
                show: true,
                colors: graphina_localize.graphinaAllGraphsOptions[id].options.colors,
                width: 5
            }
        })
    } else if (x == 'bar') {
        graphina_localize.graphinaAllGraphs[id].updateOptions({
            chart: {
                type: x
            },
            fill: {
                opacity: 0.9,
            },
            stroke: {
                show: true,
                width: 2,
                // colors: ['transparent']
            }
        })
    } else if (x == 'pie' || x == 'donut') {
        graphina_localize.graphinaAllGraphs[id].updateOptions({
            chart: {
                type: x
            },
            fill: {
                opacity: 1,
            },
        })
    } else if (x == 'polarArea') {
        graphina_localize.graphinaAllGraphs[id].updateOptions({
            chart: {
                type: x
            },
            fill: {
                opacity: 0.4,
            },
            stroke: {
                show: true,
                width: 2,
                colors: graphina_localize.graphinaAllGraphsOptions[id].options.colors,
            },
        })
    } else if (x == 'scatter') {
        graphina_localize.graphinaAllGraphs[id].updateOptions({
            chart: {
                type: x
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            fill: {
                opacity: 1
            },
            markers: {
                size: 10,
            }
        })

    }
}

function chartDatalabelsFormat(option, showlabel, showValue, numberformat, prefix, postfix, valueInStringShow, valueInString,forminatorPercentage=false,forminatorDecimal=0) {

    if (showlabel == 'yes' && showValue == 'yes') {
        return option.dataLabels.formatter = function(val, opt) {
            let seriesValue = opt.w.config.series[opt.seriesIndex];
            if (numberformat == "yes") {
                seriesValue = seriesValue.toLocaleString(graphina_localize.thousand_seperator)
            } else {
                seriesValue = valueInStringShow == 'no' ? seriesValue : graphinaAbbrNum(seriesValue, valueInString);
            }
            if(forminatorPercentage){
                let totals = opt.w.globals.seriesTotals.reduce((a, b) => {
                    return  a + b;
                }, 0)
                if(postfix.trim() === ''){
                    postfix = '%';
                }
                seriesValue =  parseFloat(seriesValue/totals * 100).toFixed(parseInt(forminatorDecimal)) +postfix
                postfix = '';
            }
            return prefix + opt.w.config.labels[opt.seriesIndex] + '-' + seriesValue + postfix
        }
    } else if (showlabel == 'yes') {
        return option.dataLabels.formatter = function(val, opt) {
            if(forminatorPercentage){
                let totals = opt.w.globals.seriesTotals.reduce((a, b) => {
                    return  a + b;
                }, 0)
                if(postfix.trim() === ''){
                    postfix = '%';
                }
                val =  parseFloat(val/totals * 100).toFixed(parseInt(forminatorDecimal)) +postfix
                postfix = '';
            }
            return prefix + opt.w.config.labels[opt.seriesIndex] + '-' + parseFloat(val).toFixed(1) + postfix
        }
    } else if (showValue == 'yes') {
        return option.dataLabels.formatter = function(val, opt) {
            let seriesValue = opt.w.config.series[opt.seriesIndex];
            if (numberformat == "yes") {
                seriesValue = seriesValue.toLocaleString(graphina_localize.thousand_seperator)
            } else {
                seriesValue = valueInStringShow == 'no' ? seriesValue : graphinaAbbrNum(seriesValue, valueInString);
            }
            if(forminatorPercentage){
                let totals = opt.w.globals.seriesTotals.reduce((a, b) => {
                    return  a + b;
                }, 0)
                if(postfix.trim() === ''){
                    postfix = '%';
                }
                seriesValue =  parseFloat(seriesValue/totals * 100).toFixed(parseInt(forminatorDecimal)) +postfix
                postfix = '';
            }
            return prefix + seriesValue + postfix
        }
    } else {
        return option.dataLabels.formatter = function(val, opt) {
            if(forminatorPercentage){
                let totals = opt.w.globals.seriesTotals.reduce((a, b) => {
                    return  a + b;
                }, 0)
                if(postfix.trim() === ''){
                    postfix = '%';
                }
                val =  parseFloat(val/totals * 100).toFixed(parseInt(forminatorDecimal)) +postfix
                postfix = '';
            }
            return prefix + parseFloat(val).toFixed(1) + postfix;
        }
    }

}

function axisTitle(option, type, title, style, xaxisYoffset = 0) {
    return option[type]['title'] = {
        text: title,
        offsetX: 0,
        offsetY: type === 'xaxis' ? xaxisYoffset : 0,
        style,
    }
}


function instantInitGraphinaCharts(id) {
    graphina_localize.graphinaAllGraphs[id] = new ApexCharts(graphina_localize.graphinaAllGraphsOptions[id].ele, graphina_localize.graphinaAllGraphsOptions[id].options);
    graphina_localize.graphinaAllGraphs[id].render();
    isInit[id] = true;
}

/**
 * Simple object check.
 * @param item
 * @returns {boolean}
 */
function isObject(item) {
    return (item && typeof item === 'object' && !Array.isArray(item));
}

/**
 * Deep merge two objects.
 * @param target
 * @param sources
 */
function mergeDeep(target, ...sources) {
    if (!sources.length) return target;
    const source = sources.shift();

    if (isObject(target) && isObject(source)) {
        for (const key in source) {
            if (source.hasOwnProperty(key)) {
                if (isObject(source[key])) {
                    if (!target[key]) Object.assign(target, {
                        [key]: {}
                    });
                    mergeDeep(target[key], source[key]);
                } else {
                    Object.assign(target, {
                        [key]: source[key]
                    });
                }
            }
        }
    }

    return mergeDeep(target, ...sources);
}

function chunk(array, size) {
    if (!array) return [];
    const firstChunk = array.slice(0, size);
    if (!firstChunk.length) {
        return array;
    }
    return [firstChunk].concat(chunk(array.slice(size, array.length), size));
}

function graphinaAbbrNum(number, decPlaces) {
    if (number === undefined || number == null) {
        return number;
    }
    var negativesign = '';
    if (number < 0) {
        negativesign = '-';
        number = Math.abs(number)
    }
    if(number < 1000){
        return negativesign + parseFloat(number).toFixed(decPlaces)
    }
    // 2 decimal places => 100, 3 => 1000, etc
    decPlaces = Math.pow(10, decPlaces);

    // Enumerate number abbreviations
    var abbrev = ["k", "m", "b", "t"];

    // Go through the array backwards, so we do the largest first
    for (var i = abbrev.length - 1; i >= 0; i--) {

        // Convert array index to "1000", "1000000", etc
        var size = Math.pow(10, (i + 1) * 3);

        // If the number is bigger or equal do the abbreviation
        if (size <= number) {
            // Here, we multiply by decPlaces, round, and then divide by decPlaces.
            // This gives us nice rounding to a particular decimal place.
            number = Math.round(number * decPlaces / size) / decPlaces;

            // Handle special case where we round up to the next abbreviation
            if ((number == 1000) && (i < abbrev.length - 1)) {
                number = 1;
                i++;
            }

            // Add the letter for the abbreviation
            number += abbrev[i];

            // We are done... stop
            break;
        }
    }

    return negativesign + number;
}

function getDataForChartsAjax(request_fields, type, id, selected_field = '') {

    if (jQuery('body').hasClass("elementor-editor-active")) {
        let element_x = parent.document.querySelector('[data-setting="iq_' + type + '_chart_sql_builder_x_columns"]');
        let element_y = parent.document.querySelector('[data-setting="iq_' + type + '_chart_sql_builder_y_columns"]');
        if (element_x !== null && element_y !== null) {
            element_x.innerHTML = '';
            element_y.innerHTML = '';
        }

        let element_a = parent.document.querySelector('[data-setting="iq_' + type + '_chart_csv_x_columns"]');
        let element_b = parent.document.querySelector('[data-setting="iq_' + type + '_chart_csv_y_columns"]');
        if (element_a !== null && element_b !== null) {
            element_a.innerHTML = '';
            element_b.innerHTML = '';
        }
    };

    if (request_fields['iq_' + type + '_chart_filter_enable'] != undefined && request_fields['iq_' + type + '_chart_filter_enable'] == 'yes') {
        selected_field = graphinaGetSelectOptionValue(id);
    }

    jQuery.ajax({
        url: graphina_localize.ajaxurl,
        type: "post",
        dataType: "json",
        data: {
            action: "get_graphina_chart_settings",
            selected_field: selected_field,
            chart_type: type,
            chart_id: id,
            fields: request_fields
        },
        success: function(response) {
            if (document.getElementsByClassName(type + '-chart-' + id).length === 0) {
                return 0;
            }
            if (request_fields['iq_' + type + '_chart_filter_enable'] !== undefined && request_fields['iq_' + type + '_chart_filter_enable'] === 'yes') {
                if (response.status === true) {
                    jQuery(document).find('.' + type + '-chart-' + id + '-loader').hide();
                    jQuery(document).find('.' + type + '-chart-' + id).show();
                } else {
                    jQuery(document).find('.' + type + '-chart-' + id + '-loader').find('img').hide();
                    jQuery(document).find('.' + type + '-chart-' + id + '-loader').find('p').show();
                }
            }
            if (response.status === true) {
                if (response.fail === true) {
                    graphina_localize.graphinaBlockCharts[response.chart_id] = response.fail_message;
                    initGraphinaCharts(response.chart_id);
                } else {
                    if (response.instant_init === true) {
                        instantInitGraphinaCharts(response.chart_id);
                        graphina_localize.graphinaAllGraphsOptions[response.chart_id].animation = false;
                    }
                    graphina_localize.graphinaAllGraphsOptions[response.chart_id].options = mergeDeep(graphina_localize.graphinaAllGraphsOptions[response.chart_id].options, response.chart_option);
                    if (isInit[response.chart_id] === true) {
                        initGraphinaCharts(response.chart_id, type);
                    }
                }

                if (request_fields['iq_' + type + '_chart_dynamic_data_option'] !== undefined) {
                    if (request_fields['iq_' + type + '_chart_dynamic_data_option'] === "sql-builder") {
                        if (jQuery('body').hasClass("elementor-editor-active")) {
                            setFieldsFromSQLStateMent(request_fields, response, type);
                        };
                    }
                }

                if (request_fields['iq_' + type + '_chart_dynamic_data_option'] !== undefined) {
                    if (request_fields['iq_' + type + '_chart_dynamic_data_option'] === "csv" || request_fields['iq_' + type + '_chart_dynamic_data_option'] === "remote-csv" || request_fields['iq_' + type + '_chart_dynamic_data_option'] === "google-sheet") {
                        if (jQuery('body').hasClass("elementor-editor-active")) {
                            setFieldsForCSV(request_fields, response, type);
                        };
                    }
                }

                if(request_fields['iq_' + type + '_chart_data_option'] !== undefined
                    && request_fields['iq_' + type + '_chart_data_option'] === 'forminator'){
                    if(jQuery('body').hasClass("elementor-editor-active")) {
                        setFieldsFromForminator(request_fields, response, type);
                    };
                }
            }
        },
        error: function() {
            console.log('fail');
        }
    });

}

function setFieldsFromSQLStateMent(request_fields, response, type) {


    let manualSql = ['mixed', 'brush', 'pie_google', 'donut_google', 'line_google', 'area_google', 'bar_google', 'column_google', 'gauge_google', 'geo_google', 'org_google', 'gantt_google'];
    let csv_sql = ['gantt_google'];
    if (manualSql.includes(type)) {
        if (response.sql_fail !== undefined && response.sql_fail !== '') {
            let char_element = document.querySelector('[id="' + type + '-chart"]');
            if (char_element !== null) {
                char_element.innerHTML = '';
                char_element.innerHTML = "<div class='text-center' style='color:red'> No data found, Please check your sql statement. </div>";
            }
            return;
        }
    } else {
        if (response.extra !== undefined && response.extra.sql_fail !== undefined && response.extra.sql_fail !== '') {
            let char_element = document.querySelector('[id="' + type + '-chart"]');
            if (char_element !== null) {
                char_element.innerHTML = '';
                char_element.innerHTML = "<div class='text-center' style='color:red'> No data found, Please check your sql statement. </div>";
            }
            return;
        }
    }

    // graphina pro sql-builder select sql result column
    let db_columns = manualSql.includes(type) ? response.db_column : response.extra.db_column;

    let csv_columns = manualSql.includes(type) ? response.db_column : response.extra.db_column;
    // console.log(csv_columns);


    if (csv_sql.includes(type)) {

        let element_id = parent.document.querySelector('[data-setting="iq_gantt_google_chart_sql_id_columns"]');
        let element_name = parent.document.querySelector('[data-setting="iq_gantt_google_chart_sql_name_columns"]');
        let element_resource = parent.document.querySelector('[data-setting="iq_gantt_google_chart_sql_resource_columns"]');
        let element_start_date = parent.document.querySelector('[data-setting="iq_gantt_google_chart_sql_start_date_columns"]');
        let element_end_date = parent.document.querySelector('[data-setting="iq_gantt_google_chart_sql_end_date_columns"]');
        let element_duration = parent.document.querySelector('[data-setting="iq_gantt_google_chart_sql_duration_columns"]');
        let element_percent = parent.document.querySelector('[data-setting="iq_gantt_google_chart_sql_percent_columns"]');
        let element_dependencies = parent.document.querySelector('[data-setting="iq_gantt_google_chart_sql_dependencies_columns"]');



        id_option_tag = '';
        name_option_tag = '';
        resource_option_tag = '';
        start_date_option_tag = '';
        end_date_option_tag = '';
        duration_option_tag = '';
        percent_option_tag = '';
        dependencies_option_tag = '';

        if (element_id == null || element_name == null || element_resource == null || element_start_date == null || element_end_date == null || element_duration == null || element_percent == null || element_dependencies == null) {

            return;
        }

        db_columns.forEach(function(currentValue, index, arr) {

            id_axis_selected_field = '';
            name_axis_selected_field = '';
            resource_axis_selected_field = '';
            start_date_axis_selected_field = '';
            end_date_axis_selected_field = '';
            duration_axis_selected_field = '';
            percent_axis_selected_field = '';
            dependencies_axis_selected_field = '';

            if (request_fields['iq_' + type + '_chart_sql_id_columns'].includes(currentValue.toLowerCase())) {
                id_axis_selected_field = 'selected';
            }
            if (request_fields['iq_' + type + '_chart_sql_name_columns'].includes(currentValue.toLowerCase())) {
                name_axis_selected_field = 'selected';
            }
            if (request_fields['iq_' + type + '_chart_sql_resource_columns'].includes(currentValue.toLowerCase())) {
                resource_axis_selected_field = 'selected';
            }
            if (request_fields['iq_' + type + '_chart_sql_start_date_columns'].includes(currentValue.toLowerCase())) {
                start_date_axis_selected_field = 'selected';
            }
            if (request_fields['iq_' + type + '_chart_sql_end_date_columns'].includes(currentValue.toLowerCase())) {
                end_date_axis_selected_field = 'selected';
            }
            if (request_fields['iq_' + type + '_chart_sql_duration_columns'].includes(currentValue.toLowerCase())) {
                duration_axis_selected_field = 'selected';
            }
            if (request_fields['iq_' + type + '_chart_sql_percent_columns'].includes(currentValue.toLowerCase())) {
                percent_axis_selected_field = 'selected';
            }
            if (request_fields['iq_' + type + '_chart_sql_dependencies_columns'].includes(currentValue.toLowerCase())) {
                dependencies_axis_selected_field = 'selected';
            }

            id_option_tag += '<option value="' + currentValue.toLowerCase() + '" ' + id_axis_selected_field + ' > ' + currentValue + '</option>';
            name_option_tag += '<option value="' + currentValue.toLowerCase() + '" ' + name_axis_selected_field + ' > ' + currentValue + '</option>';
            resource_option_tag += '<option value="' + currentValue.toLowerCase() + '" ' + resource_axis_selected_field + ' > ' + currentValue + '</option>';
            start_date_option_tag += '<option value="' + currentValue.toLowerCase() + '" ' + start_date_axis_selected_field + ' > ' + currentValue + '</option>';
            end_date_option_tag += '<option value="' + currentValue.toLowerCase() + '" ' + end_date_axis_selected_field + ' > ' + currentValue + '</option>';
            duration_option_tag += '<option value="' + currentValue.toLowerCase() + '" ' + duration_axis_selected_field + ' > ' + currentValue + '</option>';
            percent_option_tag += '<option value="' + currentValue.toLowerCase() + '" ' + percent_axis_selected_field + ' > ' + currentValue + '</option>';
            dependencies_option_tag += '<option value="' + currentValue.toLowerCase() + '" ' + dependencies_axis_selected_field + ' > ' + currentValue + '</option>';

        });



        element_id.innerHTML = id_option_tag;
        element_name.innerHTML = name_option_tag;
        element_resource.innerHTML = resource_option_tag;
        element_start_date.innerHTML = start_date_option_tag;
        element_end_date.innerHTML = end_date_option_tag;
        element_duration.innerHTML = duration_option_tag;
        element_percent.innerHTML = percent_option_tag;
        element_dependencies.innerHTML = dependencies_option_tag;

    } else {

        let element_x = parent.document.querySelector('[data-setting="iq_' + type + '_chart_sql_builder_x_columns"]');
        let element_y = parent.document.querySelector('[data-setting="iq_' + type + '_chart_sql_builder_y_columns"]');

        if (element_x == null || element_y == null) {
            return;
        }

        x_option_tag = '';
        y_option_tag = '';

        if (db_columns !== undefined && db_columns.length !== undefined && db_columns.length > 0) {
            db_columns.forEach(function(currentValue, index, arr) {
                x_axis_selected_field = '';
                y_axis_selected_field = '';
                if (request_fields['iq_' + type + '_chart_sql_builder_x_columns'].includes(currentValue)) {
                    x_axis_selected_field = 'selected';
                }
                if (request_fields['iq_' + type + '_chart_sql_builder_y_columns'].includes(currentValue)) {
                    y_axis_selected_field = 'selected';
                }
                x_option_tag += '<option value="' + currentValue.toLowerCase() + '" ' + x_axis_selected_field + ' > ' + currentValue + '</option>';
                y_option_tag += '<option value="' + currentValue.toLowerCase() + '" ' + y_axis_selected_field + ' > ' + currentValue + '</option>';
            });
        }

        element_x.innerHTML = x_option_tag;

        element_y.innerHTML = y_option_tag;
    }

}

function setFieldsForCSV(request_fields, response, type) {

    

    let manualCsv = ['mixed', 'brush', 'nested_column', 'pie_google', 'donut_google', 'line_google', 'area_google', 'bar_google', 'column_google', 'gauge_google', 'gantt_google', 'geo_google', 'org_google'];
    let csv_sql = ['gantt_google'];

    let csv_columns = manualCsv.includes(type) ? response.column : response.extra.column;

    console.log(response);
    
    if (csv_columns !== undefined && csv_columns.length !== undefined && csv_columns.length > 0) {
        
        if (csv_sql.includes(type)) {


            let element_id = parent.document.querySelector('[data-setting="iq_gantt_google_chart_csv_id_columns"]');
            let element_name = parent.document.querySelector('[data-setting="iq_gantt_google_chart_csv_name_columns"]');
            let element_resource = parent.document.querySelector('[data-setting="iq_gantt_google_chart_csv_resource_columns"]');
            let element_start_date = parent.document.querySelector('[data-setting="iq_gantt_google_chart_csv_start_date_columns"]');
            let element_end_date = parent.document.querySelector('[data-setting="iq_gantt_google_chart_csv_end_date_columns"]');
            let element_duration = parent.document.querySelector('[data-setting="iq_gantt_google_chart_csv_duration_columns"]');
            let element_percent = parent.document.querySelector('[data-setting="iq_gantt_google_chart_csv_percent_columns"]');
            let element_dependencies = parent.document.querySelector('[data-setting="iq_gantt_google_chart_csv_dependencies_columns"]');

            id_option_tag = '';
            name_option_tag = '';
            resource_option_tag = '';
            start_date_option_tag = '';
            end_date_option_tag = '';
            duration_option_tag = '';
            percent_option_tag = '';
            dependencies_option_tag = '';

            if (element_id == null || element_name == null || element_resource == null || element_start_date == null || element_end_date == null || element_duration == null || element_percent == null || element_dependencies == null) {

                return;
            }

            csv_columns.forEach(function(currentValue, index, arr) {

                id_axis_selected_field = '';
                name_axis_selected_field = '';
                resource_axis_selected_field = '';
                start_date_axis_selected_field = '';
                end_date_axis_selected_field = '';
                duration_axis_selected_field = '';
                percent_axis_selected_field = '';
                dependencies_axis_selected_field = '';

                if (request_fields['iq_' + type + '_chart_csv_id_columns'].includes(currentValue)) {
                    id_axis_selected_field = 'selected';
                }
                if (request_fields['iq_' + type + '_chart_csv_name_columns'].includes(currentValue)) {
                    name_axis_selected_field = 'selected';
                }
                if (request_fields['iq_' + type + '_chart_csv_resource_columns'].includes(currentValue)) {
                    resource_axis_selected_field = 'selected';
                }
                if (request_fields['iq_' + type + '_chart_csv_start_date_columns'].includes(currentValue)) {
                    start_date_axis_selected_field = 'selected';
                }
                if (request_fields['iq_' + type + '_chart_csv_end_date_columns'].includes(currentValue)) {
                    end_date_axis_selected_field = 'selected';
                }
                if (request_fields['iq_' + type + '_chart_csv_duration_columns'].includes(currentValue)) {
                    duration_axis_selected_field = 'selected';
                }
                if (request_fields['iq_' + type + '_chart_csv_percent_columns'].includes(currentValue)) {
                    percent_axis_selected_field = 'selected';
                }
                if (request_fields['iq_' + type + '_chart_csv_dependencies_columns'].includes(currentValue)) {
                    dependencies_axis_selected_field = 'selected';
                }

                id_option_tag += '<option value="' + currentValue + '" ' + id_axis_selected_field + ' > ' + currentValue + '</option>';
                name_option_tag += '<option value="' + currentValue + '" ' + name_axis_selected_field + ' > ' + currentValue + '</option>';
                resource_option_tag += '<option value="' + currentValue + '" ' + resource_axis_selected_field + ' > ' + currentValue + '</option>';
                start_date_option_tag += '<option value="' + currentValue + '" ' + start_date_axis_selected_field + ' > ' + currentValue + '</option>';
                end_date_option_tag += '<option value="' + currentValue + '" ' + end_date_axis_selected_field + ' > ' + currentValue + '</option>';
                duration_option_tag += '<option value="' + currentValue + '" ' + duration_axis_selected_field + ' > ' + currentValue + '</option>';
                percent_option_tag += '<option value="' + currentValue + '" ' + percent_axis_selected_field + ' > ' + currentValue + '</option>';
                dependencies_option_tag += '<option value="' + currentValue + '" ' + dependencies_axis_selected_field + ' > ' + currentValue + '</option>';

            });

            element_id.innerHTML = id_option_tag;
            element_name.innerHTML = name_option_tag;
            element_resource.innerHTML = resource_option_tag;
            element_start_date.innerHTML = start_date_option_tag;
            element_end_date.innerHTML = end_date_option_tag;
            element_duration.innerHTML = duration_option_tag;
            element_percent.innerHTML = percent_option_tag;
            element_dependencies.innerHTML = dependencies_option_tag;

        } else {
            let element_x = parent.document.querySelector('[data-setting="iq_' + type + '_chart_csv_x_columns"]');

            let element_y = parent.document.querySelector('[data-setting="iq_' + type + '_chart_csv_y_columns"]');

            if (element_x == null || element_y == null) {

                return;
            }

            x_option_tag = '';
            y_option_tag = '';

            csv_columns.forEach(function(currentValue, index, arr) {


                x_axis_selected_field = '';
                y_axis_selected_field = '';

                if (request_fields['iq_' + type + '_chart_csv_x_columns'].includes(currentValue)) {
                    x_axis_selected_field = 'selected';
                }
                if (request_fields['iq_' + type + '_chart_csv_y_columns'].includes(currentValue)) {
                    y_axis_selected_field = 'selected';
                }

                x_option_tag += '<option value="' + currentValue.toLowerCase() + '" ' + x_axis_selected_field + ' > ' + currentValue + '</option>';

                y_option_tag += '<option value="' + currentValue.toLowerCase() + '" ' + y_axis_selected_field + ' > ' + currentValue + '</option>';


            });
            element_x.innerHTML = x_option_tag;
            element_y.innerHTML = y_option_tag;
        }
    }

}

function graphinasetCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function graphinaRestrictedPasswordAjax(form, e) {
    e.preventDefault()
    jQuery.ajax({
        url: graphina_localize.ajaxurl,
        type: "post",
        data: jQuery(form).serialize(),
        success: function(response) {
            if (response.status === true) {
                graphinasetCookie(response.chart, true, 1);
                location.reload();
            } else {
                jQuery(form).find('.graphina-error').css('display', 'flex');
            }
        }
    });



}

function graphinaChartFilter(request_fields, type, selectedValue, id) {
    jQuery(document).find('.' + type + '-chart-' + id + '-loader').show();
    jQuery(document).find('.' + type + '-chart-' + id + '-loader').find('img').show();
    jQuery(document).find('.' + type + '-chart-' + id + '-loader').find('p').hide();
    jQuery(document).find('.' + type + '-chart-' + id).hide();
    getDataForChartsAjax(request_fields, type, id, graphinaGetSelectOptionValue(id));

}

function graphinaGetSelectOptionValue(id) {
    let option = []
    let allSelect = document.querySelectorAll('.graphina_filter_select' + id);
    for (let i = 0; i < allSelect.length; i++) {
        if(allSelect[i].type !== undefined && ['datetime-local','date'].includes(allSelect[i].type)){
            if (allSelect[i].value !== undefined) {
                let formatsign = "-";
                let date = new Date(allSelect[i].value)
                if (date !== undefined) {
                    let formatDate = '';
                    if (allSelect[i].type === 'date') {
                        formatDate = date.getFullYear() + formatsign + ("00" + (date.getMonth() + 1)).slice(-2) + formatsign +
                            ("00" + date.getDate()).slice(-2);
                    } else {
                        formatDate = date.getFullYear() + formatsign + ("00" + (date.getMonth() + 1)).slice(-2) + formatsign +
                            ("00" + date.getDate()).slice(-2) + " " +
                            ("00" + date.getHours()).slice(-2) + ":" +
                            ("00" + date.getMinutes()).slice(-2) + ":" +
                            ("00" + date.getSeconds()).slice(-2);
                    }
                    option.push(formatDate)
                }
            }
        }else{
            if (allSelect[i].value !== undefined || allSelect[i].value !== null) {
                if (allSelect[i].value !== 'default') {
                    option.push(allSelect[i].value)
                } else {
                    option.push('')
                }
            }
        }
    }
    return option;
}

function graphinaGoogleChartInit(ele, options, id, type) {
    resetGraphinaVars();
    if (id in graphina_localize.graphinaAllGraphs) {
        graphina_localize.graphinaAllGraphs[id].clearChart();
        delete graphina_localize.graphinaAllGraphs[id];
        delete graphina_localize.graphinaBlockCharts[id];
    }
    isInit[id] = false;
    graphina_localize.graphinaAllGraphsOptions[id] = options;
    if (ele !== null) {
        if (graphina_localize.is_view_port_disable != undefined && graphina_localize.is_view_port_disable == 'on') {
            graphinaGoogleChartRender(id, type);
        } else {
            const observer = new IntersectionObserver(enteries => {
                enteries.forEach(entry => {
                    if (entry.isIntersecting) {
                        if (isInit[id] === false) {
                            graphinaGoogleChartRender(id, type);
                        }
                    }
                })
            })
            observer.observe(ele);
        }
    }
}

function graphinaGoogleChartRender(id, type) {
    if (isInit[id] === true || graphina_localize.graphinaAllGraphs[id]) {
        graphina_localize.graphinaAllGraphs[id] = new google.visualization[graphina_localize.graphinaAllGraphsOptions[id].renderType](graphina_localize.graphinaAllGraphsOptions[id].ele);
        graphina_localize.graphinaAllGraphs[id].draw(graphina_localize.graphinaAllGraphsOptions[id].series, graphina_localize.graphinaAllGraphsOptions[id].options);
    } else {
        graphina_localize.graphinaAllGraphs[id] = new google.visualization[graphina_localize.graphinaAllGraphsOptions[id].renderType](graphina_localize.graphinaAllGraphsOptions[id].ele);
        graphina_localize.graphinaAllGraphs[id].draw(graphina_localize.graphinaAllGraphsOptions[id].series, graphina_localize.graphinaAllGraphsOptions[id].options);
    }

    if (type === 'gauge_google' && typeof graphina_localize.graphinaAllGraphs[id] != "undefined") {
        Array.prototype.forEach.call(graphina_localize.graphinaAllGraphsOptions[id].ele.getElementsByTagName('circle'), function(circle) {
            if (circle.getAttribute('fill') === '#4684ee') {
                circle.setAttribute('fill', typeof graphina_localize.graphinaAllGraphsOptions[id].ballColor !== "undefined" ? graphina_localize.graphinaAllGraphsOptions[id].ballColor : '#4684ee');
            }
            if (circle.getAttribute('fill') === '#f7f7f7') {
                circle.setAttribute('fill', typeof graphina_localize.graphinaAllGraphsOptions[id].innerCircleColor !== "undefined" ? graphina_localize.graphinaAllGraphsOptions[id].innerCircleColor : '#f7f7f7');
            }
            if (circle.getAttribute('fill') === '#cccccc') {
                circle.setAttribute('fill', typeof graphina_localize.graphinaAllGraphsOptions[id].outerCircleColor !== "undefined" ? graphina_localize.graphinaAllGraphsOptions[id].outerCircleColor : '#cccccc');
            }
        });
        Array.prototype.forEach.call(graphina_localize.graphinaAllGraphsOptions[id].ele.getElementsByTagName('path'), function(path) {
            if (path.getAttribute('stroke') === '#c63310') {
                path.setAttribute('stroke', typeof graphina_localize.graphinaAllGraphsOptions[id].needleColor !== "undefined" ? graphina_localize.graphinaAllGraphsOptions[id].needleColor : '#c63310');
                path.setAttribute('fill', typeof graphina_localize.graphinaAllGraphsOptions[id].needleColor !== "undefined" ? graphina_localize.graphinaAllGraphsOptions[id].needleColor : '#c63310');
            }
        });
    }
}

function graphinaDynamicReload(setting, type, id) {
    if (typeof getDataForChartsAjax !== "undefined") {
        if (!['mixed'].includes(type)) {
            getDataForChartsAjax(setting, type, id);
        }
        if (setting['iq_' + type + '_can_chart_reload_ajax'] !== undefined && setting['iq_' + type + '_can_chart_reload_ajax'] === 'yes') {
            window['ajaxIntervalGraphina_' + id] = setInterval(function() {
                console.log(window['ajaxIntervalGraphina_' + id]);
                getDataForChartsAjax(setting, type, id);
            }, parseInt(setting['iq_' + type + '_interval_data_refresh']) * 1000);
        }
    }
}

function setFieldsFromForminator(request_fields, response, type) {
    if(type == "gantt_google"){
        
        let element_id = parent.document.querySelector('[data-setting="iq_'+type+'_chart_for_forminator_id_columns"]');
        let element_name = parent.document.querySelector('[data-setting="iq_'+type+'_chart_for_forminator_name_columns"]');
        let element_resource = parent.document.querySelector('[data-setting="iq_'+type+'_chart_for_forminator_resource_columns"]');
        let element_start_date = parent.document.querySelector('[data-setting="iq_'+type+'_chart_for_forminator_start_date_columns"]');
        let element_end_date = parent.document.querySelector('[data-setting="iq_'+type+'_chart_for_forminator_end_date_columns"]');
        let element_duration = parent.document.querySelector('[data-setting="iq_'+type+'_chart_for_forminator_duration_columns"]');
        let element_percent = parent.document.querySelector('[data-setting="iq_'+type+'_chart_for_forminator_percent_columns"]');
        let element_dependencies = parent.document.querySelector('[data-setting="iq_'+type+'_chart_for_forminator_dependencies_columns"]');
        
        
        var columns = response.columns;

        id_option_tag = '';
        name_option_tag = '';
        resource_option_tag = '';
        start_date_option_tag = '';
        end_date_option_tag = '';
        duration_option_tag = '';
        percent_option_tag = '';
        dependencies_option_tag = '';

        if (element_id == null || element_name == null || element_resource == null || element_start_date == null || element_end_date == null || element_duration == null || element_percent == null || element_dependencies == null) {

            return;
        }

        columns.forEach(function(currentValue, index, arr) {

            id_axis_selected_field = '';
            name_axis_selected_field = '';
            resource_axis_selected_field = '';
            start_date_axis_selected_field = '';
            end_date_axis_selected_field = '';
            duration_axis_selected_field = '';
            percent_axis_selected_field = '';
            dependencies_axis_selected_field = '';

            if (request_fields['iq_' + type + '_chart_for_forminator_id_columns'].includes(index)) {
                id_axis_selected_field = 'selected';
            }
            if (request_fields['iq_' + type + '_chart_for_forminator_name_columns'].includes(index)) {
                name_axis_selected_field = 'selected';
            }
            if (request_fields['iq_' + type + '_chart_for_forminator_resource_columns'].includes(index)) {
                resource_axis_selected_field = 'selected';
            }
            if (request_fields['iq_' + type + '_chart_for_forminator_start_date_columns'].includes(index)) {
                start_date_axis_selected_field = 'selected';
            }
            if (request_fields['iq_' + type + '_chart_for_forminator_end_date_columns'].includes(index)) {
                end_date_axis_selected_field = 'selected';
            }
            if (request_fields['iq_' + type + '_chart_for_forminator_duration_columns'].includes(index)) {
                duration_axis_selected_field = 'selected';
            }
            if (request_fields['iq_' + type + '_chart_for_forminator_percent_columns'].includes(index)) {
                percent_axis_selected_field = 'selected';
            }
            if (request_fields['iq_' + type + '_chart_for_forminator_dependencies_columns'].includes(index)) {
                dependencies_axis_selected_field = 'selected';
            }

            id_option_tag += '<option value="' +index + '" ' + id_axis_selected_field + ' > ' + currentValue + '</option>';
            name_option_tag += '<option value="' +index + '" ' + name_axis_selected_field + ' > ' + currentValue + '</option>';
            resource_option_tag += '<option value="' +index + '" ' + resource_axis_selected_field + ' > ' + currentValue + '</option>';
            start_date_option_tag += '<option value="' +index + '" ' + start_date_axis_selected_field + ' > ' + currentValue + '</option>';
            end_date_option_tag += '<option value="' +index + '" ' + end_date_axis_selected_field + ' > ' + currentValue + '</option>';
            duration_option_tag += '<option value="' +index + '" ' + duration_axis_selected_field + ' > ' + currentValue + '</option>';
            percent_option_tag += '<option value="' +index + '" ' + percent_axis_selected_field + ' > ' + currentValue + '</option>';
            dependencies_option_tag += '<option value="' +index + '" ' + dependencies_axis_selected_field + ' > ' + currentValue + '</option>';

        });



        element_id.innerHTML = id_option_tag;
        element_name.innerHTML = name_option_tag;
        element_resource.innerHTML = resource_option_tag;
        element_start_date.innerHTML = start_date_option_tag;
        element_end_date.innerHTML = end_date_option_tag;
        element_duration.innerHTML = duration_option_tag;
        element_percent.innerHTML = percent_option_tag;
        element_dependencies.innerHTML = dependencies_option_tag;

    }{
        if(request_fields['iq_' + type + '_section_chart_forminator_aggregate'] !== undefined && request_fields['iq_' + type + '_section_chart_forminator_aggregate'] === 'yes'){
            let element_aggregate = parent.document.querySelector('[data-setting="iq_' + type + '_section_chart_forminator_aggregate_column"]');
            console.log(element_aggregate)
            if (element_aggregate == null) {
                return;
            }
            let manualForminator = ['mixed','brush','pie_google','donut_google','line_google','area_google','bar_google','column_google','gauge_google','geo_google','org_google'];
            let forminator_columns = manualForminator.includes(type) ? response.forminator_columns: response.extra.forminator_columns ;
            let forminator_columns_labels = manualForminator.includes(type) ? response.forminator_columns_labels: response.extra.forminator_columns_labels ;
            aggregate_column_option_tag = '' ;
            if(forminator_columns !== undefined &&  forminator_columns.length !== undefined && forminator_columns.length > 0) {
                let labels = '';
                forminator_columns.forEach(function(currentValue, index, arr) {
                    labels = '';
                    labels = forminator_columns_labels !== undefined &&  forminator_columns_labels.length > 0 && forminator_columns_labels[index] !== undefined ? forminator_columns_labels[index] : currentValue;
                    aggregate_column_selected_field = '' ;
                    if(request_fields['iq_' + type + '_section_chart_forminator_aggregate_column'].includes(currentValue)) {
                        aggregate_column_selected_field = 'selected' ;
                    }
                    aggregate_column_option_tag += '<option value="' + currentValue + '" ' + aggregate_column_selected_field + ' > ' + labels + '</option>' ;

                });
            }
            element_aggregate.innerHTML = aggregate_column_option_tag ;
        }else{
            let element_x = parent.document.querySelector('[data-setting="iq_' + type + '_section_chart_forminator_x_axis_columns"]');
            let element_y = parent.document.querySelector('[data-setting="iq_' + type + '_section_chart_forminator_y_axis_columns"]');
            if (element_x == null || element_y == null) {
                return;
            }
            let manualForminator = ['mixed','brush','pie_google','donut_google','line_google','area_google','bar_google','column_google','gauge_google','geo_google','org_google'];
            // graphina pro sql-builder select sql result column
            let forminator_columns = manualForminator.includes(type) ? response.forminator_columns: response.extra.forminator_columns ;
            let forminator_columns_labels = manualForminator.includes(type) ? response.forminator_columns_labels: response.extra.forminator_columns_labels ;
            x_option_tag = '' ;
            y_option_tag = '' ;
            if(forminator_columns !== undefined &&  forminator_columns.length !== undefined && forminator_columns.length > 0) {
                let labels = '';
                forminator_columns.forEach(function(currentValue, index, arr) {
                    labels = '';
                    labels = forminator_columns_labels !== undefined &&  forminator_columns_labels.length > 0 && forminator_columns_labels[index] !== undefined ? forminator_columns_labels[index] : currentValue;
                    x_axis_selected_field = '' ;
                    y_axis_selected_field = '' ;
                    if(request_fields['iq_' + type + '_section_chart_forminator_x_axis_columns'].includes(currentValue)) {
                        x_axis_selected_field = 'selected' ;
                    }
                    if(request_fields['iq_' + type + '_section_chart_forminator_y_axis_columns'].includes(currentValue)) {
                        y_axis_selected_field = 'selected' ;
                    }
                    x_option_tag += '<option value="' + currentValue + '" ' + x_axis_selected_field + ' > ' + labels + '</option>' ;
                    y_option_tag += '<option value="' + currentValue + '" ' + y_axis_selected_field + ' > ' + labels + '</option>' ;
                });
            }
            element_x.innerHTML = x_option_tag ;
            element_y.innerHTML = y_option_tag ;
        }
    }

    
}
