@extends('layouts.masterlayout')

@section('content')
    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-7">
                    <i class="fas fa-chart-bar mr-1"></i>
                    Consumption Channel Wise Daily Report (Monthly)
                </div>
                <div class="col-sm-2">
                    <select class="form-control form-control-sm" style="float:right;width: 70%!important;" id="themeChannelwiseConsumptionMonthly">
                        <option value="fusion">Fusion</option>
                        <option value="candy">Candy</option>
                        <option value="ocean">Ocean</option>
                        <option value="umber">Umber</option>
                        <option value="zune">Zune</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <input type="month" value="{{$returnMonthly['currentMonth']}}" max="{{$returnMonthly['currentMonth']}}" min="2010-01" name="ChannelWiseConsumptionDailyDate" id="ChannelWiseConsumptionDailyDate" style="float:right;width: 70%!important;" class="form-control form-control-sm input-xs"/>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="channelWiseConsumptionMonthly"></div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-10">
                    <i class="fas fa-chart-bar mr-1"></i>
                    Consumption Channel Wise Quarterly Report
                </div>
                <div class="col-sm-2">
                    <select class="form-control form-control-sm" style="float:right;width: 70%!important;" id="themeChannelwiseConsumptionQuarterly">
                        <option value="fusion">Fusion</option>
                        <option value="gammel">Gammel</option>
                        <option value="candy">Candy</option>
                        <option value="umber">Umber</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="channelWiseConsumptionQuarterly"></div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-10">
                    <i class="fas fa-chart-bar mr-1"></i>
                    Consumption Channel Wise Biannually Report
                </div>
                <div class="col-sm-2">
                    <select class="form-control form-control-sm" style="float:right;width: 70%!important;" id="themeChannelwiseConsumptionBiannually">
                        <option value="fusion">Fusion</option>
                        <option value="gammel">Gammel</option>
                        <option value="candy">Candy</option>
                        <option value="umber">Umber</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="channelWiseConsumptionBiannually"></div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-10">
                    <i class="fas fa-chart-bar mr-1"></i>
                    Consumption Channel Wise Annually Report
                </div>
                <div class="col-sm-2">
                    <select class="form-control form-control-sm" style="float:right;width: 70%!important;" id="themeChannelwiseConsumptionAnnually">
                        <option value="fusion">Fusion</option>
                        <option value="gammel">Gammel</option>
                        <option value="candy">Candy</option>
                        <option value="umber">Umber</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="channelWiseConsumptionAnnually"></div>
        </div>
    </div>
