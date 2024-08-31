<?php
namespace App\Http\ViewComposers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use Illuminate\Support\ServiceProvider;

class MasterComposer extends ServiceProvider
{
    protected $currentRoute;
    public function __construct(){
        $this->currentRoute = Route::current()->uri();
    }
    public function compose(View $view)
    {
        //variable fetch from database whether password has been changed.
        $has_password_changed = DB::table('users')->where('EmpId',Auth::id())->value('has_password_changed');
        $getPrivilege = DB::select("SELECT * FROM user_privilege WHERE empid = ?", [Auth::user()->EmpId]);
        $userprivilege = $getPrivilege[0];
        $lastLoginTime = DB::table('login_audit')->where('empid', Auth::id())->orderByDesc('id')->limit(1)->value('login_at');

        $view->with('currentRoute',$this->currentRoute)
            ->with('has_password_changed', $has_password_changed)
            ->with('userprivilege', $userprivilege)
            ->with('lastlogintime', $lastLoginTime);
    }
}
