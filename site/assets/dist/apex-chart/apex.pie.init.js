jQuery(document).ready(function($) {
    $(".dateHide").val('');
    //filter on  date change function
    $("#daterangelead").change(function() {
        // $(".chart-pie-simple").html('')
        leads_date_filter();
    });
    //filter on  date change function leads
    $("#leadsDate").change(function() {
        // $("#main").html('')
        hm_leads_chart();
    });
    // call to date filter
    leads_date_filter();
    hm_leads_chart();

    //leads filter 
    function leads_date_filter() {
        var selectedDate = $('#daterangelead').val();
        var BASE_URL = $("#base_url").val();
        $.ajax({
            url: BASE_URL + "dashboard/leadsFilter",
            method: "POST",
            dataType: 'json',
            data: { selectedDate: selectedDate },
            success: function(data) {
                //init chart
                var myChart = echarts.init(document.getElementById('pieChart'));
                var idx = 1;
                pieChartOption = {
                    timeline: {
                        show: false,
                        data: [
                            '2013-07-01',
                        ],
                    },
                    options: [{
                        tooltip: {
                            trigger: 'item',
                            formatter: "{a} <br/>{b} : {c} ({d}%)"
                        },
                        legend: {
                            data: data.name,
                        },
                        toolbox: {
                            show: true,
                            feature: {
                                dataView: {
                                    show: true,
                                    readOnly: false
                                },
                                magicType: {
                                    show: true,
                                    type: ['pie', 'funnel'],
                                    option: {
                                        funnel: {
                                            x: '25%',
                                            width: '50%',
                                            funnelAlign: 'left',
                                            max: 1700
                                        }
                                    }
                                },
                                restore: {
                                    show: true
                                },
                                saveAsImage: {
                                    show: true
                                }
                            }
                        },
                        series: [{
                            type: 'pie',
                            center: ['50%', '55%'],
                            radius: '70%',
                            data: data.totalNo,
                        }]
                    }]
                };
                myChart.setOption(pieChartOption);
            },
            error: function(e) {
                alert("Some Error are occurred?")
            }
        })
    }

    //lead by working type
    function hm_leads_chart() {
        var selectedDate = $('#leadsDate').val();
        var BASE_URL = $("#base_url").val();
        $.ajax({
            url: BASE_URL + "dashboard/leadsFilterByType",
            method: "POST",
            dataType: 'json',
            data: { selectedDate: selectedDate },
            success: function(res) {
                console.log(res);
                //init chart
                var myChart = echarts.init(document.getElementById('main'));
                var idx = 1;
                pieChartOption = {
                    timeline: {
                        show: false,
                        data: [
                            '2013-07-01',
                        ],
                    },
                    options: [{
                        tooltip: {
                            trigger: 'item',
                            formatter: "{a} <br/>{b} : {c} ({d}%)"
                        },
                        legend: {
                            data: res.name,
                        },
                        toolbox: {
                            show: true,
                            feature: {
                                dataView: {
                                    show: true,
                                    readOnly: false
                                },
                                magicType: {
                                    show: true,
                                    type: ['pie', 'funnel'],
                                    option: {
                                        funnel: {
                                            x: '25%',
                                            width: '50%',
                                            funnelAlign: 'left',
                                            max: 1700
                                        }
                                    }
                                },
                                restore: {
                                    show: true
                                },
                                saveAsImage: {
                                    show: true
                                }
                            }
                        },
                        series: [{
                            type: 'pie',
                            center: ['50%', '60%'],
                            radius: ['45%', '75%'],
                            avoidLabelOverlap: false,
                            data: res.totalNo,
                        }]
                    }]
                };
                myChart.setOption(pieChartOption);

            },
            error: function(e) {
                console.log("err");
            }
        });
    }
});



// initial daterange
$(".daterange").daterangepicker({
    // autoApply: true,
    // autoUpdateInput: false,
    locale: {
        format: 'YYYY/MM/DD',
        cancelLabel: 'Clear'
    },
    ranges: {
        Today: [moment(), moment()],
        Yesterday: [
            moment().subtract(1, "days"),
            moment().subtract(1, "days"),
        ],
        "Last 7 Days": [moment().subtract(6, "days"), moment()],
        "Last 30 Days": [moment().subtract(29, "days"), moment()],
        "This Month": [moment().startOf("month"), moment().endOf("month")],
        "Last Month": [
            moment().subtract(1, "month").startOf("month"),
            moment().subtract(1, "month").endOf("month"),
        ],
    },

});






