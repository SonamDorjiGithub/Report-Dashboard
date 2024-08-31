@extends('layouts.masterlayout')

@section('content')
    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-7">
                    <i class="fas fa-chart-bar mr-1"></i>
                    Prepaid Channel Wise Daily Report (Monthly)
                </div>
                <div class="col-sm-2">
                    <select class="form-control form-control-sm" style="float:right;width: 70%!important;" id="themeChannelwiseMonthly">
                        <option value="fusion">Fusion</option>
                        <option value="candy">Candy</option>
                        <option value="ocean">Ocean</option>
                        <option value="umber">Umber</option>
                        <option value="zune">Zune</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <input type="month" value="{{$returnMonthly['currentMonth']}}" max="{{$returnMonthly['currentMonth']}}" min="2010-01" name="ChannelWiseDailyDate" id="ChannelWiseDailyDate" style="float:right;width: 70%!important;" class="form-control form-control-sm input-xs"/>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="channelWiseMonthly"></div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-10">
                    <i class="fas fa-chart-bar mr-1"></i>
                    Prepaid Channel Wise Quarterly Report
                </div>
                <div class="col-sm-2">
                    <select class="form-control form-control-sm" style="float:right;width: 70%!important;" id="themeChannelwiseQuarterly">
                        <option value="fusion">Fusion</option>
                        <option value="gammel">Gammel</option>
                        <option value="candy">Candy</option>
                        <option value="umber">Umber</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="channelWiseQuarterly"></div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-10">
                    <i class="fas fa-chart-bar mr-1"></i>
                    Prepaid Channel Wise Biannually Report
                </div>
                <div class="col-sm-2">
                    <select class="form-control form-control-sm" style="float:right;width: 70%!important;" id="themeChannelwiseBiannually">
                        <option value="fusion">Fusion</option>
                        <option value="gammel">Gammel</option>
                        <option value="candy">Candy</option>
                        <option value="umber">Umber</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="channelWiseBiannually"></div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-10">
                    <i class="fas fa-chart-bar mr-1"></i>
                    Prepaid Channel Wise Annually Report
                </div>
                <div class="col-sm-2">
                    <select class="form-control form-control-sm" style="float:right;width: 70%!important;" id="themeChannelwiseAnnually">
                        <option value="fusion">Fusion</option>s
                        <option value="gammel">Gammel</option>
                        <option value="candy">Candy</option>
                        <option value="umber">Umber</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="channelWiseAnnually"></div>
        </div>
    </div>

