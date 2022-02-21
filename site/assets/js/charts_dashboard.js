jQuery(document).ready(function($) {
    //console.log( $("#base_url").val() );

    //Iti Year change to load chart
    $("#year_iti").change(function() {
        pm_iti_bar_chart();
    });

    //Leads year change to load chart
    $("#year_leads").change(function() {
        pm_leads_bar_chart();
    });


    //on agent change
    $("#agent_graph_lead").change(function() {
        pm_leads_bar_chart();
    });

    //Leads //on agent change
    $("#agent_graph").change(function() {
        pm_iti_bar_chart();
    });

    //Call charts
    pm_iti_bar_chart();
    pm_leads_bar_chart();

    //Itineraries Bar Chart
    function pm_iti_bar_chart() {
        var this_year = $("#year_iti").val();
        var agent_id = $("#agent_graph").val();
        //console.log( this_year );
        var BASE_URL = $("#base_url").val();
        $.ajax({
            url: BASE_URL + "dashboard/chart_data_monthly_iti_ajax",
            method: "POST",
            dataType: 'json',
            data: { year: this_year, agent_id: agent_id },
            beforeSend: function() {
                $(".loader_iti").show();
                $("#iti_echarts_bar").hide();
            },
            success: function(data) {
                $("#iti_echarts_bar").show();
                $(".loader_iti").hide();
                //console.log( data.data1 );
                //console.log( data.data2 );
                //console.log( data.data3 );
                // ECHARTS
                require.config({
                    paths: {
                        echarts: 'site/assets/js/echarts'
                    }
                });

                // DEMOS
                require(
                    [
                        'echarts',
                        'echarts/chart/bar',
                        'echarts/chart/line',
                    ],
                    function(ec) {
                        //--- BAR ---
                        var myChart = ec.init(document.getElementById('iti_echarts_bar'));
                        myChart.setOption({
                            tooltip: {
                                trigger: 'axis'
                            },
                            legend: {
                                data: ['Working', 'Approved', 'Declined']
                            },
                            toolbox: {
                                show: true,
                                feature: {
                                    mark: {
                                        show: false
                                    },
                                    dataView: {
                                        show: false,
                                        readOnly: false
                                    },
                                    magicType: {
                                        show: true,
                                        type: ['line', 'bar']
                                    },
                                    restore: {
                                        show: true
                                    },
                                    saveAsImage: {
                                        show: true
                                    }
                                }
                            },
                            calculable: true,
                            xAxis: [{
                                type: 'category',
                                data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                            }],
                            yAxis: [{
                                type: 'value',
                                splitArea: {
                                    show: true
                                }
                            }],
                            series: [{
                                name: 'Working',
                                type: 'bar',
                                data: data.data1
                            }, {
                                name: 'Approved',
                                type: 'bar',
                                data: data.data2
                            }, {
                                name: 'Declined',
                                type: 'bar',
                                data: data.data3
                            }]
                        });

                    }
                );
            },
            error: function(e) {
                $(".loader_iti").hide();
                console.log("err");
            }
        });
    }

    //LEADS Bar Chart
    function pm_leads_bar_chart() {
        var this_year = $("#year_leads").val();
        var agent_id = $("#agent_graph_lead").val();
        //console.log( this_year );
        var BASE_URL = $("#base_url").val();
        $.ajax({
            url: BASE_URL + "dashboard/chart_data_monthly_leads_ajax",
            method: "POST",
            dataType: 'json',
            data: { year: this_year, agent_id: agent_id },
            beforeSend: function() {
                $(".loader_lead").show();
                $("#leads_echarts_bar").hide();
            },
            success: function(data) {
                $("#leads_echarts_bar").show();
                $(".loader_lead").hide();
                //console.log( data.data1 );
                //console.log( data.data2 );
                //console.log( data.data3 );
                // ECHARTS
                require.config({
                    paths: {
                        echarts: 'site/assets/js/echarts'
                    }
                });

                // DEMOS
                require(
                    [
                        'echarts',
                        'echarts/chart/bar',
                        'echarts/chart/line',
                    ],
                    function(ec) {
                        //--- BAR ---
                        var myChart = ec.init(document.getElementById('leads_echarts_bar'));
                        myChart.setOption({
                            tooltip: {
                                trigger: 'axis'
                            },
                            legend: {
                                data: ['Working', 'Approved', 'Declined']
                            },
                            toolbox: {
                                show: true,
                                feature: {
                                    mark: {
                                        show: false
                                    },
                                    dataView: {
                                        show: false,
                                        readOnly: false
                                    },
                                    magicType: {
                                        show: true,
                                        type: ['line', 'bar']
                                    },
                                    restore: {
                                        show: true
                                    },
                                    saveAsImage: {
                                        show: true
                                    }
                                }
                            },
                            calculable: true,
                            xAxis: [{
                                type: 'category',
                                data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                            }],
                            yAxis: [{
                                type: 'value',
                                splitArea: {
                                    show: true
                                }
                            }],
                            series: [{
                                name: 'Working',
                                type: 'bar',
                                data: data.data1
                            }, {
                                name: 'Approved',
                                type: 'bar',
                                data: data.data2
                            }, {
                                name: 'Declined',
                                type: 'bar',
                                data: data.data3
                            }]
                        });

                    }
                );
            },
            error: function(e) {
                $(".loader_lead").hide();
                console.log("err");
            }
        });
    }
});