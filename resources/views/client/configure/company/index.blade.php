@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Company'])
    <div class="container-fluid py-4">
        @if (Route::currentRouteName() == 'company.create')
            @include('client.configure.company.form')
        @elseif (Route::currentRouteName() == 'company.edit')
            @include('client.configure.company.form')    
        @else
            @include('client.configure.company.list')    
        @endif
    </div>
@endsection