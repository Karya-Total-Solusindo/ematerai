@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100']) @section('content') @include('layouts.navbars.auth.topnav', ['title' => 'Roles Management'])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <div class="d-flex align-items-center">
                    {{-- <p class="mb-0">Show Role</p> --}}
                    <h6> Show Role</h6>
                    <a href="/roles" class="btn btn-primary btn-sm ms-auto">Back</a>
                </div>
            </div>
            <div class="card-body">
                <p class="text-uppercase text-sm">Role Information</p>
                <div class="row">
                    <div class="form-group">
                        <strong>Name:</strong> {{ $role->name }}
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <strong>Permissions:</strong> 
                        <div class="form-group" style="display:inline;">
                            @if(!empty($rolePermissions)) @foreach($rolePermissions as $v) <label class="label label-success">{{ $v->name }},</label> @endforeach @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
