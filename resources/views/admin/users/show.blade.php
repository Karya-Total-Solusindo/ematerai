@extends('layouts.app') @section('content') @include('layouts.navbars.auth.topnav', ['title' => 'User Management'])
<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="alert alert-light" role="alert"> This feature is available in <strong>{{ env('APP_NAME') }}</strong>. Check it <strong>
                <a href="#" target="_blank"> here </a>
            </strong>
        </div>
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
                    <a class="btn btn-primary btn-sm ms-auto" href="{{ route('users.index') }}"> Back </a>
                </div>

            </div>
            <div class="card-body">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Username</th>
                                {{-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Mail </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Role </th> --}}
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Create Date</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Update Date</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Action</th>
                            </tr>
                        </thead>
                        <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div>
                                                <img src="{{ asset('/img/team-'.rand(1,3).'.jpg') }}" class="avatar me-3" alt="image">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $user->username }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    {{-- <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $user->email }}</p>
                                    </td> --}}
                                    {{-- <td>
                                        @if(!empty($user->getRoleNames()))
                                            @foreach($user->getRoleNames() as $v)
                                            <label class="badge badge-success">{{ $v }}</label>
                                            @endforeach
                                        @endif
                                        @foreach($user->roles as $role)
                                        <span class="badge bg-primary">{{ $role->name }}</span>
                                        @endforeach
                                    </td> --}}
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-bold mb-0">  {{ Carbon\Carbon::parse($user->created_at)->format('d.m.Y') }}  </p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-bold mb-0">  {{ Carbon\Carbon::parse($user->update_at)->format('d.m.Y') }}  </p>
                                    </td>
                                    <td class="align-middle text-end">
                                        <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                            <p class="text-sm font-weight-bold mb-0">Edit</p>
                                            <p class="text-sm font-weight-bold mb-0 ps-2">Delete</p>
                                        </div>
                                    </td>
                                </tr>

                        </tbody>
                    </table>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <div class="form-group">
                            <strong>First Name:</strong>
                            <br>
                            {{ $user->firstname }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <div class="form-group">
                            <strong>Last Name:</strong>
                            <br>
                            {{ $user->lastname }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <div class="form-group">
                            <strong>Email:</strong>
                            <br>
                            {{ $user->email }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <div class="form-group">
                            <strong>Roles:</strong>
                            @foreach($user->roles as $role)
                                <span class="badge bg-primary">{{ $role->name }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>




            </div>
        </div>
    </div>
</div>
@endsection
