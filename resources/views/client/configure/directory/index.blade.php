@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Directories'])
    <div class="container-fluid py-4">
        @if (Route::currentRouteName() == 'directory.create')
            @include('client.configure.directory.form_with_template')
        @elseif (Route::currentRouteName() == 'directory.edit')
            @include('client.configure.directory.edit')
        @elseif (Route::currentRouteName() == 'directory.show')
            @if ($datas[0]->template==0)
                @include('client.stemp.create')       
            @else
                @include('client.configure.directory.show')    
            @endif 
        @else
            @include('client.configure.directory.list')    
        @endif
    </div>
@endsection