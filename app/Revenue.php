<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Revenue extends Model
{
    protected $table = 'revenue_report';
    protected $primaryKey = "slno";
    public $timestamps = false;
    protected $fillable = ["slno","t_year","t_month","t_date","paper_voucher",
        "paper_voucher_tax","etopup","etopup_tax","mbob","mbob_tax","tpay",
        "tpay_tax","bnb","bnb_tax","bdb","bdb_tax","mytashicell","mytashicell_tax",
        "web","web_tax","sales_and_order","sales_and_order_tax","eteeru","eteeru_tax",
        "total_recharge","total_recharge_tax","subs_activated","subs_deactivated","total_subs",
        "leasedline_subs","onnet_voice","offnet_voice","international_voice","sms","validity_booster_7days",
        "validity_booster_15days","validity_booster_30days","data_plan","data_pay_per_use",
        "total_on_on_iv_sms_vb_dr","total_vlr_subs","active_subs_cbs","powered_on_subs"];
}
