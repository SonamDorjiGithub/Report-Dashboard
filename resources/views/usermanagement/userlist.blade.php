@extends('layouts.masterlayout')

@section('content')
        <form action="{{Request::url()}}" method="GET">
        @csrf
        <div class="row" id="search-form">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="Name" class="control-label">Name</label>
                    <input type="text" value="{{app('request')->input('Name')}}" autocomplete="off" name="Name" id="Name" class="form-control input-sm" />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="UserName" class="control-label">Emp Id</label>
                    <input type="text" id="UserName" value="{{app('request')->input('UserName')}}" autocomplete="off"  name="UserName" class="form-control input-sm" />
                </div>
            </div>
            <div class="col-md-3 pt-sm-4">
                <button type="submit" class="btn btn-sm btn-primary">SEARCH</button>
                <button type="button" onclick="window.location.href='{{url('admin/adminpage')}}'" class="btn btn-sm btn-danger">CLEAR</button>
                <button type="button" onclick="window.location.href='{{url('admin/addusers')}}'" class="btn btn-sm btn-info">ADD</button>
            </div>
        </div>
        </form>
        <div class="table-responsive table-sm">
            <table class="table table-condensed table-bordered">
                <thead style="border-top: 1px solid #dee2e6;">
                <tr>
                    <th class="align-middle">#</th>
                    <th>Name</th>
                    <th>User Id</th>
                    <th>Email</th>
                    <th class="text-center">Actions</th>
                </tr>

                </thead>
                <tbody>
                <?php $slNo=app('request')->input('page')?(app('request')->input('page')-1)* $perPage+1:1; ?>
<!--                --><?php //$slNo = 1?>
                @forelse($users as $user)
                    <tr>
                        <td>{{$slNo++}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->EmpId}}</td>
                        <td>{{$user->email}}</td>
                        <td class="text-center">
                            <a href="#" data-id="{{$user->EmpId}}" class="reset-password btn btn-success btn-xsmall"><i class="fa fa-key"></i> RESET PASSWORD</a>
                            <a onclick="window.location.href='{{url('admin/editusers',[$user->EmpId])}}'" data-id="{{$user->EmpId}}" class="btn btn-primary btn-xsmall"><i class="fa fa-edit"></i> EDIT</a>
                            <a href="#" data-id="{{$user->EmpId}}" data-name="{{$user->EmpId}}" class="delete-user btn btn-danger btn-xsmall"><i class="fa fa-trash"></i> DELETE</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">
                            No results found!
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

        </div>
        @if(count($users)>0)
            {{$users->appends(app('request')->input())->links()}}
        @endif
        <br>
{{--    </div>--}}
{{--    </div>--}}

@stop
