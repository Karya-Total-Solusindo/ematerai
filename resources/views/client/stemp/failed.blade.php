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
        height: fit-content;
        padding-bottom: 4px;
        padding-top: 4px;
    }
    .input-group.input-sm>label>svg{
        /* height: fit-content; */
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
    .select-per-page:hover{
        idth: inherit !important;
    }
</style>


<div class="card">
    {{-- <img class="card-img-top" src="https://picsum.photos/200/10/?blur" alt="Card image cap"> --}}
    <div class="card-body">
        <div class="row p-0">
            <div class="col">
                <h4 class="card-title"><i class="ni ni-paper-diploma"></i>  Processing Failed</h4> 
            </div>
            <div class="col text-end">
                    <form action="{{ route('exportSuccecc') }}" method="get">
                        <a @class(['disabled btn btn-sm btn-info align-items-right', 'font-bold' => true])  class="disabled btn btn-sm btn-info" id="btnGetSN" onclick="$('#execute').submit();"><i class="fas fa-qrcode"></i> Execute Materai</a>
                        <input type="hidden" name="status" value="FAILUR">
                        <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i> Export Excel</button>
                    </form>
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
        <form action="" method="get">
            <div class="w-auto input-group input-sm mb-0 ">
                <label class="input-group-text" for="per_page" title="Show Per Page">Show</label>
                <select title="Show Per Page" name="view" id="per_page" class="select-per-page p-1  form-select form-select-sm">
                    <option @if(request()->input('view')==10) selected @endif value="10">10</option>
                    <option @if(request()->input('view')==50) selected @endif value="50">50</option>
                    <option @if(request()->input('view')==100) selected @endif value="100">100</option>
                    <option @if(request()->input('view')==500) selected @endif value="500">500</option>
                    <option @if(request()->input('view')=='ALL') selected @endif value="ALL">ALL</option>
                </select>
                <select title="Company" required name="company" class="w-auto p-1 form-select form-select-sm" id="company">
                    <option value="">Choose Company...</option>
                    @foreach (App\Models\Company::where('user_id',Auth::user()->id)->get() as $com)
                        <option @if($company==$com->id) selected @endif value="{{$com->id}}">{{$com->name}}</option>
                    @endforeach
                </select>
                <select title="Directory" required disabled name="directory" class="w-auto px-3 py-1 form-select form-select-sm " id="inputGroupSelectDirectory">
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
                <input title="Date Interval" type="text" class="w-auto p-1 form-control daterange" @if(request()->get('periode')) value="{{ request()->get('periode') }}" @endif  name="periode" id="date-periode" aria-describedby="helpId" placeholder="">  
                {{-- button --}}
                <button type="submit" class="  btn btn-sm  btn-primary">Filter</button>
                @if(request()->has('company'))
                <a href="{{ route('failed') }}" class=" btn btn-sm btn-sm bg-gradient-dark"> Reset</a>
                @endif
            </form>
        </div> 
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                    <form id="execute" action="{{ route('setInProgres') }}" method="POST"> 
                        @csrf
                        <input type="hidden" name="status" value="FAILUR">
                    </form>    
                    <thead>
                        <tr>
                            <th class="align-middle text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                <input form="execute" type="checkbox" name="all" value="{{request()->input('company')}}" id="selectAll">
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
                    @if(request()->has('company'))    
                        @if ($datas->count()) 
                            @foreach ($datas as $num => $data)
                            <tr>
                                <td rowspan="1" class="align-middle text-center" style="border-bottom-width: 0px !important;">
                                    <input form="execute" type="checkbox" class="chechList" name="doc[]" value="{{$data->id}}" id="">
                                </td>
                                <td rowspan="1" class="align-middle text-center" style="border-bottom-width: 0px !important;">
                                    @if (request()->has('page'))
                                        @if(request()->input('page')>1)
                                            {{ ($datas->perPage() * $datas->currentPage())+($num+1)}}
                                        @else
                                            {{$num+1}}
                                        @endif
                                    @else
                                        {{$num+1}}
                                    @endif
                                </td>
                                <td class="align-middle text-sm text-left" style="border-bottom-width: 0px !important;">
                                    <h6 class="mb-0 text-sm"><a href="{{ asset('storage'.$data->source) }}" title="click show detail">{{ $data->filename }}</a></h6>
                                </td>
                                <td class="align-middle text-sm text-left" style="border-bottom-width: 0px !important;">
                                {{ $data->company->name }}
                                </td>
                                <td class="align-middle text-sm text-left" style="border-bottom-width: 0px !important;">
                                    {{ $data->directory->name }}
                                </td>
                                <td class="align-middle text-center" style="border-bottom-width: 0px !important;">
                                    @if(Storage::disk('public')->exists($data->source))
                                    <span class="badge badge-sm  bg-gradient-warning">{{ $data->certificatelevel ?? '_' }}</span>
                                    @else
                                    <a href="#" class="badge badge-sm  bg-gradient-warning">FILE NOT FOUND</a>
                                    @endif
                                    {{-- {{ App\Models\Document::where('directory_id',$data->id)->count() ?? 0 }} --}}
                                </td>
                                <td class="align-middle text-center" style="border-bottom-width: 0px !important;">
                                    <span class="text-secondary text-xs font-weight-bold">{{ $data->updated_at->format('d/m/Y - H:i:s') }}</span>
                                </td>
                            </tr>
                            <tr class="error text-danger" style="border-bottom-width: 0px !important;">
                                <td style="margin: 0px !important; padding: 0px !important;"></td>
                                <td style="margin: 0px !important; padding: 0px !important;"></td>
                                <td style="margin: 0px !important; padding: 0px !important;" class="m-0" colspan="6">
                                    @if(!Storage::disk('public')->exists($data->source))
                                        <form id="fromUpload_{{$data->id??rand()}}" action="{{ route('updatefile',$data->id) }}" class="formUpload" enctype="multipart/form-data" form-data="{{$data->id??rand()}}">@csrf</form>
                                        <div class="input-group input-sm mb-0" form-input="{{$data->id}}">
                                            <input form="fromUpload_{{$data->id??rand()}}" class="form-control" type="file" name="file" style="height: fit-content;">
                                            <input form="fromUpload_{{$data->id??rand()}}" type="hidden" name="id" value="{{$data->id}}">
                                            <button form="fromUpload_{{$data->id??rand()}}" type="submit" class="btn btn-primary uploadSubmit" style="height: fit-content;"> <i class="fas fa-upload"></i> Reupload </button>
                                        </div>
                                    @endif
                                    <i class="fas fa-warning"></i> Error: <small class="text-muted"><em>{{$data->message}}</em></small>
                                </td>
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
                    @else
                        <tr>
                            <td colspan="7" class="text-center pt-5 align-middle text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                <h5>Nothing failed in the process</h5>
                            </td>
                        </tr>
                    @endif       
                </table>
            
            </div>
        </div>
        @if(request()->has('company'))
        {{ $datas->appends(request()->input())->links() }}
        @endif
    </div>
</div>



<script id="js-failed">
    $(document).ready(function(){
        //daterangepicker
        var firstDayOfMonth = function() {
            return 1;
        };
        var d = new Date();
        var currMonth = d.getMonth();
        var currYear = d.getFullYear();
        @if(request()->has('periode'))
            var startDate = "{{explode('-',request()->input('periode'))[0] ?? 'new Date(currYear,currMonth,firstDayOfMonth()'}}";
            var endDate = "{{explode('-',request()->input('periode'))[1] ?? 'new Date()'}}";
        @else
            var startDate = new Date(currYear,currMonth,firstDayOfMonth());
            var endDate = new Date();
        @endif
        $('.daterange').daterangepicker({
            "alwaysShowCalendars": true,
            "startDate": startDate,
            "endDate": endDate,
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
            let id = $('#company').find(":selected").val();
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
                 $('#btnGetSN').addClass('disabled');
                 $('#btnGetSN').hide();
                var dir = $('#inputGroupSelectDirectory').find(":selected").val();
                // $('#btnGetSN').hide();
                $('#selectAll').on('change',(e)=>{
                    let checkAll = $('#selectAll').is(':checked');
                    var numberNotChecked = $('input:checkbox:not(":checked")').length;
                    var chechListChecked = $('input.chechList:checked').length;
                    if(checkAll==true){
                        $('.chechList').prop('checked', true);
                        $('#btnGetSN').show();
                         $('#btnGetSN').removeClass('disabled');
                         $('#btnGetSN').show();
                        $('#selectAll').val(dir);
                    }else{
                        $('.chechList').prop('checked', false);
                         $('#btnGetSN').addClass('disabled');
                         $('#btnGetSN').hide();
                        $('#selectAll').val(null);
                    }
                    
                    if($('.chechList:checked').length >= 1){
                        // $('#btnGetSN').prop('disabled', false);
                         $('#btnGetSN').removeClass('disabled');
                         $('#btnGetSN').show();
                        $('#btnGetSN').show();
                    }else{
                         $('#btnGetSN').addClass('disabled');
                         $('#btnGetSN').hide();
                        //  $('#btnGetSN').prop('disabled', true);
                    }
                    // console.log(dir,checkAll,$('#selectAll').val(),numberNotChecked,chechListChecked);
                });


                // checkbox 
                $('.table').on('change','.chechList',(e)=>{
                    let checkAll = $('#selectAll').is(':checked');
                    var chechListNotChecked = $('input.chechList:not(":checked")').length;
                    var chechListChecked = $('input.chechList:checked').length;
                    // console.info('chechList click');
                    if($('.chechList:checked').length >= 1){
                        $('#btnGetSN').removeClass('disabled');
                        $('#btnGetSN').show();
                    }else{
                        $('#btnGetSN').addClass('disabled');
                        $('#btnGetSN').hide();
                    }
                    if(chechListNotChecked == 0){
                        $('#selectAll').prop('checked', true);
                        $('#selectAll').val(dir);
                    }else{
                        $('#selectAll').prop('checked', false);
                        $('#selectAll').val(null);
                    } 
                    // console.log(dir,checkAll,$('#selectAll').val(),chechListChecked,chechListNotChecked);
                });
            });
            // $('.uploadSubmit').click((e)=>{
            //     e.preventDefault();
            // });
            // $('.formUpload').submit((e)=>{
            //     e.preventDefault();
            // });
            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': {{csrf_token()}}// $('meta[name="csrf-token"]').attr('content')
            //     }
            // });
            // form upload
            $('.formUpload').submit((e)=>{
                e.preventDefault();
                let id = $(this).attr('form-data');
                console.log(e,e.target);
                var files = e.target[1].files; // for multiple files
                var fd = new FormData();
                var other_data = e.target.elements;
                console.log(other_data);
                $.each(other_data,function(key,input){
                    console.log(input);
                    fd.append(input.name,input.value);
                });
                fd.append('file',e.target[1].files[0]);
                console.log(fd);
               if(files.length > 0){
                
                $.ajax({
                          url: e.target.action,
                          method: 'POST',
                          data: fd,
                          contentType: false,
                          processData: false,
                          dataType: 'json',
                          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                          success: function(response){
                                // Hide error container
                                $('#err_file').removeClass('d-block');
                                $('#err_file').addClass('d-none');
                                if(response.success == true){ // Uploaded successfully
                                    toastr["success"](response.message, 'Uploaded successfully');
                                    $(e.target.elements).hide();
                                      // Response message
                                      $('#responseMsg').removeClass("alert-danger");
                                      $('#responseMsg').addClass("alert-success");
                                      $('#responseMsg').html(response.message);
                                      $('#responseMsg').show();
                                      // File preview
                                      $('#filepreview').show();
                                      $('#filepreview img,#filepreview a').hide();
                                      if(response.extension == 'jpg' || response.extension == 'jpeg' || response.extension == 'png'){
                                            $('#filepreview img').attr('src',response.filepath);
                                            $('#filepreview img').show();
                                      }else{
                                            $('#filepreview a').attr('href',response.filepath).show();
                                            $('#filepreview a').show();
                                      }
                                }else if(response.success == false){ // File not uploaded
                                     toastr["error"](response.message, 'File not uploaded');
                                      // Response message
                                      $('#responseMsg').removeClass("alert-success");
                                      $('#responseMsg').addClass("alert-danger");
                                      $('#responseMsg').html(response.message);
                                      $('#responseMsg').show();
                                }else{
                                    // Display Error
                                    toastr["error"]("error upload", "error")
                                      e.target.elements.hide();
                                      $('#err_file').text(response.error);
                                } 
                          },
                          error: function(response){
                                console.log("error : " + JSON.stringify(response) );
                          }
                     });
               }else{
                     alert("Please select a file.");
               }
            });

        </script>
    @endPushOnce
@endonce

