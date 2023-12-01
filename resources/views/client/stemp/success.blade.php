<div class="card">
    {{-- <img class="card-img-top" src="https://picsum.photos/200/10/?blur" alt="Card image cap"> --}}
    <div class="card-body">
        <div class="row p-0">
            <div class="col">
                <h4 class="card-title"><i class="ni ni-paper-diploma"></i> Certified Document</h4> 
            </div>
            <div class="col text-end">
                <a class="btn btn-info" href="{{ route('exportSuccecc') }}">Export File</a>
                {{-- <a @class(['btn btn-primary', 'font-bold' => true]) href="{{ route('directory.index') }}"> Create</a> --}}
            </div>
            {{-- <p class="card-text">Text</p> --}}
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            @if ($errors->any())
            <div class="alert alert-danger">
                {{-- <strong>Whoops!</strong> There were some problems with your input.<br><br> --}}
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
                                Document</th>
                            {{-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                Detail</th> --}}
                            <th class="text-left text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Company</th>
                            <th class="text-left text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Directory</th>            
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Sataus</th>
                            <th
                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Stemp</th>
                            <th class="text-secondary opacity-7"></th>
                        </tr>
                    </thead>
                    <tbody>
                       
                    @if ($datas->count()) 
                        @foreach ($datas as $data)
                        <tr>
                            <td>
                                <div class="d-flex px-2 py-1 align-items-center">
                                    <div>
                                        <i class="fas fa-file-pdf"></i>
                                    </div>
                                    <div class="ms-4">
                                        <h6 class="mb-0 text-sm"><a href="{{ route('stemp.show',$data->id) }}" title="click show detail">{{ $data->filename }}</a></h6>
                                        {{-- <p class="text-xs text-secondary mb-0"><i class="ni ni-building"></i> {{ $data->company->name }} <i class="fas fa-folder-open"></i> {{ $data->directory->name }}</p> --}}
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle text-sm text-left">
                               {{ $data->company->name }}
                            </td>
                            <td class="align-middle text-sm text-left">
                                {{ $data->directory->name }}
                             </td>
                            <td class="align-middle text-center">
                                <span class="badge badge-sm  bg-gradient-success">{{ $data->certificatelevel ?? 'NOT_CERTIFIED' }}</span>
                                {{-- {{ App\Models\Document::where('directory_id',$data->id)->count() ?? 0 }} --}}
                            </td>
                            <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">{{ $data->updated_at->format('d/m/Y - H:i:s') }}</span>
                            </td>
                            <td class="align-middle text-end">
                                <a href=" {{ asset('storage/docs/'.$data->company->name.'/'.$data->directory->name.'/out/'.$data->filename) }}" class="text-primary font-weight-bold text-xs"
                                    data-toggle="tooltip" data-original-title="Edit Download">
                                    <span class="badge badge-sm bg-gradient-success">Download</span>
                                </a>
                               
                                <a href="{{ route('stemp.show',$data->id) }}" class="text-primary font-weight-bold text-xs"
                                    data-toggle="tooltip" data-original-title="Edit Download">
                                    <span class="badge badge-sm bg-gradient-info"> Detail</span>
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