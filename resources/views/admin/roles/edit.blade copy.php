@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100']) @section('content') @include('layouts.navbars.auth.topnav', ['title' => 'Roles Management'])
<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <div class="d-flex align-items-center"> {{-- <p class="mb-0">Show Role</p> --}} <h6> Show Role</h6>
                    <a href="/roles" class="btn btn-primary btn-sm ms-auto">Back</a>
                </div>
            </div>
            <div class="card-body">
            </div>
        </div>
    </div>
</div>
@endsection
