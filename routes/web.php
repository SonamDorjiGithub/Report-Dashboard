<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});

//Auth::routes();

Route::group(['middleware'=>['auth']],function (){
    //prepaid revenue
    //    dont add hasprivilge middleware for ajax
    Route::group(['prefix'=>'prepaid', 'middleware'=>'hasPrivilege'],function (){
        Route::get('dailypage','RevenueController@getDailyPrepaid');
        Route::get('comparisonpage', 'RevenueController@getComparisonData');
        Route::get('channelwisepage', 'RevenueController@channelWisePage');
        Route::get('tablepage', 'RevenueController@tablePage');
        Route::get('tableallpage', 'RevenueController@tableAllPage');
    });
    Route::get('prepaidmonthlyajax', 'RevenueController@prepaidMonthlyAjax');
    Route::get('prepaidmonthlyalltabajax', 'RevenueController@prepaidMonthlyAllTabAjax');
    Route::post('fetchdailyprepaid','RevenueController@fetchDailyPrepaid');
    Route::post('fetchchannelwisequarterly', 'RevenueController@getChannelWiseQuarterly');
    Route::post('fetchmonthlyrevenue','RevenueController@fetchMonthlyRevenue');
    Route::post('fetchcomparisonmonthly', 'RevenueController@getComparisonDataMonthly');
    Route::post('fetchcomparisonquarterly', 'RevenueController@getComparisonDataQuarterly');
    Route::post('fetchcomparisonbiannually', 'RevenueController@getComparisonDataBiannually');
    Route::post('fetchcomparisonannually', 'RevenueController@getComparisonDataAnnually');
    Route::post('fetchchannelwisebiannually', 'RevenueController@getChannelWiseBiannually');
    Route::post('fetchchannelwiseannually', 'RevenueController@getChannelWiseAnnually');
    Route::post('fetchchannelwisemonthly', 'RevenueController@getChannelWiseMonthlyOnChange');

    //subscriber statistics
    Route::group(['prefix'=>'substatistics', 'middleware'=>'hasPrivilege'], function(){
        Route::get('comparisonfigures', 'RevenueController@comparisonFigures');
        Route::get('tablefigures', 'RevenueController@tableFigures');
    });
    Route::post('fetchdailyfigures','RevenueController@fetchDailyFigures');
    Route::get('tablefiguresmonthlyajax', 'RevenueController@tableFiguresMonthlyAjax');
    Route::post('fetchcomparisonfiguresubsannually', 'RevenueController@fetchComparisonFigureSubsAnnually');

    Route::get('omc/omcaddpage','Controller@goOmcPage')->middleware('hasPrivilege');
    Route::get('omcaddvalue','Controller@omcAddValue');
    Route::get('dashboard','RevenueController@getDashboard');
    Route::get('dashboardajax', 'RevenueController@getDashboardDataAjax');

    //admin page
    Route::group(['prefix'=>'admin','middleware'=>'hasPrivilege'], function(){
        Route::get('adminpage', 'UserController@adminPage');
        Route::get('editusers/{id}', 'UserController@editUsers');
        Route::get('addusers', 'UserController@addUsers');
    });
    Route::post('resetpassword', 'UserController@resetPassword');
    Route::post('deleteuser', 'UserController@deleteUsers');
    Route::post('edituserpush', 'UserController@editUserPush');
    Route::post('addnewuser', 'UserController@addNewUser');
    Route::get('changepwpage', 'RevenueController@changePwPage');
    Route::post('changepassword', 'RevenueController@changePassword');
    Route::get('logout','HomeController@getLogout');
});

//Route for cron tab to send cbs report mail
Route::get('pullreportftp','Controller@pullReportFile');
Route::get('send-mail-xxx', 'Controller@sendReportMail');
Route::get('insertintodb', 'Controller@insertDailyReportIntoDB');
Route::get('updatedaily-jjj', 'Controller@updateDailyReportTable');
Route::get('pullcustomer-dkd','Controller@pullCustomerInfoReport');
Route::get('sendcustinfo-pppp','Controller@sendCustomerInfoReport');

//realtime cron
//write code to pull realtime report
//changed the name for security reason when uploaded on github. Also removed its corresponding controller from the controller page.
Route::get('pullrealtime-xxxxx', 'Controller@xxxxController');
Route::get('insertrealtime-xxxx', 'Controller@yyyController');
Route::get('updaterealtime-yyyy', 'Controller@zzzzController');
Route::get('updaterealtime-zzzz', 'Controller@kkkkController');
Route::get('updatedaily-kkkk', 'Controller@llllController');

//eteeru
Route::get('get-xxx', 'EteeruController@getxxxx'); //removed the controller when uploaded on github for security reason
Route::get('finalupdat-yyyy', 'EteeruController@finalUpdate-yyyyy');

////Data plan and subscription
//Route::get('pulldatasubscriber', 'Controller@pullDataSubscriber');
//Route::get('insertdatasubscriberintodb', 'Controller@insertDataSubscriberIntoDB');

//CDR Test
Route::get('testcdr', 'Controller@testReadingCDR');

Auth::routes(['register' => false]);
//Auth::routes(['login' => false]);

