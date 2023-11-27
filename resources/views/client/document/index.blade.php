@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Stemp'])
    <div class="container-fluid py-4">
        @if (Route::currentRouteName() == 'document.create')
            @include('client.document.upload.multiple')
        @else

        @endif    
    </div>

@endsection            