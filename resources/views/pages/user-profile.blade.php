@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Your Profile'])
    <style>
        .input-group{
            border: solid 1px #d2d6da !important;
            border-radius: 8px !important;
            background: #e9ecef !important;
        }
        .input-group input{
            padding: 6px;
        }
        .input-group span.input-icon{
            border: solid 1px #d2d6da !important;
            border-radius: 5px 0px 0px 8px !important;
            padding: 8px !important;
            background: #e9ecef !important;
        }
        .input-group span.validity{
            top: 10px;
        }
        .input-group span:after{
            background: #fff !important;
                position: absolute;
                /* content: "✖"; */
                padding-left: 5px;
                color: #8b0000;
                /* top: 41px; */
                /* right: 13px; */
        }
    </style>
    <script>
        function edit(){
            let setDisable = false;
            let editText = 'Cencel&nbsp;&nbsp;<i class="fa fa-close"></i>';
            let saveDisplay = 'block';
            let clsRemove = 'btn-info';
            let clsadd = 'btn-dark';
            if(document.getElementById("email").disabled == false){
                setDisable = true;
                editText = 'Edit&nbsp;&nbsp;<i class="fa fa-pen"></i>';
                saveDisplay = 'none';
                clsRemove = 'btn-dark';
                clsadd = 'btn-info';
            }
            let fields = document.getElementsByClassName('profile');
            for (var i = 0; i < fields.length; i++) {
                fields[i].disabled = setDisable;
            }
            document.getElementById("btn-edit").classList.remove(clsRemove)
            document.getElementById("btn-edit").classList.add(clsadd);
            document.getElementById("btn-edit").classList.remove();
            document.getElementById("btn-edit").innerHTML = editText;
            document.getElementById("btn-save").style.display = saveDisplay;
            

           
        }
        function change(){
            let setDisable = false;
            let editText = 'Cencel&nbsp;&nbsp;<i class="fa fa-close"></i>';
            let saveDisplay = 'block';
            let clsRemove = 'btn-info';
            let clsadd = 'btn-dark';
            let save = document.getElementById("btn-save-change");
            let fields = document.getElementsByClassName('password-change');
            
            console.log(save.style.dispaly);
            if(edit==true){
                document.getElementById("btn-edit-change").classList.remove('btn-dark')
                document.getElementById("btn-edit-change").classList.add('btn-info');
                document.getElementById("btn-edit-change").classList.remove();
                document.getElementById("btn-edit-change").innerHTML = 'Change&nbsp;&nbsp;<i class="fa fa-lock"></i>';
                document.getElementById("btn-save-change").style.display = 'none';
                setDisable = true;
                edit = false;
            }else{
                
                document.getElementById("btn-edit-change").classList.remove(clsRemove)
                document.getElementById("btn-edit-change").classList.add(clsadd);
                document.getElementById("btn-edit-change").classList.remove();
                document.getElementById("btn-edit-change").innerHTML = editText;
                document.getElementById("btn-save-change").style.display = saveDisplay;
                edit = true;
            }
            for (var i = 0; i < fields.length; i++) {
                    fields[i].disabled = setDisable;
                }
            
        }
        
        function showpass(){
            let newPassword = document.getElementById('newPassword');
            let type = newPassword.getAttribute('type');
            let eyes = document.getElementById('eyes'); 
            let eyec = document.getElementById('eyec');
            if(type=='text'){
                newPassword.setAttribute('type','password');
                eyes.style.display='block';
                eyec.style.display='none';
            }else{
                eyes.style.display='none';
                eyec.style.display='block';
                newPassword.setAttribute('type','text');
            }
            console.log(newPassword.getAttribute('type'))
        }
    </script>
    <div class="card shadow-lg mx-4 card-profile-bottom">
        <div class="card-body p-3">
            <div class="row gx-4">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img src="/img/team-1.jpg" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            {{ auth()->user()->email }}
                        </h5>
                        <p class="mb-0 font-weight-bold text-sm">
                            {{-- Public Relations --}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="alert">
        @include('components.alert')
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <form role="form" method="POST" action={{ route('profile.update') }} enctype="multipart/form-data">
                        @csrf
                        <div class="card-header ">
                            <div class="d-flex align-items-center">
                                <h6 class="mb-0">USER INFORMATION</h6>
                                {{-- <button type="button" onclick="edit()" id="btn-edit" class="btn btn-info btn-sm ms-auto">Edit&nbsp;&nbsp;<i class="fa fa-pen"></i></button>
                                <button type="submit" class="btn btn-primary btn-sm ms-2" id="btn-save" style="display: none;">Save&nbsp;&nbsp;<i class="fa fa-save"></i></button> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            {{-- <p class="text-uppercase text-sm">User Information</p> --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Username</label>
                                        <input class="form-control profile" type="text" name="username_old" value="{{ old('username', auth()->user()->username) }}" readonly>
                                        {{-- <input class="form-control" type="text" name="username" value="{{ old('username', auth()->user()->username) }}"> --}}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Email address</label>
                                        <input class="form-control profile" type="email" name="email" id="email" disabled
                                        value="{{ old('email', auth()->user()->email) }}" required>
                                        <span class="validity"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    
                    <form role="form" method="POST" action={{ route('profile.password') }}>
                        @csrf
                        <input class="form-control profile" type="email" name="email" id="email" hidden
                                        value="{{ old('email', auth()->user()->email) }}" required>
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <h6 class="mb-0">CHANGE PASSWORD</h6>
                                <button type="button" onclick="change()" id="btn-edit-change" class="btn btn-info btn-sm ms-auto">Change&nbsp;&nbsp;<i class="fa fa-lock"></i></button>
                                <button type="submit" class="btn btn-primary btn-sm ms-2" id="btn-save-change" style="display: none;">Save&nbsp;&nbsp;<i class="fa fa-save"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                                {{--SHOW ERROR  --}}
                                @if ($errors->any())
                                    <div class="alert m-1 alert-danger text-white">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                  {{-- {{ $errors->any() }}
                                 {{  $errors->password->first('oldPassword') }} --}}
                                {{--SHOW ERROR  --}}
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="oldPassword" class="form-control-label">Current Password&nbsp;<span>*</span></label>
                                        <input class="form-control password-change" type="password" name="oldPassword" id="oldPassword" autocomplete="off" disabled
                                        value="" required>
                                        <span class="validity"></span>
                                    </div>
                                </div>
                                <hr class="horizontal dark">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="newPassword" class="form-control-label">New Password&nbsp;<span>*</span></label>
                                        <div class="input-group">
                                            <span id="showpass" class="input-icon" onclick="showpass()">
                                                <i class="fas fa-eye" id="eyes"></i>
                                                <i class="fas fa-eye-slash" id="eyec"@style('display:none')></i>
                                            </span>
                                            <input class="form-control password-change" pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{6,}$" type="password" name="password" id="newPassword" autocomplete="off" disabled
                                            value="" required>
                                            <span class="validity"></span>
                                        </div>
                                        <span class="text-sm help">Include a numeric, and special character</span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="confPassword" class="form-control-label">Confirm Password&nbsp;<span>*</span></label>
                                        <input class="form-control password-change" type="password" name="password_confirmation" id="confPassword" autocomplete="off" disabled
                                        value="" required>
                                        <span class="validity"></span>
                                    </div>
                                </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- @include('layouts.footers.auth.footer') --}}
    </div>
@endsection


