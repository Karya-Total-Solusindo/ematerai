@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Configure'])
    <div class="container-fluid py-4">
        {{-- @if (Route::currentRouteName() == 'configurecreate') --}}
            @include('client.stemp.create')
        {{-- @elseif (Route::currentRouteName() == 'configure') --}}
            {{-- @include('client.configure.list')     --}}
        {{-- @endif --}}
    </div>
@endsection