@endsection
@section('pagescripts')
    <script>
        $("#channelWiseConsumptionMonthly").insertFusionCharts({
            type: "stackedcolumn2d",
            width: "100%",
            height: "400",
            dataFormat: "json",
            dataSource: {
                chart: {
                    caption: "Consumption Channel Wise Daily Report (Monthly)",
                    subCaption: "{{$returnMonthly['currentMonth']}}",
                    yaxisname: "Revenue",
                    "xAxisName": "Date",
                    flatscrollbars: "0",
                    scrollheight: "12",
                    numvisibleplot: "8",
                    plottooltext:
                        "<b>$dataValue</b> Revenue from $seriesName on $label",
                    theme: "fusion",
                    "exportEnabled": "1",
                    numberPrefix: "Nu.",
                },
                categories: [
                    {
                        category: {!! json_encode($returnMonthly['t_date']) !!}
                    }
                ],
                dataset: [
                    {
                        seriesname: "Onnet Voices",
                        data: {!! json_encode($returnMonthly['onnet_voice']) !!}
                    },
                    {
                        seriesname: "Offnet Voice",
                        data: {!! json_encode($returnMonthly['offnet_voice']) !!}
                    },
                    {
                        seriesname: "International Voice",
                        data: {!! json_encode($returnMonthly['international_voice']) !!}
                    },
                    {
                        seriesname: "SMS",
                        data: {!! json_encode($returnMonthly['sms']) !!}
                    },
                    {
                        seriesname: "Validity Booster",
                        data: {!! json_encode($returnMonthly['validity_booster']) !!}
                    },
                    {
                        seriesname: "Data Plan",
                        data: {!! json_encode($returnMonthly['data_plan']) !!}
                    },
                    {
                        seriesname: "Data Pay Per Use",
                        data: {!! json_encode($returnMonthly['data_pay_per_use']) !!},
                        color: "#f120f5"
                    }
                ]
            }
        });

        $("#channelWiseConsumptionQuarterly").insertFusionCharts({
            type: "scrollstackedcolumn2d",
            width: "100%",
            height: "400",
            dataFormat: "json",
            dataSource: {
                chart: {
                    caption: "Consumption Channel Wise Quarterly Report",
                    yaxisname: "Revenue",
                    flatscrollbars: "0",
                    scrollheight: "12",
                    numvisibleplot: "8",
                    plottooltext:
                        "<b>$dataValue</b> Revenue from $seriesName in $label",
                    theme: "fusion",
                    "exportEnabled": "1",
                    numberPrefix: "Nu.",
                    scrollToEnd: 1
                },
                categories: [
                    {
                        category: {!! json_encode($returnQuarterly['category']) !!}
                    }
                ],
                dataset: [
                    {
                        seriesname: "Onnet Voices",
                        data: {!! json_encode($returnQuarterly['onnet_voice']) !!}
                    },
                    {
                        seriesname: "Offnet Voice",
                        data: {!! json_encode($returnQuarterly['offnet_voice']) !!}
                    },
                    {
                        seriesname: "International Voice",
                        data: {!! json_encode($returnQuarterly['international_voice']) !!}
                    },
                    {
                        seriesname: "SMS",
                        data: {!! json_encode($returnQuarterly['sms']) !!}
                    },
                    {
                        seriesname: "Validity Booster",
                        data: {!! json_encode($returnQuarterly['validity_booster']) !!}
                    },
                    {
                        seriesname: "Data Plan",
                        data: {!! json_encode($returnQuarterly['data_plan']) !!}
                    },
                    {
                        seriesname: "Data Pay Per Use",
                        data: {!! json_encode($returnQuarterly['data_pay_per_use']) !!},
                        color: "#f120f5"
                    }
                ]
            }
        });

        $("#channelWiseConsumptionBiannually").insertFusionCharts({
            type: "scrollstackedcolumn2d",
            width: "100%",
            height: "400",
            dataFormat: "json",
            dataSource: {
                chart: {
                    caption: "Consumption Channel Wise Biannually Report",
                    yaxisname: "Revenue",
                    flatscrollbars: "0",
                    scrollheight: "12",
                    numvisibleplot: "8",
                    plottooltext:
                        "<b>$dataValue</b> Revenue from $seriesName in $label",
                    theme: "fusion",
                    "exportEnabled": "1",
                    numberPrefix: "Nu.",
                    scrollToEnd: 1
                },
                categories: [
                    {
                        category: {!! json_encode($returnBiannually['category']) !!}
                    }
                ],
                dataset: [
                    {
                        seriesname: "Onnet Voices",
                        data: {!! json_encode($returnBiannually['onnet_voice']) !!}
                    },
                    {
                        seriesname: "Offnet Voice",
                        data: {!! json_encode($returnBiannually['offnet_voice']) !!}
                    },
                    {
                        seriesname: "International Voice",
                        data: {!! json_encode($returnBiannually['international_voice']) !!}
                    },
                    {
                        seriesname: "SMS",
                        data: {!! json_encode($returnBiannually['sms']) !!}
                    },
                    {
                        seriesname: "Validity Booster",
                        data: {!! json_encode($returnBiannually['validity_booster']) !!}
                    },
                    {
                        seriesname: "Data Plan",
                        data: {!! json_encode($returnBiannually['data_plan']) !!}
                    },
                    {
                        seriesname: "Data Pay Per Use",
                        data: {!! json_encode($returnBiannually['data_pay_per_use']) !!},
                        color: "#f120f5"
                    }
                ]
            }
        });

        $("#channelWiseConsumptionAnnually").insertFusionCharts({
            type: "scrollstackedcolumn2d",
            width: "100%",
            height: "400",
            dataFormat: "json",
            dataSource: {
                chart: {
                    caption: "Consumption Channel Wise Annually Report",
                    yaxisname: "Revenue",
                    flatscrollbars: "0",
                    scrollheight: "12",
                    numvisibleplot: "8",
                    plottooltext:
                        "<b>$dataValue</b> Revenue from $seriesName in $label",
                    theme: "fusion",
                    "exportEnabled": "1",
                    numberPrefix: "Nu.",
                    scrollToEnd: 1
                },
                categories: [
                    {
                        category: {!! json_encode($returnAnnually['category']) !!}
                    }
                ],
                dataset: [
                    {
                        seriesname: "Onnet Voices",
                        data: {!! json_encode($returnAnnually['onnet_voice']) !!}
                    },
                    {
                        seriesname: "Offnet Voice",
                        data: {!! json_encode($returnAnnually['offnet_voice']) !!}
                    },
                    {
                        seriesname: "International Voice",
                        data: {!! json_encode($returnAnnually['international_voice']) !!}
                    },
                    {
                        seriesname: "SMS",
                        data: {!! json_encode($returnAnnually['sms']) !!}
                    },
                    {
                        seriesname: "Validity Booster",
                        data: {!! json_encode($returnAnnually['validity_booster']) !!}
                    },
                    {
                        seriesname: "Data Plan",
                        data: {!! json_encode($returnAnnually['data_plan']) !!}
                    },
                    {
                        seriesname: "Data Pay Per Use",
                        data: {!! json_encode($returnAnnually['data_pay_per_use']) !!},
                        color: "#f120f5"
                    }
                ]
            }
        });
    </script>
@endsection

