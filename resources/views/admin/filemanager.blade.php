@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'File Manager'])
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-head">
                
            </div>
            <div class="card-body">
                <h6><i class="fas fa-folder"></i> File Manager</h6>
                <hr class="horizontal dark">
                <div class="row">
                    <div class="m-3" id="fm"></div>
                    {{-- <div style="height: 1600px;"> </div> --}}
                </div>
                
            </div>
        </div>
    </div>

<script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
@endsection