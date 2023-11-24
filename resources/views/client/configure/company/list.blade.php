<div class="card">
    {{-- <img class="card-img-top" src="https://picsum.photos/200/10/?blur" alt="Card image cap"> --}}
    <div class="card-body">
        <div class="row p-0">
            <div class="col">
                <h4 class="card-title"> <i class="ni ni-building"></i>  My Company</h4> 
            </div>
            <div class="col text-end">
                <a @class(['btn btn-primary', 'font-bold' => true]) href="{{ route('company.create') }}"> Create</a>
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
                                Directory</th>
                            <th
                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Create</th>
                            <th class="text-secondary opacity-7"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                        <tr>
                            <td>
                                <div class="d-flex px-2 py-1">
                                    {{-- <div>
                                        <img src="/img/team-2.jpg" class="avatar avatar-sm me-3"
                                            alt="user1">
                                    </div> --}}
                                    <div class="d-flex px-2 py-1">
                                        {{ $data->name }}
                                        {{-- <h6 class="mb-0 text-sm"><a href="{{ route('directory.show',$data->id) }}">{{ $data->name }}</a></h6> --}}
                                        {{-- <p class="text-xs text-secondary mb-0">john@creative-tim.com</p> --}}
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle text-sm">
                                {{ $data->detail }}
                                @foreach (App\Models\Directory::where('company_id',$data->id) as $dir)
                                    {{$dir->name}}
                                @endforeach
                                {{-- <span class="badge badge-sm bg-gradient-success"> Online</span> --}}
                            </td>
                            <td class="align-middle text-center text-sm">
                                {{ App\Models\Directory::where('company_id',$data->id)->count() }}
                                {{-- @foreach (App\Models\Directory::where('company_id',$data->id) as $dir)
                                    {{$dir->name}}
                                @endforeach --}}
                                {{-- <span class="badge badge-sm bg-gradient-success"> Online</span> --}}
                            </td>
                            <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">{{ $data->created_at->format('d/m/Y') }}</span>
                            </td>
                            <td class="align-middle">
                                <a href="{{ route('company.edit',$data->id) }}" class="text-secondary font-weight-bold text-xs"
                                    data-toggle="tooltip" data-original-title="Edit Company">
                                    Edit
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