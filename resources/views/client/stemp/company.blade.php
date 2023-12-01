<div class="card" style="display: none">
    {{-- <img class="card-img-top" src="https://picsum.photos/200/10/?blur" alt="Card image cap"> --}}
    <div class="card-body">
        <div class="row p-0">
            <div class="col">
                <h4 class="card-title"><i class="ni ni-building"></i> My Company</h4> 
            </div>
            <div class="col text-end">
                {{-- <a @class(['btn btn-primary', 'font-bold' => true]) href="{{ route('company.create') }}"> Create</a> --}}
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
                            
                            <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                Directory</th>
                            <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Document</th>   
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="display: none;">
                                        Detail</th>         
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Create</th>
                            <th class="text-secondary opacity-7"></th>
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
                                        <h6 class="p-0 mb-0">
                                            {{-- <i class="ni ni-building"></i>  --}}
                                            <a href="{{ route('directory',$data->id) }}">{{ $data->name }}</a></h6>
                                            <span class="d-print-none">{{ $data->detail }}</span>
                                    </div>
                                </div>
                            </td>
                           
                            <td class="align-middle text-center text-sm">
                                {{ App\Models\Directory::where('company_id',$data->id)->count() }}
                            </td>
                            <td class="align-middle text-center text-sm">
                                {{ App\Models\Document::where('company_id',$data->id)->count() }}
                            </td>
                            <td class="align-middle text-center d-print-block" style="display: none;">
                                {{ $data->detail }}
                            </td>
                            <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">{{ $data->created_at->format('d/m/Y') }}</span>
                            </td>
                            <td class="align-middle text-end text-sm">
                                <a href="{{ route('document',$data->id) }}" class="btn btn-s btn-primary text-white font-weight-bold text-xs"
                                    data-toggle="tooltip" data-original-title="Edit Company">
                                    OPEN
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
<div class="card">
    {{-- <img class="card-img-top" src="https://picsum.photos/200/10/?blur" alt="Card image cap"> --}}
    <div class="card-body mb0">
        <div class="row p-0">
            <div class="col">
                <h4 class="card-title"><i class="ni ni-building"></i> My Company</h4> 
            </div>
            <div class="col text-end">
                {{-- <a @class(['btn btn-primary', 'font-bold' => true]) href="{{ route('company.create') }}"> Create</a> --}}
                {{-- <a @class(['btn btn-sm btn-primary', 'font-bold' => true]) href="{{ route('document.create') }}"> Create</a> --}}
            </div>
            {{-- <p class="card-text">Text</p> --}}
        </div>
        <div class="card-body px-0 pt-0 mb-0 pb-2">
            <div class="row mb-0">
                <div class="col-12">
                    <div id="jstree">
                        @foreach ($datas as $data)
                            <ul>
                                <li data-jstree='{"icon":"fas fa-folder","disabled":false}' class="mt-2">
                                    <a title="{{$data->created_at->format('d/m/Y H:i:s')}}"> 
                                        <b class="ms-2">{{$data->name}}</b>
                                        {{-- <span class="position-absolute ms-1 border border-light badge badge-xs bg-gradient-warning">{{App\Models\Directory::where('company_id',$data->id)->count()}}</span> --}}
                                        {{-- <font size="1">{{$data->created_at->format('d/m/Y H:i:s')}}</font> --}}
                                    </a>
                                    <ul>
                                    @foreach (App\Models\Directory::where('company_id',$data->id)->get() as $dir)
                                        <li data-jstree='{"icon":"fas fa-folder","disabled":false}' class="mt-2">
                                            <a href="{{ route('document',$dir->id) }}">
                                                <b class="ms-2" title="{{$data->created_at->format('d/m/Y H:i:s')}}">{{$dir->name}}</b>
                                                @if(App\Models\Document::where('directory_id',$dir->id)->where('certificatelevel','NEW')->count()>=0)
                                                <span class="position-absolute ms-1 border border-light badge badge-xs bg-gradient-warning">{{App\Models\Document::where('directory_id',$dir->id)->where('certificatelevel','NEW')->count()}}</span>
                                                @endif
                                            </a>
                                        </li>
                                    @endforeach    
                                    </ul>
                                </li> 
                            </ul>
                        @endforeach
                    </div>
                </div>
                <div class="col-8"></div>
            </div>
        </div>    
    </div>    
</div>    




{{-- Javascript --}}
@once  
    @pushOnce('js')
        <script type="text/javascript">
                // const data =[
                // @foreach ($datas as $data)
                //         {
                //             'text' : '{{$data->name}}',
                //             'icon' : 'fas fa-folder text-primary',    
                //             'state' : {
                //             'opened' : false,
                //             'selected' : false
                //             },
                //             'children' : [
                //             @foreach (App\Models\Directory::where('company_id',$data->id)->get () as $dir)
                //             { 'text' : '{{ $dir->name }}','href':'1', 'icon' : 'fa fa-folder text-primary',  
                //             "html_data" : { 
                //                     "data" : 'hallo'
                //                 } 
                //             },
                //             @endforeach    
                //             ],
                //         },
                // @endforeach
                // ];        
                $('#jstree').jstree({ 
                    "animation" : 0,
                    // "html_data" : {"data" : "<li id='root'><i class='fas fa-folder'></i> <a href='#' class='w-80'>Root node</a><ul><li><a >Child node</a></li></ul></li>"},
                    "plugins" : ["themes","html_data","ui","wholerow"] ,
                    // 'core' : { 'data' :  data  } 
                })
                // listen for event
                .bind('changed.jstree', function (e, data) {
                    var href = data.node.a_attr.href;
                    if(href !='#'){
                        document.location.href = href;
                    }
                })
                // create the instance
                .jstree();
            </script>
    @endPushOnce
@endonce
