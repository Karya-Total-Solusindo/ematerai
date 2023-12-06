<style>
    select.form-select-sm{
        height: fit-content;
    }
    .input-group.input-sm>select{
        /* padding-top: 0px;
        top: -3px; */
    }
    .input-group.input-sm>input.form-control.daterange{
        padding-top: 4px !important;
        padding-bottom: 4px !important;
        height: fit-content !important; 
    }
    .input-group.input-sm>label{
        padding-bottom: 4px;
        padding-top: 4px;
    }
    .input-group.input-sm>label>svg{
         padding-bottom: 4px;
        padding-top: 4px;
    }
    .daterangepicker.dropdown-menu{
        border: solid 1.5px #f86343;
    }
    .daterangepicker_input>svg{
        position: absolute;
        top: 8px;
        left: 9px;
    }
    .daterangepicker:after{
        border-bottom: 6px solid #f86343;
    }
    .daterangepicker td.active, .daterangepicker td.active:hover {
        background-color: #f86343;
    }
</style>


<div class="card">
    {{-- <img class="card-img-top" src="https://picsum.photos/200/10/?blur" alt="Card image cap"> --}}
    <div class="card-body">
        <div class="row p-0">
            <div class="col">
                <h4 class="card-title"><i class="ni ni-paper-diploma"></i> Certified Document</h4> 
            </div>
            <div class="col text-end">
                <form action="{{ route('exportSuccecc') }}" method="get">
                    <input type="hidden" name="status" value="CERTIFIED">
                    
                    {{-- <a href="{{ route("stamp.download") }}" id="btn-download" class="btn btn-sm btn-info" ><i class="fas fa-download"></i> DOWNLOAD</a> --}}
                    <a href="#download" id="btn-download" class="btn btn-sm btn-info" onclick="$('#download-success').submit();" ><i class="fas fa-download"></i> DOWNLOAD</a>
                    <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i> Export Excel</button>
                </form>
            </div>
            <div class="col-md-12">
                <form action="" method="get">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group mb-0 input-sm mb-3">
                                <label class="input-group-text" for="company">Company</label>
                                <select required name="company" class="form-select form-select-sm" id="company">
                                  <option value="">Choose Company...</option>
                                  @foreach (App\Models\Company::where('user_id',Auth::user()->id)->get() as $com)
                                        <option @if($company==$com->id) selected @endif value="{{$com->id}}">{{$com->name}}</option>
                                  @endforeach
                                </select>
                                {{-- directory --}}
                                <label class="input-group-text" for="inputGroupSelectDirectory">Directory</label>
                                <select disabled name="directory" class="form-select form-select-sm" id="inputGroupSelectDirectory">
                                  <option value="">Choose Directory...</option>
                                  @if(request()->has('company'))
                                      @foreach (App\Models\Directory::where('company_id','=',request()->input('company') )->get()  as $d)
                                        @if(request()->input('directory') == $d->id)
                                          <option  selected value="{{$d->id}}">{{$d->name}}</option>
                                          @else
                                          <option value="{{$d->id}}">{{$d->name}}</option>
                                          @endif
                                      @endforeach  
                                  @endif
                                </select>
                                {{-- periode --}}
                                <label class="input-group-text" for="date-periode" title="Periode"> <i class="fas fa-calendar"></i></label>
                                  <input type="text" class="form-control daterange" name="periode" id="date-periode" aria-describedby="helpId" placeholder="">
                                  {{-- button --}}
                                  <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                                  <a href="{{ route('success') }}" class="btn btn-sm btn-dark"> Reset</a>
                            </div>
                        </div>
                        {{-- <div class="col-md-3">
                            <div class="input-group mb-0 input-sm mb-3">
                                <label class="input-group-text" for="inputGroupSelectDirectory">Directory</label>
                                <select disabled name="directory" class="form-select form-select-sm" id="inputGroupSelectDirectory">
                                  <option value="">Choose Directory...</option>
                                  @if(request()->has('company'))
                                      @foreach (App\Models\Directory::where('company_id','=',request()->input('company') )->get()  as $d)
                                        @if(request()->input('directory') == $d->id)
                                          <option  selected value="{{$d->id}}">{{$d->name}}</option>
                                          @else
                                          <option value="{{$d->id}}">{{$d->name}}</option>
                                          @endif
                                      @endforeach  
                                  @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-0 input-sm mb-3">
                                <label class="input-group-text" for="date-periode" title="Periode"> <i class="fas fa-calendar"></i></label>
                                  <input type="text" class="form-control daterange" name="periode" id="date-periode" aria-describedby="helpId" placeholder="">
                                
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                            <a href="{{ route('success') }}" class="btn btn-sm btn-dark"> Reset</a>
                        </div>                       --}}
                    </div>
                </form>
            </div>
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
                            <th><input type="checkbox" id="selectAll"></td>
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
                            <th
                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Date</th>
                            <th class="text-secondary opacity-7"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(request()->has('company'))
                        <form id="download-success" method="post" action="{{ route("stamp.download") }}">
                            @csrf
                            
                                @if ($datas->count()) 
                                    @foreach ($datas as $data)
                                    <tr>
                                        <td><input type="checkbox" class="chechList" name="doc[]" value="{{$data->id}}" id=""></td>
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
                                            <a target="_blank" href=" {{ asset('storage/docs/'.$data->company->name.'/'.$data->directory->name.'/out/'.$data->filename) }}" class="text-primary font-weight-bold text-xs"
                                                data-toggle="tooltip" data-original-title="Edit Download">
                                                <span class="badge badge-sm bg-gradient-success"><i class="fas fa-eye"></i> View</span>
                                            </a>
                                        
                                            {{-- <a href="{{ route('stemp.show',$data->id) }}" class="text-primary font-weight-bold text-xs"
                                                data-toggle="tooltip" data-original-title="Edit Download">
                                                <span class="badge badge-sm bg-gradient-info"> Detail</span>
                                            </a> --}}
                                        </td>
                                    </tr>
                                    @endforeach
                                    
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center pt-5 align-middle text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            <h5>Certified data is still empty</h5>
                                        </td>
                                    </tr>
                                @endif
                    @else
                    <tr>
                        <td colspan="7" class="text-center pt-5 align-middle text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            <h5>Certified data is still empty</h5>
                        </td>
                    </tr>
                    
                        </form>
                    @endif
                    </tbody>   
                </table>
            </div>
        </div>
        @if(request()->has('company'))
        {{ $datas->links() }}
        @endif
    </div>
