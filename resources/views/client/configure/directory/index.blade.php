@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Directories'])
    <div class="container-fluid py-4">
        @if (Route::currentRouteName() == 'directory.create')
            @include('client.configure.directory.form')
        @elseif (Route::currentRouteName() == 'directory.edit')
            @include('client.configure.directory.form')
        @elseif (Route::currentRouteName() == 'directory.show')
            @include('client.configure.directory.show')       
        @else
            @include('client.configure.directory.list')    
        @endif
    </div>
@endsection