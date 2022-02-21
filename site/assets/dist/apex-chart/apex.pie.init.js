$(document).ready(function() {
    // hm_iti_bar_chart()
    // console.log("jkkkk");
    //Iti Year change to load chart
    // $(".daterangelead").click(function(e) {
    //     e.preventDefault();
    //     alert("dsfkljdsf");
    //     console.log(date);

    // });


    var BASE_URL = $("#base_url").val();
    $.ajax({
        url: BASE_URL + "dashboard/leadsFilter",
        method: "POST",
        dataType: 'json',
        data: { date: 1 },
        success: function(data) {
            console.log(data);
        },
        error: function(e) {

            console.log("err");
        }

    })

});


$(function() {
    // Simple Pie Chart -------> PIE CHART
    var options_simple = {
        series: [44, 55, 13, 43, 22],
        chart: {
            fontFamily: '"Nunito Sans", sans-serif',
            width: 380,
            type: "pie",
        },
        colors: ["#2962ff", "#6993ff", "#ee9d01", "#f64e60", "#adb5bd"],
        labels: ["Team A", "Team B", "Team C", "Team D", "Team E"],
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200,
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
        document.querySelector("#chart-pie-simple"),
        options_simple
    );
    chart_pie_simple.render();



    $(".daterangelead").daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            },
            autoUpdateInput: false,
            showDropdowns: true,
            minDate: new Date(2016, 10 - 1, 25),
            //singleDatePicker: true,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Tomorrow': [moment().add(1, 'days'), moment().add(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                    .endOf('month')
                ]
            },
        },
        function(start, end, label) {
            $('.daterangelead').val(start.format('D MMMM, YYYY') + ' to ' + end.format('D MMMM, YYYY'));
            $("#date_from").attr("data-date_from", start.format('YYYY-MM-DD'));
            $("#date_to").attr("data-date_to", end.format('YYYY-MM-DD'));
            $("#todayStatus").val("");
            // console.log("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format(
            //     'YYYY-MM-DD'));
        });
});