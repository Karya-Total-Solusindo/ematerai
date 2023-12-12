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
                        <div class="col-xs-12 col-md-12 col-lg-8">
                            <h6>Users</h6>
                        </div>
                        <div class="col-xs-12 col-md-12 col-lg-4 align-items-start">
                            <div class="dropdown mb-0 dropend ">
                                <button class="btn btn-primarys btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                Select By 
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li>
                                    <a class="dropdown-item" href="{{ route('users.index') }}?active=true">Active</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('users.index') }}?active=false">Non Active</a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('users.index') }}">Show All Users </a></li>
                                </ul>
                                <a href="{{route('users.create')}}" class="btn btn-sm btn-primary">New User</a>
                            </div>
                            
                        
                    </div> 
                </div>  
            </div> 
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Mail </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Create Date</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $no => $user)
                                <tr>
                                    <td class="align-middle text-center text-sm">{{$no+1}}</td>
                                    <td>
                                        <a href="{{route('users.show',$user->id)}}" title="{{$user->firstname.' '.$user->lastname }}" >
                                            @if($user->active == 1)
                                             <h6 class="mb-0 text-sm">{{ $user->username }}</h6>
                                            @else
                                            <h6 class="mb-0 text-sm text-danger" title="User non Active"><i class="fas fa-shield-halved"></i> {{ $user->username }}</h6>
                                            @endif
                                        </a>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $user->email }}</p>
                                    </td>
                                    <td>

                                    @if(count($user->roles))
                                        @foreach($user->roles as $role)
                                            @if($user->active == 1)
                                            <span class="badge bg-primary">{{ $role->name }}</span>
                                            @else
                                            <span class="badge bg-primary">{{ $role->name }}</span>
                                            <span class="badge bg-default">None Active</span>
                                            @endif
                                        @endforeach
                                    @else
                                    <span class="badge bg-default">No Rule</span>
                                        @if($user->active == 0)
                                            <span class="badge bg-default">None</span>
                                        @else
                                            <span class="badge bg-default">None Active</span>
                                        @endif
                                    @endif
                                    
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-bold mb-0">  {{ Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}  </p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <div class="dropdown dropend text-end mb-0">
                                            <button class="btn btn-primarys btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                ACTION
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('users.edit',$user->id) }}?active=true"><i class="fas fa-pencil"></i> User Edit</a>
                                                </li>
                                                @if($user->id >=2 )
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('users.show',$user->id) }}?active=false"><i class="fas fa-circle-nodes"></i>  Service Accunt</a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form class="dropdown-item" action="{{route('users.active')}}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$user->id}}">
                                                        <button class="dropdown-item text-success" type="submit" name="active" value="1"><i class="fas fa-shield-halved"></i> active</button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form class="dropdown-item" action="{{route('users.active')}}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$user->id}}">
                                                    <button class="dropdown-item text-danger" type="submit" name="active" value="0"><i class="fas fa-user-shield"></i>  Block</button>
                                                </form>
                                                </li>
                                                @endif
                                            </ul>
                                        </div>
                                        {{-- <div class="align-middle text-center text-sm"> --}}
                                            {{-- <a href="{{ route('users.show',$user->id) }}" class="text-sm font-weight-bold px-auto mb-0">Service Account</a> --}}
                                            {{-- <a href="{{ route('users.edit',$user->id) }}" class="btn btn-sm btn-primary">Edit</a> --}}
                                            {{-- <a href="{{ URL::to('/users/'.$user->id.'/edit') }}" class="text-sm font-weight-bold mb-0">Edit</a> --}}
                                            {{-- <p class="text-sm font-weight-bold mb-0 ps-2">Delete</p> --}}
                                        {{-- </div> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer mx-2">
                    {{ $users->appends(request()->input())->links() }}
                </div>
            </div>

        </div>
    </div>
</div> @endsection
