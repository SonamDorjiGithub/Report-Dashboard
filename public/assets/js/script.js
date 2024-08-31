var script = function() {
    function renderDailyPrepaidChart(date, theme){
        if(date != ''){
            $.ajax({
                type: "POST",
                dataType: "JSON",
                data: {datePrepaid: date},
                url: "/fetchdailyprepaid",
                success: function(responseData){
                    // $("#total-daily-prepaid").html("<strong>&nbsp;&nbsp;Daily Total:</strong> Nu. "+responseData.totalDailyPrepaidFormatted);
                    const chartData = responseData.dataArray;
                    const chartConfigs = {
                        type: "doughnut3d",
                        width: "100%",
                        height: "350",
                        dataFormat: "json",
                        dataSource: {
                            "chart": {
                                "caption": "Daily Prepaid Recharge",
                                "subCaption": "Daily Total on "+date+": Nu."+responseData.totalDailyPrepaidFormatted,
                                "numberPrefix": "Nu.",
                                "theme": theme,
                                "exportEnabled": "1",
                            },
                            "data": chartData
                        }
                    }
                    $("#myChartRevenue").insertFusionCharts(chartConfigs);
                }
            });
        }
    }

    function renderMonthlyRevenueChart(monthyear, theme){
        if(monthyear != ''){
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "/fetchmonthlyrevenue",
                data: {monthYear: monthyear},
                success: function(responseData) {
                    const chartData = responseData.dataArray;
                    const chartConfigs = {
                        type: "column2d",
                        width: "100%",
                        height: "400",
                        dataFormat: "json",
                        dataSource: {
                            "chart": {
                                "caption": "Total Prepaid Revenue Day Wise (Monthly)",
                                "subCaption": monthyear+"<br\>Total: Nu."+responseData.totalMonthly,
                                "xAxisName": "Date",
                                "yAxisName": "Total Daily Prepaid Revenue",
                                "numberPrefix":"Nu. ",
                                "theme": theme,
                                "exportEnabled": "1",
                                "labeldisplay": "AUTO",
                            },
                            "data": chartData
                        }
                    }
                    $("#myBarChartDaily").insertFusionCharts(chartConfigs);
                }
            });
        }
    }

    function renderMonthlyRevenueLineChart(monthyear, theme){
        if(monthyear != ''){
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "/fetchmonthlyrevenue",
                data: {monthYear: monthyear},
                success: function(responseData) {
                    const chartData = responseData.dataArray;
                    const chartConfigs = {
                        type: "line",
                        width: "100%",
                        height: "350",
                        dataFormat: "json",
                        dataSource: {
                            chart: {
                                "caption": "Total Prepaid Revenue Day Wise (Monthly)",
                                "subCaption": monthyear+"<br\>Total: Nu."+responseData.totalMonthly,
                                xAxisName: "Date",
                                yAxisName: "Total Daily Prepaid Revenue",
                                // numberprefix: "Nu.",
                                rotatelabels: "1",
                                setadaptiveymin: "1",
                                theme: theme,
                                exportEnabled: "1",
                                lineThickness: "4",
                            },
                            data: chartData
                        }
                    }
                    $("#myLineChartDaily").insertFusionCharts(chartConfigs);
                }
            });
        }
    }

    function renderDailyChannelWiseChart(monthyear, theme){
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "/fetchchannelwisemonthly",
                data: {monthYear: monthyear},
                success: function(responseData) {
                    $("#channelWiseMonthly").insertFusionCharts({
                        type: "stackedcolumn2d",
                        width: "100%",
                        height: "400",
                        dataFormat: "json",
                        dataSource: {
                            chart: {
                                caption: "Prepaid Channel Wise Daily Report (Monthly)",
                                "subCaption": monthyear,
                                yaxisname: "Revenue",
                                "xAxisName": "Date",
                                flatscrollbars: "0",
                                scrollheight: "12",
                                numvisibleplot: "8",
                                plottooltext:
                                    "<b>$dataValue</b> Revenue from $seriesName on $label",
                                theme: theme,
                                exportEnabled: "1",
                                numberPrefix: "Nu.",
                            },
                            categories: [
                                {
                                    category: responseData.t_date
                                }
                            ],
                            dataset: [
                                {
                                    seriesname: "Paper Voucher",
                                    data: responseData.paper_voucher
                                },
                                {
                                    seriesname: "ETopup",
                                    data: responseData.etopup
                                },
                                {
                                    seriesname: "MBoB",
                                    data: responseData.mbob
                                },
                                {
                                    seriesname: "TPay",
                                    data: responseData.tpay
                                },
                                {
                                    seriesname: "BNB",
                                    data: responseData.bnb
                                },
                                {
                                    seriesname: "BDB",
                                    data: responseData.bdb
                                },
                                {
                                    seriesname: "MyTashicell",
                                    data: responseData.mytashicell
                                },
                                {
                                    seriesname: "Web",
                                    data: responseData.web,
                                    color: "#a4ebb5"
                                },
                                {
                                    seriesname: "Sales and Order",
                                    data: responseData.sales_and_order,
                                    color: "#f120f5"
                                },
                                {
                                    seriesname: "ETeeru",
                                    data: responseData.eteeru,
                                    color: "#077fdb"
                                },
                                {
                                    seriesname: "Digital Kidu",
                                    data: responseData.digital_kidu,
                                    color: "#f2e966"
                                },
                                {
                                    seriesname: "DPNB",
                                    data: responseData.pnb,
                                    color: "#5c8a96"
                                }
                            ]
                        }
                    });
                }
            });
    }

    function renderDailyChannelWiseConsumptionChart(monthyear, theme){
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "/fetchchannelwiseconsumptionmonthly",
            data: {monthYear: monthyear},
            success: function(responseData) {
                $("#channelWiseConsumptionMonthly").insertFusionCharts({
                    type: "stackedcolumn2d",
                    width: "100%",
                    height: "400",
                    dataFormat: "json",
                    dataSource: {
                        chart: {
                            caption: "Consumption Channel Wise Daily Report (Monthly)",
                            "subCaption": monthyear,
                            yaxisname: "Revenue",
                            "xAxisName": "Date",
                            flatscrollbars: "0",
                            scrollheight: "12",
                            numvisibleplot: "8",
                            plottooltext:
                                "<b>$dataValue</b> Revenue from $seriesName on $label",
                            theme: theme,
                            exportEnabled: "1",
                            numberPrefix: "Nu.",
                        },
                        categories: [
                            {
                                category: responseData.t_date
                            }
                        ],
                        dataset: [
                            {
                                seriesname: "Onnet Voices",
                                data: responseData.onnet_voice
                            },
                            {
                                seriesname: "Offnet Voice",
                                data: responseData.offnet_voice
                            },
                            {
                                seriesname: "International Voice",
                                data: responseData.international_voice
                            },
                            {
                                seriesname: "SMS",
                                data: responseData.sms
                            },
                            {
                                seriesname: "Validity Booster",
                                data: responseData.validity_booster
                            },
                            {
                                seriesname: "Data Plan",
                                data: responseData.data_plan
                            },
                            {
                                seriesname: "Data Pay Per Use",
                                data: responseData.data_pay_per_use,
                                color: "#f120f5"
                            }
                        ]
                    }
                });
            }
        });
    }

    return {
        Initialize: initialize,
        RenderMonthlyRevenueChart: renderMonthlyRevenueChart,
        RenderMonthlyRevenueLineChart: renderMonthlyRevenueLineChart,
        RenderDailyPrepaidChart: renderDailyPrepaidChart,
        RenderDailyConsumptionChart: renderDailyConsumptionChart,
        RenderMonthlyConsumptionChart: renderMonthlyConsumptionChart,
        RenderMonthlyConsumptionLineChart: renderMonthlyConsumptionLineChart
    }
}();
$(document).ready(function(){
    script.Initialize();
    FusionCharts.ready(function(){
        if($("#myBarChartDaily").length > 0){
            var todaysDate = $("#DailyPrepaidRecharge").val(); //Fetch from view
            var todaysMonth = $("#BarChartDailyRevenue").val();

            script.RenderMonthlyRevenueChart(todaysMonth, 'ocean');
            script.RenderMonthlyRevenueLineChart(todaysMonth, 'fint');
            script.RenderDailyPrepaidChart(todaysDate, 'fusion');
        }
        if($("#myConsumptionChart").length > 0){
            var todaysDate = $("#DailyConsumption").val(); //Fetch from view
            var todaysMonth = $("#BarChartDailyConsumption").val();

            script.RenderMonthlyConsumptionChart(todaysMonth, 'ocean');
            script.RenderMonthlyConsumptionLineChart(todaysMonth, 'fint');
            script.RenderDailyConsumptionChart(todaysDate, 'fusion');
        }
    });
});


