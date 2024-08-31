@extends('layouts.masterlayout')

@section('content')
{{--    <div class="card mb-4">--}}
{{--        <div class="card-header">--}}
{{--            <div class="row">--}}
{{--                <div class="col-sm-7">--}}
{{--                    <i class="fas fa-chart-bar mr-1"></i>--}}
{{--                    Prepaid Channel Wise Daily Report (Monthly)--}}
{{--                </div>--}}
{{--                <div class="col-sm-2">--}}
{{--                    <select class="form-control form-control-sm" style="float:right;width: 70%!important;" id="themeChannelwiseMonthly">--}}
{{--                        <option value="fusion">Fusion</option>--}}
{{--                        <option value="candy">Candy</option>--}}
{{--                        <option value="ocean">Ocean</option>--}}
{{--                        <option value="umber">Umber</option>--}}
{{--                        <option value="zune">Zune</option>--}}
{{--                    </select>--}}
{{--                </div>--}}
{{--                <div class="col-sm-3">--}}
{{--                    <input type="month" value="{{$returnMonthly['currentMonth']}}" max="{{$returnMonthly['currentMonth']}}" min="2010-01" name="ChannelWiseDailyDate" id="ChannelWiseDailyDate" style="float:right;width: 70%!important;" class="form-control form-control-sm input-xs"/>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="card-body">--}}
{{--            <div id="channelWiseMonthly"></div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-10">
                    <i class="fas fa-chart-bar mr-1"></i>
                    Postpaid Channel Wise Quarterly Report
                </div>
                <div class="col-sm-2">
                    <select class="form-control form-control-sm" style="float:right;width: 70%!important;" id="themeChannelwisePostpaidQuarterly">
                        <option value="fusion">Fusion</option>
                        <option value="gammel">Gammel</option>
                        <option value="candy">Candy</option>
                        <option value="umber">Umber</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="channelWisePostpaidQuarterly"></div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-10">
                    <i class="fas fa-chart-bar mr-1"></i>
                    Postpaid Channel Wise Biannually Report
                </div>
                <div class="col-sm-2">
                    <select class="form-control form-control-sm" style="float:right;width: 70%!important;" id="themeChannelwisePostpaidBiannually">
                        <option value="fusion">Fusion</option>
                        <option value="gammel">Gammel</option>
                        <option value="candy">Candy</option>
                        <option value="umber">Umber</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="channelWisePostpaidBiannually"></div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-10">
                    <i class="fas fa-chart-bar mr-1"></i>
                    Postpaid Channel Wise Annually Report
                </div>
                <div class="col-sm-2">
                    <select class="form-control form-control-sm" style="float:right;width: 70%!important;" id="themeChannelwisePostpaidAnnually">
                        <option value="fusion">Fusion</option>s
                        <option value="gammel">Gammel</option>
                        <option value="candy">Candy</option>
                        <option value="umber">Umber</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="channelWisePostpaidAnnually"></div>
        </div>
    </div>

@endsection
@section('pagescripts')
    <script>
        {{--$("#channelWiseMonthly").insertFusionCharts({--}}
        {{--    type: "stackedcolumn2d",--}}
        {{--    width: "100%",--}}
        {{--    height: "400",--}}
        {{--    dataFormat: "json",--}}
        {{--    dataSource: {--}}
        {{--        chart: {--}}
        {{--            caption: "Prepaid Channel Wise Daily Report (Monthly)",--}}
        {{--            subCaption: "{{$returnMonthly['currentMonth']}}",--}}
        {{--            yaxisname: "Revenue",--}}
        {{--            "xAxisName": "Date",--}}
        {{--            flatscrollbars: "0",--}}
        {{--            scrollheight: "12",--}}
        {{--            numvisibleplot: "8",--}}
        {{--            plottooltext:--}}
        {{--                "<b>$dataValue</b> Revenue from $seriesName on $label",--}}
        {{--            theme: "fusion",--}}
        {{--            "exportEnabled": "1",--}}
        {{--            numberPrefix: "Nu.",--}}
        {{--        },--}}
        {{--        categories: [--}}
        {{--            {--}}
        {{--                category: {!! json_encode($returnMonthly['t_date']) !!}--}}
        {{--            }--}}
        {{--        ],--}}
        {{--        dataset: [--}}
        {{--            {--}}
        {{--                seriesname: "Paper Voucher",--}}
        {{--                data: {!! json_encode($returnMonthly['paper_voucher']) !!}--}}
        {{--            },--}}
        {{--            {--}}
        {{--                seriesname: "ETopup",--}}
        {{--                data: {!! json_encode($returnMonthly['etopup']) !!}--}}
        {{--            },--}}
        {{--            {--}}
        {{--                seriesname: "MBoB",--}}
        {{--                data: {!! json_encode($returnMonthly['mbob']) !!}--}}
        {{--            },--}}
        {{--            {--}}
        {{--                seriesname: "TPay",--}}
        {{--                data: {!! json_encode($returnMonthly['tpay']) !!}--}}
        {{--            },--}}
        {{--            {--}}
        {{--                seriesname: "BNB",--}}
        {{--                data: {!! json_encode($returnMonthly['bnb']) !!}--}}
        {{--            },--}}
        {{--            {--}}
        {{--                seriesname: "BDB",--}}
        {{--                data: {!! json_encode($returnMonthly['bdb']) !!}--}}
        {{--            },--}}
        {{--            {--}}
        {{--                seriesname: "MyTashicell",--}}
        {{--                data: {!! json_encode($returnMonthly['mytashicell']) !!}--}}
        {{--            },--}}
        {{--            {--}}
        {{--                seriesname: "Web",--}}
        {{--                data: {!! json_encode($returnMonthly['web']) !!},--}}
        {{--                color: "#a4ebb5"--}}
        {{--            },--}}
        {{--            {--}}
        {{--                seriesname: "Sales and Order",--}}
        {{--                data: {!! json_encode($returnMonthly['sales_and_order']) !!},--}}
        {{--                color: "#f120f5"--}}
        {{--            },--}}
        {{--            {--}}
        {{--                seriesname: "ETeeru",--}}
        {{--                data: {!! json_encode($returnMonthly['eteeru']) !!},--}}
        {{--                color: "#077fdb"--}}
        {{--            }--}}
        {{--        ]--}}
        {{--    }--}}
        {{--});--}}

            $("#channelWisePostpaidQuarterly").insertFusionCharts({
                type: "scrollstackedcolumn2d",
                width: "100%",
                height: "400",
                dataFormat: "json",
                dataSource: {
                    chart: {
                        caption: "Postpaid Channel Wise Quarterly Report",
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
                            seriesname: "CLIR Rental",
                            data: {!! json_encode($returnQuarterly['clir_rental']) !!}
                        },
                        {
                            seriesname: "CRBT",
                            data: {!! json_encode($returnQuarterly['crbt']) !!}
                        },
                        {
                            seriesname: "CUG Rental",
                            data: {!! json_encode($returnQuarterly['cug_rental']) !!}
                        },
                        {
                            seriesname: "Data Roaming",
                            data: {!! json_encode($returnQuarterly['data_roaming']) !!}
                        },
                        {
                            seriesname: "Data Streaming",
                            data: {!! json_encode($returnQuarterly['data_streaming']) !!}
                        },
                        {
                            seriesname: "Postpaid Service Rental",
                            data: {!! json_encode($returnQuarterly['postpaid_service_rental']) !!}
                        },
                        {
                            seriesname: "Samsung EMI Package",
                            data: {!! json_encode($returnQuarterly['samsung_emi_package']) !!}
                        },
                        {
                            seriesname: "SMS International",
                            data: {!! json_encode($returnQuarterly['sms_international']) !!},
                            color: "#a4ebb5"
                        },
                        {
                            seriesname: "SMS India",
                            data: {!! json_encode($returnQuarterly['sms_india']) !!},
                            color: "#f120f5"
                        },
                        {
                            seriesname: "SMS Offnet",
                            data: {!! json_encode($returnQuarterly['sms_offnet']) !!},
                            color: "#077fdb"
                        },
                        {
                            seriesname: "SMS Onnet",
                            data: {!! json_encode($returnQuarterly['sms_onnet']) !!},
                            color: "#e3a688"
                        },
                        {
                            seriesname: "SMS Premium",
                            data: {!! json_encode($returnQuarterly['sms_premium']) !!},
                            color: "#84e9f0"
                        },
                        {
                            seriesname: "SMS Roaming",
                            data: {!! json_encode($returnQuarterly['sms_roaming']) !!},
                            color: "#bfdec7"
                        },
                        {
                            seriesname: "Voice International",
                            data: {!! json_encode($returnQuarterly['voice_international']) !!},
                            color: "#a8e673"
                        },
                        {
                            seriesname: "Voice India",
                            data: {!! json_encode($returnQuarterly['voice_india']) !!},
                            color: "#f0de56"
                        },
                        {
                            seriesname: "Voice Offnet",
                            data: {!! json_encode($returnQuarterly['voice_offnet']) !!},
                            color: "#08967f"
                        },
                        {
                            seriesname: "Voice Onnet",
                            data: {!! json_encode($returnQuarterly['voice_onnet']) !!},
                            color: "#cfad04"
                        },
                        {
                            seriesname: "Voice Premium",
                            data: {!! json_encode($returnQuarterly['voice_premium']) !!},
                            color: "#9c4409"
                        },
                        {
                            seriesname: "Voice Roaming",
                            data: {!! json_encode($returnQuarterly['voice_roaming']) !!},
                            color: "#f54562"
                        },
                        {
                            seriesname: "Discount",
                            data: {!! json_encode($returnQuarterly['discount']) !!},
                            color: "#f5a6db"
                        },
                        {
                            seriesname: "Penalty",
                            data: {!! json_encode($returnQuarterly['penalty']) !!},
                            color: "#94b2f2"
                        },
                        {
                            seriesname: "PRI Service",
                            data: {!! json_encode($returnQuarterly['pri_service']) !!},
                            color: "#edcaeb"
                        },
                        {
                            seriesname: "PRI Penalty",
                            data: {!! json_encode($returnQuarterly['pri_penalty']) !!},
                            color: "#83b7eb"
                        },
                        {
                            seriesname: "Tax",
                            data: {!! json_encode($returnQuarterly['tax']) !!},
                            color: "#83d1f7"
                        }
                    ]
                }
            });

        $("#channelWisePostpaidBiannually").insertFusionCharts({
            type: "scrollstackedcolumn2d",
            width: "100%",
            height: "400",
            dataFormat: "json",
            dataSource: {
                chart: {
                    caption: "Postpaid Channel Wise Biannually Report",
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
                        seriesname: "CLIR Rental",
                        data: {!! json_encode($returnBiannually['clir_rental']) !!}
                    },
                    {
                        seriesname: "CRBT",
                        data: {!! json_encode($returnBiannually['crbt']) !!}
                    },
                    {
                        seriesname: "CUG Rental",
                        data: {!! json_encode($returnBiannually['cug_rental']) !!}
                    },
                    {
                        seriesname: "Data Roaming",
                        data: {!! json_encode($returnBiannually['data_roaming']) !!}
                    },
                    {
                        seriesname: "Data Streaming",
                        data: {!! json_encode($returnBiannually['data_streaming']) !!}
                    },
                    {
                        seriesname: "Postpaid Service Rental",
                        data: {!! json_encode($returnBiannually['postpaid_service_rental']) !!}
                    },
                    {
                        seriesname: "Samsung EMI Package",
                        data: {!! json_encode($returnBiannually['samsung_emi_package']) !!}
                    },
                    {
                        seriesname: "SMS International",
                        data: {!! json_encode($returnBiannually['sms_international']) !!},
                        color: "#a4ebb5"
                    },
                    {
                        seriesname: "SMS India",
                        data: {!! json_encode($returnBiannually['sms_india']) !!},
                        color: "#f120f5"
                    },
                    {
                        seriesname: "SMS Offnet",
                        data: {!! json_encode($returnBiannually['sms_offnet']) !!},
                        color: "#077fdb"
                    },
                    {
                        seriesname: "SMS Onnet",
                        data: {!! json_encode($returnBiannually['sms_onnet']) !!},
                        color: "#e3a688"
                    },
                    {
                        seriesname: "SMS Premium",
                        data: {!! json_encode($returnBiannually['sms_premium']) !!},
                        color: "#84e9f0"
                    },
                    {
                        seriesname: "SMS Roaming",
                        data: {!! json_encode($returnBiannually['sms_roaming']) !!},
                        color: "#bfdec7"
                    },
                    {
                        seriesname: "Voice International",
                        data: {!! json_encode($returnBiannually['voice_international']) !!},
                        color: "#a8e673"
                    },
                    {
                        seriesname: "Voice India",
                        data: {!! json_encode($returnBiannually['voice_india']) !!},
                        color: "#f0de56"
                    },
                    {
                        seriesname: "Voice Offnet",
                        data: {!! json_encode($returnBiannually['voice_offnet']) !!},
                        color: "#08967f"
                    },
                    {
                        seriesname: "Voice Onnet",
                        data: {!! json_encode($returnBiannually['voice_onnet']) !!},
                        color: "#cfad04"
                    },
                    {
                        seriesname: "Voice Premium",
                        data: {!! json_encode($returnBiannually['voice_premium']) !!},
                        color: "#9c4409"
                    },
                    {
                        seriesname: "Voice Roaming",
                        data: {!! json_encode($returnBiannually['voice_roaming']) !!},
                        color: "#f54562"
                    },
                    {
                        seriesname: "Discount",
                        data: {!! json_encode($returnBiannually['discount']) !!},
                        color: "#f5a6db"
                    },
                    {
                        seriesname: "Penalty",
                        data: {!! json_encode($returnBiannually['penalty']) !!},
                        color: "#94b2f2"
                    },
                    {
                        seriesname: "PRI Service",
                        data: {!! json_encode($returnBiannually['pri_service']) !!},
                        color: "#edcaeb"
                    },
                    {
                        seriesname: "PRI Penalty",
                        data: {!! json_encode($returnBiannually['pri_penalty']) !!},
                        color: "#83b7eb"
                    },
                    {
                        seriesname: "Tax",
                        data: {!! json_encode($returnBiannually['tax']) !!},
                        color: "#83d1f7"
                    }
                ]
            }
        });

        $("#channelWisePostpaidAnnually").insertFusionCharts({
            type: "scrollstackedcolumn2d",
            width: "100%",
            height: "400",
            dataFormat: "json",
            dataSource: {
                chart: {
                    caption: "Postpaid Channel Wise Annually Report",
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
                        seriesname: "CLIR Rental",
                        data: {!! json_encode($returnAnnually['clir_rental']) !!}
                    },
                    {
                        seriesname: "CRBT",
                        data: {!! json_encode($returnAnnually['crbt']) !!}
                    },
                    {
                        seriesname: "CUG Rental",
                        data: {!! json_encode($returnAnnually['cug_rental']) !!}
                    },
                    {
                        seriesname: "Data Roaming",
                        data: {!! json_encode($returnAnnually['data_roaming']) !!}
                    },
                    {
                        seriesname: "Data Streaming",
                        data: {!! json_encode($returnAnnually['data_streaming']) !!}
                    },
                    {
                        seriesname: "Postpaid Service Rental",
                        data: {!! json_encode($returnAnnually['postpaid_service_rental']) !!}
                    },
                    {
                        seriesname: "Samsung EMI Package",
                        data: {!! json_encode($returnAnnually['samsung_emi_package']) !!}
                    },
                    {
                        seriesname: "SMS International",
                        data: {!! json_encode($returnAnnually['sms_international']) !!},
                        color: "#a4ebb5"
                    },
                    {
                        seriesname: "SMS India",
                        data: {!! json_encode($returnAnnually['sms_india']) !!},
                        color: "#f120f5"
                    },
                    {
                        seriesname: "SMS Offnet",
                        data: {!! json_encode($returnAnnually['sms_offnet']) !!},
                        color: "#077fdb"
                    },
                    {
                        seriesname: "SMS Onnet",
                        data: {!! json_encode($returnAnnually['sms_onnet']) !!},
                        color: "#e3a688"
                    },
                    {
                        seriesname: "SMS Premium",
                        data: {!! json_encode($returnAnnually['sms_premium']) !!},
                        color: "#84e9f0"
                    },
                    {
                        seriesname: "SMS Roaming",
                        data: {!! json_encode($returnAnnually['sms_roaming']) !!},
                        color: "#bfdec7"
                    },
                    {
                        seriesname: "Voice International",
                        data: {!! json_encode($returnAnnually['voice_international']) !!},
                        color: "#a8e673"
                    },
                    {
                        seriesname: "Voice India",
                        data: {!! json_encode($returnAnnually['voice_india']) !!},
                        color: "#f0de56"
                    },
                    {
                        seriesname: "Voice Offnet",
                        data: {!! json_encode($returnAnnually['voice_offnet']) !!},
                        color: "#08967f"
                    },
                    {
                        seriesname: "Voice Onnet",
                        data: {!! json_encode($returnAnnually['voice_onnet']) !!},
                        color: "#cfad04"
                    },
                    {
                        seriesname: "Voice Premium",
                        data: {!! json_encode($returnAnnually['voice_premium']) !!},
                        color: "#9c4409"
                    },
                    {
                        seriesname: "Voice Roaming",
                        data: {!! json_encode($returnAnnually['voice_roaming']) !!},
                        color: "#f54562"
                    },
                    {
                        seriesname: "Discount",
                        data: {!! json_encode($returnAnnually['discount']) !!},
                        color: "#f5a6db"
                    },
                    {
                        seriesname: "Penalty",
                        data: {!! json_encode($returnAnnually['penalty']) !!},
                        color: "#94b2f2"
                    },
                    {
                        seriesname: "PRI Service",
                        data: {!! json_encode($returnAnnually['pri_service']) !!},
                        color: "#edcaeb"
                    },
                    {
                        seriesname: "PRI Penalty",
                        data: {!! json_encode($returnAnnually['pri_penalty']) !!},
                        color: "#83b7eb"
                    },
                    {
                        seriesname: "Tax",
                        data: {!! json_encode($returnAnnually['tax']) !!},
                        color: "#83d1f7"
                    }
                ]
            }
        });
    </script>
@endsection

