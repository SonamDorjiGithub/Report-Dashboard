<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //cron run method for cbs report

    //pull data from FTP
    public function pullReportFile(){
        $today = Carbon::today();  //orginal subDays(1)
        $fileDate = $today->subDays(1)->format("Ymd"); //Or use subDay(), instead of subDays(1)

        //4G daily report
        $new4GReportContentsRemote = Storage::disk('sftp')->get('4G_Report_New_'.$fileDate.'.csv');
        Storage::put('public/4G_Report_New_'.$fileDate.'.csv', $new4GReportContentsRemote);

        $existing4GReportContentsRemote = Storage::disk('sftp')->get('4G_Report_Existing_'.$fileDate.'.csv');
        Storage::put('public/4G_Report_Existing_'.$fileDate.'.csv', $existing4GReportContentsRemote);

        $deactivated4GReportContentsRemote = Storage::disk('sftp')->get('4G_Report_Deactivated_'.$fileDate.'.csv');
        Storage::put('public/4G_Report_Deactivated_'.$fileDate.'.csv', $deactivated4GReportContentsRemote);

        //delete array file and date. Delete files from two days before. Don't delete Daily Revenue file as it is not sent in mail and is consumed in database
        $deleteFileDate = $today->subDays(1)->format("Ymd");//already subtracted one day, so subtract only 1 day
        $deleteFileArray = ['public/Real_Time_Payment_'.$deleteFileDate.'.csv', 'public/Payment_Reversal_'.$deleteFileDate.'.csv', 'public/Sales_Order_Payment_'.$deleteFileDate.'.csv',
            'public/ETopUp_Recharge_'.$deleteFileDate.'.csv', 'public/eTeeru_Recharge_'.$deleteFileDate.'.csv', 'public/eTeeru_Payment_'.$deleteFileDate.'.csv', 'public/NavOne_Recharge_'.$deleteFileDate.'.csv',
            'public/Bank_Recharge_Total_'.$deleteFileDate.'.csv', 'public/4G_Report_New_'.$deleteFileDate.'.csv', 'public/4G_Report_Existing_'.$deleteFileDate.'.csv', 'public/4G_Report_Deactivated_'.$deleteFileDate.'.csv',
            'public/Daily_Revenue_'.$deleteFileDate.'.csv', 'public/Bank_Recharge_Real_Time_'.$fileDate.'.csv', 'public/Daily_Revenue_Real_Time_'.$fileDate.'.csv'];//for realtime, delete, file of 1 day before, not 2. So use $fileDate
        Storage::delete($deleteFileArray);

        $this->pullDataSubscriber(); // call method
        $this->pullPRMData();
    }

    public function sendReportMail(){
        $today = Carbon::today();
        $fileDate = $today->subDays(1)->format("Ymd");  //original subDays(1)
        $this->sendMail4GReport();
    }

    //
    public function sendMail4GReport(){
        $today = Carbon::today();
        $fileDate = $today->subDays(1)->format("Ymd"); //original subDays(1)

        $report4GExisting = fopen(storage_path('app/public/4G_Report_Existing_'.$fileDate.'.csv'),"r");
        $report4GNew = fopen(storage_path('app/public/4G_Report_New_'.$fileDate.'.csv'),"r");
        $report4GDeactivated = fopen(storage_path('app/public/4G_Report_Deactivated_'.$fileDate.'.csv'),"r");

        $keysForDefaultValue = array('existingPrepaidMobileToBeCalculated', 'existingPostpaidMobileToBeCalculated', 'prepaid_wingle_existing',
            'postpaid_wingle_existing', 'prepaid_cpe_existing', 'postpaid_cpe_existing', 'prepaid_mobile_new', 'postpaid_mobile_new',
            'prepaid_wingle_new', 'postpaid_wingle_new', 'prepaid_cpe_new', 'postpaid_cpe_new', 'prepaid_unsubscribed_deactivated', 'postpaid_unsubscribed_deactivated');
        $defaultValues = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);//equal elements assignmed default value 0
        $array = array_combine($keysForDefaultValue, $defaultValues);

        $attachmentArray = [];

        $count = 0;

        while (($data = fgetcsv($report4GExisting, 1000, ",")) !== FALSE) {
            if($count > 0){
                if($count <= 6 ){
                    $fieldName = trim($data[0]);
                    if($fieldName == 'Pre Paid Mobile'){
                        $array['existingPrepaidMobileToBeCalculated'] = trim($data[1]);
                    }
                    else if($fieldName == 'Post Paid Mobile'){
                        $array['existingPostpaidMobileToBeCalculated'] = trim($data[1]);
                    }
                    else if($fieldName == 'Pre Paid Wingle'){
                        $array['prepaid_wingle_existing'] = trim($data[1]);
                    }
                    else if($fieldName == 'Post Paid Wingle'){
                        $array['postpaid_wingle_existing'] = trim($data[1]);
                    }
                    else if($fieldName == 'Pre Paid CPE'){
                        $array['prepaid_cpe_existing'] = trim($data[1]);
                    }
                    else if($fieldName == 'Post Paid CPE'){
                        $array['postpaid_cpe_existing'] = trim($data[1]);
                    }
                }
            }
            $count++;
        }
        fclose($report4GExisting);

        $countForNew = 0;
        while (($data = fgetcsv($report4GNew, 1000, ",")) !== FALSE) {
            if($countForNew > 0){
                if($countForNew <= 6 ){
                    $fieldName = trim($data[0]);
                    if($fieldName == 'Pre Paid Mobile'){
                        $array['prepaid_mobile_new'] = trim($data[1]);
                    }
                    else if($fieldName == 'Post Paid Mobile'){
                        $array['postpaid_mobile_new'] = trim($data[1]);
                    }
                    else if($fieldName == 'Pre Paid Wingle'){
                        $array['prepaid_wingle_new'] = trim($data[1]);
                    }
                    else if($fieldName == 'Post Paid Wingle'){
                        $array['postpaid_wingle_new'] = trim($data[1]);
                    }
                    else if($fieldName == 'Pre Paid CPE'){
                        $array['prepaid_cpe_new'] = trim($data[1]);
                    }
                    else if($fieldName == 'Post Paid CPE'){
                        $array['postpaid_cpe_new'] = trim($data[1]);
                    }
                }
            }
            $countForNew++;
        }
        fclose($report4GNew);

        $countForDeactivated = 0;
        while (($data = fgetcsv($report4GDeactivated, 1000, ",")) !== FALSE) {
            if($countForDeactivated > 0){
                if($countForDeactivated <= 6 ){
                    $fieldName = trim($data[0]);
                    if($fieldName == 'Pre Paid'){
                        $array['prepaid_unsubscribed_deactivated'] = trim($data[1]);
                    }
                    else if($fieldName == 'Post Paid'){
                        $array['postpaid_unsubscribed_deactivated'] = trim($data[1]);
                    }
                }
            }
            $countForDeactivated++;
        }
        fclose($report4GDeactivated);

        $array['prepaid_mobile_existing'] = $array['existingPrepaidMobileToBeCalculated'] - $array['prepaid_wingle_existing'] - $array['prepaid_cpe_existing'];

        $array['postpaid_mobile_existing'] = $array['existingPostpaidMobileToBeCalculated'] - $array['postpaid_wingle_existing'] - $array['postpaid_cpe_existing'];

        $array['prepaid_total'] = $array['existingPrepaidMobileToBeCalculated'] + $array['prepaid_mobile_new']
            + $array['prepaid_wingle_existing'] + $array['prepaid_wingle_new'] + $array['prepaid_cpe_existing'] + $array['prepaid_cpe_new'];

        $array['postpaid_total'] = $array['existingPostpaidMobileToBeCalculated'] + $array['postpaid_mobile_new']
            + $array['postpaid_wingle_existing'] + $array['postpaid_wingle_new'] + $array['postpaid_cpe_existing'] + $array['postpaid_cpe_new'];

        $array['grand_total'] = $array['prepaid_total'] + $array['postpaid_total'];

        unset($array['existingPrepaidMobileToBeCalculated']); //unset from array to avoid getting column unknown db error
        unset($array['existingPostpaidMobileToBeCalculated']);

        $array['t_year'] = $today->format("Y"); // no need to subtract $today because its already subtracted
        $array['t_month'] = strtoupper($today->format("M"));
        $array['t_date'] = $today->format("j");

        DB::table('data4greport')->insert($array);

        $array['displayYesterdaysDate'] = $today->format("d-M-Y"); //after data insert cos it would give column unknown db error

       Mail::to(["xxxx@yyy.com"])
           ->cc(["xxxx@gmail.com"])
           ->send(new SendMail("Respected All,<br/><br/>PFA the Daily 4G Report.",$attachmentArray,"4G Subscriber Report-TEST", "Pema Wangdi", "emails.email4greport", $array));
    }


    //no more in use after making realtime
    public function insertDailyReportIntoDB(){
        $today = Carbon::today();
        $fileDate = $today->subDays(1)->format("Ymd");

        $f = fopen(storage_path('app/public/Daily_Revenue_'.$fileDate.'.csv'),"r");
        $array = [];
        $count = 0;
        while (($data = fgetcsv($f, 1000, ",")) !== FALSE) {
            if($count > 0){
                //till 12 -> 2 columns
             if($count<=15) {
                 if ($count == 1) {
                     $array['subs_activated'] = trim($data[1]);
                     if($array['subs_activated'] == ''){
                         $array['subs_activated'] = 0;
                     }
                 }
                 else if ($count == 2) {
                     $array['subs_deactivated'] = trim($data[1]);
                     if($array['subs_deactivated'] == ''){
                         $array['subs_deactivated'] = 0;
                     }
                 }
                 else if ($count == 3) {
                     $array['active_subs_cbs'] = trim($data[1]);
                     if($array['active_subs_cbs'] == ''){
                         $array['active_subs_cbs'] = 0;
                     }
                 }
                 else if ($count == 4) {
                     $array['subs_barred'] = trim($data[1]);
                     if($array['subs_barred'] == ''){
                         $array['subs_barred'] = 0;
                     }
                 }
                 else if ($count == 5) {
                     $array['subs_suspended'] = trim($data[1]);
                     if($array['subs_suspended'] == ''){
                         $array['subs_suspended'] = 0;
                     }
                 }
                 else if ($count == 6) {
                     $array['total_subs'] = trim($data[1]);
                     if($array['total_subs'] == ''){
                         $array['total_subs'] = 0;
                     }
                 }
                 else if ($count == 7) {
                     $array['leasedline_subs'] = trim($data[1]);
                     if($array['leasedline_subs'] == ''){
                         $array['leasedline_subs'] = 0;
                     }
                 }
                 else if ($count == 8) {
                     $array['onnet_voice'] = trim($data[1]);
                     if($array['onnet_voice'] == ''){
                         $array['onnet_voice'] = 0;
                     }
                 }
                 else if ($count == 9) {
                     $array['offnet_voice'] = trim($data[1]);
                     if($array['offnet_voice'] == ''){
                         $array['offnet_voice'] = 0;
                     }
                 }
                 else if ($count == 10) {
                     $array['international_voice'] = trim($data[1]);
                     if($array['international_voice'] == ''){
                         $array['international_voice'] = 0;
                     }
                 }
                 else if ($count == 11) {
                     $array['sms'] = trim($data[1]);
                     if($array['sms'] == ''){
                         $array['sms'] = 0;
                     }
                 }
                 else if ($count == 12) {
                     $array['data_plan'] = trim($data[1]);
                     if($array['data_plan'] == ''){
                         $array['data_plan'] = 0;
                     }
                 }
                 else if ($count == 13) {
                     $array['data_pay_per_use'] = trim($data[1]);
                     if($array['data_pay_per_use'] == ''){
                         $array['data_pay_per_use'] = 0;
                     }
                 }

                 else if ($count == 15) {
                     $array['validity_booster_7days'] = trim($data[1]);
                     $array['validity_booster_15days'] = trim($data[2]);
                     $array['validity_booster_30days'] = trim($data[3]);

                     if($array['validity_booster_7days'] == ''){
                         $array['validity_booster_7days'] = 0;
                     }
                     if($array['validity_booster_15days'] == ''){
                         $array['validity_booster_15days'] = 0;
                     }
                     if($array['validity_booster_30days'] == ''){
                         $array['validity_booster_30days'] = 0;
                     }
                 }
             }
            }
            $count++;
        }
        fclose($f);

        $array['total_on_on_iv_sms_vb_dr'] = $array['onnet_voice'] + $array['offnet_voice'] + $array['international_voice'] + $array['sms'] +  $array['validity_booster_7days'] + $array['validity_booster_15days'] + $array['validity_booster_30days'] + $array['data_plan'] + $array['data_pay_per_use'];

        $array['t_year'] = $today->format("Y"); // no need to subtract $today because its already subtracted
        $array['t_month'] = strtoupper($today->format("M"));
        $array['t_date'] = $today->format("j");
        DB::table('revenue_report')->insert($array);

    }

    //to update the banking recharges
    public function updateDailyReportTable(){
        $today = Carbon::today();
        $fileDate = $today->subDays(1)->format("Ymd");

        $updateConditionArray = [];
        $updateConditionArray['t_year'] = $today->format("Y");
        $updateConditionArray['t_month'] = strtoupper($today->format("M"));
        $updateConditionArray['t_date'] = $today->format("j");

        $f = fopen(storage_path('app/public/Bank_Recharge_Total_' . $fileDate . '.csv'), "r");
        $keysForDefaultValue = array('bdb', 'bnb', 'eteeru', 'etopup', 'mbob', 'mytashicell', 'web', 'paper_voucher',
            'sales_and_order', 'tpay', 'paper_voucher_tax', 'etopup_tax', 'mbob_tax', 'tpay_tax', 'bnb_tax', 'bdb_tax',
            'mytashicell_tax', 'web_tax', 'sales_and_order_tax', 'eteeru_tax', 'digital_kidu', 'pnb');
        $defaultValues = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);//assign equal default value 0
        $updateValueArray = array_combine($keysForDefaultValue, $defaultValues);
        $count = 0;
        while (($data = fgetcsv($f, 1000, ",")) !== FALSE) {
             if($count > 0){
                if($count <= 12 ){
                    $fieldName = trim($data[1]);
                    if($fieldName == 'BDB'){
                        $updateValueArray['bdb'] = trim($data[2]);
                    }
                    else if($fieldName == 'BNB'){
                        $updateValueArray['bnb'] = trim($data[2]);
                    }
                    else if($fieldName == 'eTeeru'){
                        $updateValueArray['eteeru'] = trim($data[2]);
                    }
                    else if($fieldName == 'ETopUp'){
                        $updateValueArray['etopup'] = trim($data[2]);
                    }
                    else if($fieldName == 'BOB'){
                        $updateValueArray['mbob'] = trim($data[2]);
                    }
                    else if($fieldName == 'MyTashiCell'){
                        $updateValueArray['mytashicell'] = trim($data[2]);
                    }
                    else if($fieldName == 'Paper'){
                        $updateValueArray['paper_voucher'] = trim($data[2]);
                    }
                    else if($fieldName == 'Sales Order'){
                        $updateValueArray['sales_and_order'] = trim($data[2]);
                    }
                    else if($fieldName == 'TBank'){
                        $updateValueArray['tpay'] = trim($data[2]);
                    }
                    else if($fieldName == 'Digital Kidu'){
                        $updateValueArray['digital_kidu'] = trim($data[2]);
                    }
                    else if($fieldName == 'DPNB'){
                        $updateValueArray['pnb'] = trim($data[2]);
                    }
                }
            }
        $count++;
        }

        $updateValueArray['total_recharge'] = $updateValueArray['bdb'] + $updateValueArray['bnb'] + $updateValueArray['eteeru'] + $updateValueArray['etopup'] + $updateValueArray['mbob'] + $updateValueArray['mytashicell'] + $updateValueArray['web'] + $updateValueArray['paper_voucher'] + $updateValueArray['sales_and_order'] + $updateValueArray['tpay'] + $updateValueArray['digital_kidu'] + $updateValueArray['pnb'];
        $updateValueArray['total_recharge_tax'] =  $updateValueArray['paper_voucher_tax'] + $updateValueArray['etopup_tax'] + $updateValueArray['mbob_tax'] + $updateValueArray['tpay_tax'] + $updateValueArray['bnb_tax'] + $updateValueArray['bdb_tax'] + $updateValueArray['mytashicell_tax'] + $updateValueArray['web_tax'] + $updateValueArray['sales_and_order_tax'] + $updateValueArray['eteeru_tax'];
        fclose($f);

        DB::table("revenue_report")->where($updateConditionArray)->update($updateValueArray);
    }

    //Realtime Pull Data
    public function pullRealTimeDailyRevenueReport(){
        $today = Carbon::today();
        $fileDate = $today->subDays(0)->format("Ymd");

        $bankRechargeTotalRemote = Storage::disk('sftp')->get('Bank_Recharge_Real_Time_'.$fileDate.'.csv');
        Storage::put('public/Bank_Recharge_Real_Time_'.$fileDate.'.csv', $bankRechargeTotalRemote);

        //daily prepaid revenue report, to be inserted into database
        $dailyRevenueReport = Storage::disk('sftp')->get('Daily_Revenue_Real_Time_'.$fileDate.'.csv');
        Storage::put('public/Daily_Revenue_Real_Time_'.$fileDate.'.csv', $dailyRevenueReport);
    }

    //realtime insert data at 3 am


    //update the data realtime. 6 am onwards till 9 pm
    public function updateRealtimeDailyRevenue(){
        $today = Carbon::today();
        $fileDate = $today->subDays(0)->format("Ymd");

        $f = fopen(storage_path('app/public/Daily_Revenue_Real_Time_'.$fileDate.'.csv'),"r");
        $array = [];
        $count = 0;
        while (($data = fgetcsv($f, 1000, ",")) !== FALSE) {
            if($count >= 0){
                //till 12 -> 2 columns
                if($count<=14) {
                    if ($count == 0) {
                        $array['subs_activated'] = trim($data[1]);
                        if($array['subs_activated'] == ''){
                            $array['subs_activated'] = 0;
                        }
                    }
                    else if ($count == 1) {
                        $array['subs_deactivated'] = trim($data[1]);
                        if($array['subs_deactivated'] == ''){
                            $array['subs_deactivated'] = 0;
                        }
                    }
                    else if ($count == 2) {
                        $array['active_subs_cbs'] = trim($data[1]);
                        if($array['active_subs_cbs'] == ''){
                            $array['active_subs_cbs'] = 0;
                        }
                    }
                    else if ($count == 3) {
                        $array['subs_barred'] = trim($data[1]);
                        if($array['subs_barred'] == ''){
                            $array['subs_barred'] = 0;
                        }
                    }
                    else if ($count == 4) {
                        $array['subs_suspended'] = trim($data[1]);
                        if($array['subs_suspended'] == ''){
                            $array['subs_suspended'] = 0;
                        }
                    }
                    else if ($count == 5) {
                        $array['total_subs'] = trim($data[1]);
                        if($array['total_subs'] == ''){
                            $array['total_subs'] = 0;
                        }
                    }
                    else if ($count == 6) {
                        $array['new_leasedline_subs'] = trim($data[1]);
                        if($array['new_leasedline_subs'] == ''){
                            $array['new_leasedline_subs'] = 0;
                        }
                    }
                    else if ($count == 7) {
                        $array['leasedline_subs'] = trim($data[1]);
                        if($array['leasedline_subs'] == ''){
                            $array['leasedline_subs'] = 0;
                        }
                    }
                    else if ($count == 8) {
                        $array['onnet_voice'] = trim($data[1]);
                        if($array['onnet_voice'] == ''){
                            $array['onnet_voice'] = 0;
                        }
                    }
                    else if ($count == 9) {
                        $array['offnet_voice'] = trim($data[1]);
                        if($array['offnet_voice'] == ''){
                            $array['offnet_voice'] = 0;
                        }
                    }
                    else if ($count == 10) {
                        $array['international_voice'] = trim($data[1]);
                        if($array['international_voice'] == ''){
                            $array['international_voice'] = 0;
                        }
                    }
                    else if ($count == 11) {
                        $array['sms'] = trim($data[1]);
                        if($array['sms'] == ''){
                            $array['sms'] = 0;
                        }
                    }
                    else if ($count == 12) {
                        $array['data_plan'] = trim($data[1]);
                        if($array['data_plan'] == ''){
                            $array['data_plan'] = 0;
                        }
                    }
                    else if ($count == 13) {
                        $array['data_pay_per_use'] = trim($data[1]);
                        if($array['data_pay_per_use'] == ''){
                            $array['data_pay_per_use'] = 0;
                        }
                    }

                    else if ($count == 14) {
                        $array['validity_booster_7days'] = trim($data[1]);
                        $array['validity_booster_15days'] = trim($data[2]);
                        $array['validity_booster_30days'] = trim($data[3]);

                        if($array['validity_booster_7days'] == ''){
                            $array['validity_booster_7days'] = 0;
                        }
                        if($array['validity_booster_15days'] == ''){
                            $array['validity_booster_15days'] = 0;
                        }
                        if($array['validity_booster_30days'] == ''){
                            $array['validity_booster_30days'] = 0;
                        }
                    }
                }
            }
            $count++;
        }
        fclose($f);

        $array['total_on_on_iv_sms_vb_dr'] = $array['onnet_voice'] + $array['offnet_voice'] + $array['international_voice'] + $array['sms'] +  $array['validity_booster_7days'] + $array['validity_booster_15days'] + $array['validity_booster_30days'] + $array['data_plan'] + $array['data_pay_per_use'];

        $updateConditionArray = [];
        $updateConditionArray['t_year'] = $today->format("Y");
        $updateConditionArray['t_month'] = strtoupper($today->format("M"));
        $updateConditionArray['t_date'] = $today->format("j");
        dd($array);
        DB::table("revenue_report")->where($updateConditionArray)->update($array);
    }

    //update bank recharge realtime
    public function updateRealTimeBankRecharge(){
        $today = Carbon::today();
        $fileDate = $today->subDays(0)->format("Ymd");

        $updateConditionArray = [];
        $updateConditionArray['t_year'] = $today->format("Y");
        $updateConditionArray['t_month'] = strtoupper($today->format("M"));
        $updateConditionArray['t_date'] = $today->format("j");

        $f = fopen(storage_path('app/public/Bank_Recharge_Real_Time_' . $fileDate . '.csv'), "r");
        $keysForDefaultValue = array('bdb', 'bnb', 'eteeru', 'etopup', 'mbob', 'mytashicell', 'web', 'paper_voucher',
            'sales_and_order', 'tpay', 'paper_voucher_tax', 'etopup_tax', 'mbob_tax', 'tpay_tax', 'bnb_tax', 'bdb_tax',
            'mytashicell_tax', 'web_tax', 'sales_and_order_tax', 'eteeru_tax', 'digital_kidu', 'pnb');
        $defaultValues = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);//assign equal elements default value 0
        $updateValueArray = array_combine($keysForDefaultValue, $defaultValues);
        $count = 0;
        while (($data = fgetcsv($f, 1000, ",")) !== FALSE) {
            if($count > 0){
                if($count <= 12 ){
                    $fieldName = trim($data[1]);
                    if($fieldName == 'BDB'){
                        $updateValueArray['bdb'] = trim($data[2]);
                    }
                    else if($fieldName == 'BNB'){
                        $updateValueArray['bnb'] = trim($data[2]);
                    }
                    else if($fieldName == 'eTeeru'){
                        $updateValueArray['eteeru'] = trim($data[2]);
                    }
                    else if($fieldName == 'ETopUp'){
                        $updateValueArray['etopup'] = trim($data[2]);
                    }
                    else if($fieldName == 'BOB'){
                        $updateValueArray['mbob'] = trim($data[2]);
                    }
                    else if($fieldName == 'MyTashiCell'){
                        $updateValueArray['mytashicell'] = trim($data[2]);
                    }
                    else if($fieldName == 'Paper'){
                        $updateValueArray['paper_voucher'] = trim($data[2]);
                    }
                    else if($fieldName == 'Sales Order'){
                        $updateValueArray['sales_and_order'] = trim($data[2]);
                    }
                    else if($fieldName == 'TBank'){
                        $updateValueArray['tpay'] = trim($data[2]);
                    }
                    else if($fieldName == 'Digital Kidu'){
                        $updateValueArray['digital_kidu'] = trim($data[2]);
                    }
                    else if($fieldName == 'DPNB'){
                        $updateValueArray['pnb'] = trim($data[2]);
                    }
                }
            }
            $count++;
        }

        $updateValueArray['total_recharge'] = $updateValueArray['bdb'] + $updateValueArray['bnb'] + $updateValueArray['eteeru'] + $updateValueArray['etopup'] + $updateValueArray['mbob'] + $updateValueArray['mytashicell'] + $updateValueArray['web'] + $updateValueArray['paper_voucher'] + $updateValueArray['sales_and_order'] + $updateValueArray['tpay'] + $updateValueArray['digital_kidu'] + $updateValueArray['pnb'];
        $updateValueArray['total_recharge_tax'] =  $updateValueArray['paper_voucher_tax'] + $updateValueArray['etopup_tax'] + $updateValueArray['mbob_tax'] + $updateValueArray['tpay_tax'] + $updateValueArray['bnb_tax'] + $updateValueArray['bdb_tax'] + $updateValueArray['mytashicell_tax'] + $updateValueArray['web_tax'] + $updateValueArray['sales_and_order_tax'] + $updateValueArray['eteeru_tax'];
        fclose($f);

        DB::table("revenue_report")->where($updateConditionArray)->update($updateValueArray);
    }

    //update final data for end of the day, yesterday's data.

    public function goOmcPage(){
        return view('omcpage');
    }

    public function omcAddValue(Request $request){
        $today = Carbon::today()->subDays(1);

        $updateConditionArray = [];
        $updateConditionArray['t_year'] = $today->format("Y");
        $updateConditionArray['t_month'] = $today->format("M");
        $updateConditionArray['t_date'] = $today->format("j");

        $updateValueArray = [];
        $updateValueArray['total_vlr_subs'] = $request->vlr;
        $updateValueArray['powered_on_subs'] = $request->poweron;
        // before inserting, check if the value for a particular data has been set.
        $isValueInserted = DB::table("revenue_report")->whereNotNull("total_vlr_subs")->where($updateConditionArray)->count();
        if($isValueInserted == 1){
            return redirect('omc/omcaddpage')->with('errormessage','Data For Today Already Added');
        }
        DB::table("revenue_report")->where($updateConditionArray)->update($updateValueArray);
        return redirect('omc/omcaddpage')->with('successmessage','Data For Today Added Successfully');
    }

    public function sendCustomerInfoReport()
    {
        //removed
    }

    public function pullDataMonthlyRevenuePostpaidILL(){

    }



    //data plan subscribers and count
    public function pullDataSubscriber(){
        //removed
    }

    public function insertDataSubscriberIntoDB(){
        //removed
    }


}
