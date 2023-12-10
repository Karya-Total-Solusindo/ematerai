@extends('layouts.app') @section('content') 
@include('layouts.navbars.auth.topnav', ['title' => 'User Management'])
<div class="row mt-4 mx-4">
    <div class="col-12">
        {{-- <div class="alert alert-light" role="alert"> This feature is available in <strong>{{ env('APP_NAME') }}</strong>. Check it <strong>
                <a href="#" target="_blank"> here </a>
            </strong>
        </div> --}}
        <div class="card mb-4">
            <div class="card-header pb-0">
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-6">
                        <h6>Users</h6>
                    </div>
                    <div class="col-xs-12 col-md-12 col-lg-6 text-end align-items-center">
                        <a href="{{route('users.create')}}" class="btn btn-sm btn-primary">New User</a>
                    </div> 
                </div>
                
                {{-- @role('Admin')
                    I am a super-admin!
                @else
                    I am not a super-admin...
                @endrole --}}
                
            </div> 
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Mail </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Role </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Create Date</th>
                                {{-- <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Action</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $no => $user)
                                <tr>
                                    <td class="align-middle text-center text-sm">{{$no+1}}</td>
                                    <td>
                                        <a href="{{route('users.show',$user->id)}}" title="{{$user->firstname.' '.$user->lastname }}" >
                                        <div class="d-flex px-3 py-1">
                                            {{-- <div>
                                                <img src="./img/team-{{ rand(1,3) }}.jpg" class="avatar me-3" alt="image">
                                            </div> --}}
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $user->username }}</h6>
                                            </div>
                                        </div>
                                        </a>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $user->email }}</p>
                                    </td>
                                    <td>
                                    {{-- @if(!empty($user->getRoleNames()))
                                        @foreach($user->getRoleNames() as $v)
                                           <label class="badge badge-success">{{ $v }}</label>
                                        @endforeach
                                    @endif --}}
                                    @if(count($user->roles))
                                        @foreach($user->roles as $role)
                                        <span class="badge bg-primary">{{ $role->name }}</span>
                                        @endforeach
                                    @else
                                        <span class="badge bg-default">None</span>
                                    @endif
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-bold mb-0">  {{ Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}  </p>
                                    </td>
                                    {{-- <td class="align-middle text-end"> --}}
                                        {{-- <div class="d-flex px-3 py-1 justify-content-center align-items-center"> --}}
                                            {{-- <a href="{{ route('users.show',$user->id) }}" class="text-sm font-weight-bold px-auto mb-0">Service Account</a> --}}
                                            {{-- <a href="{{ route('users.edit',$user->id) }}" class="text-sm font-weight-bold mx-auto mb-0">Edit</a> --}}
                                            {{-- <a href="{{ URL::to('/users/'.$user->id.'/edit') }}" class="text-sm font-weight-bold mb-0">Edit</a> --}}
                                            {{-- <p class="text-sm font-weight-bold mb-0 ps-2">Delete</p> --}}
                                        {{-- </div> --}}
                                    {{-- </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> @endsection
