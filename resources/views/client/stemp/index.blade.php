@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Stemp'])
    <div class="container-fluid py-4">
        @if (Route::currentRouteName() == 'stemp.index')
            @include('client.stemp.list')
        @elseif (Route::currentRouteName() == 'company')
            @include('client.stemp.company')
        @elseif (Route::currentRouteName() == 'directory')
            @include('client.stemp.directory')
        @elseif (Route::currentRouteName() == 'document')
            @include('client.stemp.document')
        @elseif (Route::currentRouteName() == 'add.file')    
            @if ($datas[0]->template==0)
                @include('client.stemp.upload')       
            @else
                @include('client.stemp.upload_multiple')    
                {{-- @include('client.configure.directory.show')     --}}
            @endif
            
        @elseif (Route::currentRouteName() == 'stemp.create')
            @include('client.stemp.create')
        @elseif (Route::currentRouteName() == 'stemp.show')
            @include('client.stemp.show')     
        @endif
    </div>
@endsection
