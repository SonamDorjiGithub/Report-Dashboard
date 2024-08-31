<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Revenue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

//use Illuminate\Support\Facades\Input as Input;
use Auth;

class RevenueController extends Controller
{
    public function getDashboard(){
        $today = Carbon::today()->subDays(1); //yesterday's date - subtract 1

        $yesterdayDate = $today->format("j");
        $month = $today->format("M");
        $year = $today->format('Y');

        $yesterdaysprepaidconsumption = DB::select("SELECT CONCAT(t_date,'-',t_month,'-',t_year) AS `date`, paper_voucher, etopup, mbob, tpay, bnb, `bdb`, mytashicell, web, sales_and_order, eteeru, digital_kidu, pnb, total_recharge, onnet_voice, offnet_voice, international_voice, sms, (validity_booster_7days + validity_booster_15days + validity_booster_30days) AS validty_booster, data_plan, data_pay_per_use, total_on_on_iv_sms_vb_dr AS total_comsumption, subs_activated, subs_deactivated, active_subs_cbs, subs_barred, subs_suspended, total_subs, total_vlr_subs, powered_on_subs, leasedline_subs, new_leasedline_subs FROM revenue_report WHERE t_date=".$yesterdayDate." AND t_month='".$month."' AND t_year=".$year);
        $data['passyesterdaysdata'] = $yesterdaysprepaidconsumption[0];

        $getPrivilege = DB::select("SELECT * FROM user_privilege WHERE empid = ?", [Auth::user()->EmpId]);
        $data['userprivilege'] = $getPrivilege[0];

        return view('dashboard', $data);
    }

    public function getDashboardDataAjax(Request $request){
        $selectedDay = $request->selectedday;
        if($selectedDay == "today"){
            $today = Carbon::today()->subDays(0);
        }
        else{
            $today = Carbon::today()->subDays(1);
        }

        $yesterdayDate = $today->format("j");
        $month = $today->format("M");
        $year = $today->format('Y');

        $yesterdaysprepaidconsumption = DB::select("SELECT CONCAT(t_date,'-',t_month,'-',t_year) AS `date`, paper_voucher, etopup, mbob, tpay, bnb, `bdb`, mytashicell, web, sales_and_order, eteeru, digital_kidu, pnb, total_recharge, onnet_voice, offnet_voice, international_voice, sms, (validity_booster_7days + validity_booster_15days + validity_booster_30days) AS validty_booster, data_plan, data_pay_per_use, total_on_on_iv_sms_vb_dr AS total_comsumption, subs_activated, subs_deactivated, active_subs_cbs, subs_barred, subs_suspended, total_subs, total_vlr_subs, powered_on_subs, leasedline_subs, new_leasedline_subs FROM revenue_report WHERE t_date=".$yesterdayDate." AND t_month='".$month."' AND t_year=".$year);
        $data['passyesterdaysdata'] = $yesterdaysprepaidconsumption[0];
        return response()->json($data['passyesterdaysdata']);
    }

    public function dailyRevenue(){
        $year = date('Y');
        $month = date('M');

        //query to get unique year from db
        $dataTable['yearall'] = DB::connection('mysql')->table("revenue_report")->orderByDesc("t_year")->selectRaw("DISTINCT t_year")->get()->toArray();
        $dataTable['currentyearsmonth'] = DB::table("revenue_report")->where("t_year", $year)->orderByDesc("t_year")->selectRaw("DISTINCT t_month")->get()->toArray();
        $dataTable['currentyear'] = $year;
        $dataTable['currentmonth'] = strtoupper($month);
        $dataTable['tablebothprepaidconsumption'] = $this->getTableBothPrepaidAndConsumption($month, $year);

        return view('dailyrevenue', $dataTable);
    }

