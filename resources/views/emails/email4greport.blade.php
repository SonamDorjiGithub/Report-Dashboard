<!DOCTYPE html>
<html>
<head>
    <!--
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    -->
    <style>

        .mail4GTableClass{
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
            font-size: 12px;
        }

        .mail4GTableClass tr td {
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
            font-size: 12px;
        }
    </style>

{{--    bootstrap--}}
{{--    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">--}}
{{--    <link rel="stylesheet" type="text/css" href="{{asset("/css/main.css")}}">--}}
{{--    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>--}}
{{--    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>--}}
{{--    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>--}}
</head>
<body>
{!! $mailBody !!}
<table class="mail4GTableClass">
    <tbody>
        <tr>
            <td colspan="18" ><strong>4G Subscriber Report</strong></td>
        </tr>
        <tr class="align-items-center">
            <td rowspan="3" style="background-color:#CDE0FF"><strong>DATE</strong>
            </td>
            <td colspan="8" style="background-color:#FFE1E1"><strong>Pre-Paid - Existing (Active/Barred/Suspend)</strong>
            </td>
            <td colspan="8" style="background-color:#FFE1E1"><strong>Post-Paid - Existing (Active/Barred/Suspend)</strong>
            </td>
            <td rowspan="3" style="background-color:#CDE0FF"><strong>Total</strong>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="background-color:#FFE1E1"><strong>Mobile</strong></td>
            <td colspan="2" style="background-color:#FFE1E1"><strong>Wingle</strong></td>
            <td colspan="2" style="background-color:#FFE1E1"><strong>CPE</strong></td>
            <td rowspan="2" style="background-color:#F4B083"><strong>4G Unsubscribed + 4G Deactivated</strong></td>
            <td rowspan="2" style="background-color:#f5d290"><strong>Total</strong></td>
            <td colspan="2" style="background-color:#FFE1E1"><strong>Mobile</strong></td>
            <td colspan="2" style="background-color:#FFE1E1"><strong>Wingle</strong></td>
            <td colspan="2" style="background-color:#FFE1E1"><strong>CPE</strong></td>
            <td rowspan="2" style="background-color:#F4B083"><strong>4G Unsubscribed + 4G Deactivated</strong></td>
            <td rowspan="2" style="background-color:#f5d290"><strong>Total</strong></td>
        </tr>
        <tr>
            <td style="background-color:#F4B083"><strong>Existing</strong></td>
            <td style="background-color:#F4B083"><strong>New</strong></td>
            <td style="background-color:#F4B083"><strong>Existing</strong></td>
            <td style="background-color:#F4B083"><strong>New</strong></td>
            <td style="background-color:#F4B083"><strong>Existing</strong></td>
            <td style="background-color:#F4B083"><strong>New</strong></td>
            <td style="background-color:#F4B083"><strong>Existing</strong></td>
            <td style="background-color:#F4B083"><strong>New</strong></td>
            <td style="background-color:#F4B083"><strong>Existing</strong></td>
            <td style="background-color:#F4B083"><strong>New</strong></td>
            <td style="background-color:#F4B083"><strong>Existing</strong></td>
            <td style="background-color:#F4B083"><strong>New</strong></td>
        </tr>
        <tr>
            <td style="background-color:#FFFBC1"><strong>{{$dataInTemplateArray['displayYesterdaysDate']}}</strong></td>
            <td style="background-color:#A9D08E">{{$dataInTemplateArray['prepaid_mobile_existing']}}</td>
            <td style="background-color:#A9D08E">{{$dataInTemplateArray['prepaid_mobile_new']}}</td>
            <td style="background-color:#A9D08E">{{$dataInTemplateArray['prepaid_wingle_existing']}}</td>
            <td style="background-color:#A9D08E">{{$dataInTemplateArray['prepaid_wingle_new']}}</td>
            <td style="background-color:#A9D08E">{{$dataInTemplateArray['prepaid_cpe_existing']}}</td>
            <td style="background-color:#A9D08E">{{$dataInTemplateArray['prepaid_cpe_new']}}</td>
            <td style="background-color:#A9D08E">{{$dataInTemplateArray['prepaid_unsubscribed_deactivated']}}</td>
            <td style="background-color:#f5d290">{{$dataInTemplateArray['prepaid_total']}}</td>
            <td style="background-color:#A9D08E">{{$dataInTemplateArray['postpaid_mobile_existing']}}</td>
            <td style="background-color:#A9D08E">{{$dataInTemplateArray['postpaid_mobile_new']}}</td>
            <td style="background-color:#A9D08E">{{$dataInTemplateArray['postpaid_wingle_existing']}}</td>
            <td style="background-color:#A9D08E">{{$dataInTemplateArray['postpaid_wingle_new']}}</td>
            <td style="background-color:#A9D08E">{{$dataInTemplateArray['postpaid_cpe_existing']}}</td>
            <td style="background-color:#A9D08E">{{$dataInTemplateArray['postpaid_cpe_new']}}</td>
            <td style="background-color:#A9D08E">{{$dataInTemplateArray['postpaid_unsubscribed_deactivated']}}</td>
            <td style="background-color:#f5d290">{{$dataInTemplateArray['postpaid_total']}}</td>
            <td style="background-color:#A9D08E">{{$dataInTemplateArray['grand_total']}}</td>
        </tr>
    </tbody>
    <br>
</table>
<br/>Pema Wangdi
</body>
</html>

