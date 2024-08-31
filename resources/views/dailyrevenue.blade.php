@extends('layouts.masterlayout')

@section('content')
    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-10">
                    <i class="fas fa-table mr-1"></i>
                    Daily Revenue Report
                </div>
                <div class="col-sm-2">
                    <button class="float-right btn-primary btn-xs" id="bothprepaidconsumption-download-xlsx"><i class="fas fa-file-download"></i></button>
                    <button class="float-right btn-primary btn-xs hide" id="bothprepaidconsumptionajax-download-xlsx"><i class="fas fa-file-download"></i></button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" role="tablist">
                @foreach($yearall as $year)
                    <li class="nav-item">
                        <a class="nav-link @if($year->t_year == $currentyear){{"active"}}@endif" data-toggle="tab" href="#year{{$year->t_year}}">{{$year->t_year}}</a>
                    </li>
                @endforeach
            </ul>

            <!-- Tab panes -->
            <div class="tab-content" id="bothprepaidconsumptionmonthlytab">
                @foreach($yearall as $year)
                    <div id="year{{$year->t_year}}" data-year="{{$year->t_year}}" class="container tab-pane @if($year->t_year == $currentyear){{"active"}}@else{{"fade"}}@endif">
                        <ul class="nav">
                            @if($year->t_year == $currentyear)
                                @foreach($currentyearsmonth as $month)
                                    <li class="nav-item" data-month="{{$month->t_month}}">
                                        <a class="nav-link @if($month->t_month == $currentmonth){{"disabled"}}@endif" href="#">{{$month->t_month}}</a>
                                    </li>
                                @endforeach
                            @else
                                <li class="nav-item" data-month="JAN">
                                    <a class="nav-link" href="#">JAN</a>
                                </li>
                                <li class="nav-item" data-month="FEB">
                                    <a class="nav-link" href="#">FEB</a>
                                </li>
                                <li class="nav-item" data-month="MAR">
                                    <a class="nav-link" href="#">MAR</a>
                                </li>
                                <li class="nav-item" data-month="APR">
                                    <a class="nav-link" href="#">APR</a>
                                </li>
                                <li class="nav-item" data-month="MAY">
                                    <a class="nav-link" href="#">MAY</a>
                                </li>
                                <li class="nav-item" data-month="JUN">
                                    <a class="nav-link" href="#">JUN</a>
                                </li>
                                <li class="nav-item" data-month="JUL">
                                    <a class="nav-link" href="#">JUL</a>
                                </li>
                                <li class="nav-item" data-month="AUG">
                                    <a class="nav-link" href="#">AUG</a>
                                </li>
                                <li class="nav-item" data-month="SEP">
                                    <a class="nav-link" href="#">SEP</a>
                                </li>
                                <li class="nav-item" data-month="OCT">
                                    <a class="nav-link" href="#">OCT</a>
                                </li>
                                <li class="nav-item" data-month="NOV">
                                    <a class="nav-link" href="#">NOV</a>
                                </li>
                                <li class="nav-item" data-month="DEC">
                                    <a class="nav-link" href="#">DEC</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                @endforeach
            </div>
            <div id="bothprepaidconsumption-table"></div>
        </div>
    </div>