    public function getTableBothPrepaidAndConsumption($month,$year){
        $dataTable['tablebothprepaidconsumption'] = DB::select("(SELECT 'Total' AS `date`, SUM(paper_voucher) AS paper_voucher, SUM(paper_voucher_tax) AS paper_voucher_tax, SUM(etopup) AS etopup, SUM(etopup_tax) AS etopup_tax, SUM(mbob) AS mbob, SUM(mbob_tax) AS mbob_tax, SUM(tpay) AS tpay, SUM(tpay_tax) AS tpay_tax, SUM(bnb) AS bnb, SUM(bnb_tax) AS bnb_tax, SUM(`bdb`) AS `bdb`, SUM(bdb_tax) AS bdb_tax, SUM(mytashicell) AS mytashicell, SUM(mytashicell_tax) AS mytashicell_tax, SUM(web) AS web, SUM(web_tax) AS web_tax, SUM(sales_and_order) AS sales_and_order, SUM(sales_and_order_tax) AS sales_and_order_tax, SUM(eteeru) AS eteeru, SUM(eteeru_tax) AS eteeru_tax, SUM(digital_kidu) AS digital_kidu, SUM(pnb) AS pnb, SUM(total_recharge) AS total_recharge, SUM(total_recharge_tax) AS total_recharge_tax, SUM(onnet_voice) AS onnet_voice, SUM(offnet_voice) AS offnet_voice, SUM(international_voice) AS international_voice, SUM(sms) AS sms, SUM(validity_booster_7days) AS validity_booster_7days, SUM(validity_booster_15days) AS validity_booster_15days, SUM(validity_booster_30days) AS validity_booster_30days, SUM(data_plan) AS data_plan, SUM(data_pay_per_use) AS data_pay_per_use, SUM(total_on_on_iv_sms_vb_dr) AS total_comsumption, SUM(subs_activated) AS subs_activated, SUM(subs_deactivated) AS subs_deactivated, (SELECT active_subs_cbs FROM revenue_report WHERE t_year=".$year." AND t_month='".$month."' AND t_date=(SELECT MAX(t_date) FROM revenue_report WHERE t_month='".$month."' AND t_year=".$year.")) AS active_subs_cbs, (SELECT subs_barred FROM revenue_report WHERE t_year=".$year." AND t_month='".$month."' AND t_date=(SELECT MAX(t_date) FROM revenue_report WHERE t_month='".$month."' AND t_year=".$year.")) AS subs_barred, (SELECT subs_suspended FROM revenue_report WHERE t_year=".$year." AND t_month='".$month."' AND t_date=(SELECT MAX(t_date) FROM revenue_report WHERE t_month='".$month."' AND t_year=".$year.")) AS subs_suspended, (SELECT total_subs FROM revenue_report WHERE t_year=".$year." AND t_month='".$month."' AND t_date=(SELECT MAX(t_date) FROM revenue_report WHERE t_month='".$month."' AND t_year=".$year.")) AS total_subs, (SELECT total_vlr_subs FROM revenue_report WHERE t_year=".$year." AND t_month='".$month."' AND t_date=(SELECT MAX(t_date) FROM revenue_report WHERE t_month='".$month."' AND t_year=".$year.")) AS total_vlr_subs, (SELECT powered_on_subs FROM revenue_report WHERE t_year=".$year." AND t_month='".$month."' AND t_date=(SELECT MAX(t_date) FROM revenue_report WHERE t_month='".$month."' AND t_year=".$year.")) AS powered_on_subs, (SELECT leasedline_subs FROM revenue_report WHERE t_year=".$year." AND t_month='".$month."' AND t_date=(SELECT MAX(t_date) FROM revenue_report WHERE t_month='".$month."' AND t_year=".$year.")) AS leasedline_subs, SUM(new_leasedline_subs) AS new_leasedline_subs FROM revenue_report WHERE t_month='".$month."' AND t_year=".$year.")
                                UNION ALL (SELECT CONCAT(t_date,'-',t_month,'-',t_year) AS `date`, paper_voucher, paper_voucher_tax, etopup, etopup_tax, mbob, mbob_tax, tpay, tpay_tax, bnb, bnb_tax, `bdb`, bdb_tax, mytashicell, mytashicell_tax, web, web_tax, sales_and_order, sales_and_order_tax, eteeru, eteeru_tax, digital_kidu, pnb, total_recharge, total_recharge_tax, onnet_voice, offnet_voice, international_voice, sms, validity_booster_7days, validity_booster_15days, validity_booster_30days, data_plan, data_pay_per_use, total_on_on_iv_sms_vb_dr AS total_comsumption, subs_activated, subs_deactivated, active_subs_cbs, subs_barred, subs_suspended, total_subs, total_vlr_subs, powered_on_subs, leasedline_subs, new_leasedline_subs FROM revenue_report  WHERE t_month='".$month."' AND t_year=".$year.") ORDER BY STR_TO_DATE(`date`, '%e-%b-%Y') DESC");

        return $dataTable['tablebothprepaidconsumption'];
    }

    public function bothPrepaidConsumptionTabAjax(Request $request){
        $month = $request->month;
        $year = $request->year;
        return $this->getTableBothPrepaidAndConsumption($month, $year);
    }

    // For prepaid, most of the method names are not mentioned as prepaid. Whereas for consumption, it is explicitly mentioned as consumption in the method name
    public function getDailyPrepaid(){
        //To show in view
        $today = Carbon::today()->subDays(0); //today's date

        $data['todaysDate'] = $today->format("Y-m-d");
        $data['currentMonth'] = $today->format("Y-m");

        //To pass in query
        $date = $today->format("j");
        $month = $today->format("M");

        return view('dailyprepaid',$data);
    }

    public function fetchDailyPrepaid(Request $request){
        $date = $request->datePrepaid;

        $dateObject = date_create($date);

        $date = date_format($dateObject, "j");
        $month = date_format($dateObject,"M");
        $year = date_format($dateObject,"Y");

//        $dailyTotalPrepaid = DB::select("SELECT IFNULL(paper_voucher, 0) + IFNULL(etopup, 0) + IFNULL(mbob, 0) + IFNULL(tpay, 0) + IFNULL(bnb, 0) + IFNULL(`bdb`,0) + IFNULL(mytashicell, 0) + IFNULL(web, 0) + IFNULL(sales_and_order, 0) + IFNULL(eteeru, 0) + IFNULL(digital_kidu, 0) AS daily_prepaid_total FROM revenue_report WHERE t_date=".$date." AND t_month='".$month."' AND t_year=".$year.";");
        $dailyTotalPrepaid = DB::select("SELECT total_recharge AS daily_prepaid_total FROM revenue_report WHERE t_date=".$date." AND t_month='".$month."' AND t_year=".$year.";");
        $dailyPrepaidRecharge = DB::select("SELECT t_date, t_month, t_year, paper_voucher, etopup, mbob, tpay, bnb, `bdb`, mytashicell, web, sales_and_order, eteeru, digital_kidu, pnb FROM revenue_report WHERE t_date=".$date." AND t_month='".$month."' AND t_year=".$year.";");

        $dataArray = [];

        if(count($dailyPrepaidRecharge) == 0){
            $dataArray  = [0,0,0,0,0,0,0,0,0,0,0,0];
        }
        else{
            array_push($dataArray,["label"=>"RCV","value"=>$dailyPrepaidRecharge[0]->paper_voucher]);
            array_push($dataArray,["label"=>"ETopup","value"=>$dailyPrepaidRecharge[0]->etopup]);
            array_push($dataArray,["label"=>"mBoB","value"=>$dailyPrepaidRecharge[0]->mbob]);
            array_push($dataArray,["label"=>"TPay","value"=>$dailyPrepaidRecharge[0]->tpay]);
            array_push($dataArray,["label"=>"BNB","value"=>$dailyPrepaidRecharge[0]->bnb]);
            array_push($dataArray,["label"=>"BDB","value"=>$dailyPrepaidRecharge[0]->bdb]);
            array_push($dataArray,["label"=>"MyTashiCell","value"=>$dailyPrepaidRecharge[0]->mytashicell]);
            array_push($dataArray,["label"=>"Web","value"=>$dailyPrepaidRecharge[0]->web]);
            array_push($dataArray,["label"=>"Sales and Order","value"=>$dailyPrepaidRecharge[0]->sales_and_order]);
            array_push($dataArray,["label"=>"eTeeru","value"=>$dailyPrepaidRecharge[0]->eteeru]);
            array_push($dataArray,["label"=>"DigitalKidu","value"=>$dailyPrepaidRecharge[0]->digital_kidu]);
            array_push($dataArray,["label"=>"DPNB","value"=>$dailyPrepaidRecharge[0]->pnb]);
        }
        return ['dataArray'=>$dataArray, 'totalDailyPrepaidFormatted'=>number_format($dailyTotalPrepaid[0]->daily_prepaid_total,2), 'totalDailyPrepaid' => $dailyTotalPrepaid[0]->daily_prepaid_total];
    }

    public function fetchMonthlyRevenue(Request $request){
        $date = $request->monthYear;
        $dateObject = date_create($date);
        $month = date_format($dateObject,"M");
        $year = date_format($dateObject,"Y");

        //$monthlyRevenueData = DB::select("SELECT t_date, IFNULL(paper_voucher, 0) + IFNULL(etopup, 0) + IFNULL(mbob, 0) + IFNULL(tpay, 0) + IFNULL(bnb, 0) + IFNULL(`bdb`,0) + IFNULL(mytashicell, 0) + IFNULL(web, 0) + IFNULL(sales_and_order, 0) + IFNULL(eteeru, 0) + IFNULL(digital_kidu, 0) AS total_recharge FROM revenue_report WHERE t_month='".$month."' AND t_year=".$year.";");
        $monthlyRevenueData = DB::select("SELECT t_date, total_recharge FROM revenue_report WHERE t_month='".$month."' AND t_year=".$year.";");

        $monthlyTotal = DB::select("SELECT SUM(total_recharge) AS MonthlyTotal FROM revenue_report WHERE t_month='".$month."' AND t_year=".$year.";");
        $dataArray = [];
        foreach ($monthlyRevenueData as $monthlyRevenueDatas)  {
            array_push($dataArray,['label'=>(string)$monthlyRevenueDatas->t_date,'value'=>$monthlyRevenueDatas->total_recharge]);
        }
        return ['dataArray'=>$dataArray, 'totalMonthly'=>number_format($monthlyTotal[0]->MonthlyTotal,2)];
    }

    public function getComparisonData(){
        $years = DB::table("revenue_report")->selectRaw("DISTINCT t_year")->pluck('t_year')->toArray();
        $dataComparison['yearsInt'] = $years;

        $dataComparison['years'] = array_map('strval', $years);
        // dd($dataComparison);
        $dataComparison['yearlyTotal'] = DB::table("revenue_report")->groupBy("t_year")->orderBy("slno")->selectRaw("t_year, ROUND(SUM(total_recharge),2) AS yearlytotal")->pluck("yearlytotal")->toArray();
        // dd($dataComparison);
        $dataComparison['yearlyTotal'] = array_map('doubleval', $dataComparison['yearlyTotal']);

        $dataComparisonMonthWise = $this->comparisonMonthWise($dataComparison['years']);
        $dataComparisonQuarterWise = $this->comparisonQuarterWise($dataComparison['years']);
        $dataComparisonBiannualWise = $this->comparisonBiannual($dataComparison['years']);
        $YearDataArray = $this->comparisonYearly($dataComparison['years'], $dataComparison['yearlyTotal']);

        $dataComparison['monthly'] = $dataComparisonMonthWise;
        $dataComparison['quarterly'] = $dataComparisonQuarterWise;
        $dataComparison['biannually'] = $dataComparisonBiannualWise;
        $dataComparison['yearly'] = $YearDataArray;

        return view('comparison',$dataComparison);
    }

    public function getComparisonDataMonthly(){
        $years = DB::table("revenue_report")->selectRaw("DISTINCT t_year")->pluck('t_year')->toArray();
        $dataComparison['yearsInt'] = $years;
        $dataComparison['years'] = array_map('strval', $years);

        $dataComparisonMonthWise = $this->comparisonMonthWise($dataComparison['years']);
        return response()->json($dataComparisonMonthWise);
    }

    public function comparisonMonthWise($years){
        $dataComparisonMonthWise = [];
        foreach($years as $year){
            $dataComparison[$year]['seriesname'] = $year;
            $dataRaw = DB::table("revenue_report")->where('t_year',$year)->selectRaw("ROUND(SUM(total_recharge),2) as monthlytotal")->groupBy('t_year')->groupBy('t_month')->orderBy('slno')->pluck('monthlytotal')->toArray();
            $dataRaw = array_map('doubleval',$dataRaw);
            $dataComparison[$year]['data'] = [];
            foreach($dataRaw as $dataRawSingle):
                array_push($dataComparison[$year]['data'],['value'=>$dataRawSingle]);
            endforeach;
            array_push($dataComparisonMonthWise,$dataComparison[$year]);
        }
        return $dataComparisonMonthWise;
    }

    public function getComparisonDataQuarterly(){
        $years = DB::table("revenue_report")->selectRaw("DISTINCT t_year")->pluck('t_year')->toArray();
        $dataComparison['yearsInt'] = $years;
        $dataComparison['years'] = array_map('strval', $years);

        $dataComparisonQuarterWise = $this->comparisonQuarterWise($dataComparison['years']);
        return response()->json($dataComparisonQuarterWise);
    }

    public function comparisonQuarterWise($years){
        foreach($years as $year){
            $dataComparisonQuarterWise = [];
            foreach($years as $year){
                $dataComparison[$year]['seriesname'] = $year;
                $dataRaw = DB::table("revenue_report")->where('t_year',$year)->selectRaw("CASE WHEN (t_month='JAN' OR t_month='FEB' OR t_month = 'MAR') THEN 'Q1' ELSE CASE WHEN (t_month='APR' OR t_month='MAY' OR t_month = 'JUN') THEN 'Q2' ELSE CASE WHEN (t_month='JUL' OR t_month='AUG' OR t_month = 'SEP') THEN 'Q3' ELSE 'Q4' END END END AS QUARTER, SUM(total_recharge) AS querterlytotal")->groupBy('QUARTER')->orderBy('slno')->pluck('querterlytotal')->toArray();
                $dataRaw = array_map('doubleval',$dataRaw);
                $dataComparison[$year]['data'] = [];
                foreach($dataRaw as $dataRawSingle):
                    array_push($dataComparison[$year]['data'],['value'=>$dataRawSingle]);
                endforeach;
                array_push($dataComparisonQuarterWise, $dataComparison[$year]);
            }
        }
        return $dataComparisonQuarterWise;
    }

    public function getComparisonDataBiannually(){
        $years = DB::table("revenue_report")->selectRaw("DISTINCT t_year")->pluck('t_year')->toArray();
        $dataComparison['yearsInt'] = $years;
        $dataComparison['years'] = array_map('strval', $years);

        $dataComparisonBiannualWise = $this->comparisonBiannual($dataComparison['years']);
        return response()->json($dataComparisonBiannualWise);
    }

    public function comparisonBiannual($years){
        foreach($years as $year){
            $dataComparisonBiannualWise = [];
            foreach($years as $year){
                $dataComparison[$year]['seriesname'] = $year;
                $dataRaw = DB::table("revenue_report")->where('t_year',$year)->selectRaw("CASE WHEN (t_month='JAN' OR t_month='FEB' OR t_month='MAR' OR t_month='APR' OR t_month='MAY' OR t_month='JUN') THEN 'H1' ELSE 'H2' END AS biannual, SUM(total_recharge) AS biannually_total")->groupBy('biannual')->orderBy('slno')->pluck('biannually_total')->toArray();
                $dataRaw = array_map('doubleval',$dataRaw);
                $dataComparison[$year]['data'] = [];
                foreach($dataRaw as $dataRawSingle):
                    array_push($dataComparison[$year]['data'],['value'=>$dataRawSingle]);
                endforeach;
                array_push($dataComparisonBiannualWise, $dataComparison[$year]);
            }
        }
        return $dataComparisonBiannualWise;
    }

    public function getComparisonDataAnnually(){
        $years = DB::table("revenue_report")->selectRaw("DISTINCT t_year")->pluck('t_year')->toArray();
        $dataComparison['yearsInt'] = $years;
        $dataComparison['years'] = array_map('strval', $years);

        $dataComparison['yearlyTotal'] = DB::table("revenue_report")->groupBy("t_year")->orderBy("slno")->selectRaw("t_year, ROUND(SUM(total_recharge),2) AS yearlytotal")->pluck("yearlytotal")->toArray();
        $dataComparison['yearlyTotal'] = array_map('doubleval', $dataComparison['yearlyTotal']);

        $YearDataArray = $this->comparisonYearly($dataComparison['years'], $dataComparison['yearlyTotal']);
        return response()->json($YearDataArray);
    }

    public function comparisonYearly($years, $yearlyTotal){
        $YearDataArray = []; $countYear = $years[0];
        foreach ($yearlyTotal as $yearTotalSingle) {
            array_push($YearDataArray,['label'=>(string)$countYear,'value'=>$yearTotalSingle]);
            $countYear++;
        }
        return $YearDataArray;
    }

    public function channelWisePage(){
        $returnQuarterly = $this->getChannelWiseQuarterly();
        $returnBiannually = $this->getChannelWiseBiannually();
        $returnAnnually = $this->getChannelWiseAnnually();
        $returnMonthly = $this->getChannelWiseMonthly();
        // dd($returnMonthly);
        return view('channelwise')
            ->with('returnQuarterly',$returnQuarterly)
            ->with('returnBiannually',$returnBiannually)
            ->with('returnAnnually', $returnAnnually)
            ->with('returnMonthly',$returnMonthly);
    }

    public function getChannelWiseMonthly(){
        //To show in view
        $today = Carbon::today(); //todays date
        $data['currentMonth'] = $today->format("Y-m");

        //To pass in query
        $year = $today->format("Y");
        $month = $today->format("M");

        $dataChannelWise['monthly'] = DB::table("revenue_report")->orderBy("t_date")->selectRaw("t_date, paper_voucher, etopup, mbob, tpay, bnb, `bdb`, mytashicell, web, sales_and_order, eteeru, digital_kidu, pnb")->where('t_month',$month)->where('t_year', $year)->get()->toArray();
        if($dataChannelWise['monthly'] == null){ //issues in end of the month. So display the previous month's data
            //To show in view
            $today = Carbon::today(); //todays date
            $data['currentMonth'] = $today->subDays(1)->format("Y-m");

            //To pass in query
            $year = $today->format("Y");
            $month = $today->format("M");
            $dataChannelWise['monthly'] = DB::table("revenue_report")->orderBy("t_date")->selectRaw("t_date, paper_voucher, etopup, mbob, tpay, bnb, `bdb`, mytashicell, web, sales_and_order, eteeru, digital_kidu, pnb")->where('t_month',$month)->where('t_year', $year)->get()->toArray();
        }
        $dataValues = [
            ['index'=>'t_date','key'=>'label'],
            ['index'=>'paper_voucher','key'=>'value'],
            ['index'=>'etopup','key'=>'value'],
            ['index'=>'mbob','key'=>'value'],
            ['index'=>'tpay','key'=>'value'],
            ['index'=>'bnb','key'=>'value'],
            ['index'=>'bdb','key'=>'value'],
            ['index'=>'mytashicell','key'=>'value'],
            ['index'=>'web','key'=>'value'],
            ['index'=>'sales_and_order','key'=>'value'],
            ['index'=>'eteeru','key'=>'value'],
            ['index'=>'digital_kidu','key'=>'value'],
            ['index'=>'pnb','key'=>'value'],
        ];
        foreach($dataValues as $dataValue):
            $dataChannel[$dataValue['index']] = array_column($dataChannelWise['monthly'], $dataValue['index']);
        endforeach;
        $count = 0;
        $returnMonthly['t_date'] = [];

        foreach($dataChannel['t_date'] as $category):
            $dataChannel['t_date'][$count] = (string)$category;
            foreach($dataValues as $dataValue):
                if(!isset($returnMonthly[$dataValue['index']])){
                    $returnMonthly[$dataValue['index']] = [];
                }
                array_push($returnMonthly[$dataValue['index']],[$dataValue['key']=>$dataChannel[$dataValue['index']][$count]]);
            endforeach;
            $count++;
        endforeach;
        $returnMonthly['currentMonth'] = $data['currentMonth'];
        return $returnMonthly;
    }

    public function getChannelWiseMonthlyOnChange(Request $request){
        //To show in view
        $today = Carbon::today(); //todays date
        $data['currentMonth'] = $today->format("Y-m");

        //To pass in query
        //$year = $today->format("Y");
        //$month = $today->format("M");

        //To pass in query at load
        $date = $request->monthYear;

        $dateObject = date_create($date);
        $month = date_format($dateObject,"M");
        $year = date_format($dateObject,"Y");

        $dataChannelWise['monthly'] = DB::table("revenue_report")->orderBy("t_date")->selectRaw("t_date, paper_voucher, etopup, mbob, tpay, bnb, `bdb`, mytashicell, web, sales_and_order, eteeru")->where('t_month',$month)->where('t_year', $year)->get()->toArray();

        $dataValues = [
            ['index'=>'t_date','key'=>'label'],
            ['index'=>'paper_voucher','key'=>'value'],
            ['index'=>'etopup','key'=>'value'],
            ['index'=>'mbob','key'=>'value'],
            ['index'=>'tpay','key'=>'value'],
            ['index'=>'bnb','key'=>'value'],
            ['index'=>'bdb','key'=>'value'],
            ['index'=>'mytashicell','key'=>'value'],
            ['index'=>'web','key'=>'value'],
            ['index'=>'sales_and_order','key'=>'value'],
            ['index'=>'eteeru','key'=>'value'],
        ];
        foreach($dataValues as $dataValue):
            $dataChannel[$dataValue['index']] = array_column($dataChannelWise['monthly'], $dataValue['index']);
        endforeach;
        $count = 0;
        $returnMonthly['t_date'] = [];
        foreach($dataChannel['t_date'] as $category):
            $dataChannel['t_date'][$count] = (string)$category;
            foreach($dataValues as $dataValue):
                if(!isset($returnMonthly[$dataValue['index']])){
                    $returnMonthly[$dataValue['index']] = [];
                }
                array_push($returnMonthly[$dataValue['index']],[$dataValue['key']=>$dataChannel[$dataValue['index']][$count]]);
            endforeach;
            $count++;
        endforeach;

        $returnMonthly['currentMonth'] = $data['currentMonth'];
        return $returnMonthly;
    }

    public function getChannelWiseQuarterly(){
        $dataChannelWise['quarterly'] = DB::table("revenue_report")->groupBy("category")->orderBy("slno")->selectRaw("CASE WHEN (t_month='JAN' OR t_month='FEB' OR t_month = 'MAR') THEN CONCAT('Q1-',t_year) ELSE CASE WHEN (t_month='APR' OR t_month='MAY' OR t_month = 'JUN') THEN CONCAT('Q2-',t_year) ELSE CASE WHEN (t_month='JUL' OR t_month='AUG' OR t_month = 'SEP') THEN CONCAT('Q3-', t_year) ELSE CONCAT('Q4-',t_year) END END END AS category, SUM(paper_voucher) AS paper_voucher, SUM(etopup) AS etopup, SUM(mbob) AS mbob, SUM(tpay) AS tpay, SUM(bnb) AS bnb, SUM(`bdb`) AS 'bdb', SUM(mytashicell) AS mytashicell, SUM(web) AS web, SUM(sales_and_order) AS sales_and_order, SUM(eteeru) AS eteeru, SUM(digital_kidu) AS digital_kidu, SUM(pnb) AS pnb")->get()->toArray();

        $dataValues = [
            ['index'=>'category','key'=>'label'],
            ['index'=>'paper_voucher','key'=>'value'],
            ['index'=>'etopup','key'=>'value'],
            ['index'=>'mbob','key'=>'value'],
            ['index'=>'tpay','key'=>'value'],
            ['index'=>'bnb','key'=>'value'],
            ['index'=>'bdb','key'=>'value'],
            ['index'=>'mytashicell','key'=>'value'],
            ['index'=>'web','key'=>'value'],
            ['index'=>'sales_and_order','key'=>'value'],
            ['index'=>'eteeru','key'=>'value'],
            ['index'=>'digital_kidu','key'=>'value'],
            ['index'=>'pnb','key'=>'value'],
        ];
        foreach($dataValues as $dataValue):
            $dataChannel[$dataValue['index']] = array_column($dataChannelWise['quarterly'], $dataValue['index']);
        endforeach;
        $count = 0;
        $returnQuarterly['category'] = [];
        foreach($dataChannel['category'] as $category):
            foreach($dataValues as $dataValue):
                if(!isset($returnQuarterly[$dataValue['index']])){
                    $returnQuarterly[$dataValue['index']] = [];
                }
                array_push($returnQuarterly[$dataValue['index']],[$dataValue['key']=>$dataChannel[$dataValue['index']][$count]]);
            endforeach;
            $count++;
        endforeach;
        return $returnQuarterly;
    }

    public function getChannelWiseBiannually(){
        $dataChannelWise['biannually'] = DB::table("revenue_report")->groupBy("category")->orderBy("slno")->selectRaw("CASE WHEN (t_month='JAN' OR t_month='FEB' OR t_month='MAR' OR t_month='APR' OR t_month='MAY' OR t_month='JUN') THEN CONCAT('H1-',t_year)  ELSE CONCAT('H2-',t_year) END AS category, SUM(paper_voucher) AS paper_voucher, SUM(etopup) AS etopup, SUM(mbob) AS mbob, SUM(tpay) AS tpay, SUM(bnb) AS bnb, SUM(`bdb`) AS 'bdb', SUM(mytashicell) AS mytashicell, SUM(web) AS web, SUM(sales_and_order) AS sales_and_order, SUM(eteeru) AS eteeru, SUM(digital_kidu) AS digital_kidu, SUM(pnb) AS pnb")->get()->toArray();
        $dataValues = [
            ['index'=>'category','key'=>'label'],
            ['index'=>'paper_voucher','key'=>'value'],
            ['index'=>'etopup','key'=>'value'],
            ['index'=>'mbob','key'=>'value'],
            ['index'=>'tpay','key'=>'value'],
            ['index'=>'bnb','key'=>'value'],
            ['index'=>'bdb','key'=>'value'],
            ['index'=>'mytashicell','key'=>'value'],
            ['index'=>'web','key'=>'value'],
            ['index'=>'sales_and_order','key'=>'value'],
            ['index'=>'eteeru','key'=>'value'],
            ['index'=>'digital_kidu','key'=>'value'],
            ['index'=>'pnb','key'=>'value'],
        ];
        foreach($dataValues as $dataValue):
            $dataChannel[$dataValue['index']] = array_column($dataChannelWise['biannually'], $dataValue['index']);
        endforeach;
        $count = 0;
        $returnBiannually['category'] = [];
        foreach($dataChannel['category'] as $category):
            foreach($dataValues as $dataValue):
                if(!isset($returnBiannually[$dataValue['index']])){
                    $returnBiannually[$dataValue['index']] = [];
                }
                array_push($returnBiannually[$dataValue['index']],[$dataValue['key']=>$dataChannel[$dataValue['index']][$count]]);
            endforeach;
            $count++;
        endforeach;
        return $returnBiannually;
    }

    public function getChannelWiseAnnually(){
        $dataChannelWise['annually'] = DB::table("revenue_report")->groupBy("category")->orderBy("slno")->selectRaw("CAST(t_year AS CHAR(7)) AS category, SUM(paper_voucher) AS paper_voucher, SUM(etopup) AS etopup, SUM(mbob) AS mbob, SUM(tpay) AS tpay, SUM(bnb) AS bnb, SUM(`bdb`) AS 'bdb', SUM(mytashicell) AS mytashicell, SUM(web) AS web, SUM(sales_and_order) AS sales_and_order, SUM(eteeru) AS eteeru, SUM(digital_kidu) AS digital_kidu, SUM(pnb) AS pnb")->get()->toArray();
        $dataValues = [
            ['index'=>'category','key'=>'label'],
            ['index'=>'paper_voucher','key'=>'value'],
            ['index'=>'etopup','key'=>'value'],
            ['index'=>'mbob','key'=>'value'],
            ['index'=>'tpay','key'=>'value'],
            ['index'=>'bnb','key'=>'value'],
            ['index'=>'bdb','key'=>'value'],
            ['index'=>'mytashicell','key'=>'value'],
            ['index'=>'web','key'=>'value'],
            ['index'=>'sales_and_order','key'=>'value'],
            ['index'=>'eteeru','key'=>'value'],
            ['index'=>'digital_kidu','key'=>'value'],
            ['index'=>'pnb','key'=>'value'],
        ];
        foreach($dataValues as $dataValue):
            $dataChannel[$dataValue['index']] = array_column($dataChannelWise['annually'], $dataValue['index']);
        endforeach;
        $count = 0;
        $returnAnnually['category'] = [];
        foreach($dataChannel['category'] as $category):
            foreach($dataValues as $dataValue):
                if(!isset($returnAnnually[$dataValue['index']])){
                    $returnAnnually[$dataValue['index']] = [];
                }
                array_push($returnAnnually[$dataValue['index']],[$dataValue['key']=>$dataChannel[$dataValue['index']][$count]]);
            endforeach;
            $count++;
        endforeach;
        return $returnAnnually;
    }

    public function getDailyConsumption(){
        //To show in view
        $today = Carbon::today()->subDays(0); //yesterday's date
        $data['todaysDate'] = $today->format("Y-m-d");
        $data['currentMonth'] = $today->format("Y-m");

        //To pass in query
        $date = $today->format("j");
        $month = $today->format("M");
        $year = $today->format("Y");

        $data['dailyStatistics'] = DB::select("SELECT t_date, t_month, t_year, subs_activated, subs_deactivated, total_subs, leasedline_subs, total_vlr_subs, active_subs_cbs, powered_on_subs FROM revenue_report WHERE t_date=".$date." AND t_month='".$month."' AND t_year=".$year.";");

        return view('dailyconsumption',$data);
    }

    public function fetchDailyConsumption(Request $request){
        $date = $request->consumptionDate;

        $dateObject = date_create($date);
        $date = date_format($dateObject, "j");
        $month = date_format($dateObject,"M");
        $year = date_format($dateObject,"Y");

        $totalDailyConsumption = DB::select("SELECT IFNULL(onnet_voice, 0) + IFNULL(offnet_voice,0) + IFNULL(international_voice,0) + IFNULL(sms, 0) + IFNULL(validity_booster_7days,0) + IFNULL(validity_booster_15days,0) + IFNULL(validity_booster_30days,0) + IFNULL(data_plan,0) + IFNULL(data_pay_per_use,0) AS totaldailyconsumption FROM revenue_report WHERE t_date=".$date." AND t_month='".$month."' AND t_year=".$year.";");
        $dailyConsumption = DB::select("SELECT onnet_voice, offnet_voice, international_voice, sms, IFNULL(validity_booster_7days, 0) + IFNULL(validity_booster_15days, 0) + IFNULL(validity_booster_30days,0) AS validity_booster, data_plan, data_pay_per_use FROM revenue_report WHERE t_date=".$date." AND t_month='".$month."' AND t_year=".$year.";");
        $dataArray = [];
        if(count($dailyConsumption)==0){
            $dataArray = [0,0,0,0,0,0,0];
        }else{
            array_push($dataArray,["label"=>"Onnet Voice","value"=>$dailyConsumption[0]->onnet_voice]);
            array_push($dataArray,["label"=>"Offnet Voice","value"=>$dailyConsumption[0]->offnet_voice]);
            array_push($dataArray,["label"=>"International Voice","value"=>$dailyConsumption[0]->international_voice]);
            array_push($dataArray,["label"=>"SMS","value"=>$dailyConsumption[0]->sms]);
            array_push($dataArray,["label"=>"Validity Booster","value"=>$dailyConsumption[0]->validity_booster]);
            array_push($dataArray,["label"=>"Data Plan","value"=>$dailyConsumption[0]->data_plan]);
            array_push($dataArray,["label"=>"Data Pay Per Use","value"=>$dailyConsumption[0]->data_pay_per_use]);
        }
        return ['dataArray'=>$dataArray, 'totalDailyConsumptionFormatted'=>number_format($totalDailyConsumption[0]->totaldailyconsumption,2), 'totalDailyConsumption'=>$totalDailyConsumption[0]->totaldailyconsumption];
    }

    public function fetchMonthlyConsumption(Request $request){
        $date = $request->monthYear;
        $dateObject = date_create($date);
        $month = date_format($dateObject,"M");
        $year = date_format($dateObject,"Y");

        $monthlyConsumptionData = DB::select("SELECT t_date, total_on_on_iv_sms_vb_dr AS total_consumption FROM revenue_report WHERE t_month='".$month."' AND t_year=".$year.";");
        $monthlyConsumptionTotal = DB::select("SELECT SUM(total_on_on_iv_sms_vb_dr) AS MonthlyConsumptionTotal FROM revenue_report WHERE t_month='".$month."' AND t_year=".$year.";");
        $dataArray = [];
        foreach ($monthlyConsumptionData as $monthlyConsumptionDatas) {
            array_push($dataArray,['label'=>(string)$monthlyConsumptionDatas->t_date,'value'=>$monthlyConsumptionDatas->total_consumption]);
        }
        return ['dataArray'=>$dataArray, 'totalMonthly'=>number_format($monthlyConsumptionTotal[0]->MonthlyConsumptionTotal,2)];
    }

    public function getComparisonConsumptionData(){
        $years = DB::table("revenue_report")->selectRaw("DISTINCT t_year")->pluck('t_year')->toArray();
        $dataComparison['yearsInt'] = $years;
        $dataComparison['years'] = array_map('strval', $years);

        $dataComparison['yearlyTotal'] = DB::table("revenue_report")->groupBy("t_year")->orderBy("slno")->selectRaw("t_year, ROUND(SUM(total_on_on_iv_sms_vb_dr),2) AS yearlytotal")->pluck("yearlytotal")->toArray();
        $dataComparison['yearlyTotal'] = array_map('doubleval', $dataComparison['yearlyTotal']);

        $dataComparisonMonthWise = $this->comparisonConsumptionMonthWise($dataComparison['years']);
        $dataComparisonQuarterWise = $this->comparisonConsumptionQuarterWise($dataComparison['years']);
        $dataComparisonBiannualWise = $this->comparisonConsumptionBiannual($dataComparison['years']);
        $YearDataArray = $this->comparisonConsumptionYearly($dataComparison['years'], $dataComparison['yearlyTotal']);

        $dataComparison['monthly'] = $dataComparisonMonthWise;
        $dataComparison['quarterly'] = $dataComparisonQuarterWise;
        $dataComparison['biannually'] = $dataComparisonBiannualWise;
        $dataComparison['yearly'] = $YearDataArray;

        return view('comparisonconsumption',$dataComparison);
    }

    public function getComparisonConsumptionDataMonthly(){
        $years = DB::table("revenue_report")->selectRaw("DISTINCT t_year")->pluck('t_year')->toArray();
        $dataComparison['yearsInt'] = $years;
        $dataComparison['years'] = array_map('strval', $years);

        $dataComparisonMonthWise = $this->comparisonConsumptionMonthWise($dataComparison['years']);
        return response()->json($dataComparisonMonthWise);
    }

    public function comparisonConsumptionMonthWise($years){
        $dataComparisonMonthWise = [];
        foreach($years as $year){
            $dataComparison[$year]['seriesname'] = $year;
            $dataRaw = DB::table("revenue_report")->where('t_year',$year)->selectRaw("ROUND(SUM(total_on_on_iv_sms_vb_dr),2) as monthlytotal")->groupBy('t_year')->groupBy('t_month')->orderBy('slno')->pluck('monthlytotal')->toArray();
            $dataRaw = array_map('doubleval',$dataRaw);
            $dataComparison[$year]['data'] = [];
            foreach($dataRaw as $dataRawSingle):
                array_push($dataComparison[$year]['data'],['value'=>$dataRawSingle]);
            endforeach;
            array_push($dataComparisonMonthWise,$dataComparison[$year]);
        }
        return $dataComparisonMonthWise;
    }

    public function getConsumptionQuarterly(){
        $years = DB::table("revenue_report")->selectRaw("DISTINCT t_year")->pluck('t_year')->toArray();
        $dataComparison['yearsInt'] = $years;
        $dataComparison['years'] = array_map('strval', $years);

        $dataComparisonQuarterWise = $this->comparisonConsumptionQuarterWise($dataComparison['years']);
        return response()->json($dataComparisonQuarterWise);
    }

    public function comparisonConsumptionQuarterWise($years){
        foreach($years as $year){
            $dataComparisonQuarterWise = [];
            foreach($years as $year){
                $dataComparison[$year]['seriesname'] = $year;
                $dataRaw = DB::table("revenue_report")->where('t_year',$year)->selectRaw("CASE WHEN (t_month='JAN' OR t_month='FEB' OR t_month = 'MAR') THEN 'Q1' ELSE CASE WHEN (t_month='APR' OR t_month='MAY' OR t_month = 'JUN') THEN 'Q2' ELSE CASE WHEN (t_month='JUL' OR t_month='AUG' OR t_month = 'SEP') THEN 'Q3' ELSE 'Q4' END END END AS QUARTER, SUM(total_on_on_iv_sms_vb_dr) AS querterlytotal")->groupBy('QUARTER')->orderBy('slno')->pluck('querterlytotal')->toArray();
                $dataRaw = array_map('doubleval',$dataRaw);
                $dataComparison[$year]['data'] = [];
                foreach($dataRaw as $dataRawSingle):
                    array_push($dataComparison[$year]['data'],['value'=>$dataRawSingle]);
                endforeach;
                array_push($dataComparisonQuarterWise, $dataComparison[$year]);
            }
        }
        return $dataComparisonQuarterWise;
    }

    public function getConsumptionBiannually(){
        $years = DB::table("revenue_report")->selectRaw("DISTINCT t_year")->pluck('t_year')->toArray();
        $dataComparison['yearsInt'] = $years;
        $dataComparison['years'] = array_map('strval', $years);

        $dataComparisonBiannualWise = $this->comparisonConsumptionBiannual($dataComparison['years']);
        return response()->json($dataComparisonBiannualWise);
    }

    public function comparisonConsumptionBiannual($years){
        foreach($years as $year){
            $dataComparisonBiannualWise = [];
            foreach($years as $year){
                $dataComparison[$year]['seriesname'] = $year;
                $dataRaw = DB::table("revenue_report")->where('t_year',$year)->selectRaw("CASE WHEN (t_month='JAN' OR t_month='FEB' OR t_month='MAR' OR t_month='APR' OR t_month='MAY' OR t_month='JUN') THEN 'H1' ELSE 'H2' END AS biannual, SUM(total_on_on_iv_sms_vb_dr) AS biannually_total")->groupBy('biannual')->orderBy('slno')->pluck('biannually_total')->toArray();
                $dataRaw = array_map('doubleval',$dataRaw);
                $dataComparison[$year]['data'] = [];
                foreach($dataRaw as $dataRawSingle):
                    array_push($dataComparison[$year]['data'],['value'=>$dataRawSingle]);
                endforeach;
                array_push($dataComparisonBiannualWise, $dataComparison[$year]);
            }
        }
        return $dataComparisonBiannualWise;
    }

    public function getConsumptionAnnually(){
        $years = DB::table("revenue_report")->selectRaw("DISTINCT t_year")->pluck('t_year')->toArray();
        $dataComparison['yearsInt'] = $years;
        $dataComparison['years'] = array_map('strval', $years);

        $dataComparison['yearlyTotal'] = DB::table("revenue_report")->groupBy("t_year")->orderBy("slno")->selectRaw("t_year, ROUND(SUM(total_on_on_iv_sms_vb_dr),2) AS yearlytotal")->pluck("yearlytotal")->toArray();
        $dataComparison['yearlyTotal'] = array_map('doubleval', $dataComparison['yearlyTotal']);

        $YearDataArray = $this->comparisonConsumptionYearly($dataComparison['years'], $dataComparison['yearlyTotal']);
        return response()->json($YearDataArray);
    }

    public function comparisonConsumptionYearly($years, $yearlyTotal){
        $YearDataArray = []; $countYear = $years[0];
        foreach ($yearlyTotal as $yearTotalSingle) {
            array_push($YearDataArray,['label'=>(string)$countYear,'value'=>$yearTotalSingle]);
            $countYear++;
        }
        return $YearDataArray;
    }

    public function channelWiseConsumptionPage(){
        $returnQuarterly = $this->getChannelWiseConsumptionQuarterly();
        $returnBiannually = $this->getChannelWiseConsumptionBiannually();
        $returnAnnually = $this->getChannelWiseConsumptionAnnually();
        $returnMonthly = $this->getChannelWiseConsumptionMonthly();

        return view('channelwiseconsumption')
            ->with('returnQuarterly',$returnQuarterly)
            ->with('returnBiannually',$returnBiannually)
            ->with('returnAnnually', $returnAnnually)
            ->with('returnMonthly',$returnMonthly);
    }

    public function getChannelWiseConsumptionMonthly(){
        //To show in view
        $today = Carbon::today(); //todays date
        $data['currentMonth'] = $today->format("Y-m");

        //To pass in query
        $year = $today->format("Y");
        $month = $today->format("M");

        $dataChannelWise['monthly'] = DB::table("revenue_report")->orderBy("t_date")->selectRaw("t_date, onnet_voice, offnet_voice, international_voice, sms, validity_booster_7days+validity_booster_15days+validity_booster_30days AS validity_booster, data_plan, data_pay_per_use")->where('t_month',$month)->where('t_year', $year)->get()->toArray();
        if($dataChannelWise['monthly'] == null){
            //To show in view
            $today = Carbon::today(); //todays date
            $data['currentMonth'] = $today->subDays(1)->format("Y-m");

            //To pass in query
            $year = $today->format("Y");
            $month = $today->format("M");

            $dataChannelWise['monthly'] = DB::table("revenue_report")->orderBy("t_date")->selectRaw("t_date, onnet_voice, offnet_voice, international_voice, sms, validity_booster_7days+validity_booster_15days+validity_booster_30days AS validity_booster, data_plan, data_pay_per_use")->where('t_month',$month)->where('t_year', $year)->get()->toArray();
        }
        $dataValues = [
            ['index'=>'t_date','key'=>'label'],
            ['index'=>'onnet_voice','key'=>'value'],
            ['index'=>'offnet_voice','key'=>'value'],
            ['index'=>'international_voice','key'=>'value'],
            ['index'=>'sms','key'=>'value'],
            ['index'=>'validity_booster','key'=>'value'],
            ['index'=>'data_plan','key'=>'value'],
            ['index'=>'data_pay_per_use','key'=>'value'],
        ];
        foreach($dataValues as $dataValue):
            $dataChannel[$dataValue['index']] = array_column($dataChannelWise['monthly'], $dataValue['index']);
        endforeach;
        $count = 0;
        $returnMonthly['t_date'] = [];

        foreach($dataChannel['t_date'] as $category):
            $dataChannel['t_date'][$count] = (string)$category;
            foreach($dataValues as $dataValue):
                if(!isset($returnMonthly[$dataValue['index']])){
                    $returnMonthly[$dataValue['index']] = [];
                }
                array_push($returnMonthly[$dataValue['index']],[$dataValue['key']=>$dataChannel[$dataValue['index']][$count]]);
            endforeach;
            $count++;
        endforeach;
        $returnMonthly['currentMonth'] = $data['currentMonth'];
        return $returnMonthly;
    }

    public function getChannelWiseConsumptionMonthlyOnChange(Request $request){
        //To show in view
        $today = Carbon::today(); //todays date
        $data['currentMonth'] = $today->format("Y-m");

        //To pass in query at load
        $date = $request->monthYear;

        $dateObject = date_create($date);
        $month = date_format($dateObject,"M");
        $year = date_format($dateObject,"Y");

        $dataChannelWise['monthly'] = DB::table("revenue_report")->orderBy("t_date")->selectRaw("t_date, onnet_voice, offnet_voice, international_voice, sms, validity_booster_7days+validity_booster_15days+validity_booster_30days AS validity_booster, data_plan, data_pay_per_use")->where('t_month',$month)->where('t_year', $year)->get()->toArray();

        $dataValues = [
            ['index'=>'t_date','key'=>'label'],
            ['index'=>'onnet_voice','key'=>'value'],
            ['index'=>'offnet_voice','key'=>'value'],
            ['index'=>'international_voice','key'=>'value'],
            ['index'=>'sms','key'=>'value'],
            ['index'=>'validity_booster','key'=>'value'],
            ['index'=>'data_plan','key'=>'value'],
            ['index'=>'data_pay_per_use','key'=>'value'],
        ];
        foreach($dataValues as $dataValue):
            $dataChannel[$dataValue['index']] = array_column($dataChannelWise['monthly'], $dataValue['index']);
        endforeach;
        $count = 0;
        $returnMonthly['t_date'] = [];

        foreach($dataChannel['t_date'] as $category):
            $dataChannel['t_date'][$count] = (string)$category;
            foreach($dataValues as $dataValue):
                if(!isset($returnMonthly[$dataValue['index']])){
                    $returnMonthly[$dataValue['index']] = [];
                }
                array_push($returnMonthly[$dataValue['index']],[$dataValue['key']=>$dataChannel[$dataValue['index']][$count]]);
            endforeach;
            $count++;
        endforeach;
        $returnMonthly['currentMonth'] = $data['currentMonth'];
        return $returnMonthly;
    }

    public function getChannelWiseConsumptionQuarterly(){
        $dataChannelWise['quarterly'] = DB::table("revenue_report")->groupBy("category")->orderBy("slno")->selectRaw("CASE WHEN (t_month='JAN' OR t_month='FEB' OR t_month = 'MAR') THEN CONCAT('Q1-',t_year) ELSE CASE WHEN (t_month='APR' OR t_month='MAY' OR t_month = 'JUN') THEN CONCAT('Q2-',t_year) ELSE CASE WHEN (t_month='JUL' OR t_month='AUG' OR t_month = 'SEP') THEN CONCAT('Q3-', t_year) ELSE CONCAT('Q4-',t_year) END END END AS category, SUM(onnet_voice) AS onnet_voice, SUM(offnet_voice) AS offnet_voice, SUM(international_voice) AS international_voice, SUM(sms) AS sms, SUM(validity_booster_7days)+SUM(validity_booster_15days)+SUM(validity_booster_30days) AS validity_booster, SUM(data_plan) AS data_plan, SUM(data_pay_per_use) AS data_pay_per_use")->get()->toArray();
        $dataValues = [
            ['index'=>'category','key'=>'label'],
            ['index'=>'onnet_voice','key'=>'value'],
            ['index'=>'offnet_voice','key'=>'value'],
            ['index'=>'international_voice','key'=>'value'],
            ['index'=>'sms','key'=>'value'],
            ['index'=>'validity_booster','key'=>'value'],
            ['index'=>'data_plan','key'=>'value'],
            ['index'=>'data_pay_per_use','key'=>'value'],
        ];
        foreach($dataValues as $dataValue):
            $dataChannel[$dataValue['index']] = array_column($dataChannelWise['quarterly'], $dataValue['index']);
        endforeach;
        $count = 0;
        $returnQuarterly['category'] = [];
        foreach($dataChannel['category'] as $category):
            foreach($dataValues as $dataValue):
                if(!isset($returnQuarterly[$dataValue['index']])){
                    $returnQuarterly[$dataValue['index']] = [];
                }
                array_push($returnQuarterly[$dataValue['index']],[$dataValue['key']=>$dataChannel[$dataValue['index']][$count]]);
            endforeach;
            $count++;
        endforeach;
        return $returnQuarterly;
    }

    public function getChannelWiseConsumptionBiannually(){
        $dataChannelWise['biannually'] = DB::table("revenue_report")->groupBy("category")->orderBy("slno")->selectRaw("CASE WHEN (t_month='JAN' OR t_month='FEB' OR t_month='MAR' OR t_month='APR' OR t_month='MAY' OR t_month='JUN') THEN CONCAT('H1-',t_year)  ELSE CONCAT('H2-',t_year) END AS category, SUM(onnet_voice) AS onnet_voice, SUM(offnet_voice) AS offnet_voice, SUM(international_voice) AS international_voice, SUM(sms) AS sms, SUM(validity_booster_7days)+SUM(validity_booster_15days)+SUM(validity_booster_30days) AS validity_booster, SUM(data_plan) AS data_plan, SUM(data_pay_per_use) AS data_pay_per_use")->get()->toArray();
        $dataValues = [
            ['index'=>'category','key'=>'label'],
            ['index'=>'onnet_voice','key'=>'value'],
            ['index'=>'offnet_voice','key'=>'value'],
            ['index'=>'international_voice','key'=>'value'],
            ['index'=>'sms','key'=>'value'],
            ['index'=>'validity_booster','key'=>'value'],
            ['index'=>'data_plan','key'=>'value'],
            ['index'=>'data_pay_per_use','key'=>'value'],
        ];
        foreach($dataValues as $dataValue):
            $dataChannel[$dataValue['index']] = array_column($dataChannelWise['biannually'], $dataValue['index']);
        endforeach;
        $count = 0;
        $returnBiannually['category'] = [];
        foreach($dataChannel['category'] as $category):
            foreach($dataValues as $dataValue):
                if(!isset($returnBiannually[$dataValue['index']])){
                    $returnBiannually[$dataValue['index']] = [];
                }
                array_push($returnBiannually[$dataValue['index']],[$dataValue['key']=>$dataChannel[$dataValue['index']][$count]]);
            endforeach;
            $count++;
        endforeach;
        return $returnBiannually;
    }

    public function getChannelWiseConsumptionAnnually(){
        $dataChannelWise['annually'] = DB::table("revenue_report")->groupBy("category")->orderBy("slno")->selectRaw("CAST(t_year AS CHAR(7)) AS category, SUM(onnet_voice) AS onnet_voice, SUM(offnet_voice) AS offnet_voice, SUM(international_voice) AS international_voice, SUM(sms) AS sms, SUM(validity_booster_7days)+SUM(validity_booster_15days)+SUM(validity_booster_30days) AS validity_booster, SUM(data_plan) AS data_plan, SUM(data_pay_per_use) AS data_pay_per_use")->get()->toArray();
        $dataValues = [
            ['index'=>'category','key'=>'label'],
            ['index'=>'onnet_voice','key'=>'value'],
            ['index'=>'offnet_voice','key'=>'value'],
            ['index'=>'international_voice','key'=>'value'],
            ['index'=>'sms','key'=>'value'],
            ['index'=>'validity_booster','key'=>'value'],
            ['index'=>'data_plan','key'=>'value'],
            ['index'=>'data_pay_per_use','key'=>'value'],
        ];
        foreach($dataValues as $dataValue):
            $dataChannel[$dataValue['index']] = array_column($dataChannelWise['annually'], $dataValue['index']);
        endforeach;
        $count = 0;
        $returnAnnually['category'] = [];
        foreach($dataChannel['category'] as $category):
            foreach($dataValues as $dataValue):
                if(!isset($returnAnnually[$dataValue['index']])){
                    $returnAnnually[$dataValue['index']] = [];
                }
                array_push($returnAnnually[$dataValue['index']],[$dataValue['key']=>$dataChannel[$dataValue['index']][$count]]);
            endforeach;
            $count++;
        endforeach;
        return $returnAnnually;
    }

    public function fetchDailyFigures(Request $request){
        $date = $request->date;

        $dateObject = date_create($date);
        $date = date_format($dateObject,"j");
        $month = date_format($dateObject,"M");
        $year = date_format($dateObject,"Y");
        $data['dailyStatistics'] = DB::select("SELECT t_date, t_month, t_year, subs_activated, subs_deactivated, total_subs, leasedline_subs, total_vlr_subs, active_subs_cbs, powered_on_subs FROM revenue_report WHERE t_date=".$date." AND t_month='".$month."' AND t_year=".$year.";");
        return view('dailyfigures',$data);
    }

    public function tablePage(){
        $year = date('Y');
        $dataTable['yearall'] = DB::table("revenue_report")->orderByDesc("t_year")->selectRaw("DISTINCT t_year")->get()->toArray();
        $dataTable['tableprepaidmonthly'] = $this->getTablePrepaidMonthly($year);

        return view('tablepage', $dataTable);
    }

    public function tableAllPage(){
        $year = date('Y');
        $month = date('M');

        //query to get unique year from db
        $dataTable['yearall'] = DB::table("revenue_report")->orderByDesc("t_year")->selectRaw("DISTINCT t_year")->get()->toArray();
        $dataTable['currentyearsmonth'] = DB::table("revenue_report")->where("t_year", $year)->orderByDesc("t_year")->selectRaw("DISTINCT t_month")->get()->toArray();
        $dataTable['currentyear'] = $year;
        $dataTable['currentmonth'] = strtoupper($month);
        $dataTable['tableprepaid'] = $this->getTablePrepaidTabs($month, $year);
        return view('tableallpage', $dataTable);
    }

    public function getTablePrepaidTabs($month,$year){
        $dataTable['tableprepaid'] = DB::select("(SELECT 'Total' AS `date`, SUM(paper_voucher) AS paper_voucher, SUM(paper_voucher_tax) AS paper_voucher_tax, SUM(etopup) AS etopup, SUM(etopup_tax) AS etopup_tax, SUM(mbob) AS mbob, SUM(mbob_tax) AS mbob_tax, SUM(tpay) AS tpay, SUM(tpay_tax) AS tpay_tax, SUM(bnb) AS bnb, SUM(bnb_tax) AS bnb_tax, SUM(`bdb`) AS `bdb`, SUM(bdb_tax) AS bdb_tax, SUM(mytashicell) AS mytashicell, SUM(mytashicell_tax) AS mytashicell_tax, SUM(web) AS web, SUM(web_tax) AS web_tax, SUM(sales_and_order) AS sales_and_order, SUM(sales_and_order_tax) AS sales_and_order_tax, SUM(eteeru) AS eteeru, SUM(eteeru_tax) AS eteeru_tax, SUM(digital_kidu) AS digital_kidu, SUM(pnb) AS pnb, SUM(total_recharge) AS total_recharge, SUM(total_recharge_tax) AS total_recharge_tax FROM revenue_report WHERE t_month='".$month."' AND t_year=".$year.") UNION ALL (SELECT CONCAT(t_date,'-',t_month,'-',t_year) AS `date`, paper_voucher, paper_voucher_tax, etopup, etopup_tax, mbob, mbob_tax, tpay, tpay_tax, bnb, bnb_tax, `bdb`, bdb_tax, mytashicell, mytashicell_tax, web, web_tax, sales_and_order, sales_and_order_tax, eteeru, eteeru_tax, digital_kidu, pnb, total_recharge, total_recharge_tax FROM revenue_report  WHERE t_month='".$month."' AND t_year=".$year.") ORDER BY STR_TO_DATE(`date`, '%e-%b-%Y') DESC");
        return $dataTable['tableprepaid'];
    }

    public function prepaidMonthlyAjax(Request $request){
        $year = $request->date;
        return $this->getTablePrepaidMonthly($year);
    }

    public function prepaidMonthlyAllTabAjax(Request $request){
        $month = $request->month;
        $year = $request->year;
        return $this->getTablePrepaidAllMonthly($month, $year);
    }

    public function consumptionMonthlyAjax(Request $request){
        $year = $request->date;
        return $this->getTableConsumptionMonthly($year);
    }

    public function consumptionMonthlyAllTabAjax(Request $request){
        $month = $request->month;
        $year = $request->year;
        return $this->getTableConsumptionMonthlyAjax($month, $year);
    }

    public function getTablePrepaidMonthly($year){
        $dataTable['tableprepaidmonthly'] = DB::select("SELECT '1' as OrderColumn,t_month, SUM(paper_voucher) AS paper_voucher, SUM(etopup) AS etopup, SUM(mbob) AS mbob, SUM(tpay) AS tpay, SUM(bnb) AS bnb, SUM(`bdb`) AS `bdb`, SUM(mytashicell) AS mytashicell, SUM(web) AS web, SUM(sales_and_order) AS sales_and_order, SUM(eteeru) AS eteeru, SUM(digital_kidu) AS digital_kidu, SUM(pnb) AS pnb, SUM(total_recharge) AS monthlytotal FROM revenue_report WHERE t_year=".$year." GROUP BY t_month UNION ALL SELECT '2' as OrderColumn,'Total' AS t_month, SUM(paper_voucher) AS paper_voucher, SUM(etopup) AS etopup, SUM(mbob) AS mbob, SUM(tpay) AS tpay, SUM(bnb) AS bnb, SUM(`bdb`) AS `bdb`, SUM(mytashicell) AS mytashicell, SUM(web) AS web, SUM(sales_and_order) AS sales_and_order, SUM(eteeru) AS eteeru, SUM(digital_kidu) AS digital_kidu, SUM(pnb) AS pnb, SUM(total_recharge) AS monthlytotal FROM revenue_report WHERE t_year=".$year." ORDER BY OrderColumn,STR_TO_DATE(concat('$year','-',t_month,'-01'), '%Y-%b-%d')");
        return $dataTable['tableprepaidmonthly'];
    }

    public function getTablePrepaidAllMonthly($month,$year){
        $dataTable['tableprepaidmonthly'] = DB::select("(SELECT 'Total' AS `date`, SUM(paper_voucher) AS paper_voucher, SUM(paper_voucher_tax) AS paper_voucher_tax, SUM(etopup) AS etopup, SUM(etopup_tax) AS etopup_tax, SUM(mbob) AS mbob, SUM(mbob_tax) AS mbob_tax, SUM(tpay) AS tpay, SUM(tpay_tax) AS tpay_tax, SUM(bnb) AS bnb, SUM(bnb_tax) AS bnb_tax, SUM(`bdb`) AS `bdb`, SUM(bdb_tax) AS bdb_tax, SUM(mytashicell) AS mytashicell, SUM(mytashicell_tax) AS mytashicell_tax, SUM(web) AS web, SUM(web_tax) AS web_tax, SUM(sales_and_order) AS sales_and_order, SUM(sales_and_order_tax) AS sales_and_order_tax, SUM(eteeru) AS eteeru, SUM(eteeru_tax) AS eteeru_tax, SUM(digital_kidu) AS digital_kidu, SUM(pnb) AS pnb, SUM(total_recharge) AS total_recharge, SUM(total_recharge_tax) AS total_recharge_tax FROM revenue_report WHERE t_month='".$month."' AND t_year=".$year.") UNION ALL (SELECT CONCAT(t_date,'-',t_month,'-',t_year) AS `date`, paper_voucher, paper_voucher_tax, etopup, etopup_tax, mbob, mbob_tax, tpay, tpay_tax, bnb, bnb_tax, `bdb`, bdb_tax, mytashicell, mytashicell_tax, web, web_tax, sales_and_order, sales_and_order_tax, eteeru, eteeru_tax, digital_kidu, pnb, total_recharge, total_recharge_tax FROM revenue_report  WHERE t_month='".$month."' AND t_year=".$year.") ORDER BY STR_TO_DATE(`date`, '%e-%b-%Y') DESC");
        return $dataTable['tableprepaidmonthly'];
    }

    public function comparisonFigures(){
        $years = DB::table("revenue_report")->selectRaw("DISTINCT t_year")->pluck('t_year')->toArray();
        $dataComparison['yearsInt'] = $years;
        $dataComparison['years'] = array_map('strval', $years);

        $unionFirstQuery = DB::table("revenue_report")->selectRaw("t_year, total_subs")->orderByDesc("slno")->limit(1);
        $dataComparison['yearEndSubscriber'] = DB::table("revenue_report")->selectRaw("t_year, total_subs")->where('t_date',31)->where('t_month', 'DEC')->unionAll($unionFirstQuery)->pluck("total_subs")->toArray();

        $YearDataArray = $this->comparisonSubsFigureYearly($dataComparison['years'], $dataComparison['yearEndSubscriber']);

        $dataComparison['yearly'] = $YearDataArray;
        return view('comparisonfigures', $dataComparison);
    }

    public function fetchComparisonFigureSubsAnnually(){
        $years = DB::table("revenue_report")->selectRaw("DISTINCT t_year")->pluck('t_year')->toArray();
        $dataComparison['yearsInt'] = $years;
        $dataComparison['years'] = array_map('strval', $years);

        $unionFirstQuery = DB::table("revenue_report")->selectRaw("t_year, total_subs")->orderByDesc("slno")->limit(1);
        $dataComparison['yearEndSubscriber'] = DB::table("revenue_report")->selectRaw("t_year, total_subs")->where('t_date',31)->where('t_month', 'DEC')->unionAll($unionFirstQuery)->pluck("total_subs")->toArray();

        $YearDataArray = $this->comparisonSubsFigureYearly($dataComparison['years'], $dataComparison['yearEndSubscriber']);
        return response()->json($YearDataArray);
    }

    public function comparisonSubsFigureYearly($years, $yearlyTotal){
        $YearDataArray = []; $countYear = $years[0];
        foreach ($yearlyTotal as $yearTotalSingle) {
            array_push($YearDataArray,['label'=>(string)$countYear,'value'=>$yearTotalSingle]);
            $countYear++;
        }
        return $YearDataArray;
    }

    public function tableConsumption(){
        $year = date('Y');
        $dataTable['yearall'] = DB::table("revenue_report")->orderByDesc("t_year")->selectRaw("DISTINCT t_year")->get()->toArray();
        $dataTable['tableconsumptionmonthly'] = $this->getTableConsumptionMonthly($year);
        return view('tableconsumption', $dataTable);
    }

    public function tableConsumptionAll(){
        $year = date('Y');
        $month = date('M');

        //query to get unique year from db
        $dataTable['yearall'] = DB::table("revenue_report")->orderByDesc("t_year")->selectRaw("DISTINCT t_year")->get()->toArray();
        $dataTable['currentyearsmonth'] = DB::table("revenue_report")->where("t_year", $year)->orderByDesc("t_year")->selectRaw("DISTINCT t_month")->get()->toArray();
        $dataTable['currentyear'] = $year;
        $dataTable['currentmonth'] = strtoupper($month);

        $dataTable['tableconsumption'] = $this->getTableConsumptionTabs($month, $year);
        return view('tableconsumptionall', $dataTable);
    }

    public function tableFigures(){
        $year = date('Y');
        $month = date('M');

        //query to get unique year from db
        $dataTable['yearall'] = DB::table("revenue_report")->orderByDesc("t_year")->selectRaw("DISTINCT t_year")->get()->toArray();
        $dataTable['currentyearsmonth'] = DB::table("revenue_report")->where("t_year", $year)->orderByDesc("t_year")->selectRaw("DISTINCT t_month")->get()->toArray();
        $dataTable['currentyear'] = $year;
        $dataTable['currentmonth'] = strtoupper($month);
        $dataTable['tablefigures'] = $this->getTableFigures($month, $year);
        return view('tablefigures', $dataTable);
    }

    public function getTableConsumptionTabs($month,$year){
        $dataTable['tableconsumption'] = DB::select("(SELECT CONCAT(t_date,'-',t_month,'-',t_year) AS `date`, onnet_voice, offnet_voice, international_voice, sms, validity_booster_7days, validity_booster_15days, validity_booster_30days, data_plan, data_pay_per_use, total_on_on_iv_sms_vb_dr AS total_comsumption FROM revenue_report WHERE t_month='".$month."' AND t_year=".$year.") UNION ALL (SELECT 'Total' AS `date`, SUM(onnet_voice) AS onnet_voice, SUM(offnet_voice) AS offnet_voice, SUM(international_voice) AS international_voice, SUM(sms) AS sms, SUM(validity_booster_7days) AS validity_booster_7days, SUM(validity_booster_15days) AS validity_booster_15days, SUM(validity_booster_30days) AS validity_booster_30days, SUM(data_plan) AS data_plan, SUM(data_pay_per_use) AS data_pay_per_use, SUM(total_on_on_iv_sms_vb_dr) AS total_comsumption FROM revenue_report WHERE t_month='".$month."' AND t_year=".$year.") ORDER BY STR_TO_DATE(`date`, '%e-%b-%Y') DESC");

        return $dataTable['tableconsumption'];
    }

    public function getTableConsumption(){
        $dataTable['tableconsumption'] = DB::table("revenue_report")->selectRaw("slno, CONCAT(t_date,'-',t_month,'-',t_year) AS `date`, onnet_voice, offnet_voice, international_voice, sms, validity_booster_7days, validity_booster_15days, validity_booster_30days, data_plan, data_pay_per_use, total_on_on_iv_sms_vb_dr AS total_comsumption")->orderByDesc("slno")->get()->toArray();
        return $dataTable['tableconsumption'];
    }

    public function getTableConsumptionMonthly($year){
//        $dataTable['tableconsumptionmonthly'] = DB::select("(SELECT t_month, SUM(onnet_voice) AS onnet_voice, SUM(offnet_voice) AS offnet_voice, SUM(international_voice) AS international_voice, SUM(sms) AS sms, SUM(validity_booster_7days) AS validity_booster_7days, SUM(validity_booster_15days) AS validity_booster_15days, SUM(validity_booster_30days) AS validity_booster_30days, SUM(data_plan) AS data_plan, SUM(data_pay_per_use) AS data_pay_per_use, SUM(total_on_on_iv_sms_vb_dr) AS total_comsumption FROM revenue_report WHERE t_year=".$year." GROUP BY t_month ORDER BY slno) UNION ALL (SELECT 'Total' AS t_month, SUM(onnet_voice) AS onnet_voice, SUM(offnet_voice) AS offnet_voice, SUM(international_voice) AS international_voice, SUM(sms) AS sms, SUM(validity_booster_7days) AS validity_booster_7days, SUM(validity_booster_15days) AS validity_booster_15days, SUM(validity_booster_30days) AS validity_booster_30days, SUM(data_plan) AS data_plan, SUM(data_pay_per_use) AS data_pay_per_use, SUM(total_on_on_iv_sms_vb_dr) AS total_comsumption FROM revenue_report WHERE t_year=".$year.")");
        $dataTable['tableconsumptionmonthly'] = DB::select("SELECT '1' as OrderColumn, t_month, SUM(onnet_voice) AS onnet_voice, SUM(offnet_voice) AS offnet_voice, SUM(international_voice) AS international_voice, SUM(sms) AS sms, SUM(validity_booster_7days) AS validity_booster_7days, SUM(validity_booster_15days) AS validity_booster_15days, SUM(validity_booster_30days) AS validity_booster_30days, SUM(data_plan) AS data_plan, SUM(data_pay_per_use) AS data_pay_per_use, SUM(total_on_on_iv_sms_vb_dr) AS total_comsumption FROM revenue_report WHERE t_year=".$year." GROUP BY t_month UNION ALL SELECT '2' as OrderColumn, 'Total' AS t_month, SUM(onnet_voice) AS onnet_voice, SUM(offnet_voice) AS offnet_voice, SUM(international_voice) AS international_voice, SUM(sms) AS sms, SUM(validity_booster_7days) AS validity_booster_7days, SUM(validity_booster_15days) AS validity_booster_15days, SUM(validity_booster_30days) AS validity_booster_30days, SUM(data_plan) AS data_plan, SUM(data_pay_per_use) AS data_pay_per_use, SUM(total_on_on_iv_sms_vb_dr) AS total_comsumption FROM revenue_report WHERE t_year=".$year." ORDER BY OrderColumn, STR_TO_DATE(concat('$year','-',t_month,'-01'), '%Y-%b-%d')");

        return $dataTable['tableconsumptionmonthly'];
    }

    public function getTableConsumptionMonthlyAjax($month,$year){
        $dataTable['tableconsumptionmonthly'] = DB::select("(SELECT CONCAT(t_date,'-',t_month,'-',t_year) AS `date`, onnet_voice, offnet_voice, international_voice, sms, validity_booster_7days, validity_booster_15days, validity_booster_30days, data_plan, data_pay_per_use, total_on_on_iv_sms_vb_dr AS total_comsumption FROM revenue_report WHERE t_month='".$month."' AND t_year=".$year.") UNION ALL (SELECT 'Total' AS `date`, SUM(onnet_voice) AS onnet_voice, SUM(offnet_voice) AS offnet_voice, SUM(international_voice) AS international_voice, SUM(sms) AS sms, SUM(validity_booster_7days) AS validity_booster_7days, SUM(validity_booster_15days) AS validity_booster_15days, SUM(validity_booster_30days) AS validity_booster_30days, SUM(data_plan) AS data_plan, SUM(data_pay_per_use) AS data_pay_per_use, SUM(total_on_on_iv_sms_vb_dr) AS total_comsumption FROM revenue_report WHERE t_month='".$month."' AND t_year=".$year.") ORDER BY STR_TO_DATE(`date`, '%e-%b-%Y') DESC");
        return $dataTable['tableconsumptionmonthly'];
    }

    public function getTableFigures($month, $year){
        $dataTable['tablefigures'] = DB::select("SELECT CONCAT(t_date,'-',t_month,'-',t_year) AS `date`, subs_activated, subs_deactivated, total_subs, leasedline_subs, total_vlr_subs, active_subs_cbs, powered_on_subs, subs_barred, subs_suspended, new_leasedline_subs FROM revenue_report WHERE t_month='".$month."' AND t_year=".$year." ORDER BY STR_TO_DATE(`date`, '%e-%b-%Y') DESC");
        return $dataTable['tablefigures'];
    }

    public function tableFiguresMonthlyAjax(Request $request){
        $month = $request->month;
        $year = $request->year;
        return $this->getTableFiguresMonthly($month, $year);
    }

    public function getTableFiguresMonthly($month,$year){
        $dataTable['tablefigures'] = DB::select("SELECT CONCAT(t_date,'-',t_month,'-',t_year) AS `date`, subs_activated, subs_deactivated, total_subs, leasedline_subs, total_vlr_subs, active_subs_cbs, powered_on_subs, subs_barred, subs_suspended, new_leasedline_subs FROM revenue_report WHERE t_month='".$month."' AND t_year=".$year." ORDER BY STR_TO_DATE(`date`, '%e-%b-%Y') DESC");

        return $dataTable['tablefigures'];
    }

    public function prepaidVsConsumption(){
        //in this, datas are fetched differenly, not in single variable. Datasets and categories differently
        $years = DB::table("revenue_report")->selectRaw("DISTINCT t_year")->pluck('t_year')->toArray();
        $dataComparison['years'] = array_map('strval', $years);

        $dataYearArray = [];
        foreach ($dataComparison['years'] as $year)  {
            array_push($dataYearArray,['label'=>$year]);
        }
        $dataComparison['yearlabel'] = $dataYearArray;

        $dataComparison['prepaidYearlyTotal'] = DB::table("revenue_report")->groupBy("t_year")->selectRaw("SUM(total_recharge) AS prepaidyearlytotal")->pluck("prepaidyearlytotal")->toArray();
        $dataComparison['prepaidYearlyTotal'] = array_map('doubleval', $dataComparison['prepaidYearlyTotal']);

        $dataPrepaidYearlyArray = [];
        foreach ($dataComparison['prepaidYearlyTotal'] as $yearlytotal)  {
            array_push($dataPrepaidYearlyArray,['value'=>(string)$yearlytotal]);
        }
        $dataComparison['prepaiddata'] = $dataPrepaidYearlyArray;

        $dataComparison['consumptionYearlyTotal'] = DB::table("revenue_report")->groupBy("t_year")->selectRaw("SUM(total_on_on_iv_sms_vb_dr) AS consumptionyearlytotal")->pluck("consumptionyearlytotal")->toArray();
        $dataComparison['consumptionYearlyTotal'] = array_map('doubleval', $dataComparison['consumptionYearlyTotal']);

        $dataConsumptionYearlyArray = [];
        foreach ($dataComparison['consumptionYearlyTotal'] as $yearlytotal)  {
            array_push($dataConsumptionYearlyArray,['value'=>(string)$yearlytotal]);
        }
        $dataComparison['consumptiondata'] = $dataConsumptionYearlyArray;

        //daily comparison
        //To show in view
        $today = Carbon::today(); //todays date
        $dataComparison['currentMonth'] = $today->format("Y-m");

        //pass in query
        $selectedYear = $today->format("Y");
        $selectedMonth = $today->format("M");

        $dates = DB::table("revenue_report")->selectRaw("DISTINCT t_date")->where("t_month", $selectedMonth)->where("t_year", $selectedYear)->pluck('t_date')->toArray();
        $dataComparison['dates'] = array_map('strval', $dates);

        $dataDateArray = [];
        foreach ($dataComparison['dates'] as $dates)  {
            array_push($dataDateArray,['label'=>$dates]);
        }
        $dataComparison['datelabel'] = $dataDateArray;

        $dataComparison['prepaidDaily'] = DB::table("revenue_report")->selectRaw("total_recharge")->where("t_month", $selectedMonth)->where("t_year", $selectedYear)->pluck("total_recharge")->toArray();
        $dataComparison['prepaidDaily'] = array_map('doubleval', $dataComparison['prepaidDaily']);

        $dataPrepaidDailyArray = [];
        foreach ($dataComparison['prepaidDaily'] as $daily)  {
            array_push($dataPrepaidDailyArray,['value'=>(string)$daily]);
        }
        $dataComparison['prepaiddailydata'] = $dataPrepaidDailyArray;

        $dataComparison['consumptionDaily'] = DB::table("revenue_report")->selectRaw("total_on_on_iv_sms_vb_dr AS consumptiondaily")->where("t_month", $selectedMonth)->where("t_year", $selectedYear)->pluck("consumptiondaily")->toArray();
        $dataComparison['consumptionDaily'] = array_map('doubleval', $dataComparison['consumptionDaily']);

        $dataConsumptionDailyArray = [];
        foreach ($dataComparison['consumptionDaily'] as $daily)  {
            array_push($dataConsumptionDailyArray,['value'=>(string)$daily]);
        }
        $dataComparison['consumptiondailydata'] = $dataConsumptionDailyArray;

        //Monthly
        //year list for dropdown
        $dataComparison['yearall'] = DB::table("revenue_report")->orderByDesc("t_year")->selectRaw("DISTINCT t_year")->get()->toArray();

        $monthsList = DB::table("revenue_report")->selectRaw("DISTINCT t_month")->pluck('t_month')->toArray();
        $dataComparison['monthsList'] = array_map('strval', $monthsList);

        $dataMonthArray = [];
        foreach ($dataComparison['monthsList'] as $months)  {
            array_push($dataMonthArray,['label'=>$months]);
        }
        $dataComparison['monthlabel'] = $dataMonthArray;

        $dataComparison['prepaidMonthly'] = DB::table("revenue_report")->selectRaw("SUM(total_recharge) AS total_recharge")->where("t_year", $selectedYear)->orderBy("slno")->groupBy("t_month")->pluck("total_recharge")->toArray();
        $dataComparison['prepaidMonthly'] = array_map('doubleval', $dataComparison['prepaidMonthly']);

        $dataPrepaidMonthlyArray = [];
        foreach ($dataComparison['prepaidMonthly'] as $monthly)  {
            array_push($dataPrepaidMonthlyArray,['value'=>(string)$monthly]);
        }
        $dataComparison['prepaidmonthlydata'] = $dataPrepaidMonthlyArray;

        $dataComparison['consumptionMonthly'] = DB::table("revenue_report")->selectRaw("sum(total_on_on_iv_sms_vb_dr) AS consumptionmonthly")->where("t_year", $selectedYear)->orderBy("slno")->groupBy("t_month")->pluck("consumptionmonthly")->toArray();
        $dataComparison['consumptionMonthly'] = array_map('doubleval', $dataComparison['consumptionMonthly']);

        $dataConsumptionMonthlyArray = [];
        foreach ($dataComparison['consumptionMonthly'] as $monthly)  {
            array_push($dataConsumptionMonthlyArray,['value'=>(string)$monthly]);
        }
        $dataComparison['consumptionmonthlydata'] = $dataConsumptionMonthlyArray;

        return view('prepaidvsconsumption',$dataComparison);
    }

    public function getRechargeVsConsumptionDaily(Request $request){//ajax
        //To pass in query at load
        $date = $request->monthYear;

        $dateObject = date_create($date);
        $selectedMonth = date_format($dateObject,"M");
        $selectedYear = date_format($dateObject,"Y");

        $dates = DB::table("revenue_report")->selectRaw("DISTINCT t_date")->where("t_month", $selectedMonth)->where("t_year", $selectedYear)->pluck('t_date')->toArray();
        $dataComparison['dates'] = array_map('strval', $dates);

        $dataDateArray = [];
        foreach ($dataComparison['dates'] as $dates)  {
            array_push($dataDateArray,['label'=>$dates]);
        }
        $dataComparison['datelabel'] = $dataDateArray;

        $dataComparison['prepaidDaily'] = DB::table("revenue_report")->selectRaw("total_recharge")->where("t_month", $selectedMonth)->where("t_year", $selectedYear)->pluck("total_recharge")->toArray();
        $dataComparison['prepaidDaily'] = array_map('doubleval', $dataComparison['prepaidDaily']);

        $dataPrepaidDailyArray = [];
        foreach ($dataComparison['prepaidDaily'] as $daily)  {
            array_push($dataPrepaidDailyArray,['value'=>(string)$daily]);
        }
        $dataComparison['prepaiddailydata'] = $dataPrepaidDailyArray;

        $dataComparison['consumptionDaily'] = DB::table("revenue_report")->selectRaw("total_on_on_iv_sms_vb_dr AS consumptiondaily")->where("t_month", $selectedMonth)->where("t_year", $selectedYear)->pluck("consumptiondaily")->toArray();
        $dataComparison['consumptionDaily'] = array_map('doubleval', $dataComparison['consumptionDaily']);

        $dataConsumptionDailyArray = [];
        foreach ($dataComparison['consumptionDaily'] as $daily)  {
            array_push($dataConsumptionDailyArray,['value'=>(string)$daily]);
        }
        $dataComparison['consumptiondailydata'] = $dataConsumptionDailyArray;

        return $dataComparison;
    }

    public function getRechargeVsConsumptionMonthly(Request $request){//ajax
        $selectedYear = $request->year;
        $monthsList = DB::table("revenue_report")->selectRaw("DISTINCT t_month")->pluck('t_month')->toArray();
        $dataComparison['monthsList'] = array_map('strval', $monthsList);

        $dataMonthArray = [];
        foreach ($dataComparison['monthsList'] as $months)  {
            array_push($dataMonthArray,['label'=>$months]);
        }
        $dataComparison['monthlabel'] = $dataMonthArray;

        $dataComparison['prepaidMonthly'] = DB::table("revenue_report")->selectRaw("SUM(total_recharge) AS total_recharge")->where("t_year", $selectedYear)->orderBy("slno")->groupBy("t_month")->pluck("total_recharge")->toArray();
        $dataComparison['prepaidMonthly'] = array_map('doubleval', $dataComparison['prepaidMonthly']);

        $dataPrepaidMonthlyArray = [];
        foreach ($dataComparison['prepaidMonthly'] as $monthly)  {
            array_push($dataPrepaidMonthlyArray,['value'=>(string)$monthly]);
        }
        $dataComparison['prepaidmonthlydata'] = $dataPrepaidMonthlyArray;

        $dataComparison['consumptionMonthly'] = DB::table("revenue_report")->selectRaw("sum(total_on_on_iv_sms_vb_dr) AS consumptionmonthly")->where("t_year", $selectedYear)->orderBy("slno")->groupBy("t_month")->pluck("consumptionmonthly")->toArray();
        $dataComparison['consumptionMonthly'] = array_map('doubleval', $dataComparison['consumptionMonthly']);

        $dataConsumptionMonthlyArray = [];
        foreach ($dataComparison['consumptionMonthly'] as $monthly)  {
            array_push($dataConsumptionMonthlyArray,['value'=>(string)$monthly]);
        }
        $dataComparison['consumptionmonthlydata'] = $dataConsumptionMonthlyArray;

        return $dataComparison;
    }

    public function getPrepaidVsConsumptionAjax(){
        $years = DB::table("revenue_report")->selectRaw("DISTINCT t_year")->pluck('t_year')->toArray();
        $dataComparison['years'] = array_map('strval', $years);

        $dataYearArray = [];
        foreach ($dataComparison['years'] as $year)  {
            array_push($dataYearArray,['label'=>$year]);
        }
        $dataComparison['yearlabel'] = $dataYearArray;

        $dataComparison['prepaidYearlyTotal'] = DB::table("revenue_report")->groupBy("t_year")->selectRaw("SUM(total_recharge) AS prepaidyearlytotal")->pluck("prepaidyearlytotal")->toArray();
        $dataComparison['prepaidYearlyTotal'] = array_map('doubleval', $dataComparison['prepaidYearlyTotal']);

        $dataPrepaidYearlyArray = [];
        foreach ($dataComparison['prepaidYearlyTotal'] as $yearlytotal)  {
            array_push($dataPrepaidYearlyArray,['value'=>(string)$yearlytotal]);
        }
        $dataComparison['prepaiddata'] = $dataPrepaidYearlyArray;

        $dataComparison['consumptionYearlyTotal'] = DB::table("revenue_report")->groupBy("t_year")->selectRaw("SUM(total_on_on_iv_sms_vb_dr) AS consumptionyearlytotal")->pluck("consumptionyearlytotal")->toArray();
        $dataComparison['consumptionYearlyTotal'] = array_map('doubleval', $dataComparison['consumptionYearlyTotal']);

        $dataConsumptionYearlyArray = [];
        foreach ($dataComparison['consumptionYearlyTotal'] as $yearlytotal)  {
            array_push($dataConsumptionYearlyArray,['value'=>(string)$yearlytotal]);
        }
        $dataComparison['consumptiondata'] = $dataConsumptionYearlyArray;
        return response()->json($dataComparison);
    }

    public function changePwPage(){
        return view('changepw');
    }

    public function changePassword(Request $request){
        $empid = Auth::user()->EmpId;
        $password = $request->newpassword;

        DB::update("UPDATE users SET password = ?,has_password_changed=1 where EmpId = ?",[Hash::make($password),$empid]);
        return redirect()->route('logout');
    }

}
