@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100']) @section('content') @include('layouts.navbars.auth.topnav', ['title' => 'Roles Management'])
<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <div class="d-flex align-items-center">
                    <h6> Edit Role</h6>
                    <a href="/roles" class="btn btn-primary btn-sm ms-auto">Back</a>
                </div>
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> something went wrong.<br><br>
                        <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="card-body">
                {!! Form::model($role, ['method' => 'PATCH','route' => ['roles.update', $role->id]]) !!}
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Name:</strong>
                            {{-- <input type="text" name="name" id="name" placeholder="name" class="form-control" value="{{ $role->name }}"> --}}
                            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Permission:</strong>
                        <div class="row">
                            <br/>
                            @foreach($permission as $value)
                                {{-- <input type="checkbox" name="permission[]" id="{{ $value->id }}" value="{{ in_array($value->id, $rolePermissions) ? true : false }}"> --}}
                                {{-- <label for="{{ $value->id }}">{{ $value->name }}</label> --}}
                                <label class="col-2" style="float: left;">{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                                {{ $value->name }}</label>
                            <br/>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
