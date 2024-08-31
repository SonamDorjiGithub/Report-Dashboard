<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="shortcut icon" href="{{asset("assets/img/logo.png")}}" type="image/x-icon">
    <link rel="icon" href="{{asset("assets/img/logo.png")}}" type="image/x-icon">
    <title>Report Dashboard</title>
    <link href="{{asset("css/styles.css")}}" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" type="text/css" href="{{asset("/css/main.css")}}">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <script type="text/javascript" src="{{asset('assets/js/fusioncharts.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jquery-fusioncharts.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/themes/fusioncharts.theme.fusion.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/themes/fusioncharts.theme.candy.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/themes/fusioncharts.theme.carbon.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/themes/fusioncharts.theme.fint.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/themes/fusioncharts.theme.gammel.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/themes/fusioncharts.theme.ocean.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/themes/fusioncharts.theme.umber.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/themes/fusioncharts.theme.zune.js')}}"></script>

    <script src="{{asset('assets/js/script.js')}}"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.js"></script>

    <link href="https://unpkg.com/tabulator-tables@4.8.1/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables@4.8.1/dist/js/tabulator.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js" integrity="sha512-zP5W8791v1A6FToy+viyoyUUyjCzx+4K8XZCKzW28AnCoepPNIXecxh9mvGuy3Rt78OzEsU+VCvcObwAMvBAww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css" integrity="sha512-0V10q+b1Iumz67sVDL8LPFZEEavo6H/nBSyghr7mm9JEQkOAm91HNoZQRvQdjennBb/oEuW+8oZHVpIKq+d25g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script type="text/javascript" src="https://oss.sheetjs.com/sheetjs/xlsx.full.min.js"></script>
    @yield('pagestyles')


