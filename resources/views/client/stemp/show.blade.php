<div class="card">
    <div class="card-body">
       
        <div class="row justify-content-center align-items-center g-2">
            <div class="col-md-6"> <h4 class="card-title">{{ substr($datas[0]->filename,11)}}</h4></div>
            <div class="col-md-6 text-end">
                <a href="{{ url()->previous()}}" class="btn btn-s bg-danger text-white">Close</a>
            </div>
        </div>
        {{-- <p class="card-text">{{ substr($datas[0]->filename,11)}}</p> --}}
        <div class="table-responsive">
            <table class="table table-default">
                <tbody>
                    @foreach ($datas as $data)
                        <tr class="">
                            <td width="10px">File Name</td>
                            <td width="1px">:</td>
                            <td>{{ $data->filename }}</td>
                        </tr>
                        {{-- <tr class="">
                            <td>Source</td>
                            <td>:</td>
                            <td><a href="{{asset('storage'.$data->source ) }}" >{{$data->source}}</a></td>
                        </tr> --}}
                        <tr class="">
                            <td>Company</td>
                            <td>:</td>
                            <td>{{$data->company->name}}</td>
                        </tr>
                        <tr class="">
                            <td>Directory</td>
                            <td>:</td>
                            <td>{{$data->directory->name}}</td>
                        </tr>
                        <tr class="">
                            <td>Stemp</td>
                            <td>:</td>
                            <td> Page:  {{$data->page}},<br>
                                <span>visULX:</span> {{$data->x1}},visURX: {{$data->y1}},
                                visLLY: {{$data->x2}},visURY: {{$data->y2}},  
                            </tr>
                        <tr class="">
                            <td>Status Stemp</td>
                            <td>:</td>
                            <td>
                                @if(!$data->certificatelevel)
                                    <span class="badge btn-warning badge-warning">NOT CERTIFIED</span>
                                @else
                                    {{$data->certificatelevel}}
                                @endif
                            </td>
                        </tr>
                        <tr class="">
                            <td>Stemp Serial Number</td>
                            <td>:</td>
                            <td>{{ $data->sn ?? '{Serial Number}'  }}</td>
                        </tr>
                        <tr class="">
                            <td>Materai</td>
                            <td>:</td>
                            <td><img src="{{ asset('storage/'.$data->spesimenPath) ?? '#'  }}" alt="Stemp spesimenPath"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row justify-content-center align-items-center g-2">
            <div class="col-md-6"></div>
            <div class="col-md-6 text-end">
                <a href="{{ url()->previous() }}" class="btn btn-s bg-danger text-white">Close</a>
            </div>
        </div>
        
    </div>
</div>