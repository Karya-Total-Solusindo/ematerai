<div class="card">
    {{-- <img class="card-img-top" src="https://picsum.photos/200/10/?blur" alt="Card image cap"> --}}
    <div class="card-body">
        <div class="row p-0">
            <div class="col">
                <h4 class="card-title">My Directory </h4> 
                {{ $datas[0]->company->name ?? '' }} 
            </div>
            <div class="col text-end">
                <a @class(['btn btn-sm btn-danger', 'font-bold' => true]) href="{{ route('company') }}"> Back</a>
            </div>
            {{-- <p class="card-text">Text</p> --}}
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Name</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                Detail</th>
                            <th
                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Documents</th>
                            <th
                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Create</th>
                            <th class="text-secondary opacity-7" width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                        <tr>
                            <td>
                                <div class="align-middle text-sm">
                                    {{-- <div>
                                        <img src="/img/team-2.jpg" class="avatar avatar-sm me-3"
                                            alt="user1">
                                    </div> --}}
                                    <div class="">
                                        <h6 class="p-0"><a href="{{ route('directory',$data->id) }}">{{ $data->name }}</a></h6>
                                        {{-- <p class="text-xs text-secondary mb-0">john@creative-tim.com</p> --}}
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle text-sm">
                                 {{ $data->detail }} 
                                {{-- <span class="badge badge-sm bg-gradient-success"> Online</span> --}}
                            </td>
                            <td class="align-middle text-center text-sm">
                                 {{ App\Models\Document::where('directory_id',$data->id)->count() }}
                                {{-- <span class="badge badge-sm bg-gradient-success"> Online</span> --}}
                            </td>
                            <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">{{ $data->created_at->format('d/m/Y') }}</span>
                            </td>
                            <td class="align-middle text-end">
                                {{-- <a href="{{ route('stemp.show',$data->id) }}" class="btn btn-s btn-primary text-white font-weight-bold text-xs"
                                    data-toggle="tooltip" data-original-title="Edit Company">
                                    Detail
                                </a> --}}
                                <a href="{{ route('document',$data->id) }}" class="btn btn-s btn-primary text-white font-weight-bold text-xs"
                                    data-toggle="tooltip" data-original-title="Edit Company">
                                    Open
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                </table>

            </div>
        </div>
        {{ $datas->links() }}
    </div>
</div>