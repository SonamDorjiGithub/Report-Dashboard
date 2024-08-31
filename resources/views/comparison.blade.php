@extends('layouts.masterlayout')

@section('content')
    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-10">
                    <i class="fas fa-chart-bar mr-1"></i>
                    Yearly Prepaid Comparison Report (Month Wise)
                </div>
                <div class="col-sm-2">
                    <select class="form-control form-control-sm" style="float:right;width: 70%!important;" id="themechooserComparisonMonthly">
                        <option value="fint">Fint</option>
                        <option value="fusion">Fusion</option>
                        <option value="candy">Candy</option>
                        <option value="gammel">Gammel</option>
                        <option value="umber">Umber</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="comparisonMonthlyFusion"></div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-10">
                    <i class="fas fa-chart-bar mr-1"></i>
                    Yearly Prepaid Comparison Report (Quarter Wise)
                </div>
                <div class="col-sm-2">
                    <select class="form-control form-control-sm" style="float:right;width: 70%!important;" id="themechooserComparisonQuarterly">
                        <option value="fint">Fint</option>
                        <option value="fusion">Fusion</option>
                        <option value="candy">Candy</option>
                        <option value="gammel">Gammel</option>
                        <option value="umber">Umber</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="comparisonQuarterly"></div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-10">
                    <i class="fas fa-chart-bar mr-1"></i>
                    Yearly Prepaid Comparison Report (Biannual Wise)
                </div>
                <div class="col-sm-2">
                    <select class="form-control form-control-sm" style="float:right;width: 70%!important;" id="themechooserComparisonBiannually">
                        <option value="fint">Fint</option>
                        <option value="fusion">Fusion</option>
                        <option value="candy">Candy</option>
                        <option value="gammel">Gammel</option>
                        <option value="umber">Umber</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="comparisonBiannually"></div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-10">
                    <i class="fas fa-chart-bar mr-1"></i>
                    Yearly Prepaid Total
                </div>
                <div class="col-sm-2">
                    <select class="form-control form-control-sm" style="float:right;width: 70%!important;" id="themechooserComparisonAnnually">
                        <option value="fint">Fint</option>
                        <option value="fusion">Fusion</option>
                        <option value="candy">Candy</option>
                        <option value="gammel">Gammel</option>
                        <option value="umber">Umber</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="comparisonAnnuallyLine"></div>
        </div>
    </div>
@endsection
@section('pagescripts')
    <script>
        $("#comparisonMonthlyFusion").insertFusionCharts({
            type: "msline",
            width: "100%",
            height: "400",
            dataFormat: "json",
            dataSource: {
                chart: {
                    caption: "Yearly Prepaid Comparison Report (Month Wise)",
                    yaxisname: "Revenue",
                    showhovereffect: "1",
                    // numberPrefix: "Nu.",
                    // numbersuffix: "%",
                    drawcrossline: "1",
                    plottooltext: "<b>$dataValue</b> in $seriesName",
                    theme: "fint",
                    exportEnabled: "1",
                },
                categories: [
                    {
                        category: [
                            {
                                label: "Jan"
                            },
                            {
                                label: "Feb"
                            },
                            {
                                label: "Mar"
                            },
                            {
                                label: "Apr"
                            },
                            {
                                label: "May"
                            },
                            {
                                label: "Jun"
                            },
                            {
                                label: "July"
                            },
                            {
                                label: "Aug"
                            },
                            {
                                label: "Sep"
                            },
                            {
                                label: "Oct"
                            },
                            {
                                label: "Nov"
                            },
                            {
                                label: "Dec"
                            }
                        ]
                    }
                ],
                dataset: {!! json_encode($monthly) !!}
            }
        });

        $("#comparisonQuarterly").insertFusionCharts({
            type: "msline",
            width: "100%",
            height: "400",
            dataFormat: "json",
            dataSource: {
                chart: {
                    caption: "Yearly Prepaid Comparison Report (Quarter Wise)",
                    yaxisname: "Revenue",
                    // subcaption: "2012-2016",
                    showhovereffect: "1",
                    // numbersuffix: "%",
                    // numberPrefix: "Nu.",
                    drawcrossline: "1",
                    plottooltext: "<b>$dataValue</b> in $seriesName",
                    theme: "fint",
                    exportEnabled: "1",
                },
                categories: [
                    {
                        category: [
                            {
                                label: "Q1"
                            },
                            {
                                label: "Q2"
                            },
                            {
                                label: "Q3"
                            },
                            {
                                label: "Q4"
                            }
                        ]
                    }
                ],
                dataset: {!! json_encode($quarterly) !!}
            }
        });

        $("#comparisonBiannually").insertFusionCharts({
            type: "msline",
            width: "100%",
            height: "400",
            dataFormat: "json",
            dataSource: {
                chart: {
                    caption: "Yearly Prepaid Comparison Report (Biannual Wise)",
                    yaxisname: "Revenue",
                    showhovereffect: "1",
                    // numberPrefix: "Nu.",
                    drawcrossline: "1",
                    plottooltext: "<b>$dataValue</b> in $seriesName",
                    theme: "fint",
                    exportEnabled: "1",
                },
                categories: [
                    {
                        category: [
                            {
                                label: "H1"
                            },
                            {
                                label: "H2"
                            }
                        ]
                    }
                ],
                dataset: {!! json_encode($biannually) !!}
            }
        });

        $("#comparisonAnnuallyLine").insertFusionCharts({
            type: "line",
            width: "100%",
            height: "350",
            dataFormat: "json",
            dataSource: {
                chart: {
                    caption: "Yearly Prepaid Total",
                    yaxisname: "Revenue",
                    // numberprefix: "Nu.",
                    rotatelabels: "1",
                    setadaptiveymin: "1",
                    theme: "fint",
                    exportEnabled: "1",
                    lineThickness: "4",
                    anchorBgColor: "#05f545",
                    anchorRadius: "5",
                },
                data: {!!json_encode($yearly)!!}
            }
        });
    </script>
@endsection
