<style>
.modal-body {
    /* 100% = dialog height, 120px = header + footer */
    /* max-height: calc(100% - 20px); */
    /* overflow-y: scroll; */
}
.modal-dialog, .modal-content {
    height: 120% !important;
}
</style>
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
                <h4 class=" card-title">New Documents</h4>
                {{-- {{ ($datas[0]->directory->template ?? '')}} --}}
            </div>
            <div class="col text-end">
                <span class=""> <i class="fas fa-briefcase"></i> {{ $datas[0]->company->name ?? '' }} @if(!empty($datas[0]->directory))  <i class="fas fa-folder-tree"></i>  @endif  {{ $datas[0]->directory->name ?? ''}}</span>
                {{-- {{ URL::previous() }} --}}
                {{-- <a @class(['btn btn-sm btn-danger', 'font-bold' => true]) href="{{ route('directory', $datas[0]->company->id ?? '') }}"> Back</a> --}}
                {{-- <a @class(['btn btn-sm btn-primary', 'font-bold' => true]) href="{{ route('add.file', Request::segment(4)) }}"> Create</a> --}}
            </div>
            <div class="row mb-0">
                <div class="col-8 text-start">
                    @if($datas->count()>0)
                    {{-- @if($datas[0]->directory->template == 1) --}}
                     <button @class(['btn me-5 btn-sm btn-info align-items-right', 'font-bold' => true]) class="btn btn-sm btn-info" id="btnGetSN" onclick="$('#execute').submit();"><i class="fas fa-qrcode"></i> Execute Materai</button>
                    {{-- @endif --}}
                    @endif
                    <a @class(['btn me-5 btn-sm btn-primary', 'font-bold' => true]) href="{{ route('document.create', $directory->id) }}"> Upload</a>
                    <a @class(['btn me-5 btn-sm btn-dark', 'font-bold' => true]) href="{{ route('company') }}"> Back</a>
                </div>
                <div class="col-4 text-end">
                    <a @class(['btn ms-5 btn-sm btn-danger', 'font-bold' => true]) href="#" onclick="alert('Are you sure you want to delete?')" id="delete-new-file"> Delete</a> 
                </div>
            </div>
            {{-- <p class="card-text">Text</p> --}}
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <form action="" method="get">
                <div class="w-auto input-group input-sm mb-0 ">
                    <label class="input-group-text" for="per_page" title="Show Per Page">Show</label>
                    <select title="Show Per Page" name="view" id="per_page" class="select-per-page p-1  form-select form-select-sm">
                        <option @if(request()->input('view')=='ALL') selected @endif value="ALL">ALL</option>
                        <option @if(request()->input('view')==10) selected @endif value="10">10</option>
                        <option @if(request()->input('view')==50) selected @endif value="50">50</option>
                        <option @if(request()->input('view')==100) selected @endif value="100">100</option>
                        <option @if(request()->input('view')==500) selected @endif value="500">500</option>
                    </select>
                    {{-- <select title="Company" required name="company" class="w-auto p-1 form-select form-select-sm" id="company">
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
                    </select> --}}
                    <input title="Date Interval" type="text" class="w-auto p-1 form-control daterange" @if(request()->get('periode')) value="{{ request()->get('periode') }}" @endif  name="periode" id="date-periode" aria-describedby="helpId" placeholder="">  
                    {{-- button --}}
                    <button type="submit" class="  btn btn-sm  btn-primary">Filter</button>
                    @if(request()->has('view'))
                    <a href="{{ route('document',$directory->id) }}" class=" btn btn-sm btn-sm bg-gradient-dark"> Reset</a>
                    @endif
                </form>
            </div> 
            <div class="table-responsive p-0">
                {{-- Show data with template --}}
                    {{-- <form id="execute" action="{{ route('getSerialNumber') }}" method="POST"> --}}
                        {{-- Update status to INPROGRES --}}
                    <form id="execute" action="{{ route('setInProgres') }}" method="POST"> 
                        {{-- <form id="execute" action="{{ route('stampExecute') }}" method="POST">  --}}    
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                @if($directory->count()>0)
                                    @if($directory->template==1)
                                    <td><input type="checkbox" name="all" value="{{$directory->id}}" id="selectAll"></td>
                                    @endif
                                @endif
                                <th class="text-uppercase text-start text-secondary text-xxs font-weight-bolder opacity-7">
                                    No</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Name</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Materai Serial Number</th>
                                {{-- <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Status</th> --}}
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Create</th>
                                <th class="text-secondary text-end m-0 p-0 opacity-7" width="10%">
                                   
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($datas->count()>0)
                            @foreach ($datas  as $key =>  $data)
                            <tr>
                                @if($data->directory->template==1)    
                                <td>
                                    <input type="checkbox" class="chechList" name="doc[]" value="{{$data->id}}" id="">
                                    @if($data->sn == '')
                                    @endif
                                </td>
                                @endif
                                <td class="align-middle text-center">
                                    @if (request()->has('page'))
                                        @if(request()->input('page')>1)
                                            {{ ($datas->perPage() * $datas->currentPage())+($key+1)}}
                                        @else
                                            {{$key+1}}
                                        @endif
                                    @else
                                    {{$key+1}}
                                    @endif
                                </td>
                                <td class="align-middle text-sm">
                                    <h6 class="mb-0">
                                        <a target="_blank" title="Click to show file" class="mb-0" href="{{ asset('storage'.$data->source) }}">{{ $data->filename }}</a>
                                    </h6>
                                </td>
                                <td class="align-middle text-sm">
                                    {{ $data->sn ?? 'NOT_CERTIFIED' }}
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-bold">{{ $data->updated_at->format('d/m/Y H:i:s') }}</span>
                                </td>
                                <td class="align-middle text-end ">
                                    {{-- <a href="{{ route('stemp.show',$data->id) }}" class="btn btn-s btn-primary text-white font-weight-bold text-xs"
                                        data-toggle="tooltip" data-original-title="Edit Company">
                                        Detail 
                                    </a> --}}
                                    @if($data->certificatelevel == 'FAILUR')
                                        {{-- <a href="#edit" class="btn btn-s btn-primary text-white font-weight-bold text-xs view" ><i class="fas fa-pencil"></i> Edit</a> --}}
                                    @endif
                                    @if($data->sn != '')
                                        {{-- <a href="{{ route('process',$data->id)}}" class="btn btn-s btn-primary text-white font-weight-bold text-xs view" ><i class="fas fa-stamp"></i> Stamp Materai</a> --}}
                                    @else
                                        {{-- <button class="btn btn-sm btn-info" id="btnGetSN"><i class="fas fa-qrcode"></i> Get Materai</button> --}}
                                        {{-- <button href="#" disabled class="btn btn-s btn-disable text-white font-weight-bold text-xs view" >Stemp Document</button> --}}
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center pt-5 align-middle text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        <h5>Empty Data</h5>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                    </table>
                        @csrf
                        
                    </form>
    
                {{-- data don have template --}}
            </div>
        </div>
        <hr class="horizontal dark">
        @if(request()->has('view'))
        {{ $datas->appends(request()->input())->links() }}
        @endif

        @env('local')
            {{$directory->template}}
        @endenv
    </div>


