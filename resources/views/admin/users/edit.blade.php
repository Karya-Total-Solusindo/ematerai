@extends('layouts.app') @section('content') @include('layouts.navbars.auth.topnav', ['title' => 'User Management'])
<div class="row mt-4 mx-4">
    <div class="col-12">
        @if (count($errors) > 0) 
        <div class="alert alert-warning text-white">
            <strong>Whoops!</strong> Something went wrong.<br><br>
            <ul> @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach </ul>
        </div> 
        @endif
        <div class="row">
            <div class="col-lg-12 mb-lg-0 mb-4">
                <div class="card">
                    {{-- <div class="card-header pb-0"> </div> --}}
                    <div class="card-body">
                        <h6>Users Edit</h6> 
                        <hr class="horizontal dark">
                    
                            {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!} 
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <strong>Username:</strong> {!! Form::text('username', null, array('readonly'=>true ,'placeholder' => 'Name','class' => 'form-control')) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <strong>Email:</strong> {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <strong>Password:</strong> 
                                        <input type="password" class="form-control" name="password" id="u_password" minlength="6" aria-describedby="helpId" placeholder="Password">
                                        <span></span>  
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <strong>Confirm Password:</strong> 
                                        <input type="password" class="form-control" name="confirm-password" id="c_password" minlength="6" aria-describedby="helpId" placeholder="Confirm Password">
                                        {{-- {!! Form::password('confirm-password', array('id'=>'c_password','placeholder' => 'Confirm Password','class' => 'form-control')) !!} --}}
                                        <span></span>  
                                    </div>
                                </div>
                                @if($user->id >= 3 )
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <strong>Role:</strong> 
                                            {!! Form::select('roles[]', ['Client'=>'Client','Admin'=>'Admin'],$userRole, array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <strong>Active:</strong>
                                        <select name="active" id="active" class="form-control">
                                            @if($user->active == 0)
                                            <option value="0">none</option>
                                            @else
                                            <option value="1">active</option>
                                            @endif
                                            <option value="0">none</option>
                                            <option value="1">active</option>
                                        </select>
                                        </div>
                                    </div>
                                @else
                                <input type="hidden" name="roles[]" value="Admin">    
                                <input type="hidden" name="active" value="1">    
                                @endif    
                               
                                    <div class="col-xs-12 col-sm-12 col-md-6 text-start">
                                        <a href="{{ URL::previous() }}" class="btn btn-dark">Back</a>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 text-end">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                               
                               
                            </div>
                            {!! Form::close() !!}
                       
                    </div>
                </div>
            </div>

    </div>
    </div>
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