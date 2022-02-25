jQuery(document).ready(function($) {
    agentTOtalSales();

    function agentTOtalSales() {
        var selectedDate = $('#leadsDate').val();
        var BASE_URL = $("#base_url").val();
        $.ajax({
            url: BASE_URL + "dashboard/agentSalesThisMonth",
            method: "POST",
            dataType: 'json',
            data: { selectedDate: selectedDate },
            success: function(res) {
                // console.log(res.totalsale);
                //init chart
                var myChart = echarts.init(document.getElementById('gauge'));
                var idx = 1;
                pieChartOption = {
                    timeline: {
                        show: false,
                        data: [
                            '2013-07-01',
                        ],
                    },

                    options: [{
                        series: [{
                            type: 'gauge',
                            min: 0,
                            max: 1000000,
                            axisLine: {
                                lineStyle: {
                                    width: 10,
                                    color: [
                                        [0.3, 'red'],
                                        [0.7, 'Cyan'],
                                        [1, 'green']
                                    ]
                                }
                            },
                            pointer: {
                                itemStyle: {
                                    color: 'auto'
                                }
                            },
                            // axisTick: {
                            //     distance: -30,
                            //     length: 8,
                            //     lineStyle: {
                            //         color: '#re',
                            //         width: 2
                            //     }
                            // },
                            splitLine: {
                                distance: -30,
                                length: 30,
                                lineStyle: {
                                    color: '#fff',
                                    width: 4
                                }
                            },
                            axisLabel: {
                                color: 'auto',
                                distance: 0,
                                fontSize: 20
                            },
                            detail: {
                                valueAnimation: true,
                                formatter: '{value} ',
                                color: 'auto'
                            },
                            center: ['50%', '60%'],
                            radius: ['5%', '100%'],
                            data: [
                                { value: res.totalsale }
                            ],
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