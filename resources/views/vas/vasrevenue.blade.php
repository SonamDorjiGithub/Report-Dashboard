@extends('layouts.masterlayout')

@section('content')
    <div class="container">
        <ul class="nav nav-tabs" id="vastabclick" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-value="smpp" data-toggle="tab" href="#smpp">SMPP</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-value="tollfree" data-toggle="tab" href="#tollfree">Toll Free</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-value="shortcode" data-toggle="tab" href="#shortcode">ShortCode</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-value="ussd" data-toggle="tab" href="#ussd">USSD</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-value="bulksms" data-toggle="tab" href="#bulksms">Bulk SMS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-value="crbt" data-toggle="tab" href="#crbt">CRBT</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-value="covidtollfree" data-toggle="tab" href="#covidtollfree">Covid TollFree</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div id="smpp" class="container tab-pane active"><br>
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-8">
                                <i class="fas fa-chart-bar mr-1"></i>
                                SMPP Monthly
                            </div>
                            <div class="col-sm-2">
                                <button class="float-right btn-primary btn-xs" id="smpp-download-xlsx"><i class="fas fa-file-download"></i></button>
                                <button class="float-right btn-primary btn-xs hide" id="smppajax-download-xlsx"><i class="fas fa-file-download"></i></button>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control form-control-sm" id="SmppMonthlyTable" name="SmppMonthlyTable" style="float:right;width: 70%!important;">
                                    @foreach($yearallsmpp as $year)
                                        <option value="{{$year->t_year}}">{{$year->t_year}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="smpp-table-monthly"></div>
                    </div>
                </div>
            </div>
            <div id="tollfree" class="container tab-pane"><br>
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-8">
                                <i class="fas fa-chart-bar mr-1"></i>
                                Toll Free Monthly
                            </div>
                            <div class="col-sm-2">
                                <button class="float-right btn-primary btn-xs" id="tollfree-download-xlsx"><i class="fas fa-file-download"></i></button>
                                <button class="float-right btn-primary btn-xs hide" id="tollfreeajax-download-xlsx"><i class="fas fa-file-download"></i></button>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control form-control-sm" id="TollFreeMonthlyTable" name="TollFreeMonthlyTable" style="float:right;width: 70%!important;">
                                    <option value="" selected="selected">--YEAR--</option>
                                    @foreach($yearalltollfree as $year)
                                        <option value="{{$year->t_year}}">{{$year->t_year}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="tollfree-table-monthly"></div>
                    </div>
                </div>
            </div>
            <div id="shortcode" class="container tab-pane"><br>
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-8">
                                <i class="fas fa-chart-bar mr-1"></i>
                                Short Code Monthly
                            </div>
                            <div class="col-sm-2">
                                <button class="float-right btn-primary btn-xs" id="shortcode-download-xlsx"><i class="fas fa-file-download"></i></button>
                                <button class="float-right btn-primary btn-xs hide" id="shortcodeajax-download-xlsx"><i class="fas fa-file-download"></i></button>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control form-control-sm" id="ShortCodeMonthlyTable" name="ShortCodeMonthlyTable" style="float:right;width: 70%!important;">
                                    <option value="" selected="selected">--YEAR--</option>
                                    @foreach($yearallshortcode as $year)
                                        <option value="{{$year->t_year}}">{{$year->t_year}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="shortcode-table-monthly"></div>
                    </div>
                </div>
            </div>
            <div id="ussd" class="container tab-pane"><br>
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-8">
                                <i class="fas fa-chart-bar mr-1"></i>
                                USSD Monthly
                            </div>
                            <div class="col-sm-2">
                                <button class="float-right btn-primary btn-xs" id="ussd-download-xlsx"><i class="fas fa-file-download"></i></button>
                                <button class="float-right btn-primary btn-xs hide" id="ussdajax-download-xlsx"><i class="fas fa-file-download"></i></button>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control form-control-sm" id="UssdMonthlyTable" name="UssdMonthlyTable" style="float:right;width: 70%!important;">
                                    <option value="" selected="selected">--YEAR--</option>
                                    @foreach($yearallussd as $year)
                                        <option value="{{$year->t_year}}">{{$year->t_year}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="ussd-table-monthly"></div>
                    </div>
                </div>
            </div>
            <div id="bulksms" class="container tab-pane"><br>
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-8">
                                <i class="fas fa-chart-bar mr-1"></i>
                                Bulk SMS Monthly
                            </div>
                            <div class="col-sm-2">
                                <button class="float-right btn-primary btn-xs" id="bulksms-download-xlsx"><i class="fas fa-file-download"></i></button>
                                <button class="float-right btn-primary btn-xs hide" id="bulksmsajax-download-xlsx"><i class="fas fa-file-download"></i></button>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control form-control-sm" id="BulkSmsMonthlyTable" name="BulkSmsMonthlyTable" style="float:right;width: 70%!important;">
                                    <option value="" selected="selected">--YEAR--</option>
                                    @foreach($yearallbulksms as $year)
                                        <option value="{{$year->t_year}}">{{$year->t_year}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="bulksms-table-monthly"></div>
                    </div>
                </div>
            </div>
            <div id="crbt" class="container tab-pane"><br>
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-8">
                                <i class="fas fa-chart-bar mr-1"></i>
                                CRBT Monthly
                            </div>
                            <div class="col-sm-2">
                                <button class="float-right btn-primary btn-xs" id="crbt-download-xlsx"><i class="fas fa-file-download"></i></button>
                                <button class="float-right btn-primary btn-xs hide" id="crbtajax-download-xlsx"><i class="fas fa-file-download"></i></button>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control form-control-sm" id="CrbtMonthlyTable" name="CrbtMonthlyTable" style="float:right;width: 70%!important;">
                                    <option value="" selected="selected">--YEAR--</option>
                                    @foreach($yearallcrbt as $year)
                                        <option value="{{$year->t_year}}">{{$year->t_year}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="crbt-table-monthly"></div>
                    </div>
                </div>
            </div>
            <div id="covidtollfree" class="container tab-pane"><br>
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-10">
                                <i class="fas fa-table mr-1"></i>
                                Covid TollFree
                            </div>
                            <div class="col-sm-2">
                                <button class="float-right btn-primary btn-xs" id="covidtollfree-download-xlsx"><i class="fas fa-file-download"></i></button>
                                <button class="float-right btn-primary btn-xs hide" id="covidtollfreeajax-download-xlsx"><i class="fas fa-file-download"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" role="tablist">
                            @foreach($yearallcovidtollfree as $year)
                                <li class="nav-item">
                                    <a class="nav-link @if($year->t_year == $currentyear){{"active"}}@endif" data-toggle="tab" href="#year{{$year->t_year}}">{{$year->t_year}}</a>
                                </li>
                            @endforeach
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content" id="covidtollfreemonthlytab">
                            @foreach($yearallcovidtollfree as $year)
                                <div id="year{{$year->t_year}}" data-year="{{$year->t_year}}" class="container tab-pane @if($year->t_year == $currentyear){{"active"}}@else{{"fade"}}@endif">
                                    <ul class="nav">
                                        @if($year->t_year == $currentyear)
                                            @foreach($currentyearsmonth as $month)
                                                <li class="nav-item" data-month="{{$month->t_month}}">
                                                    <a class="nav-link @if($month->t_month == $currentmonth){{"disabled"}}@endif" href="#">{{$month->t_month}}</a>
                                                </li>
                                            @endforeach
                                        @elseif($year->t_year == 2020)
                                            {{--                       For 2020 it is only from Aug and didn't code for other years as this service is temporary until covid--}}
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
                        <div id="covidtollfree-table"></div>
                    </div>
                </div>
            </div>
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

        var customMutatorWithoutDecimal = function(value){
            if(value == null){
                return 'NA';
            }
            else{
                return parseInt(value).toLocaleString('en-US');
            }
        }

        //montly
        var smpptable = new Tabulator("#smpp-table-monthly", {
            height:"400px",
            virtualDomBuffer:250,
            layoutColumnsOnNewData:true,
            layout:"fitData",
            columnMinWidth:90,
            data:{!! json_encode($tablesmppmonthly) !!},
            columns:[
                {title:"Month", field:"t_month", hozAlign:"center", frozen:true, sorter:"number", headerSort:false}, //frozen column
                {title:"BOB", field:"BOB", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"BIL", field:"BIL", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"BNBL", field:"BNBL", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"BPC", field:"BPC", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"DPNB", field:"DPNB", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"RICB", field:"RICB", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"BDB", field:"BDB", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"TBANK", field:"TBANK", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"NPPF", field:"NPPF", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"G2C", field:"G2C", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"ECB", field:"ECB", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"RCSC", field:"RCSC", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"BOB CHARO", field:"BOB_CHARO", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"BHUTAN BUY", field:"BHUTAN_BUY", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"EDruk", field:"EDRUK", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"Druk Ride", field:"DRUK_RIDE", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"ELAYOG BT", field:"ELAYOGBT", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"Dragon Coders", field:"DRAGON_CODERS", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"PAYSAP", field:"PAYSAP", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"Digital Kidu", field:"DIGITAL_KIDU", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"ZALA BT", field:"ZALA_BT", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"JOBA JOBA", field:"JOBA_JOBA", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"NRDCL", field:"NRDCL", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"BBooking", field:"BBOOKING", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"Relief Kidu", field:"RELIEF_KIDU", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"RMA", field:"RMA", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"RSTA", field:"RSTA", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"CAB", field:"CAB", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"Druk Air", field:"DAIR", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"Druk Smart", field:"DRUK_SMART", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"DNT", field:"DNT", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"Gyelposhing_College", field:"GYELPOSHING_COLLEGE", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"Gawa Shop", field:"GAWA_SHOP", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"Samuh", field:"SAMUH", hozAlign:"center", mutator:customMutator, headerSort:false},
            ],
        });

        document.getElementById("smpp-download-xlsx").addEventListener("click", function(){
            smpptable.download("xlsx", "smpp.xlsx");
        });

        var tollfreetable = new Tabulator("#tollfree-table-monthly", {
            height:"400px",
            virtualDomBuffer:250,
            layoutColumnsOnNewData:true,
            layout:"fitData",
            columnMinWidth:90,
            data:{!! json_encode($tabletollfreemonthly) !!},
            columns:[
                {title:"Month", field:"t_month", hozAlign:"center", frozen:true, sorter:"number", headerSort:false}, //frozen column
                {title:"BPC", field:"BPC", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"G2C", field:"G2C", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"NPPF", field:"NPPF", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"Druk Air", field:"DAIR", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"BNBL", field:"BNBL", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"Tashi Air", field:"TAIR", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"TBank", field:"TBANK", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"DRC", field:"DRC", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"Pling Thromde", field:"PLING_THROMDE", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"Mountain Hazelnuts", field:"MOUNTAIN_HAZELNUTS", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"Quality Assurance and Standardization", field:"QUALITY_ASSURANCE", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"DPNB", field:"DPNB", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"Tashi Beverages", field:"TASHI_BEVERAGES", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"MOLHR", field:"MOLHR", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"OCP", field:"OCP", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"BDB", field:"BDB", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"BOB", field:"BOB", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"RICB", field:"RICB", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"JOBA JOBA", field:"JOBA_JOBA", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"BIL", field:"BIL", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"Pyelbar", field:"PYELBAR", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"ECB", field:"ECB", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"RMA", field:"RMA", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"Swift Service Center", field:"SWIFT_SERVICE_CENTER", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"CAB", field:"CAB", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"ABI", field:"ABI", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"Tyangtse Dzongkhag", field:"TYANGTSE_DZONGKHAG", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"Druk Smart", field:"DRUK_SMART", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"Desung HQ", field:"DESUNG_HQ", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"Digital Kidu", field:"DIGITAL_KIDU", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"Samuh", field:"SAMUH", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"Help Desk 1010", field:"HELP_DESK_1010", hozAlign:"center", mutator:customMutator, headerSort:false}
            ],
        });

        document.getElementById("tollfree-download-xlsx").addEventListener("click", function(){
            tollfreetable.download("xlsx", "tollfree.xlsx");
        });

        var shortcodetable = new Tabulator("#shortcode-table-monthly", {
            height:"400px",
            virtualDomBuffer:250,
            layoutColumnsOnNewData:true,
            layout:"fitData",
            columnMinWidth:90,
            data:{!! json_encode($tableshortcodemonthly) !!},
            columns:[
                {title:"Month", field:"t_month", hozAlign:"center", frozen:true, sorter:"number", headerSort:false}, //frozen column
                {title:"Druk Smart", field:"DRUK_SMART", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"Radio Valley", field:"RADIO_VALLEY", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"Bhutan Airport Shuttle Service", field:"BHUTAN_AIRPORT_SHUTTLE_SERVICE", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"Druk Ride", field:"DRUK_RIDE", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"The Biryani House and Cafe", field:"THE_BIRYANI_HOUSE_AND_CAFE", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"Mawongpa Water Solution", field:"MAWONGPA_WATER_SOLUTION", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"Falcom Bhotania", field:"FALCOM_BHOTANIA", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"O Pizza Cafe", field:"O_PIZZA_CAFE", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"Azha Pasa", field:"AZHA_PASA", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"Kuzu FM", field:"KUZU_FM", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"BDB", field:"BDB", hozAlign:"center", mutator:customMutator, headerSort:false},
                {title:"PAYSAP", field:"PAYSAP", hozAlign:"center", mutator:customMutator, headerSort:false},
            ],
        });

        document.getElementById("shortcode-download-xlsx").addEventListener("click", function(){
            shortcodetable.download("xlsx", "shortcode.xlsx");
        });

        var ussdtable = new Tabulator("#ussd-table-monthly", {
            height:"400px",
            virtualDomBuffer:250,
            layoutColumnsOnNewData:true,
            layout:"fitDataFill",
            columnMinWidth:90,
            data:{!! json_encode($tableussdmonthly) !!},
            columns:[
                {title:"Month", field:"t_month", hozAlign:"center", frozen:true, sorter:"number", headerSort:false}, //frozen column
                {title:"BOB", field:"BOB", hozAlign:"center", mutator:customMutator, headerSort:false},
            ],
        });

        document.getElementById("ussd-download-xlsx").addEventListener("click", function(){
            ussdtable.download("xlsx", "ussd.xlsx");
        });

        var bulksmstable = new Tabulator("#bulksms-table-monthly", {
            height:"400px",
            virtualDomBuffer:250,
            layoutColumnsOnNewData:true,
            layout:"fitDataFill",
            columnMinWidth:90,
            data:{!! json_encode($tablebulksmsmonthly) !!},
            columns:[
                {title:"Date", field:"t_month", hozAlign:"center", frozen:true, sorter:"number", headerSort:false}, //frozen column
                {title:"Client Name", field:"client_name", hozAlign:"center", headerSort:false},
                {title:"Amount", field:"amount", hozAlign:"center", mutator:customMutator, headerSort:false},
            ],
        });

        document.getElementById("bulksms-download-xlsx").addEventListener("click", function(){
            bulksmstable.download("xlsx", "bulksms.xlsx");
        });

        var crbttable = new Tabulator("#crbt-table-monthly", {
            height:"400px",
            virtualDomBuffer:250,
            layoutColumnsOnNewData:true,
            layout:"fitDataFill",
            columnMinWidth:90,
            data:{!! json_encode($tablecrbtmonthly) !!},
            columns:[
                {title:"Month", field:"t_month", hozAlign:"center", frozen:true, sorter:"number", headerSort:false}, //frozen column
                {title:"No of Subscriptions", field:"subscribers", hozAlign:"center", mutator:customMutatorWithoutDecimal, headerSort:false},
                {title:"No of Songs Downloaded", field:"songs_downloaded", hozAlign:"center", mutator:customMutatorWithoutDecimal, headerSort:false},
            ],
        });

        document.getElementById("crbt-download-xlsx").addEventListener("click", function(){
            crbttable.download("xlsx", "crbt.xlsx");
        });

        var covidtollfreetable = new Tabulator("#covidtollfree-table", {
            height:"400px",
            virtualDomBuffer:150,
            layoutColumnsOnNewData:true,
            layout:"fitDataFill",
            columnMinWidth:90,
            data:{!! json_encode($tablecovidtollfree) !!},
            columns:[
                {title:"Date", field:"date", frozen:true, sorter:"number",hozAlign:"center", headerSort:false}, //frozen column
                {title:"Client", field:"client", hozAlign:"center", headerSort:false},
                {title:"Place", field:"place", hozAlign:"center", headerSort:false},
                {title:"Region", field:"region", hozAlign:"center", headerSort:false},
                {title:"Short Code", field:"shortcode", hozAlign:"center", headerSort:false},
                {title:"Amount", field:"amount", hozAlign:"center", mutator:customMutator, headerSort:false},
            ],
        });

        document.getElementById("covidtollfree-download-xlsx").addEventListener("click", function(){
            covidtollfreetable.download("xlsx", "covidtollfree.xlsx");
        });
    </script>
@endsection
