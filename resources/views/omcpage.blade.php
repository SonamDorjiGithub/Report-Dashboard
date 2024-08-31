@extends('layouts.masterlayout')

@section('content')
    <h1 class="mt-4">Network Usage by Subscriber (9:00 AM)</h1>
    <div class="card mb-4">
        <form action="/omcaddvalue" method="GET">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="vlr" class="control-label">Total VLR Active Subscribers<span class="required-marker">*</span></label>
                            <input type="number" name="vlr" id="vlr" required class="form-control input-xs"/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="poweron" class="control-label">Power On Subscribers<span style="color:red">*</span>
                            </label>
                            <input type="number" name="poweron" id="poweron" required class="form-control input-xs"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
    {{--                    <a href="{{url('#')}}" class="discard-changes-success btn btn-success">Submit</a>--}}
                        <button type="submit" class="discard-changes-success btn btn-success">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@stop