</head>
<body class="sb-nav-fixed">
    <div id="ajax-loader" class="hide">
        <center><i class="fa fa-spinner fa-spin fa-4x"></i></center>
        <strong>Processing... Please don't refresh the page</strong>
    </div>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-info">
        <a class="navbar-brand" href="{{URL::to('dashboard')}}">Report Dashboard</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
                    <div class="input-group-append">
                        @if($userprivilege->omc)
                            <a class="btn btn-dark" href="{{URL::to('omc/omcaddpage')}}"><i class="fas fa-plus"></i></a>
                        @endif
                    </div>
                </div>
            </div>
        <!-- Navbar-->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    @if($userprivilege->admin)<a class="dropdown-item" href="{{URL::to('admin/adminpage')}}">Administration</a>@endif
                    <a class="dropdown-item" href="{{URL::to('changepwpage')}}">Change Password</a>
{{--                    <div class="dropdown-divider"></div>--}}
                    <a class="dropdown-item" href="{{URL::to('logout')}}">Logout</a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Reports</div>

                        @if($userprivilege->dailyrevenue)
                            <a class="nav-link collapsed {{$currentRoute == "dailyrevenue" ? "active": ""}}" href="{{URL::to('dailyrevenue')}}">
                                <div class="sb-nav-link-icon"><i style="color:#165b7d" class="fas fa-coins"></i></div>
                                Daily Revenue
                                {{--                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>--}}
                            </a>
                        @endif
                        @if($userprivilege->prepaid)
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="true" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i style="color:#165b7d" class="fas fa-columns"></i></div>
                            Prepaid Recharge
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse @if(in_array($currentRoute,['prepaid/dailypage','prepaid/tableallpage','prepaid/tablepage','prepaid/comparisonpage','prepaid/channelwisepage'])){{"show"}}@endif" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link {{$currentRoute == "prepaid/dailypage" ? "active":""}}" href="{{URL::to('prepaid/dailypage')}}">Daily</a>
                                <a class="nav-link {{$currentRoute == "prepaid/comparisonpage" ? "active":""}}" href="{{URL::to('prepaid/comparisonpage')}}">Trends</a>
                                <a class="nav-link {{$currentRoute == "prepaid/channelwisepage" ? "active":""}}" href="{{URL::to('prepaid/channelwisepage')}}">Channel Wise</a>
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                    Data Sheet
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse @if(in_array($currentRoute,['prepaid/tablepage','prepaid/tableallpage'])){{"show"}}@endif" id="pagesCollapseAuth" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link {{$currentRoute == "prepaid/tableallpage" ? "active":""}}" href="{{URL::to('prepaid/tableallpage')}}">Daily/Monthly</a>
                                        <a class="nav-link {{$currentRoute == "prepaid/tablepage" ? "active":""}}" href="{{URL::to('prepaid/tablepage')}}">Monthly/Yearly</a>
                                    </nav>
                                </div>
                            </nav>
                        </div>
                        @endif

                    @if($userprivilege->consumption)
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayoutsConsumption" aria-expanded="true" aria-controls="collapseLayoutsConsumption">
                            <div class="sb-nav-link-icon"><i style="color:#165b7d" class="fas fa-chart-bar"></i></div>
                            Consumption
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse @if(in_array($currentRoute,['consumption/dailyconsumptionpage','consumption/comparisonconsumption','consumption/channelwiseconsumption','consumption/tableconsumption', 'consumption/tableconsumptionall'])){{"show"}}@endif" id="collapseLayoutsConsumption" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link {{$currentRoute == "consumption/dailyconsumptionpage"? "active":""}}" href="{{URL::to('consumption/dailyconsumptionpage')}}">Daily</a>
                                <a class="nav-link {{$currentRoute == "consumption/comparisonconsumption"? "active":""}}" href="{{URL::to('consumption/comparisonconsumption')}}">Trends</a>
                                <a class="nav-link {{$currentRoute == "consumption/channelwiseconsumption"? "active":""}}" href="{{URL::to('consumption/channelwiseconsumption')}}">Service Wise</a>

                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                    Data Sheet
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse @if(in_array($currentRoute,['consumption/tableconsumption','consumption/tableconsumptionall'])){{"show"}}@endif" id="pagesCollapseAuth" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link {{$currentRoute == "consumption/tableconsumptionall"? "active":""}}" href="{{URL::to('consumption/tableconsumptionall')}}">Daily/Monthly</a>
                                        <a class="nav-link {{$currentRoute == "consumption/tableconsumption"? "active":""}}" href="{{URL::to('consumption/tableconsumption')}}">Monthly/Yearly</a>
                                    </nav>
                                </div>
                            </nav>
                        </div>
                        @endif

                        @if($userprivilege->prepaidvsconsumption)
                        <a class="nav-link collapsed" href="{{URL::to('prepaidvsconsumption')}}">
                            <div class="sb-nav-link-icon"><i style="color:#165b7d" class="fas fa-balance-scale-left"></i></div>
                            Recharge/Consumption
                        </a>
                        @endif

                        @if($userprivilege->substatistics)
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSubsStats" aria-expanded="true" aria-controls="collapseSubsStats">
                            <div class="sb-nav-link-icon"><i style="color:#165b7d" class="fas fa-table"></i></div>
                            Subscriber Statistics
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        @endif
                        <div class="collapse @if(in_array($currentRoute,['substatistics/tablefigures', 'substatistics/comparisonfigures'])){{"show"}}@endif" id="collapseSubsStats" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link {{$currentRoute == "substatistics/comparisonfigures" ? "active":""}}" href="{{URL::to('substatistics/comparisonfigures')}}">Trends</a>
                                <a class="nav-link {{$currentRoute == "substatistics/tablefigures" ? "active":""}}" href="{{URL::to('substatistics/tablefigures')}}">Data Sheet</a>
                            </nav>
                        </div>


                        @if($userprivilege->postpaid)
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayoutsPostpaid" aria-expanded="true" aria-controls="collapseLayoutsPostpaid">
                                <div class="sb-nav-link-icon"><i style="color:#165b7d" class="fas fa-chart-line"></i></div>
                                Postpaid
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse @if(in_array($currentRoute,['postpaid/tablepostpaid', 'postpaid/comparisonpostpaid', 'postpaid/channelwisepostpaid'])){{"show"}}@endif" id="collapseLayoutsPostpaid" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link {{$currentRoute == "postpaid/comparisonpostpaid" ? "active":""}}" href="{{URL::to('postpaid/comparisonpostpaid')}}">Trends</a>
                                    <a class="nav-link {{$currentRoute == "postpaid/channelwisepostpaid" ? "active":""}}" href="{{URL::to('postpaid/channelwisepostpaid')}}">Service Wise</a>
                                    <a class="nav-link {{$currentRoute == "postpaid/tablepostpaid" ? "active":""}}" href="{{URL::to('postpaid/tablepostpaid')}}">Data Sheet</a>
                                </nav>
                            </div>
                        @endif

                        @if($userprivilege->leasedline)
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayoutsLeasedLine" aria-expanded="true" aria-controls="collapseLayoutsLeasedLine">
                                <div class="sb-nav-link-icon"><i style="color:#165b7d" class="fas fa-project-diagram"></i></div>
                                Leased Line
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse @if(in_array($currentRoute,['leasedline/tableleasedline', 'leasedline/comparisonleasedline', 'leasedline/channelwiseleasedline'])){{"show"}}@endif" id="collapseLayoutsLeasedLine" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link {{$currentRoute == "leasedline/comparisonleasedline" ? "active":""}}" href="{{URL::to('leasedline/comparisonleasedline')}}">Trends</a>
                                    <a class="nav-link {{$currentRoute == "leasedline/channelwiseleasedline" ? "active":""}}" href="{{URL::to('leasedline/channelwiseleasedline')}}">Service Wise</a>
                                    <a class="nav-link {{$currentRoute == "leasedline/tableleasedline" ? "active":""}}" href="{{URL::to('leasedline/tableleasedline')}}">Data Sheet</a>
                                </nav>
                            </div>
                        @endif

                        @if($userprivilege->dataplanusage)
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayoutsDataplanAndUsage" aria-expanded="true" aria-controls="collapseLayoutsLeasedLine">
                                <div class="sb-nav-link-icon"><i style="color:#165b7d" class="fas fa-chart-area"></i></div>
                                Data Plan & Usage
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse @if(in_array($currentRoute,['dataplanusage/tabledatausage', 'dataplanusage/comparisondatausage', 'dataplanusage/subscribertable', 'dataplanusage/subscribertrends', 'dataplanusage/costpergbtrend'])){{"show"}}@endif" id="collapseLayoutsDataplanAndUsage" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link {{$currentRoute == "dataplanusage/comparisondatausage" ? "active":""}}" href="{{URL::to('dataplanusage/comparisondatausage')}}">Data Usage Trends</a>
                                    <a class="nav-link {{$currentRoute == "dataplanusage/tabledatausage" ? "active":""}}" href="{{URL::to('dataplanusage/tabledatausage')}}">Data Usage Sheet</a>
                                    <a class="nav-link {{$currentRoute == "dataplanusage/subscribertrends" ? "active":""}}" href="{{URL::to('dataplanusage/subscribertrends')}}">Data Plan Trends</a>
                                    <a class="nav-link {{$currentRoute == "dataplanusage/subscribertable" ? "active":""}}" href="{{URL::to('dataplanusage/subscribertable')}}">Data Plan Sheet</a>
                                    <a class="nav-link {{$currentRoute == "dataplanusage/costpergbtrend" ? "active":""}}" href="{{URL::to('dataplanusage/costpergbtrend')}}">Revenue/GB Trends</a>
                                </nav>
                            </div>
                        @endif

                    @if($userprivilege->interconnect)
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayoutsInterconnect" aria-expanded="true" aria-controls="collapseLayoutsInterconnect">
                            <div class="sb-nav-link-icon"><i style="color:#165b7d" class="fas fa-ethernet"></i></div>
                            Interconnect
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse @if(in_array($currentRoute,['interconnect/tableinterconnectdomestic','interconnect/tableinterconnectinternational','interconnect/comparisoninterconnect','interconnect/comparisoninternationalconnect'])){{"show"}}@endif" id="collapseLayoutsInterconnect" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseDomestic" aria-expanded="false" aria-controls="pagesCollapseDomestic">
                                    Domestic
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse @if(in_array($currentRoute,['interconnect/tableinterconnectdomestic','interconnect/comparisoninterconnect'])){{"show"}}@endif" id="pagesCollapseDomestic" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link {{$currentRoute == "interconnect/comparisoninterconnect" ? "active":""}}" href="{{URL::to('interconnect/comparisoninterconnect')}}">Trends</a>
                                        <a class="nav-link {{$currentRoute == "interconnect/tableinterconnectdomestic" ? "active":""}}" href="{{URL::to('interconnect/tableinterconnectdomestic')}}">Data Sheet</a>
                                    </nav>
                                </div>

                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseInternational" aria-expanded="false" aria-controls="pagesCollapseInternational">
                                    International
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse @if(in_array($currentRoute,['interconnect/tableinterconnectinternational','interconnect/comparisoninternationalconnect'])){{"show"}}@endif" id="pagesCollapseInternational" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link {{$currentRoute == "interconnect/comparisoninternationalconnect" ? "active":""}}" href="{{URL::to('interconnect/comparisoninternationalconnect')}}">Trends</a>
                                        <a class="nav-link {{$currentRoute == "interconnect/tableinterconnectinternational" ? "active":""}}" href="{{URL::to('interconnect/tableinterconnectinternational')}}">Data Sheet</a>
                                    </nav>
                                </div>
                            </nav>
                        </div>
                    @endif

                    @if($userprivilege->eteeru)
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayoutsEteeru" aria-expanded="true" aria-controls="collapseLayoutsEteeru">
                                <div class="sb-nav-link-icon"><i style="color:#165b7d" class="fas fa-chart-pie"></i></div>
                                eTeeru
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse @if(in_array($currentRoute,['eteeru/eteerudailytable','eteeru/eteerumonthlytable','eteeru/eteerutrends', 'eteeru/eteerustatistics'])){{"show"}}@endif" id="collapseLayoutsEteeru" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link {{$currentRoute == "eteeru/eteerustatistics" ? "active":""}}" href="{{URL::to('eteeru/eteerustatistics')}}">Statistics</a>
                                    <a class="nav-link {{$currentRoute == "eteeru/eteerutrends" ? "active":""}}" href="{{URL::to('eteeru/eteerutrends')}}">Trends</a>
                                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Data Sheet
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse @if(in_array($currentRoute,['eteeru/eteerudailytable','eteeru/eteerumonthlytable'])){{"show"}}@endif" id="pagesCollapseAuth" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link {{$currentRoute == "eteeru/eteerudailytable" ? "active":""}}" href="{{URL::to('eteeru/eteerudailytable')}}">Daily/Monthly</a>
                                            <a class="nav-link {{$currentRoute == "eteeru/eteerumonthlytable" ? "active":""}}" href="{{URL::to('eteeru/eteerumonthlytable')}}">Monthly/Yearly</a>
                                        </nav>
                                    </div>
                                </nav>
                            </div>
                        @endif

                        @if($userprivilege->tda)
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayoutsTda" aria-expanded="true" aria-controls="collapseLayoutsTda">
                                <div class="sb-nav-link-icon"><i style="color:#165b7d" class="fas fa-hourglass-end"></i></div>
                                TDA Data
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse @if(in_array($currentRoute,['tda/tdadatausagetrend', 'tda/tdamarketshare', 'tda/tdarechargesales'])){{"show"}}@endif" id="collapseLayoutsTda" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link {{$currentRoute == "tda/tdadatausagetrend" ? "active":""}}" href="{{URL::to('tda/tdadatausagetrend')}}">Data Usage Trend</a>
                                    <a class="nav-link {{$currentRoute == "tda/tdamarketshare" ? "active":""}}" href="{{URL::to('tda/tdamarketshare')}}">Market Share Analysis</a>
                                    <a class="nav-link {{$currentRoute == "tda/tdarechargesales" ? "active":""}}" href="{{URL::to('tda/tdarechargesales')}}">Recharge Sales Analysis</a>
                                </nav>
                            </div>
                        @endif

                        @if($userprivilege->vas)
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayoutsVas" aria-expanded="true" aria-controls="collapseLayoutsVas">
                                <div class="sb-nav-link-icon"><i style="color:#165b7d" class="fas fa-comments"></i></div>
                                VAS
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse @if(in_array($currentRoute,['vas/vasrevenue'])){{"show"}}@endif" id="collapseLayoutsVas" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link {{$currentRoute == "vas/vasrevenue" ? "active":""}}" href="{{URL::to('vas/vasrevenue')}}">VAS Revenue</a>
                                </nav>
                            </div>
                        @endif


                        {{--                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">--}}
{{--                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>--}}
{{--                            Report2--}}
{{--                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>--}}
{{--                        </a>--}}
                        <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                    Authentication
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="login.html">Login</a>
                                        <a class="nav-link" href="register.html">Register</a>
                                        <a class="nav-link" href="password.html">Forgot Password</a>
                                    </nav>
                                </div>
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                    Error
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="401.html">401 Page</a>
                                        <a class="nav-link" href="404.html">404 Page</a>
                                        <a class="nav-link" href="500.html">500 Page</a>
                                    </nav>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    {{Auth::user()->name}} at
                    <span class="small">{{$lastlogintime}}</span>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main id="body-wrapper">
                <div class="container-fluid pt-1">
                    @if(app('request')->session()->has('errormessage'))
                        <div class="alert alert-danger" role="alert">
                            Error! {!! app('request')->session()->pull('errormessage') !!}
                        </div>
                    @endif
                        @if(app('request')->session()->has('successmessage'))
                            <div class="alert alert-success" role="alert">
                                Success! {!! app('request')->session()->pull('successmessage') !!}
                            </div>
                        @endif
                        @if($has_password_changed === 0)
                            <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                Please change your default password <a class="alert-link" href="{{url('changepwpage')}}">Click here</a>
                            </div>
                        @endif
                    @yield('content')
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; MIS TashiCell {{date('Y')}}</div>
{{--                        <div>--}}
{{--                            <a href="#">Privacy Policy</a>--}}
{{--                            &middot;--}}
{{--                            <a href="#">Terms &amp; Conditions</a>--}}
{{--                        </div>--}}
                    </div>
                </div>
            </footer>
        </div>
    </div>
{{--    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>--}}
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js" integrity="sha512-zP5W8791v1A6FToy+viyoyUUyjCzx+4K8XZCKzW28AnCoepPNIXecxh9mvGuy3Rt78OzEsU+VCvcObwAMvBAww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{--    <script src="js/scripts.js"></script>--}}
    @yield('pagescripts')


</body>
</html>
