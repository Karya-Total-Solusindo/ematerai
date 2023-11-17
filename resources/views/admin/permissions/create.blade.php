@extends('layouts.app') @section('content') @include('layouts.navbars.auth.topnav', ['title' => 'Roles Management'])
<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <div class="d-flex align-items-center">
                    <h6> Create Permission</h6>
                    <a href="/roles" class="btn btn-primary btn-sm ms-auto">Back</a>
                </div>
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> something went wrong.<br><br>
                        <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Method</th>
                                <th>URI</th>
                                <th>Name</th>
                                <th>Middleware</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($routes as $route)
                                @if($route->getName() != '' && count($route->middleware()) !=0)
                                @if((strlen($route->middleware()[0]) < 10))
                                <form class="p-0 m-0" method="POST" action="{{ route('permissions-store') }}">
                                    @csrf
                                    <tr class="p-0">
                                        <td class="mb-0">
                                            {{-- {{ response()->json($route); }} --}}
                                            @switch($route->methods()[0])
                                                @case('GET') <span class="badge bg-success">{{$route->methods()[0]}}</span> @break
                                                @case('POST') <span class="badge bg-primary">{{$route->methods()[0]}}</span> @break
                                                @case('PUT') <span class="badge bg-warning">{{$route->methods()[0]}}</span> @break
                                                @case('DELETE') <span class="badge bg-danger">{{$route->methods()[0]}}</span> @break
                                                        <span class="badge bg-default">{{$route->methods()[0]}}</span>
                                                @default
                                            @endswitch
                                        </td>
                                        <td class="mb-0">{{ $route->uri() }}</td>
                                        <td class="mb-0">{{ $route->getName() }}</td>
                                        <td class="mb-0 text-center"> 
                                            @if(count($route->middleware()) !=0)
                                                {{ (strlen($route->middleware()[0]) < 10) ? $route->middleware()[0]:'' }}
                                            @endif
                                        </td>
                                        <td class="mb-0">
                                            @if(!in_array($route->getName(), $permissions_array))
                                            <input type="hidden" name="name" value="{{ $route->getName() }}">  <button type="submit" class="btn btn-sm btn-success">Add</button>
                                           @endif
                                        </td>
                                        {{-- <td>{{ $route->getActionName() }}</td> --}}
                                    </tr>
                                </form>
                                @endif
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <p>
                    {{-- {{!! print_r($permissions_array) !!}} --}}
                </p>
            </div>
        </div>
    </div>
</div>

@endsection
