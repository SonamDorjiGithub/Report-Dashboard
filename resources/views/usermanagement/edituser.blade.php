@extends('layouts.masterlayout')

@section('content')
    <h2 class="mt-4">Edit Users</h2>
    <div class="card mb-4">
        <form action="/edituserpush" method="POST" id="edituserform">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name" class="control-label">Name<span class="required-marker">*</span></label>
                            <input type="text" name="name" value="{{$user[0]->name}}" id="name" data-validation="required" class="form-control input-xs"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="empid" class="control-label">EmpID<span class="required-marker">*</span>
                            </label>
                            <input type="text" name="empid" value="{{$user[0]->EmpId}}" readonly id="empid" data-validation="required" class="form-control input-xs"/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="email" class="control-label">EmailID</label>
                            <input type="text" name="email" value="{{$user[0]->email}}" id="email" class="form-control input-xs"/>
                        </div>
                    </div>
                </div><hr>
                <h5 class="mt-4">User Privilege</h5>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-check">
                            <label class="form-check-label" for="dailyrevenue">
                                <input type="checkbox" class="form-check-input" id="dailyrevenue" name="dailyrevenue" value="1" @if($userprivilege->dailyrevenue==1) checked @endif>Daily Revenue
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <label class="form-check-label" for="prepaid">
                                <input type="checkbox" class="form-check-input" id="prepaid" name="prepaid" value="1" @if($userprivilege->prepaid==1) checked @endif>Prepaid
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <label class="form-check-label" for="consumption">
                                <input type="checkbox" class="form-check-input" id="consumption" name="consumption" value="1" @if($userprivilege->consumption==1) checked @endif>Consumption
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <label class="form-check-label" for="prepaidvsconsumption">
                                <input type="checkbox" class="form-check-input" id="prepaidvsconsumption" name="prepaidvsconsumption" value="1" @if($userprivilege->prepaidvsconsumption==1) checked @endif>Prepaid VS Consumption
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-check">
                            <label class="form-check-label" for="substatistics">
                                <input type="checkbox" class="form-check-input" id="substatistics" name="substatistics" value="1" @if($userprivilege->substatistics==1) checked @endif>Subscriber Statistics
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <label class="form-check-label" for="postpaid">
                                <input type="checkbox" class="form-check-input" id="postpaid" name="postpaid" value="1" @if($userprivilege->postpaid==1) checked @endif>Postpaid
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <label class="form-check-label" for="leasedline">
                                <input type="checkbox" class="form-check-input" id="leasedline" name="leasedline" value="1" @if($userprivilege->leasedline==1) checked @endif>LeasedLine
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <label class="form-check-label" for="dataplanusage">
                                <input type="checkbox" class="form-check-input" id="dataplanusage" name="dataplanusage" value="1" @if($userprivilege->dataplanusage==1) checked @endif>Data Plan Usage
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-check">
                            <label class="form-check-label" for="interconnect">
                                <input type="checkbox" class="form-check-input" id="interconnect" name="interconnect" value="1" @if($userprivilege->interconnect==1) checked @endif>Interconnect
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <label class="form-check-label" for="eteeru">
                                <input type="checkbox" class="form-check-input" id="eteeru" name="eteeru" value="1" @if($userprivilege->eteeru==1) checked @endif>eTeeru
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <label class="form-check-label" for="vas">
                                <input type="checkbox" class="form-check-input" id="vas" name="vas" value="1" @if($userprivilege->vas==1) checked @endif>VAS
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <label class="form-check-label" for="omc">
                                <input type="checkbox" class="form-check-input" id="omc" name="omc" value="1" @if($userprivilege->omc==1) checked @endif>OMC
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-check">
                            <label class="form-check-label" for="tda">
                                <input type="checkbox" class="form-check-input" id="tda" name="tda" value="1" @if($userprivilege->tda==1) checked @endif>TDA
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <label class="form-check-label" for="admin">
                                <input type="checkbox" class="form-check-input" id="admin" name="admin" value="1" @if($userprivilege->admin==1) checked @endif>Admin
                            </label>
                        </div>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-md-3">
                        <input type="button" id="submit-edituser-btn" class="action-button btn btn-sm btn-success" value="Confirm" />
                        <a href="{{url('admin/adminpage')}}" class="discard-changes-warning btn btn-sm btn-warning">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

@stop
