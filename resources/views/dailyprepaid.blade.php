@extends('layouts.masterlayout')

@section('content')
    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-7">
                    <i class="fas fa-chart-bar mr-1"></i>
                    Prepaid Recharge Daily
                </div>
                <div class="col-sm-2">
                    <select class="form-control form-control-sm" style="float:right;width: 70%!important;" id="themechooserPrepaidDaily">
                        <option value="fusion">Fusion</option>
                        <option value="candy">Candy</option>
                        <option value="carbon">Carbon</option>
                        <option value="fint">Fint</option>
                        <option value="gammel">Gammel</option>
                        <option value="ocean">Ocean</option>
                        <option value="umber">Umber</option>
                        <option value="zune">Zune</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <input type="date" value="{{$todaysDate}}" min="2010-01-01" max="{{$todaysDate}}" name="DailyPrepaidRecharge" id="DailyPrepaidRecharge" style="float:right;width: 70%!important;" class="form-control form-control-sm input-xs"/>
                </div>
{{--                <div class="col-md-4" id="total-daily-prepaid"></div>--}}
            </div>
        </div>
        <div class="card-body" id="prepaid-chart-container">
            <div id="myChartRevenue"></div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-7">
                    <i class="fas fa-chart-bar mr-1"></i>
                    Total Prepaid Revenue Day Wise (Monthly) - Bar Chart
                </div>
                <div class="col-sm-2">
                    <select name="" class="form-control form-control-sm" style="float:right;width: 70%!important;" id="themechooserMonthlyRevenue">
                        <option value="ocean">Ocean</option>
                        <option value="fusion">Fusion</option>
                        <option value="carbon">Carbon</option>
                        <option value="fint">Fint</option>
                        <option value="umber">Umber</option>
                        <option value="zune">Zune</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <input type="month" value="{{$currentMonth}}" min="2010-01" max="{{$currentMonth}}" name="BarChartDailyRevenue" id="BarChartDailyRevenue" style="float:right;width: 70%!important;" class="form-control form-control-sm input-xs"/>
                </div>
            </div>
        </div>
        <div class="card-body" id="monthlyrevenue-chart-container">
            <div id="myBarChartDaily"></div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-7">
                    <i class="fas fa-chart-bar mr-1"></i>
                    Total Prepaid Revenue Day Wise (Monthly) - Line Chart
                </div>
                <div class="col-sm-2">
                    <select name="" class="form-control form-control-sm" style="float:right;width: 70%!important;" id="themechooserMonthlyRevenueLine">
                        <option value="fint">Fint</option>
                        <option value="fusion">Fusion</option>
                        <option value="candy">Candy</option>
                        <option value="gammel">Gammel</option>
                        <option value="umber">Umber</option>
                        <option value="zune">Zune</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <input type="month" value="{{$currentMonth}}" min="2010-01" max="{{$currentMonth}}" name="LineChartDailyRevenue" id="LineChartDailyRevenue" style="float:right;width: 70%!important;" class="form-control form-control-sm input-xs"/>
                </div>
            </div>
        </div>
        <div class="card-body" id="monthlyrevenue-linechart-container">
            <div id="myLineChartDaily"></div>
        </div>
    </div>
@stop


