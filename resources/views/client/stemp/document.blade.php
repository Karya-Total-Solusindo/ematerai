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
                    <a @class(['btn ms-5 btn-sm btn-dark', 'font-bold' => true]) href="{{ route('company') }}"> Back</a>
                </div>
                <div class="col-4 text-end">
                    <a @class(['btn ms-5 btn-sm btn-danger', 'font-bold' => true]) href="#" onclick="alert('on dev')"> Delete</a> 
                </div>
            </div>
            {{-- <p class="card-text">Text</p> --}}
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                {{-- Show data with template --}}
                
                {{-- <form id="execute" action="{{ route('getSerialNumber') }}" method="POST"> --}}
                    <form id="execute" action="{{ route('stampExecute') }}" method="POST">test 
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                @if($directory->count()>0)
                                    @if($directory->template==1)
                                        <td><input type="checkbox" id="selectAll"></td>
                                    @endif
                                @endif
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
                            @foreach ($datas as $data)
                            <tr>
                                @if($data->directory->template==1)    
                                <td>
                                    @if($data->sn == '')
                                        <input type="checkbox" class="chechList" name="doc[]" value="{{$data->id}}" id="">
                                    @endif
                                </td>
                                @endif
                                <td>
                                    <div class="align-middle text-sm">
                                        <div class="">
                                            <h6 class="p-0"><a href="{{ route('stemp.show',$data->id) }}">{{ $data->filename }}</a></h6>
                                        </div>
                                    </div>
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
                                    @if($data->sn != '')
                                        {{-- <a href="{{ route('process',$data->id)}}" class="btn btn-s btn-primary text-white font-weight-bold text-xs view" ><i class="fas fa-stamp"></i> Stamp Materai</a> --}}
                                    @else
                                        {{-- <button class="btn btn-sm btn-info" id="btnGetSN"><i class="fas fa-qrcode"></i> Get Materai</button> --}}
                                        {{-- <button href="#" disabled class="btn btn-s btn-disable text-white font-weight-bold text-xs view" >Stemp Document</button> --}}
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                    </table>
                        @csrf
                        
                    </form>
    
                {{-- data don have template --}}
            </div>
        </div>
        <hr class="horizontal dark">
        {{ $datas->links() }}

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