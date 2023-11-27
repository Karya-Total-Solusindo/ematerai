
{{-- FORM UPLOAD  --}}
<div class="card">
    <div class="card-body">
        <h4><i class="fas fa-file-upload"></i> Upload PDF </h4>
    </div>
</div>    
    <div class="card-body">
    <div class="col-md-12">
        {{-- RESULT --}}
        <div class="card">
            <form action="/genereted/bulk/sn" method="post">
            <div class="card-body mb-0">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title"><i class="fas fa-laptop-file"></i> File </h4>
                        {{-- <h4 class="card-title">  <i class="fas fa-server"></i> Upload </h4> --}}
                    </div>
                    <div class="col-md-6 text-end">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-sm btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#modalId">Now File</button>
                    </div>
                </div>
                <div id="results"></div>
                <div class="table-responsive p-0">
                    <table class="table mb-0" id="table-result">
                        <thead>
                            <tr>
                                <th width="5px" class="m-0 ps-0 pe-0"> 
                                    <input type='checkbox' name='all' id='selectAll' autocomplete="off"> All</th>
                                <th width="">Title</th>
                                <th width="">Number</th>
                                <th>Amount</th>
                                <th>#</th>
                            </tr>
                        </thead>
                            <tbody id="body-result">
                            </tbody>
                      
                    </table>
                </div>
            </div>
            <div class="card-footer text-muted mb-0">
                <div class="row">
                    <div class="col-md-6 mb-0" id="footer-left"></div>
                    <div class="col-md-6 mb-0 text-end" id="footer-rigth">
                        <button class="btn btn-sm btn-info" id="btnGetSN"><i class="fas fa-qrcode"></i> Generated Serial Number</button>
                        {{-- <button class="btn btn-sm btn-danger" id="fileRemove"><i class="fas fa-trash"></i>  Remove</button> --}}
                    </div>
                </div>
            </div>
        </form>
        </div>
    </div>

    <div class="col-md-12"></div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalId" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true" style="z-index: 99999;">
    <div class="modal-dialog modal-sm modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId"><i class="fas fa-file-upload"></i> Multiple Upload PDF </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-upload" enctype="multipart/form-data" class="m-0">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                    <div class="col-md-6 mb-0">
                                        <label for="companyId" class="form-label"><i class="fa-solid fa-building"></i> Company</label>
                                        <select required class="form-select form-select-sm" name="company" id="companyId">
                                            <option selected value="">Select one</option>
                                            @foreach ($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                            @endforeach
                                        </select>
                                        <span></span>
                                    </div>
                                    <div class="col-md-6 mb-0">
                                        <label for="directoryId" class="form-label"><i class="fa-solid fa-folder-open"></i> Directory</label>
                                        <select required class="form-select form-select-sm" name="directory" id="directoryId">
                                            <option selected value="">Select one</option>
                                        </select>
                                        <span class="valid"></span>
                                    </div>
                            </div>
                        </div>
                        {{-- Document Informasi--}}
                        <div class="col-md-4 mb-3">
                            <label for="titleId" class="form-label m-0" ><i class="fa-solid fa-note-sticky"></i> Title</label>
                            <input required type="text" class="form-control form-control-sm" name="title" id="titleId" aria-describedby="helpId" placeholder="">
                            <span class="valid"></span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="number" class="form-label m-0"><i class="fa-solid fa-tag"></i> Number</label>
                            <input required type="text" class="form-control form-control-sm" name="number" id="numberId" aria-describedby="helpId" placeholder="">
                            <span class="valid"></span>
                            <small id="helptId-number" class="form-text text-muted"></small>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="amountId" class="form-label m-0"><i class="fa-solid fa-money-bill"></i> Amount</label>
                            <input required type="text" class="form-control form-control-sm" name="amount" id="amountId" aria-describedby="helpId" placeholder="">
                            <span class="valid"></span>
                            <small id="helpId-amount" class="form-text text-muted"></small>
                        </div>
                        {{-- <input type="file" name="pdf" id="pdfid" class="form-control form-control-sm" accept="application/pdf"> --}}
                        <div class="col-md-12 mb-3">
                            <label for="pdfId" class="form-label m-0"><i class="fas fa-file-pdf"></i> PDF</label>
                            <input required type="file" class="form-control form-control-sm col-md-12" name="pdf" id="pdfId" accept="application/pdf" aria-describedby="helpId" placeholder="">
                            <span class="valid"></span>
                            <small id="helpId-pdf" class="form-text text-muted"></small>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <div class="col-md-6"></div>
                                <div class="col-md-6 text-end">
                                    {{-- <span class="btn btn-sm btn-info btn_file_upload" id="btn_file_upload"><i class="fas fa-upload"></i>  Upload</span> --}}
                                    {{-- <span class="btn btn-sm btn-danger" id="fileRemove"><i class="fas fa-trash"></i>  Remove</span> --}}
                                </div>
                            </div>
                                  
                        </div>
                    </div>
                            
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-info btn_file_upload" id="btn_file_upload"><i class="fas fa-upload"></i>  Upload</button>
                    <button type="reset" class="btn btn-sm btn-danger btn_file_reset" id="btn_file_reset"><i class="fas fa-upload"></i>  Reset</button>
                </div>
            </form>
        </div>
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
                $('#btnGetSN').hide();
                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                $("#companyId").change(function(){
                    let val = $(this).val();
                    var APP_URL = {!! json_encode(url('/document/directory/')) !!}
                    $("#directoryId").load(APP_URL+'/'+val);
                 });

                @if(env('APP_DEBUG')=='true')
                    $('#titleId').val('title');
                    $('#numberId').val('1234567890');
                    $('#amountId').val('5.000.000');
                @endif
                console.log('Upload reaload success!');
                let form_upload = $('#form-upload');
                let form_sn = $('#form-sn').serializeArray();
                // var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
                var files = $('#pdfId')[0].files;
                    // $('.btn_file_upload').click((e)=>{ });   
                    $('#form-upload').submit(function(e) {
                        e.preventDefault();
                        var formData = new FormData(this);
                        $.ajax({
                            url:"{{ route('document.store') }}", 
                            type: "POST",
                            data: formData,
                            contentType: false,
                            cache : false,
                            processData: false,
                            beforeSend : function()
                            {
                               //$("#preview").fadeOut();
                               //$("results").fadeOut();
                               $("#results").fadeIn();
                            },
                            success: function(result){
                                // console.log(result);
                                $("#results").html(result).fadeIn();
                                $('#modalId').modal('toggle');
                                toastr["success"](result.message, "Success");
                                $("#body-result").append(result.result);
                                $('#titleId').val('');
                                $('#numberId').val('');
                                $('#amountId').val('');
                                $('#pdfId').val('');
                                let rowCount = $('#body-result tr').length;
                                // console.log(rowCount);
                                if(rowCount >= 1){
                                    $('#btnGetSN').show();
                                }
                                $('#selectAll').prop('checked', true);
                                $('.chechList').prop('checked', true);
                            },
                            error: function(result)
                            {   
                                toastr["error"](result.responseJSON.message , "Failed to upload PDF file!");
                            },
                            complete: function(){
                               
                            }
                        
                        });
                        
                    });  

                // checkbox 
                $('#body-result').on('change','.chechList',(e)=>{
                    console.info('chechList click');
                    if($('.chechList:checked').length >= 1){
                        $('#btnGetSN').prop('disabled', false);
                    }else{
                        $('#btnGetSN').prop('disabled', true);
                    }
                });
    
                $('#selectAll').on('change',(e)=>{
                    let checkAll = $('#selectAll').is(':checked');
                    var numberNotChecked = $('input:checkbox:not(":checked")').length;
                    // console.log(checkAll);
                    if(checkAll==true){
                        $('.chechList').prop('checked', true);
                    }else{
                        $('.chechList').prop('checked', false);
                    }
                    
                    if($('.chechList:checked').length >= 1){
                        $('#btnGetSN').prop('disabled', false);
                    }else{
                        $('#btnGetSN').prop('disabled', true);
                    }
                });
                
                
                
                  
        });    
        </script>
    @endPushOnce
@endonce
