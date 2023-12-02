<div class="card">
    {{-- <img class="card-img-top" src="https://picsum.photos/200/10/?blur" alt="Card image cap"> --}}
    <div class="card-body">
        <div class="row p-0">
            <div class="col">
                <h4 class="card-title"><i class="ni ni-paper-diploma"></i>  Processing Failed</h4> 
            </div>
            <div class="col text-end">
                <div class="d-flex ">
                    <button @class(['btn me-5 btn-sm btn-info align-items-right', 'font-bold' => true]) class="btn btn-sm btn-info" id="btnGetSN" onclick="$('#execute').submit();"><i class="fas fa-qrcode"></i> Execute Materai</button>
                    
                    <form action="{{ route('exportSuccecc') }}" method="get">
                        <input type="hidden" name="status" value="FAILUR">
                        <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i> Export Excel</button>
                    </form>

                </div>
                {{-- <a class="btn btn-info" href="{{ route('exportSuccecc') }}" onclick="alert(on dev)">Export File</a> --}}
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
                                <input type="checkbox" id="selectAll">
                            </th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                No</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Document</th>
                            {{-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                Detail</th> --}}
                            <th class="text-left text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Company</th>
                            <th class="text-left text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Directory</th>            
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Status</th>
                            {{-- <th
                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Stemp</th> --}}
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Last Update</th>
                        </tr>
                    </thead>
                    <tbody>
                <form id="execute" action="{{ route('setInProgres') }}" method="POST"> 
                    @csrf
                    @if ($datas->count()) 
                        @foreach ($datas as $num => $data)
                        <tr>
                            <td rowspan="1" class="align-middle text-center" style="border-bottom-width: 0px !important;">
                                <input type="checkbox" class="chechList" name="doc[]" value="{{$data->id}}" id="">
                            </td>
                            <td class="align-middle text-center" style="border-bottom-width: 0px !important;">
                                {{ $num+1 }} {{-- <i class="fas fa-file-pdf"></i> --}}
                            </td>
                            <td class="align-middle text-sm text-left" style="border-bottom-width: 0px !important;">
                                <h6 class="mb-0 text-sm"><a href="{{ route('stemp.show',$data->id) }}" title="click show detail">{{ $data->filename }}</a></h6>
                            </td>
                            <td class="align-middle text-sm text-left" style="border-bottom-width: 0px !important;">
                               {{ $data->company->name }}
                            </td>
                            <td class="align-middle text-sm text-left" style="border-bottom-width: 0px !important;">
                                {{ $data->directory->name }}
                             </td>
                            <td class="align-middle text-center" style="border-bottom-width: 0px !important;">
                                <span class="badge badge-sm  bg-gradient-warning">{{ $data->certificatelevel ?? 'NOT_CERTIFIED' }}</span>
                                {{-- {{ App\Models\Document::where('directory_id',$data->id)->count() ?? 0 }} --}}
                            </td>
                            <td class="align-middle text-center" style="border-bottom-width: 0px !important;">
                                <span class="text-secondary text-xs font-weight-bold">{{ $data->updated_at->format('d/m/Y - H:i:s') }}</span>
                            </td>
                        </tr>
                        <tr class="error text-danger" style="border-bottom-width: 0px !important;">
                            <td style="margin: 0px !important; padding: 0px !important;"></td>
                            <td style="margin: 0px !important; padding: 0px !important;" class="m-0" colspan="5"><i class="fas fa-warning"></i> Error: <small class="text-muted"><em>{{$data->message}}</em></small></td>
                        </tr>
                        @endforeach
                        </tbody>
                    @else
                        <tr>
                            <td colspan="7" class="text-center pt-5 align-middle text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                <h5>Nothing failed in the process</h5>
                            </td>
                        </tr>
                    @endif
                </form>      
                </table>
            </div>
        </div>
        {{ $datas->links() }}
    </div>
</div>


{{-- Javascript --}}
@once  
    @pushOnce('js')
        <script type="text/javascript">
        //load data
             $(document).ready(function (e) {
                $('#selectAll').prop('checked', false);
                $('#btnGetSN').prop('disabled', true);
                // $('#btnGetSN').hide();
                $('#selectAll').on('change',(e)=>{
                    let checkAll = $('#selectAll').is(':checked');
                    var numberNotChecked = $('input:checkbox:not(":checked")').length;
                    var chechListChecked = $('input.chechList:checked').length;
                    if(checkAll==true){
                        $('.chechList').prop('checked', true);
                        $('#btnGetSN').show();
                    }else{
                        $('.chechList').prop('checked', false);
                    }
                    
                    if($('.chechList:checked').length >= 1){
                        $('#btnGetSN').prop('disabled', false);
                        $('#btnGetSN').show();
                    }else{
                        $('#btnGetSN').prop('disabled', true);
                    }
                    // console.log(checkAll,numberNotChecked,chechListChecked);
                });


                // checkbox 
                $('.table').on('change','.chechList',(e)=>{
                    var chechListNotChecked = $('input.chechList:not(":checked")').length;
                    var chechListChecked = $('input.chechList:checked').length;
                    // console.info('chechList click');
                    if($('.chechList:checked').length >= 1){
                        $('#btnGetSN').prop('disabled', false);
                        $('#btnGetSN').show();
                    }else{
                        $('#btnGetSN').prop('disabled', true);
                    }
                    if(chechListNotChecked == 0){
                        $('#selectAll').prop('checked', true);
                    }else{
                        $('#selectAll').prop('checked', false);
                    } 
                    // console.log(chechListChecked,chechListNotChecked);
                });

            });    
        </script>
    @endPushOnce
@endonce

