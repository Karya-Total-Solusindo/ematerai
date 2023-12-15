@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Stemp'])
    <div class="card">
        <div class="card-body">
            <h3><i class="fas fa-database"></i> Database Backup</h3>
        <div class="row">
            <div class="col-xs-12 clearfix">
                <form action="{{ url('backup/create') }}" method="GET" class="add-new-backup" enctype="multipart/form-data" id="CreateBackupForm">
                    {{ csrf_field() }}
                    <input type="submit" name="submit" class="theme-button btn btn-primary pull-right" style="margin-bottom:2em;" value="Create Database Backup">
                </form>
            </div>
        <div class="col-xs-12">
                @if ( Session::has('success') )
                    <div class="alert alert-success alert-dismissible text-white">
                        <a type="button" class="close" data-dismiss="alert">&times;</a>
                        {{ Session::get('success') }}
                    </div>
                    @endif

                    @if ( Session::has('update') )
                    <div class="alert alert-success alert-dismissible text-white">
                        <a type="button" class="close" data-dismiss="alert">&times;</a>
                        {{ Session::get('update') }}
                    </div>
                    @endif

                    @if ( Session::has('delete') )
                    <div class="alert alert-danger alert-dismissible text-white">
                        <a type="button" class="close" data-dismiss="alert">&times;</a>
                        {{ Session::get('delete') }}
                    </div>
                @endif

                @if (count($backups))
                    <table class="table table-striped table-bordered ">
                        <thead>
                        <tr>
                            <th>File Name</th>
                            <th>File Size</th>
                            <th>Created Date</th>
                            <th>Created Age</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($backups as $backup)
                            <tr>
                                <td>{{ $backup['file_name'] }}</td>
                                <td>{{ \App\Http\Controllers\BackupController::humanFilesize($backup['file_size']) }}</td>
                                <td>
                                    {{ date('F jS, Y, g:ia (T)',$backup['last_modified']) }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($backup['last_modified'])->diffForHumans() }}
                                </td>
                                <td class="text-right">
                                    <a class="btn btn-success"
                                    href="{{ url('backup/download/'.$backup['file_name']) }}">
                                    <i class="fa fa-cloud-download"></i> Download</a>
                                    <a class="btn btn-danger" onclick="return confirm('Do you really want to delete this file')" data-button-type="delete"
                                    href="{{ url('backup/delete/'.$backup['file_name']) }}"><i class="fas fa-trash"></i>
                                    Delete</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="well">
                        <h4>No backups</h4>
                    </div>
                @endif
            </div>
        </div>
        {{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js" type="text/javascript"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" type="text/javascript"></script> --}}
        <script type="text/javascript">
            $("#CreateBackupForm").on('submit',function(e){
                $('.theme-button').attr('disabled','disabled');
            });
        </script>
        </div>
    </div>
    
@endsection   