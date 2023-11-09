@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Configure'])
    <div class="container-fluid py-4">
        @if (Route::currentRouteName() == 'stemp.index')
            @include('client.stemp.list')
        @elseif (Route::currentRouteName() == 'stemp.create')
            @include('client.stemp.create')
        @elseif (Route::currentRouteName() == 'stemp.show')
            @include('client.stemp.show')         
        @endif
    </div>
@endsection