/*
function chart(totalNo, name) {
    var options_simple = {
        series: totalNo,
        chart: {
            fontFamily: '"Nunito Sans", sans-serif',
            width: 400,
            height: 220,
            type: "pie",
        },
        dataLabels: {
            enabled: false
        },
        title: {
            text: "LEADS GRAPH",
            align: 'left',
            margin: 10,
            offsetX: 0,
            offsetY: 0,
            floating: false,
            style: {
                fontSize: '16px',
                fontWeight: 'bold',
                color: '#263238'
            },
        },
        colors: ["#2962ff", "#6993ff", "#ee9d01", "#f64e60", "#adb5bd", '#FFFF00', '#FF00FF', '#00008B', '#AFDCEC', '#46C7C7'],
        labels: name,
        responsive: [{
            breakpoint: 500,
            options: {
                chart: {
                    width: 480,

                },
                legend: {
                    position: "bottom",
                },
            },
        }, ],
        legend: {
            labels: {
                colors: ["#a1aab2"],
            },
        },
    };
    var chart_pie_simple = new ApexCharts(
        document.querySelector(".chart-pie-simple"),
        options_simple
    );
    chart_pie_simple.render();

}




$(function() {
    "use strict";

    // ------------------------------
    // nightingale chart
    // ------------------------------
    // based on prepared DOM, initialize echarts instance
    var nightingaleChart = echarts.init(
        document.getElementById("nightingale-chart")
    );
    var option = {
        title: {
            text: "Employee's salary review",
            subtext: "Senior front end developer",
            x: "center",
        },

        // Add tooltip
        tooltip: {
            trigger: "item",
            formatter: "{a} <br/>{b}: +{c}$ ({d}%)",
        },

        // Add legend
        legend: {
            x: "left",
            y: "top",
            orient: "vertical",
            data: [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December",
            ],
        },

        color: [
            "#ffbc34",
            "#00acc1",
            "#212529",
            "#f62d51",
            "#1e88e5",
            "#FFC400",
            "#006064",
            "#FF1744",
            "#1565C0",
            "#FFC400",
            "#64FFDA",
            "#607D8B",
        ],


        // Add series
        series: [{
            name: "Increase (brutto)",
            type: "pie",
            radius: ["15%", "73%"],
            center: ["50%", "57%"],
            roseType: "area",

            // Funnel
            width: "40%",
            height: "78%",
            x: "30%",
            y: "17.5%",
            max: 450,
            sort: "ascending",

            data: [
                { value: 440, name: "January" },
                { value: 260, name: "February" },
                { value: 350, name: "March" },
                { value: 250, name: "April" },
                { value: 210, name: "May" },
                { value: 350, name: "June" },
                { value: 300, name: "July" },
                { value: 430, name: "August" },
                { value: 400, name: "September" },
                { value: 450, name: "October" },
                { value: 330, name: "November" },
                { value: 200, name: "December" },
            ],
        }, ],
    };
    nightingaleChart.setOption(option);


})


function chart1(totalNo) {

    var options_simple = {
        series: totalNo,
        chart: {
            fontFamily: '"Nunito Sans", sans-serif',
            width: 400,
            height: 220,
            type: "donut",
        },
        dataLabels: {
            enabled: false
        },
        title: {
            text: "LEADS GRAPH",
            align: 'left',
            margin: 10,
            offsetX: 0,
            offsetY: 0,
            floating: false,
            style: {
                fontSize: '16px',
                fontWeight: 'bold',
                color: '#263238'
            },
        },
        colors: ["#2962ff", "#6993ff", "#ee9d01", "#f64e60", "#adb5bd", '#FFFF00', '#FF00FF', '#00008B', '#AFDCEC', '#46C7C7'],
        labels: ['Decline', 'Booked', 'Pending'],
        responsive: [{
            breakpoint: 500,
            options: {
                chart: {
                    width: 480,

                },
                legend: {
                    position: "bottom",
                },
            },
        }, ],
        legend: {
            labels: {
                colors: ["#a1aab2"],
            },
        },
    };
    var chart_pie_simple = new ApexCharts(
        document.querySelector("#chart-pie-simple1"),
        options_simple
    );
    chart_pie_simple.render();

}


var oilCanvas = document.getElementById("chart-pie-simple1");

Chart.defaults.global.defaultFontFamily = "Lato";
Chart.defaults.global.defaultFontSize = 18;

var oilData = {
    labels: [
        "Saudi Arabia",
        "Russia",
        "Iraq",
        "United Arab Emirates",
        "Canada"
    ],
    datasets: [
        {
            data: [133.3, 86.2, 52.2, 51.2, 50.2],
            backgroundColor: [
                "#FF6384",
                "#63FF84",
                "#84FF63",
                "#8463FF",
                "#6384FF"
            ]
        }]
};

var pieChart = new Chart(oilCanvas, {
  type: 'pie',
  data: oilData
});*/