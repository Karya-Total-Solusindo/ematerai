
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
            <div class="alert alert-danger text-white">
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
                    <strong>Username:</strong>
                    <input type="text" name="username" required class="form-control" placeholder="username" autocomplete="false">
                    <span></span>
                    {{-- {!! Form::text('username', null, array('placeholder' => 'Name','class' => 'form-control','autocomplete'=>'off')) !!} --}}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Email:</strong>
                    <input type="email" name="email" required pattern="/^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/" class="form-control" placeholder="email" autocomplete="false">
                    <span></span>
                    {{-- {!! Form::text('email', null, array('required'=>'required', 'placeholder' => 'Email','class' => 'form-control','autocomplete'=>'off')) !!} --}}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Password:</strong>
                    <input type="password" name="password" required id="u_password" class="form-control" placeholder="Password">
                    {{-- {!! Form::password('password', array('required'=>'required', 'placeholder' => 'Password','class' => 'form-control')) !!} --}}
                    <span></span>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Confirm Password:</strong>
                    <input type="password" name="confirm-password" required  id="c_password" class="form-control" placeholder="Confirm Password">
                    {{-- {!! Form::password('confirm-password', array('required'=>'required','placeholder' => 'Confirm Password','class' => 'form-control')) !!} --}}
                    <span></span>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Role:</strong>
                    <select name="roles" id="roles" required class="form-control">
                            <option value=""></option>
                            <option value="Client">Client</option>
                            <option value="Admin">Admin</option>
                    </select>
                    <span></span>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Active:</strong>
                    <select name="active" id="active" required class="form-control">
                            <option value=""></option>
                            <option value="0">None</option>
                            <option value="1">Active</option>
                    </select>
                    <span></span>
                </div>
            </div>
            <div class="row mb-0">
                <hr class="horizontal dark">
                <div class="col-xs-12 col-sm-12 col-md-6 text-start mb-0">
                    <a type="submit" class="btn btn-dark" href="{{route('users.index') }}">Back</a>
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
        
{{-- Javascript --}}
@once  
    @pushOnce('js')
    <script>
        $(document).ready(function(){
            $('#u_password, #c_password').on('keyup', function () {
            if ($('#u_password').val() == $('#c_password').val()) {
                $('#c_password')[0].setCustomValidity('');
            } else {
                $('#c_password')[0].setCustomValidity('invalid');
            }});
        });
    </script>
@endPushOnce
@endonce