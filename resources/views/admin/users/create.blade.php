
@extends('layouts.app') @section('content') @include('layouts.navbars.auth.topnav', ['title' => 'User Management'])




<div class="card text-start  mb-0">
  <div class="card-header">
    <div class="col-xs-12 col-sm-12 col-md-6">
        <h4 class="card-title">New User</h4>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
    
    </div>
    <hr class="horizontal dark">
    <div class="col-12">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
            <strong>Whoops!</strong>Something went wrong.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            </div>
        @endif
    </div>  
  </div>  
  <div class="card-body pb-0">
        {!! Form::open(array('route' => 'users.store','method'=>'POST')) !!}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Name:</strong>
                    {!! Form::text('username', null, array('placeholder' => 'Name','class' => 'form-control','autocomplete'=>'off')) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Email:</strong>
                    {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control','autocomplete'=>'off')) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Password:</strong>
                    {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Confirm Password:</strong>
                    {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Role:</strong>
                    
                    <select name="roles" id="roles" class="form-control">
                            <option value="Client">Client</option>
                            <option value="Admin">Admin</option>
                    </select>
                </div>
            </div>
            <div class="row mb-0">
                <hr class="horizontal dark">
                <div class="col-xs-12 col-sm-12 col-md-6 text-start mb-0">
                    <a type="submit" class="btn btn-dark">Back</a>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 text-end mb-0">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

        @endsection
        
