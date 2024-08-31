<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        'fetchdailyfigures',
        'fetchdailyprepaid',
        'fetchdailyconsumption',
        'fetchmonthlyrevenue',
        'fetchcomparisonmonthly',
        'fetchcomparisonquarterly',
        'fetchcomparisonbiannually',
        'fetchcomparisonannually',
        'fetchchannelwisequarterly',
        'fetchchannelwisebiannually',
        'fetchchannelwiseannually',
        'dailyconsumptionpage',
        'fetchmonthlyconsumption',
        'fetchcomparisonconsumptionmonthly',
        'fetchconsumptionquarterly',
        'fetchconsumptionbiannually',
        'fetchconsumptionannually',
        'channelwiseconsumptionquarterly',
        'channelwiseconsumptionbiannually',
        'channelwiseconsumptionannually',
        'fetchchannelwisemonthly',
        'fetchchannelwiseconsumptionmonthly',
        'fetchcomparisonprepaidvsconsumption',
        'getrechargevsconsumptiondaily',
        'getrechargevsconsumptionmonthly',
        'fetchcomparisonfiguresubsannually',
        'fetchcomparisonpostpaidmonthly',
        'fetchpostpaidquarterly',
        'fetchpostpaidbiannually',
        'fetchpostpaidannually',
        'fetchcomparisonleasedlinemonthly',
        'fetchleasedlinequarterly',
        'fetchleasedlinebiannually',
        'fetchleasedlineannually',
        'fetchchannelwisepostpaidquarterly',
        'fetchchannelwisepostpaidbiannually',
        'fetchchannelwisepostpaidannually',
        'fetchchannelwiseleasedlinequarterly',
        'fetchchannelwiseleasedlinebiannually',
        'fetchchannelwiseleasedlineannually',
        'datausagemonthlyajax',
        'fetchcomparisondatausagemonthly',
        'fetchdatausagequarterly',
        'fetchdatausagebiannually',
        'fetchdatausageannually',
        'getinterconnectdomesticmonthly',
        'getinterconnectinternationalmonthly',
        'getinterconnectdomesticyearly',
        'getinterconnectinternationalyearly',
        'getcashincashoutmonthly',
        'getp2pmerchantmonthly',
        'resetpassword',
        'deleteuser',
        'datasubscriberajax',
        'fetchdailydatasubs',
        'fetchdailystudentdataplansubs',
        'studentdataplansubscriberajax',
        'fetchdatausagewisemonthly',
        'fetchdatarevenuemonthly',
        'fetchdataaggregatemonthly',
        'fetchdatapaygmonthly',
        'fetchdataratmonthly',
        'fetchcustomerbasemonthly',
        'fetchlocalcallsharemonthly',
        'fetchnetadditionmonthly',
        'fetchuniqueuserrechargemonthly',
        'fetchnoofrechargesmonthly',
        'fetchlocalcallshareyearly',
        'fetchnoofrechargesyearly'
    ];
}