<!-- Button trigger modal -->  
  <!-- Modal -->
  <div class="modal fade" id="modalId" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true" style="z-index: 99999; heigth:100%;">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">View Document</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: black;"><i class="fa fa-close"></i></button>
                        {{-- <input type="text" class="form-control" name="lower_left_x" value="" style="width: 100%"/> --}}
                </div>
                <div class="modal-body p-0 m-0" style="overflow-y: visible !important; overflow-x: visible !important;">
                      <object style="overflow-x: visible !important;" width="100%" height="100%" id="obj-pdf" data="https://127.0.0.1/docs/CV. USER DUA/Dir/in/1700592978_Contoh_Format_Surat_Perjanjian_Kontrak_K.pdf" type="application/pdf">
                        <div>No PDF viewer available</div>
                    </object>
                 {{-- <div class="container-fluid"> </div> --}}
              </div>
              <div class="modal-footer mb-0">
                  <button type="button" class="btn btn-secondary mb-0" data-bs-dismiss="modal">Close</button>
                  {{-- <button type="button" class="btn btn-primary">Save</button> --}}
              </div>
          </div>
      </div>
  </div>
</div>
  <script>
      var modalTitleId =  document.getElementById('modalTitleId');
      var modalId = document.getElementById('modalId');
      var objpdf = document.getElementById('obj-pdf'); 
      modalId.addEventListener('show.bs.modal', function (event) {
            // Button that triggered the modal
            let button = event.relatedTarget;
            // Extract info from data-bs-* attributes
            let recipient = button.getAttribute('data-bs-whatever');
            let url = button.getAttribute('data-url');
            let title = button.getAttribute('data-title');
            modalTitleId.innerHTML = title;
            objpdf.setAttribute("data", url); 
            // console.log(url);
          // Use above variables to manipulate the DOM
      });
  </script>


{{-- Javascript --}}
@once  
    @pushOnce('js')
    
        <script type="text/javascript">
        //load data
            $(document).ready(function (e) {
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


            $('#delete-new-file').click((e)=>{
                $('#execute').attr("action","{{route('stamp.deleteNewFile')}}");
                $('#execute').submit();
                 //console.log($('.chechList').val()); 
            });

            



        </script>
    @endPushOnce
@endonce