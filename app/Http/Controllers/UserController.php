<?php

namespace App\Http\Controllers;

use App\User;
use App\UserPrivilege;
use DateTime;
use Illuminate\Http\Request;
use App\Revenue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

//use Illuminate\Support\Facades\Input as Input;
use Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function adminPage(Request $request){
        $name = $request->input('Name');
        $userName = $request->input('UserName');

        $params = [];
        $condition = "1=1";
        if($name){
            $condition.=" and name like ?";
            array_push($params,"%$name%");
        }
        if($userName){
            $condition.=" and EmpId = ?";
            array_push($params,"$userName");
        }

        $data['perPage'] = 5;
        $data['users'] = DB::table('users')
                            ->whereRaw("$condition",$params)
                            ->select('name', 'EmpId', 'email')
            ->paginate($data['perPage']);
        return view('usermanagement.userlist', $data);
    }

    public function resetPassword(Request $request){
        $password = $request->password;
        $id = $request->id;
        DB::update("UPDATE users SET password = ?, has_password_changed = 0 WHERE EmpId = ?", [Hash::make($password), $id]);
        return ["success"=>true];
    }

    public function deleteUsers(Request $request){
        $id = $request->id;
        DB::table('users')->where('EmpId', $id)->delete();
        DB::table('user_privilege')->where('empid', $id)->delete();

        DB::insert("INSERT INTO sys_databasechangehistory (Id, TableName, EmployeeId, Deleted, Changes) VALUES (UUID(),?,?,?,?)",['user',Auth::user()->EmpId,1,$id]);

        return ["success"=>true];
    }

    public function editUsers($id){
        $user = DB::table('users')->where('EmpId', $id)->get()->toArray();
        $userPrivilegeQuery = DB::table('user_privilege')->where('empid', $id)->get()->toArray();
        $userPrivilege = $userPrivilegeQuery[0];

        return view('usermanagement.edituser')->with('user',$user)->with('userprivilege', $userPrivilege);
    }

    public function editUserPush(Request $request){
        $rules = [
            'name' => 'required',
            'empid' => 'required',
            'email' => 'required|email',
        ];

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
            return back()->withInput()->withErrors($validator);
        }

        $userData['name'] = $request->name;
        $userData['email'] = $request->email;
        $userData['updated_at'] = date("Y-m-d H:i:s");
        $empid = $request->empid;

        $dataUserPrivilege['dailyrevenue'] = isset($request->dailyrevenue)?(int)$request->dailyrevenue:0;
        $dataUserPrivilege['prepaid'] = isset($request->prepaid)?(int)$request->prepaid:0;
        $dataUserPrivilege['consumption'] = isset($request->consumption)?(int)$request->consumption:0;
        $dataUserPrivilege['prepaidvsconsumption'] = isset($request->prepaidvsconsumption)?(int)$request->prepaidvsconsumption:0;
        $dataUserPrivilege['substatistics'] = isset($request->substatistics)?(int)$request->substatistics:0;
        $dataUserPrivilege['postpaid'] = isset($request->postpaid)?(int)$request->postpaid:0;
        $dataUserPrivilege['leasedline'] = isset($request->leasedline)?(int)$request->leasedline:0;
        $dataUserPrivilege['dataplanusage'] = isset($request->dataplanusage)?(int)$request->dataplanusage:0;
        $dataUserPrivilege['interconnect'] = isset($request->interconnect)?(int)$request->interconnect:0;
        $dataUserPrivilege['eteeru'] = isset($request->eteeru)?(int)$request->eteeru:0;
        $dataUserPrivilege['vas'] = isset($request->vas)?(int)$request->vas:0;
        $dataUserPrivilege['omc'] = isset($request->omc)?(int)$request->omc:0;
        $dataUserPrivilege['admin'] = isset($request->admin)?(int)$request->admin:0;
        $dataUserPrivilege['tda'] = isset($request->tda)?(int)$request->tda:0;

        $objectUserPrivilege = UserPrivilege::find($empid);
        $objectUserPrivilege->fill($dataUserPrivilege);
        $changes = $objectUserPrivilege->getDirty();
        $objectUserPrivilege->update();
        $userPrivilegeRecordJson = json_encode([$changes]);

        $objectUser = User::find($empid);
        $objectUser->fill($userData);
        $changesUser = $objectUser->getDirty();
        $objectUser->update();
        $userRecordJson = json_encode([$changesUser]);

        if(count($changes) > 0){
            DB::insert("INSERT INTO sys_databasechangehistory (Id, TableName, EmployeeId, Deleted, Changes) VALUES (UUID(),?,?,?,?)",['user_privilege',Auth::user()->EmpId,0,$userPrivilegeRecordJson]);
        }
        if(count($changesUser) > 0){
            DB::insert("INSERT INTO sys_databasechangehistory (Id, TableName, EmployeeId, Deleted, Changes) VALUES (UUID(),?,?,?,?)",['users',Auth::user()->EmpId,0,$userRecordJson]);
        }

        return redirect('admin/adminpage')->with('successmessage','User Updated Successfully!');
    }

    public function addUsers(Request $request){
        return view('usermanagement.adduser');
    }

    public function addNewUser(Request $request){
        $name = $request->name;
        $empid = $request->empid;
        $email = $request->email;
        $password = Hash::make('password123');
        $createdAt = date("Y-m-d H:i:s");

        $dataUserPrivilege['dailyrevenue'] = isset($request->dailyrevenue)?(int)$request->dailyrevenue:0;
        $dataUserPrivilege['prepaid'] = isset($request->prepaid)?(int)$request->prepaid:0;
        $dataUserPrivilege['consumption'] = isset($request->consumption)?(int)$request->consumption:0;
        $dataUserPrivilege['prepaidvsconsumption'] = isset($request->prepaidvsconsumption)?(int)$request->prepaidvsconsumption:0;
        $dataUserPrivilege['substatistics'] = isset($request->substatistics)?(int)$request->substatistics:0;
        $dataUserPrivilege['postpaid'] = isset($request->postpaid)?(int)$request->postpaid:0;
        $dataUserPrivilege['leasedline'] = isset($request->leasedline)?(int)$request->leasedline:0;
        $dataUserPrivilege['dataplanusage'] = isset($request->dataplanusage)?(int)$request->dataplanusage:0;
        $dataUserPrivilege['interconnect'] = isset($request->interconnect)?(int)$request->interconnect:0;
        $dataUserPrivilege['eteeru'] = isset($request->eteeru)?(int)$request->eteeru:0;
        $dataUserPrivilege['vas'] = isset($request->vas)?(int)$request->vas:0;
        $dataUserPrivilege['omc'] = isset($request->omc)?(int)$request->omc:0;
        $dataUserPrivilege['admin'] = isset($request->admin)?(int)$request->admin:0;
        $dataUserPrivilege['empid'] = $empid;

        //see if the user exists
        $existsValue = DB::table('users')->where('EmpId', $empid)->exists();
        if($existsValue){
            return redirect('admin/addusers')->with('errormessage','User Already Exists');
        }
        else{
            DB::insert("INSERT INTO users(name, EmpId, email, password, created_at) VALUES (?,?,?,?,?)",[$name,$empid,$email,$password, $createdAt]);
            DB::table('user_privilege')->insert($dataUserPrivilege);
            return redirect('admin/adminpage')->with('successmessage','User Added Successfully');
        }

    }
}