@endsection
@section('pagescripts')
    <script>
        $("#channelWiseMonthly").insertFusionCharts({
            type: "stackedcolumn2d",
            width: "100%",
            height: "400",
            dataFormat: "json",
            dataSource: {
                chart: {
                    caption: "Prepaid Channel Wise Daily Report (Monthly)",
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
                        seriesname: "Paper Voucher",
                        data: {!! json_encode($returnMonthly['paper_voucher']) !!}
                    },
                    {
                        seriesname: "ETopup",
                        data: {!! json_encode($returnMonthly['etopup']) !!}
                    },
                    {
                        seriesname: "MBoB",
                        data: {!! json_encode($returnMonthly['mbob']) !!}
                    },
                    {
                        seriesname: "TPay",
                        data: {!! json_encode($returnMonthly['tpay']) !!}
                    },
                    {
                        seriesname: "BNB",
                        data: {!! json_encode($returnMonthly['bnb']) !!}
                    },
                    {
                        seriesname: "BDB",
                        data: {!! json_encode($returnMonthly['bdb']) !!}
                    },
                    {
                        seriesname: "MyTashicell",
                        data: {!! json_encode($returnMonthly['mytashicell']) !!}
                    },
                    {
                        seriesname: "Web",
                        data: {!! json_encode($returnMonthly['web']) !!},
                        color: "#a4ebb5"
                    },
                    {
                        seriesname: "Sales and Order",
                        data: {!! json_encode($returnMonthly['sales_and_order']) !!},
                        color: "#f120f5"
                    },
                    {
                        seriesname: "ETeeru",
                        data: {!! json_encode($returnMonthly['eteeru']) !!},
                        color: "#077fdb"
                    },
                    {
                        seriesname: "Digital Kidu",
                        data: {!! json_encode($returnMonthly['digital_kidu']) !!},
                        color: "#f2e966"
                    },
                    {
                        seriesname: "DPNB",
                        data: {!! json_encode($returnMonthly['pnb']) !!},
                        color: "#5c8a96"
                    }
                ]
            }
        });

        $("#channelWiseQuarterly").insertFusionCharts({
            type: "scrollstackedcolumn2d",
            width: "100%",
            height: "400",
            dataFormat: "json",
            dataSource: {
                chart: {
                    caption: "Prepaid Channel Wise Quarterly Report",
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
                        seriesname: "Paper Voucher",
                        data: {!! json_encode($returnQuarterly['paper_voucher']) !!}
                    },
                    {
                        seriesname: "ETopup",
                        data: {!! json_encode($returnQuarterly['etopup']) !!}
                    },
                    {
                        seriesname: "MBoB",
                        data: {!! json_encode($returnQuarterly['mbob']) !!}
                    },
                    {
                        seriesname: "TPay",
                        data: {!! json_encode($returnQuarterly['tpay']) !!}
                    },
                    {
                        seriesname: "BNB",
                        data: {!! json_encode($returnQuarterly['bnb']) !!}
                    },
                    {
                        seriesname: "BDB",
                        data: {!! json_encode($returnQuarterly['bdb']) !!}
                    },
                    {
                        seriesname: "MyTashicell",
                        data: {!! json_encode($returnQuarterly['mytashicell']) !!}
                    },
                    {
                        seriesname: "Web",
                        data: {!! json_encode($returnQuarterly['web']) !!},
                        color: "#a4ebb5"
                    },
                    {
                        seriesname: "Sales and Order",
                        data: {!! json_encode($returnQuarterly['sales_and_order']) !!},
                        color: "#f120f5"
                    },
                    {
                        seriesname: "ETeeru",
                        data: {!! json_encode($returnQuarterly['eteeru']) !!},
                        color: "#077fdb"
                    },
                    {
                        seriesname: "Digital Kidu",
                        data: {!! json_encode($returnQuarterly['digital_kidu']) !!},
                        color: "#f2e966"
                    },
                    {
                        seriesname: "DPNB",
                        data: {!! json_encode($returnMonthly['pnb']) !!},
                        color: "#5c8a96"
                    }
                ]
            }
        });

        $("#channelWiseBiannually").insertFusionCharts({
            type: "scrollstackedcolumn2d",
            width: "100%",
            height: "400",
            dataFormat: "json",
            dataSource: {
                chart: {
                    caption: "Prepaid Channel Wise Biannually Report",
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
                        seriesname: "Paper Voucher",
                        data: {!! json_encode($returnBiannually['paper_voucher']) !!}
                    },
                    {
                        seriesname: "ETopup",
                        data: {!! json_encode($returnBiannually['etopup']) !!}
                    },
                    {
                        seriesname: "MBoB",
                        data: {!! json_encode($returnBiannually['mbob']) !!}
                    },
                    {
                        seriesname: "TPay",
                        data: {!! json_encode($returnBiannually['tpay']) !!}
                    },
                    {
                        seriesname: "BNB",
                        data: {!! json_encode($returnBiannually['bnb']) !!}
                    },
                    {
                        seriesname: "BDB",
                        data: {!! json_encode($returnBiannually['bdb']) !!}
                    },
                    {
                        seriesname: "MyTashicell",
                        data: {!! json_encode($returnBiannually['mytashicell']) !!}
                    },
                    {
                        seriesname: "Web",
                        data: {!! json_encode($returnBiannually['web']) !!},
                        color: "#a4ebb5"
                    },
                    {
                        seriesname: "Sales and Order",
                        data: {!! json_encode($returnBiannually['sales_and_order']) !!},
                        color: "#f120f5"
                    },
                    {
                        seriesname: "ETeeru",
                        data: {!! json_encode($returnBiannually['eteeru']) !!},
                        color: "#077fdb"
                    },
                    {
                        seriesname: "Digital Kidu",
                        data: {!! json_encode($returnBiannually['digital_kidu']) !!},
                        color: "#f2e966"
                    },
                    {
                        seriesname: "DPNB",
                        data: {!! json_encode($returnMonthly['pnb']) !!},
                        color: "#5c8a96"
                    }
                ]
            }
        });

        $("#channelWiseAnnually").insertFusionCharts({
            type: "scrollstackedcolumn2d",
            width: "100%",
            height: "400",
            dataFormat: "json",
            dataSource: {
                chart: {
                    caption: "Prepaid Channel Wise Annually Report",
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
                        seriesname: "Paper Voucher",
                        data: {!! json_encode($returnAnnually['paper_voucher']) !!}
                    },
                    {
                        seriesname: "ETopup",
                        data: {!! json_encode($returnAnnually['etopup']) !!}
                    },
                    {
                        seriesname: "MBoB",
                        data: {!! json_encode($returnAnnually['mbob']) !!}
                    },
                    {
                        seriesname: "TPay",
                        data: {!! json_encode($returnAnnually['tpay']) !!}
                    },
                    {
                        seriesname: "BNB",
                        data: {!! json_encode($returnAnnually['bnb']) !!}
                    },
                    {
                        seriesname: "BDB",
                        data: {!! json_encode($returnAnnually['bdb']) !!}
                    },
                    {
                        seriesname: "MyTashicell",
                        data: {!! json_encode($returnAnnually['mytashicell']) !!}
                    },
                    {
                        seriesname: "Web",
                        data: {!! json_encode($returnAnnually['web']) !!},
                        color: "#a4ebb5"
                    },
                    {
                        seriesname: "Sales and Order",
                        data: {!! json_encode($returnAnnually['sales_and_order']) !!},
                        color: "#f120f5"
                    },
                    {
                        seriesname: "ETeeru",
                        data: {!! json_encode($returnAnnually['eteeru']) !!},
                        color: "#077fdb"
                    },
                    {
                        seriesname: "Digital Kidu",
                        data: {!! json_encode($returnAnnually['digital_kidu']) !!},
                        color: "#f2e966"
                    },
                    {
                        seriesname: "DPNB",
                        data: {!! json_encode($returnMonthly['pnb']) !!},
                        color: "#5c8a96"
                    }
                ]
            }
        });
    </script>
@endsection

