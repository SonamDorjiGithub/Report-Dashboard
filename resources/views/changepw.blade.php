@extends('layouts.masterlayout')

@section('content')
    <h1 class="mt-4">Change Password</h1>
    <div class="card mb-4">
        <form action="/changepassword" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="vlr" class="control-label">New Password<span class="required-marker">*</span></label>
                            <input type="password" name="newpassword" id="newpassword" required autocomplete="off" class="form-control input-xs"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <button type="submit" class="discard-changes-success btn btn-success">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@stop
