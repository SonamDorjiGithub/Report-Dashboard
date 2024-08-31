@extends('layouts.masterlayout')

@section('content')
    <h2 class="mt-4">Add Users</h2>
    <div class="card mb-4">
        <form action="/addnewuser" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="name" class="control-label">Name<span class="required-marker">*</span></label>
                            <input type="text" name="name" id="name" required class="form-control input-xs"/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="empid" class="control-label">EmpID/Mobile No.<span class="required-marker">*</span>
                            </label>
                            <input type="text" name="empid" id="empid" required class="form-control input-xs"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="control-label">EmailID</label>
                            <input type="email" name="email" id="email" required class="form-control input-xs"/>
                        </div>
                    </div>
                </div><hr>
                <h5 class="mt-4">User Privilege</h5>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-check">
                            <label class="form-check-label" for="dailyrevenue">
                                <input type="checkbox" class="form-check-input" id="dailyrevenue" name="dailyrevenue" value="1">Daily Revenue
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <label class="form-check-label" for="prepaid">
                                <input type="checkbox" class="form-check-input" id="prepaid" name="prepaid" value="1">Prepaid
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <label class="form-check-label" for="consumption">
                                <input type="checkbox" class="form-check-input" id="consumption" name="consumption" value="1">Consumption
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <label class="form-check-label" for="prepaidvsconsumption">
                                <input type="checkbox" class="form-check-input" id="prepaidvsconsumption" name="prepaidvsconsumption" value="1">Prepaid VS Consumption
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-check">
                            <label class="form-check-label" for="substatistics">
                                <input type="checkbox" class="form-check-input" id="substatistics" name="substatistics" value="1">Subscriber Statistics
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <label class="form-check-label" for="postpaid">
                                <input type="checkbox" class="form-check-input" id="postpaid" name="postpaid" value="1">Postpaid
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <label class="form-check-label" for="leasedline">
                                <input type="checkbox" class="form-check-input" id="leasedline" name="leasedline" value="1">LeasedLine
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <label class="form-check-label" for="dataplanusage">
                                <input type="checkbox" class="form-check-input" id="dataplanusage" name="dataplanusage" value="1">Data Plan Usage
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-check">
                            <label class="form-check-label" for="interconnect">
                                <input type="checkbox" class="form-check-input" id="interconnect" name="interconnect" value="1">Interconnect
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <label class="form-check-label" for="eteeru">
                                <input type="checkbox" class="form-check-input" id="eteeru" name="eteeru" value="1">eTeeru
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <label class="form-check-label" for="vas">
                                <input type="checkbox" class="form-check-input" id="vas" name="vas" value="1">VAS
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <label class="form-check-label" for="omc">
                                <input type="checkbox" class="form-check-input" id="omc" name="omc" value="1">OMC
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-check">
                            <label class="form-check-label" for="admin">
                                <input type="checkbox" class="form-check-input" id="admin" name="admin" value="1">Admin
                            </label>
                        </div>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-md-3">
{{--                        <input type="button" id="submit-adduser-btn" class="action-button btn btn-sm btn-success" value="Confirm" />--}}
                        <button type="submit" class="btn btn-sm btn-success">Confirm</button>
                        <a href="{{url('admin/addusers')}}" class="discard-changes-warning btn btn-sm btn-warning">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

@stop
