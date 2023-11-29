@extends('layouts.app') @section('content') @include('layouts.navbars.auth.topnav', ['title' => 'Roles Management'])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="alert alert-light" role="alert"> This feature is available in <strong>{{ env('APP_NAME') }}</strong>. Check it <strong>
                <a href="#" target="_blank"> here </a>
            </strong>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="card mb-4">
            <div class="card-header pb-0">
                
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Rules</h6>
                                @role('Superadmin, web')
                                {{-- I am a super-admin! --}}
                                 @else
                                {{-- I am not a super-admin... --}}
                                @endrole
                            </div>
                            <div class="col-md-6 text-end">
                                @can('role-create')
                                    <a class="btn btn-warning btn-sm" href="{{ route('permissions-create') }}"> Add Permission </a>
                                    <a class="btn btn-success btn-sm" href="{{ route('roles.create') }}"> Create New Role </a>
                                @endcan
                            </div>
                        </div>
                    </div>  
                </div>
               
                <div class="d-flex align-items-center"> </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th width="80px" class="px-5 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Role </th>
                                <th width="280px" class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $key => $role)
                            <tr>
                                <td class="px-5">{{ ++$i }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    <a class="btn btn-info" href="{{ route('roles.show',$role->id) }}">Show</a>
                                    {{-- <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a> --}}
                                    @can('role-edit')
                                        <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a>
                                    @endcan
                                    @can('role-delete')
                                        {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                                            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                        {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!! $roles->render() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
