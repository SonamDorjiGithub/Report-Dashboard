<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getLogout(){
        $this->saveLoginAuditLog();
        Auth::logout();
        return redirect('login');
    }

    public function saveLoginAuditLog(){
        $data['empid'] = Auth::user()->EmpId;
        $data['logout_at'] = date("Y-m-d H:i:s");
        $dataCondition['sessionid'] = session()->getId();

        DB::table('login_audit')->updateOrInsert($dataCondition, $data);
    }
}
