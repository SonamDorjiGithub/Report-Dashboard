<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPrivilege extends Model
{
    protected $table = 'user_privilege';
    protected $primaryKey = "empid";
    public $timestamps = false;
    protected $fillable = ["id","empid","dailyrevenue","prepaid","consumption",
        "prepaidvsconsumption","substatistics","postpaid","leasedline","dataplanusage","interconnect",
        "eteeru","vas","admin","omc", "tda"];
}
