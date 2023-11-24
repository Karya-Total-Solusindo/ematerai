<div class="card">
    {{-- <img class="card-img-top" src="https://picsum.photos/200/10/?blur" alt="Card image cap"> --}}
    <div class="card-body">
        <div class="row p-0">
            <div class="col">
                <h4 class="card-title">My Document</h4> 
            </div>
            <div class="col text-end">
                <a @class(['btn btn-primary', 'font-bold' => true]) href="{{ route('directory.index') }}"> Create</a>
            </div>
            {{-- <p class="card-text">Text</p> --}}
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Name</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                Satatus</th>
                            <th  class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Create</th>
                            <th class="text-secondary opacity-7"></th>
                        </tr>
                    </thead>
                    <tbody>
                       
                    @if ($datas->count()) 
                        @foreach ($datas as $data)
                        <tr>
                            <td>
                                <h6 class="mb-0 text-sm"><a href="{{ route('stemp.show',$data->id) }}">{{ $data->filename }}</a></h6>
                                <p class="text-xs text-secondary mb-0">{{ $data->company->name }} / {{ $data->directory->name }}</p>
                            </td>
                            <td class="align-middle text-center text-sm">
                                @if ($data->certificatelevel == 'CERTIFIED')
                                    <span class="badge badge-sm bg-gradient-success">{{$data->certificatelevel}}</span>
                                @else
                                    <span class="badge badge-sm bg-gradient-secondary">{{ $data->certificatelevel ?? 'NOT_CERTIFIED' }}</span>
                                @endif
                                
                            </td>

                            <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">{{ $data->created_at->format('d/m/Y - H:i:s') }}</span>
                            </td>

                            <td class="align-middle text-end">
                                @if ($data->certificatelevel == 'CERTIFIED')
                                    <a href="{{ route('stemp.show',$data->id) }}" class="text-secondary font-weight-bold text-xs"
                                        data-toggle="tooltip" data-original-title="Edit Company">
                                        <span class="badge badge-sm bg-gradient-success"> Download </span>
                                    </a>
                                @endif
                                <a href="{{ route('stemp.show',$data->id) }}" class="text-secondary font-weight-bold text-xs"
                                    data-toggle="tooltip" data-original-title="Edit Company">
                                    <span class="badge badge-sm bg-gradient-info">Detail</span>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    @endif    
                </table>
            </div>
        </div>
        {{ $datas->links() }}
    </div>
</div>