</div>

<script id="js-success">
    $(document).ready(function(){
        //daterangepicker
        var firstDayOfMonth = function() {
            return 1;
        };
        var d = new Date();
        var currMonth = d.getMonth();
        var currYear = d.getFullYear();
        var startDate = new Date(currYear,currMonth,firstDayOfMonth());
        $('.daterange').daterangepicker({
            "alwaysShowCalendars": true,
            "startDate": startDate,
            "autoApply": true,
            "opens": "left",
            locale: {
                format: 'DD/MM/YYYY'
            },
        });
        //end daterange

        //DOWNLOAD ACTION
        $('#btn-download').click((e)=>{
            var c = $('#company').find(":selected").val();
            var d = $('#inputGroupSelectDirectory').find(":selected").val();
            var p = $('#periode').val();
            var f = $('#download-success');
            var formData = new FormData(f);
            console.log(formData);
            // window.location.replace('{{ route("stamp.download") }}?company='+c+'&directory='+d+'&periode='+p);
            // $.get('{{ route("stamp.download") }}?company='+c+'&directory='+d, function( data ) {

            // });
            //toastr["info"]("error", "Toastr Test");
        });
        @if(request()->has('directory'))
            $('#inputGroupSelectDirectory').prop("disabled", false); 
        @endif
        //get directory of company 
        $('#company').on('change',(e)=>{
            let id = $(this).find(":selected").val();
            const url = '{{URL::to("/document/directory/")}}/';
            e.preventDefault();
            console.log(id); 
            if(id!=''){
                // $('#inputGroupSelectDirectory').prop("disabled", true); 
                $.get(url+id, function( data ) {
                    //$('#inputGroupSelectDirectory').attr('disabled');
                    $('#inputGroupSelectDirectory').html('');  
                }).done(function(data) {           
                    //alert( "second success" );
                })
                .fail(function(data) {
                    $('#inputGroupSelectDirectory').prop("disabled", true);
                    //alert( "error" );
                })
                .always(function(data) {
                    $('#inputGroupSelectDirectory').append(data);  
                    $('#inputGroupSelectDirectory').prop("disabled", false);
                    //alert( "finished" );
                });
            }
            
        });     

    });


    

</script>

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