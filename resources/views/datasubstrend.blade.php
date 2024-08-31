@extends('layouts.masterlayout')

@section('content')
    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6">
                    <i class="fas fa-table mr-1"></i>
                    Normal Data Plan Subscriber
                </div>
                <div class="col-sm-3">
                    <input type="date" value="{{$todaysDate}}" min="2021-07-26" max="{{$todaysDate}}" name="DailyTrendDataSubscriber" id="DailyTrendDataSubscriber" style="float:right;width: 70%!important;" class="form-control form-control-sm input-xs"/>
                </div>
                {{--                <div class="col-sm-2">--}}
                {{--                    <button class="float-right btn-primary btn-xs" id="figure-download-xlsx"><i class="fas fa-file-download"></i></button>--}}
                {{--                    <button class="float-right btn-primary btn-xs hide" id="figureajax-download-xlsx"><i class="fas fa-file-download"></i></button>--}}
                {{--                </div>--}}
            </div>
        </div>
        <div class="card-body">
            <div id="data-subscriber-trend"></div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6">
                    <i class="fas fa-table mr-1"></i>
                    Student Data Plan Subscriber
                </div>
                <div class="col-sm-3">
                    <input type="date" value="{{$todaysDate}}" min="2021-07-26" max="{{$todaysDate}}" name="DailyTrendStudentDataPlanSubscriber" id="DailyTrendStudentDataPlanSubscriber" style="float:right;width: 70%!important;" class="form-control form-control-sm input-xs"/>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="studentdataplan-subscriber-trend"></div>
        </div>
    </div>
@endsection
@section('pagescripts')
    <script>
        $("#data-subscriber-trend").insertFusionCharts({
            type: "column3d",
            width: "100%",
            height: "400",
            // height: "100%",
            dataFormat: "json",
            dataSource: {
                chart: {
                    caption: "Normal Data Plan Subscriber",
                    showlabels: "1",
                    exportEnabled: "1",
                    theme: "zune",
                    showvalues: "1",
                    placevaluesinside: "0",
                    valuefontcolor: "#3b3838"
                },
                data: {!! json_encode($datasubscriber) !!}
            }
        });

        $("#studentdataplan-subscriber-trend").insertFusionCharts({
            type: "column3d",
            width: "100%",
            height: "400",
            // height: "100%",
            dataFormat: "json",
            dataSource: {
                chart: {
                    caption: "Student Data Plan Subscriber",
                    showlabels: "1",
                    exportEnabled: "1",
                    theme: "zune",
                    showvalues: "1",
                    placevaluesinside: "0",
                    valuefontcolor: "#3b3838"
                },
                data: {!! json_encode($studentdataplansubscriber) !!}
            }
        });
    </script>
@endsection

