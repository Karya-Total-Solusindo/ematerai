@extends('layouts.app') @section('content') @include('layouts.navbars.auth.topnav', ['title' => 'User Management'])
<div class="row mt-4 mx-4">
    <div class="col-12">
        {{-- <div class="alert alert-light" role="alert"> This feature is available in <strong>{{ env('APP_NAME') }}</strong>. Check it <strong>
                <a href="#" target="_blank"> here </a>
            </strong>
        </div> --}}
        <div class="card mb-4">
            <div class="card-header pb-0">
                {{-- <h6>Users</h6>
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <h2> Show User</h2>
                        </div>
                        <div class="pull-right">
                            <a class="btn btn-primary" href="{{ route('users.index') }}"> Back </a>
                        </div>
                    </div>
                </div> --}}
                <div class="d-flex align-items-center">
                    <h6> Show User</h6>
                    <hr class="horizontal dark">
                </div>

            </div>
            <div class="card-body">
                <div class="row">
                    <h6> User Information </h6>
                    <hr class="horizontal dark">
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>Email:</strong>
                            <br>
                            {{ $user->email }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>Roles:</strong>
                            @foreach($user->roles as $role)
                            <br>
                            {{ $role->name }}
                                {{-- <span class="badge bg-primary">{{ $role->name }}</span> --}}
                            @endforeach
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>Create:</strong>
                            <br>
                            @foreach($user->roles as $role)
                            
                            {{ Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}
                                {{-- <span class="badge bg-primary">{{ $role->name }}</span> --}}
                            @endforeach
                        </div>
                    </div>
                   
                </div>
            </div>
            
        </div>
<div class="row">
        <div class="col-lg-6 mb-lg-0 mb-4">
            <div class="card">
                <div class="card-body">
                    <h6>Setting E-materai Service Account </h6>
                    <hr class="horizontal dark">
                    <div class="col-12">
                        <div id="response"></div>
                    </div>
                    <form action="{{ route('setpemungut') }}" method="post">
                        @csrf
                        <input type="hidden"name="user" value="{{$user->id}}">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <div class="mb-3">
                                    <label for="username" class="form-label"><strong>Username:</strong></label>
                                    {{-- <input type="text" required class="form-control" minlength="6" value={{(env('APP_DEBUG')==true) ?? env('EMATRERAI_USER')}} name="username" id="username" aria-describedby="helpId" placeholder=""> --}}
                                    <input type="text" required class="form-control" minlength="6" value="" name="username" id="username" aria-describedby="helpId" placeholder="">
                                        <span></span>  
                                        <small id="helpId" class="form-text text-muted">Account Peruri</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <div class="mb-3">
                                        <label for="password" class="form-label"><strong>Password:</strong></label>
                                        <input type="password" required minlength="6"
                                        {{-- class="form-control" name="password" value="{{(env('APP_DEBUG')==true)? env('EMATRERAI_PASSWORD')}}" id="password" aria-describedby="helpId" placeholder=""> --}}
                                        class="form-control" name="password" value="" id="password" aria-describedby="helpId" placeholder="">
                                            <span></span>  
                                        </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <div class="mb-3">
                                        <label for="confirm-password" class="form-label"><strong>Confirm Password:</strong></label>
                                        <input type="password" required minlength="6"
                                        class="form-control" name="confirm-password" id="confirm-password" aria-describedby="helpId" placeholder="">
                                        <span id="validate-comfirm"></span>  
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                    <a class="btn btn-dark btn-sm ms-auto" href="{{ route('users.index') }}"> Back </a>
                                    <a type="submit" id="accunt-test" class="btn btn-sm btn-info">Validation</a>
                                    <button type="submit" class="float-end btn btn-sm btn-primary">Save</button>
                            </div>
                        </div>
                    </form> 
                </div>
            </div>
        </div>
            <div class="col-lg-6 mb-lg-0 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h6> E-materai Service Account </h6>
                        <hr class="horizontal dark">
                        <div class="row">
                            <div class="col-12">
                                <strong>Username:</strong><br>
                                {{ $user->pemungut->p_user ?? '-' }}
                                
                            </div>
                            {{-- <div class="col-12" >
                                <strong>Password:</strong><br> 
                               {{ $pass  ?? '-' }}
                            </div> --}}
                            {{-- <div class="col-12">
                                <strong>Nama Pemungut:</strong><br>
                                {{ $user->pemungut->namedipungut ?? '-' }}
                            </div> --}}
                            {{-- <div class="col-12">
                                <strong>Role:</strong> 
                            </div>
                            <div class="col-12">
                                <strong>Role:</strong> 
                            </div>
                            <div class="col-12">
                                <strong>Role:</strong> 
                            </div> --}}
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
            $('#accunt-test').click((e)=>{
               var u = $('#username').val();
               var p = $('#password').val();
               $.ajax({  
                     url:"{{ route('checkpemungut') }}",  
                     method:"POST",  
                     data:{'username':u,'password':p,'_token':'{{ csrf_token() }}'},  
                     beforeSend:function(e){  
                      console.log(e.upload);
                          $('#response').html('<br><p><center>Checking Process...</p></center>');
                          $('#response').show();   
                     },success:function(data){  
                          console.log('data.message',data.message);
                            //obj = $.parseJSON(data);
                            //$('form').trigger("reset");  
                          if(data.message=='success'){
                            $('#response').html('<br><center><p class="text-success">Validated</p></center>');
                          $('#response').show();  
                            toastr["success"]("Validated", "Success");
                            //window.location.href = '{{ route("success") }}';
                          }
                          if(data.message != 'success'){
                            $('#response').html('<br><center><p class="text-danger">Invalid Account...</p></center>');
                            $('#response').show(); 
                            toastr["error"]("Login Failed <br> Code : "+ data.message +"<br>Message : "+ data.result, "Failed");
                            //window.location.href = '#';
                          }
                          setTimeout(function(){  
                               $('#response').fadeOut("slow");  
                          }, 5000);  
                     },
                     error: function(XMLHttpRequest, textStatus, errorThrown) { 
                      console.log(XMLHttpRequest);
                      var errM = '';
                      var errN = '';
                      if(XMLHttpRequest.message){
                        errM = XMLHttpRequest.message +"<br>";
                        errN = XMLHttpRequest.message +"<br>";
                      }
                      toastr["error"]("Process Failed <br>"+ 
                                  errN + errM +
                                  XMLHttpRequest.message,
                                   "Failed");
                     } 
                    });
            });

            $('#password, #confirm-password').on('keyup', function () {
            if ($('#password').val() == $('#confirm-password').val()) {
                console.log('valid')
                $('#confirm-password')[0].setCustomValidity('');
            } else{ 
                console.log('invalid')
                $('#confirm-password')[0].setCustomValidity('invalid');
            }});
        });
    </script>
@endPushOnce
@endonce