@endsection
@section('pagescripts')
    <script>
        //define custom mutator
        var customMutator = function(value){
            if(value == null){
                return 'NA';
            }
            else{
                return parseFloat(value).toLocaleString('en-US', { minimumFractionDigits: 2 })
            }
        }

        var table = new Tabulator("#bothprepaidconsumption-table", {
            height:"400px",
            virtualDomBuffer:150, //how much to load data in buffer. It determines the column size of total field
            layoutColumnsOnNewData:true,
            columnVertAlign: "center",
            data:{!! json_encode($tablebothprepaidconsumption) !!},
            columns:[
                {title:"Date", field:"date", frozen:true, sorter:"number", headerSort:false}, //frozen column
                {
                title:"Recharge",
                columns: [
                    {title:"RCV", field:"paper_voucher", hozAlign:"center", mutator:customMutator, headerSort:false},
                    {title:"RCV Tax", field:"paper_voucher_tax", hozAlign:"center", mutator:customMutator, headerSort:false, visible: false},
                    {title:"ETopup", field:"etopup", hozAlign:"center", mutator:customMutator, headerSort:false},
                    {title:"ETopup Tax", field:"etopup_tax", hozAlign:"center", mutator:customMutator, headerSort:false, visible: false},
                    {title:"mBoB", field:"mbob", hozAlign:"center", mutator:customMutator, headerSort:false},
                    {title:"mBoB Tax", field:"mbob_tax", hozAlign:"center", mutator:customMutator, headerSort:false, visible: false},
                    {title:"TPay", field:"tpay", hozAlign:"center", mutator:customMutator, headerSort:false},
                    {title:"TPay Tax", field:"tpay_tax", hozAlign:"center", mutator:customMutator, headerSort:false, visible: false},
                    {title:"BNB", field:"bnb", hozAlign:"center", mutator:customMutator, headerSort:false},
                    {title:"BNB Tax", field:"bnb_tax", hozAlign:"center", mutator:customMutator, headerSort:false, visible: false},
                    {title:"BDB", field:"bdb", hozAlign:"center", mutator:customMutator, headerSort:false},
                    {title:"BDB Tax", field:"bdb_tax", hozAlign:"center", mutator:customMutator, headerSort:false, visible: false},
                    {title:"MyTashiCell", field:"mytashicell", hozAlign:"center", mutator:customMutator, headerSort:false},
                    {title:"MyTashiCell Tax", field:"mytashicell_tax", hozAlign:"center", mutator:customMutator, headerSort:false, visible: false},
                    {title:"Web", field:"web", hozAlign:"center", mutator:customMutator, headerSort:false},
                    {title:"Web Tax", field:"web_tax", hozAlign:"center", mutator:customMutator, headerSort:false, visible: false},
                    {title:"Sales and Order", field:"sales_and_order", hozAlign:"center", mutator:customMutator, headerSort:false},
                    {title:"Sales and Order Tax", field:"sales_and_order_tax", hozAlign:"center", mutator:customMutator, headerSort:false, visible: false},
                    {title:"eTeeru", field:"eteeru", hozAlign:"center", mutator:customMutator, headerSort:false},
                    {title:"eTeeru Tax", field:"eteeru_tax", hozAlign:"center", mutator:customMutator, headerSort:false, visible: false},
                    {title:"Digital Kidu", field:"digital_kidu", hozAlign:"center", mutator:customMutator, headerSort:false},
                    {title:"DPNB", field:"pnb", hozAlign:"center", mutator:customMutator, headerSort:false},
                    {title:"Total Recharge", field:"total_recharge", hozAlign:"center", mutator:customMutator, headerSort:false},
                    {title:"Total Recharge Tax", field:"total_recharge_tax", hozAlign:"center", mutator:customMutator, headerSort:false, visible: false},
                ]
            },
            {
                title:"Consumption",
                columns: [
                    {title:"Onnet Voice", field:"onnet_voice", hozAlign:"center", mutator:customMutator, headerSort:false},
                    {title:"Offnet Voice", field:"offnet_voice", hozAlign:"center", mutator:customMutator, headerSort:false},
                    {title:"International Voice", field:"international_voice", hozAlign:"center", mutator:customMutator, headerSort:false},
                    {title:"SMS", field:"sms", hozAlign:"center", mutator:customMutator, headerSort:false},
                    {title:"Validity Booster 7 Days", field:"validity_booster_7days", hozAlign:"center", mutator:customMutator, headerSort:false},
                    {title:"Validity Booster 15 Days", field:"validity_booster_15days", hozAlign:"center", mutator:customMutator, headerSort:false},
                    {title:"Validity Booster 30 Days", field:"validity_booster_30days", hozAlign:"center", mutator:customMutator, headerSort:false},
                    {title:"Data Plan", field:"data_plan", hozAlign:"center", mutator:customMutator, headerSort:false},
                    {title:"Data Pay Per Use", field:"data_pay_per_use", hozAlign:"center", mutator:customMutator, headerSort:false},
                    {title:"Total Consumption", field:"total_comsumption", hozAlign:"center", mutator:customMutator, headerSort:false},
                ]
            },
            {
                title:"Subscriber Statistics",
                columns: [
                    {title:"Subscribers Activated", field:"subs_activated", hozAlign:"center", mutator:customMutator, headerSort:false},
                    {title:"Subscribers Deactivated", field:"subs_deactivated", hozAlign:"center", mutator:customMutator, headerSort:false},
                    {title:"Active Subscribers (CBS)", field:"active_subs_cbs", hozAlign:"center", mutator:customMutator, headerSort:false},
                    {title:"Barred Subscribers", field:"subs_barred", hozAlign:"center", mutator:customMutator, headerSort:false},
                    {title:"Suspended Subscribers", field:"subs_suspended", hozAlign:"center", mutator:customMutator, headerSort:false},
                    {title:"Total Subscribers (Active+Barring+Suspend)", field:"total_subs", hozAlign:"center", mutator:customMutator, headerSort:false},
                    {title:"Total VLR Subscriber", field:"total_vlr_subs", hozAlign:"center", mutator:customMutator, headerSort:false},
                    {title:"Powered On Subscribers", field:"powered_on_subs", hozAlign:"center", mutator:customMutator, headerSort:false},
                    {title:"New ILL Subscribers", field:"new_leasedline_subs", hozAlign:"center", mutator:customMutator, headerSort:false},
                    {title:"Total ILL Subscribers", field:"leasedline_subs", hozAlign:"center", mutator:customMutator, headerSort:false},
                ]

            }],
            dataLoaded:function(data){ //freeze first row on data load
                var lastRow = this.getRows()[{{count($tablebothprepaidconsumption) - 1}}];

                if(lastRow){
                    lastRow.freeze();
                }
            }
        });

        document.getElementById("bothprepaidconsumption-download-xlsx").addEventListener("click", function(){
            table.download("xlsx", "Daily Revenue Report.xlsx");
        });
    </script>
@endsection

