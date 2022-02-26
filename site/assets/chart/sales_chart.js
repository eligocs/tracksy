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
                            startAngle: 180,
                            endAngle: 0,
                            min: 0,
                            max: 500000,
                            axisLine: {
                                lineStyle: {
                                    width: 25,
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
                            axisTick: {
                                show: false,
                                lineStyle: {
                                    color: '#re',
                                    width: 2
                                }
                            },
                            splitLine: {
                                show: false,
                                length: 30,
                                lineStyle: {
                                    color: '#fff',
                                    width: 4
                                }
                            },
                            axisLabel: {
                                color: 'auto',
                                distance: 0,
                                fontSize: 10
                            },
                            detail: {
                                valueAnimation: true,
                                offsetCenter: [0, '-20%'],
                                formatter: '{value} ₹ ',
                                color: 'auto'
                            },
                            center: ['40%', '50%'],
                            radius: ['40%', '100%'],
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