@extends('layouts.masterlayout')

@section('content')
{{--    Those who don't have access privilege to prepaid consumption and subs statistics, add here--}}
    {{--@if(Auth::user()->EmpId == "omc2020" || Auth::user()->EmpId == "E00664")--}}
        @if(!$userprivilege->dailyrevenue)
        <div>
            <h2 class="mt-4">TashiCell MIS Reports</h2>
            <div class="card mb-4">
                <div class="card-body">
                    TashiCell MIS Reports System provides the view of performance metrics and would serve as a business intelligence tool to display data visualizations.
                    It provides all the historical data and also real time data for some.
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <img src="{{asset("assets/img/logo.png")}}" height="20%" width="20%" class="rounded img-fluid" alt="TashiCell Logo">
                </div>
            </div>
        </div>
        @else
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            What's New? Most used TDA Data is now Available in Report Dashboard.<a class="alert-link" href="{{url('tda/tdadatausagetrend')}}"> Data Usage Trend</a>, <a class="alert-link" href="{{url('tda/tdamarketshare')}}">Market Share Analysis</a> and <a class="alert-link" href="{{url('tda/tdarechargesales')}}">Recharge Sales Analysis</a>
        </div>
        <ul class="nav" id="dashboard-day">
            <li class="nav-item" data-day="today">
                <a id="tod" class="nav-link" href="#">TODAY</a>
            </li>
            <li class="nav-item" data-day="yesterday">
                <a id="yes" class="nav-link disabled" href="#">YESTERDAY</a>
            </li>
        </ul>
        <div class="card mb-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-10">
                        <i class="fas fa-chart-bar mr-1"></i>
                        Prepaid Recharge (in Nu)  <span id="showdate">{{$passyesterdaysdata->date}}</span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row w-100">
                    <div class="col-md-2">
                        <div class="card border-info mx-sm-1 p-1">
                            <div class="text-info text-center">RCV</div>
                            <div class="text-info text-center" id="rcv-ajax">{{number_format($passyesterdaysdata->paper_voucher, 2)}}</div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card border-success mx-sm-1 p-1">
                            <div class="text-success text-center">ETopup</div>
                            <div class="text-success text-center" id="etopup-ajax">{{number_format($passyesterdaysdata->etopup,2)}}</div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card border-info mx-sm-1 p-1">
                            <div class="text-info text-center">MBoB</div>
                            <div class="text-info text-center" id="mbob-ajax">{{number_format($passyesterdaysdata->mbob,2)}}</div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card border-success mx-sm-1 p-1">
                            <div class="text-success text-center">TPay</div>
                            <div class="text-success text-center" id="tpay-ajax">{{number_format($passyesterdaysdata->tpay,2)}}</div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card border-info mx-sm-1 p-1">
                            <div class="text-info text-center">BNB</div>
                            <div class="text-info text-center" id="bnb-ajax">{{number_format($passyesterdaysdata->bnb,2)}}</div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card border-success mx-sm-1 p-1">
                            <div class="text-success text-center">BDB</div>
                            <div class="text-success text-center" id="bdb-ajax">{{number_format($passyesterdaysdata->bdb,2)}}</div>
                        </div>
                    </div>
                </div>
                <div class="row w-100 pt-3">
                    <div class="col-md-2">
                        <div class="card border-success mx-sm-1 p-1">
                            <div class="text-success text-center">MyTashicell</div>
                            <div class="text-success text-center" id="mytashicell-ajax">{{number_format($passyesterdaysdata->mytashicell,2)}}</div>
                        </div>
                    </div>
{{--                    <div class="col-md-2">--}}
{{--                        <div class="card border-info mx-sm-1 p-1">--}}
{{--                            <div class="text-info text-center">Web</div>--}}
{{--                            <div class="text-info text-center" id="web-ajax">{{number_format($passyesterdaysdata->web,2)}}</div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="col-md-2">
                        <div class="card border-info mx-sm-1 p-1">
                            <div class="text-info text-center">DPNB</div>
                            <div class="text-info text-center" id="pnb-ajax">{{number_format($passyesterdaysdata->pnb,2)}}</div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card border-success mx-sm-1 p-1">
                            <div class="text-success text-center">Sales & Order</div>
                            <div class="text-success text-center" id="salesandorder-ajax">{{number_format($passyesterdaysdata->sales_and_order,2)}}</div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card border-info mx-sm-1 p-1">
                            <div class="text-info text-center">eTeeru</div>
                            <div class="text-info text-center" id="eteeru-ajax">{{number_format($passyesterdaysdata->eteeru,2)}}</div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card border-success mx-sm-1 p-1">
                            <div class="text-success text-center">Digital Kidu</div>
                            <div class="text-success text-center" id="digital_kidu-ajax">{{isset($passyesterdaysdata->digital_kidu)?number_format($passyesterdaysdata->digital_kidu,2):0}}</div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card bg-light border-info mx-sm-1 p-1">
                            <div class="text-success text-center">Total Recharge</div>
                            <div class="text-success text-center" id="totalrecharge-ajax">{{number_format($passyesterdaysdata->total_recharge,2)}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-10">
                        <i class="fas fa-chart-bar mr-1"></i>
                        Consumption (in Nu) <span id="showdate">{{$passyesterdaysdata->date}}</span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row w-100">
                    <div class="col-md-2">
                        <div class="card border-info mx-sm-1 p-1">
                            <div class="text-info text-center">Onnet Voice</div>
                            <div class="text-info text-center" id="onnet-ajax">{{number_format($passyesterdaysdata->onnet_voice, 2)}}</div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card border-success mx-sm-1 p-1">
                            <div class="text-success text-center">Offnet Voice</div>
                            <div class="text-success text-center" id="offnet-ajax">{{number_format($passyesterdaysdata->offnet_voice,2)}}</div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card border-info mx-sm-1 p-1">
                            <div class="text-info text-center">International Voice</div>
                            <div class="text-info text-center" id="internationalvoice-ajax">{{number_format($passyesterdaysdata->international_voice,2)}}</div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card border-success mx-sm-1 p-1">
                            <div class="text-success text-center">SMS</div>
                            <div class="text-success text-center" id="sms-ajax">{{number_format($passyesterdaysdata->sms,2)}}</div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card border-info mx-sm-1 p-1">
                            <div class="text-info text-center">Validity Booster</div>
                            <div class="text-info text-center" id="validitybooster-ajax">{{number_format($passyesterdaysdata->validty_booster,2)}}</div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card border-success mx-sm-1 p-1">
                            <div class="text-success text-center">Data Plan</div>
                            <div class="text-success text-center" id="dataplan-ajax">{{number_format($passyesterdaysdata->data_plan,2)}}</div>
                        </div>
                    </div>
                </div>
                <div class="row w-100 pt-3">
                    <div class="col-md-2">
                        <div class="card border-success mx-sm-1 p-1">
                            <div class="text-success text-center">Data Pay Per Use</div>
                            <div class="text-success text-center" id="datapayperuse-ajax">{{number_format($passyesterdaysdata->data_pay_per_use,2)}}</div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card bg-light border-info mx-sm-1 p-1">
                            <div class="text-info text-center">Total Consumption</div>
                            <div class="text-info text-center" id="totalconsumption-ajax">{{number_format($passyesterdaysdata->total_comsumption,2)}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-10">
                        <i class="fas fa-chart-bar mr-1"></i>
                         Mobile Subscriber Statistics  <span id="showdate">{{$passyesterdaysdata->date}}</span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row w-100">
                    <div class="col-md-2">
                        <div class="card border-info mx-sm-1 p-1">
                            <div class="text-info text-center">Activated</div>
                            <div class="text-info text-center" id="subsactivated-ajax">{{number_format($passyesterdaysdata->subs_activated)}}</div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card border-success mx-sm-1 p-1">
                            <div class="text-success text-center">Deactivated</div>
                            <div class="text-success text-center" id="subsdeactivated-ajax">{{number_format($passyesterdaysdata->subs_deactivated)}}</div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card border-info mx-sm-1 p-1">
                            <div class="text-info text-center">Active CBS</div>
                            <div class="text-info text-center" id="cbsactive-ajax">{{number_format($passyesterdaysdata->active_subs_cbs)}}</div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card border-success mx-sm-1 p-1">
                            <div class="text-success text-center">Barred</div>
                            <div class="text-success text-center" id="subsbarred-ajax">{{number_format($passyesterdaysdata->subs_barred)}}</div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card border-info mx-sm-1 p-1">
                            <div class="text-info text-center">Suspended</div>
                            <div class="text-info text-center" id="subsuspended-ajax">{{number_format($passyesterdaysdata->subs_suspended)}}</div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card bg-light border-success mx-sm-1 p-1">
                            <div class="text-success text-center">Total Subscribers</div>
                            <div class="text-success text-center" id="totalsubs-ajax">{{number_format($passyesterdaysdata->total_subs)}}</div>
                        </div>
                    </div>
                </div>
                <div class="row w-100 pt-3">
                    <div class="col-md-2">
                        <div class="card border-success mx-sm-1 p-1">
                            <div class="text-success text-center">Total VLR</div>
                            <div class="text-success text-center" id="totalvlr-ajax">{{number_format($passyesterdaysdata->total_vlr_subs)}}</div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card border-info mx-sm-1 p-1">
                            <div class="text-info text-center">Powered On</div>
                            <div class="text-info text-center" id="poweredon-ajax">{{number_format($passyesterdaysdata->powered_on_subs)}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-10">
                        <i class="fas fa-chart-bar mr-1"></i>
                        Internet Leasedline  <span id="showdate">{{$passyesterdaysdata->date}}</span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row w-100 pt-3">
                    <div class="col-md-2">
                        <div class="card border-success mx-sm-1 p-1">
                            <div class="text-success text-center">New ILL</div>
                            <div class="text-success text-center" id="newill-ajax">{{number_format($passyesterdaysdata->new_leasedline_subs)}}</div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card bg-light border-info mx-sm-1 p-1">
                            <div class="text-info text-center">Total ILL</div>
                            <div class="text-info text-center" id="totalill-ajax">{{number_format($passyesterdaysdata->leasedline_subs)}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

