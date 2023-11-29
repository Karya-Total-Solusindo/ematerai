<html>
 <head> 
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="{{ asset('./assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('./assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  {{-- <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script> --}}


  <link href="{{ asset('assets/css/nucleo-svg.css" rel="stylesheet') }}" />
  <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.css') }}" rel="stylesheet" />
  <link id="pagestyle" href="{{ asset('assets/css/validity.css') }}" rel="stylesheet" />
  <link id="pagestyle" href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" />
  <link id="pagestyle" href="{{ asset('assets/css/sidebar-nav.css') }}" rel="stylesheet" />
  <!-- CSS Files -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/imgareaselect/0.9.10/css/imgareaselect-animated.css" integrity="sha512-VOWGVItJ5anAaHwRzNFPo8YGbAGDl34AkUq0/Dkn4UJxK0ag95IZQWoitH6xM7Bq6C3i2VW5oFzkL1+wYkLdmQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

  <style>
  body{
      overflow-x: visible !important;
  }  
  .sf-js-enabled{
      overflow-x: hidden !important;
  }  
  .form-control,.input-sm {
      height: 30px !important;
      padding: 5px 10px !important;
      font-size: 12px !important;
      line-height: 1.5 !important;
      border-radius: 3px;
  }      
  #upload-button {
    margin: 20px auto;
  }

  #file-to-upload {
    display: none;
  }

  #pdf-main-container {
    /* width: 100%; */
    /* margin: 50px 50px; */
  }

  #pdf-loader {
    display: none;
    text-align: center;
    color: #999999;
    font-size: 13px;
    line-height: 100px;
    height: 100px;
  }

  #pdf-contents {
    display: none;
  }

  #pdf-meta {
    background: rgb(195 190 189 / 46%);
      overflow: hidden;
      padding: 10px;
      border-radius: 10px 10px 0px 0px;
      padding: 5px;
  }

  #pdf-buttons {
    float: left;
  }

  a.btn-sm{
    font-size: medium !important;
  }

  #page-count-container {
    /* float: right;
    font-size: 15pt; */
  }
  @media (max-width:768px){
    #page-count-container {
      float: right;
      font-size: 12pt;
    }
  }

  #pdf-current-page {
    display: inline;
  }

  #pdf-total-pages {
    display: inline;
  }

  #pdf-canvas {
    width: 100%;
    border: 2px solid rgba(0,0,0,0.2);
    box-sizing: border-box;
  }

  #page-loader {
    height: 100px;
    line-height: 100px;
    text-align: center;
    display: none;
    color: #999999;
    font-size: 13px;
  }
  fixed-top{
      position: fixed;
      z-index: 999;
      background: #fff;
      top:0px;
  }
  fixed-bottom{
      position: fixed;
      z-index: 999;
      bottom: 0px;
  }
  #response{
      position: fixed;
      z-index: 9999;
      margin: auto;
      background-color: #00000070;
      height: 100%;
      width: 100%;
      text-align: center;
      color: #fff;
      padding-top: 20%;
  }
  .bg-primary {
    background-color: #fb6340 !important;
}
  </style>

  {{-- <script src="{{ asset('assets/js/plugins/sidebar-nav.js') }}" crossorigin="anonymous"></script> --}}
  {{-- <script src="{{ asset("assets/js/plugins/pdf/pdf.js") }}" type="module"></script> --}}
 </head>
  <body>




<div id="response" class="text-center"> 
    <center>
      <div class="start-25 end-25">
        <div class="progress w-50">
          <div id="progress_bar" class="progress-bar progress-bar-striped bg-primary progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
        </div>
      </div>
      <div id="text-response"></div>
    </center>
</div>

<div class="stamp-area">  
<div class=" min-height-300 bg-primary position-absolute h-10 w-100">
    <div class="card fixed-top-s m-2 mb-0 bg-white" >
      <div class="card-head">
        <div class="row ms-5 me-5 mb-0">
        <hr class="horizontal dark">
        <div class="col-8 mb-0">
          <h6 class="mb-1">Stamp Position <br>{{$datas->company->name}} / {{$datas->directory->name}}</h6>
        </div>
        <div class="col-4 text-end">
          <a href={{ URL::previous() }} class="btn btn-dark mb-0 me-2">Cancel</a>
          <span id="doStemp" type="submite" class="btn btn-primary mb-0 me-2"><i class="fas fa-stamp"></i> S T A M P</span>
        </div>
        
      </div>
    </div>
    </div> 
</div>

{{-- kordinat tapilan awal --}}
<input type="text" placeholder="Lower Left X" class="form-control input-sm" name="x1" value="" hidden />
<input type="text" placeholder="Lower Left Y" class="form-control input-sm" name="y1" value="" hidden/>
<input type="text" placeholder="Upper Right X" class="form-control input-sm" name="x2" value="" hidden/>
<input type="text" placeholder="Upper Right Y" class="form-control input-sm" name="y2" value="" hidden/>


  @if($datas->sn != null)
      {{-- <form action="{{route('stemp.store')}}" class="m-0 p-0" method="POST" enctype="multipart/form-data" > --}}
      <form id="submit_form" action="#" class="pt-8 ms-10 me-10">
          @csrf
          <div id="docnumberDiv" class="mb-3" style="display: none;">
              <label for="docnumber" class="form-label">Document Number :</label>
              <input type="text" required class="form-control" name="docnumber" value="{{$datas->docnumber}}" id="docnumber" aria-describedby="helpId" placeholder="">
              <small id="helpdocnumber" class="form-text text-muted"></small>
          </div>
          <input type="hidden" name="sign"  value="{{ config('sign-adapter.API_STEMPTING') }}">
          <input type="file" name="file" id="file-to-upload"  accept="application/pdf"/>

          <input type="hidden" name="id" value="{{$datas->id}}" required/>
          <input type="hidden" name="source" value="{{ $datas->source }}" required/>
          <input type="hidden" name="company" value="{{$datas->company->id}}" required/>
          <input type="hidden" name="directory_name" value="{{$datas->directory->name}}" required/>
          <input type="hidden" name="directory" value="{{$datas->id}}" required/>
          {{-- Kordinat yang digunakan --}}
          <input type="hidden" name="lower_left_x" value="" required/>
          <input type="hidden" name="lower_left_y" value="" required />
          <input type="hidden" name="upper_right_x" value="" required />
          <input type="hidden" name="upper_right_y" value="" required />
          <input type="hidden" name="dokumen_height" value="" required="required" />
          <input type="hidden" name="dokumen_width" value="" required="required" />
          <input type="hidden" name="dokumen_page" id="dokumen_page" required>
          <input type="hidden" name="digital_signature_path" id="digital_signature_path" width: 100px; height: 100px; value="{{ asset('storage'.$datas->spesimenPath) }}">
          <input type="hidden" name="is_visible_sign" id="is_visible_sign" value="True">
          <div class="card">
            <div class="card-body">
              <div id="pdf-main-container">
                  <div id="pdf-loader">Loading document ...</div>
                      <div id="pdf-contents">
                          <div id="pdf-meta" class="p-0 mb-0"></div>
                              <div class="row mb-0">
                                @if(env('APP_DEBUG')!=false)
                                  <div class="input-group">
                                    <title id="txt_lower_left_x" class="input-group-text pe-0 input-sm" style="padding-right: 0px !important;">Lower Left X : </title>
                                    <title id="txt_lower_left_y" class="input-group-text pe-0 input-sm" style="top:0px; padding-right: 0px !important;">Lower Left Y :</title>
                                    <title id="txt_upper_right_x" class="input-group-text pe-0 input-sm" style="top:0px; padding-right: 0px !important;">Upper Right X :</title>
                                    <title id="txt_upper_right_y" class="input-group-text pe-0 input-sm" style="top:0px; padding-right: 0px !important;">Upper Right Y :</title>
                                  </div>
                                @endif
                                <div class="text-center">
                                  {{$datas->filename}}
                                </div>
                                <hr class="horizontal dark">
                                  <div id="pdf-buttonss" class="btn-group btn-group-sm mb-0" role="group" aria-label="Page Control">
                                      <a id="pdf-first" class="btn btn-secondary btn-sm">First</a>
                                      <a id="pdf-prev" class="btn btn-secondary btn-sm"><i class="fa fa-step-backward" aria-hidden="true"></i> Prev</a>
                                      <div id="page-count-container" class="btn disabled" >Page <div id="pdf-current-page" class="p-0 mb-0"></div> of <div id="pdf-total-pages"></div></div>
                                      <a id="pdf-next" class="btn btn-secondary btn-sm">Next <i class="fa fa-step-forward" aria-hidden="true"></i></a>
                                      <a id="pdf-last" class="btn btn-secondary btn-sm">Last</a>
                                  </div>
                              </div>
                              {{-- <canvas id="pdf-canvas" width="1000"></canvas> --}}
                              <canvas id="pdf-canvas"  width="2000"></canvas>
                              <div id="page-loader">Loading page ...</div>
                              <div class="row mb-0" style="display: none;">
                              <div id="pdf-buttonss" class="btn-group btn-group-sm mb-0" role="group" aria-label="Page Control">
                                <a id="pdf-first-b" class="btn btn-secondary btn-sm">First</a>
                                <a id="pdf-prev-b" class="btn btn-secondary btn-sm"><i class="fa fa-step-backward" aria-hidden="true"></i> Prev</a>
                                <div id="page-count-container" class="btn disabled" >Page <div id="pdf-current-page" class="p-0 mb-0"></div> of <div id="pdf-total-pages"></div></div>
                                {{-- <div id="page-count-container">Page <div id="pdf-current-page"></div> of <div id="pdf-total-pages"></div></div> --}}
                                <a id="pdf-next-b" class="btn btn-secondary btn-sm">Next <i class="fa fa-step-forward" aria-hidden="true"></i></a>
                                <a id="pdf-last-b" class="btn btn-secondary btn-sm">Last</a>
                              </div>
                      </div>
                      <div class="row p-0 mb-0 fixed-bottom" >
                          {{-- <button type="submite" class="btn btn-primary btn-sm mb-0">Stemp</button> --}}
                          {{-- <span id="doStemp" type="submite" class="btn btn-primary btn-sm mb-0">S T E M P</span> --}}
                      </div>
                  </div>
              </div>
            </div>
          </div>
      </form>
  @endif
</div>    
<!-- jQuery 3 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="{{ asset('assets/js/plugins/fontawesome_42d5adcbca.js') }}" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/plugins/sidebar-nav.js') }}" crossorigin="anonymous"></script>
    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset("assets/js/plugins/perfect-scrollbar.min.js") }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>


{{-- <script src="https://e-form.peruri.co.id/pdfviewer/bower_components/jquery/dist/jquery.min.js"></script> --}}
{{-- <script src="https://e-form.peruri.co.id/pdfviewer/dist/js/new/pdf.js"></script> --}}
<script src="{{ asset("assets/js/plugins/pdf/pdf.19.js") }}"></script>
<script src="{{ asset("assets/js/plugins/pdf/pdf.worker.19.js") }}"></script>
{{-- <script src="https://e-form.peruri.co.id/pdfviewer/dist/js/new/pdf.worker.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/imgareaselect/0.9.10/js/jquery.imgareaselect.min.js" integrity="sha512-59swnhUs+9AinrKlTPqsoO5ukNPPFbPXFyaf41MAgiTG/fv3LBZwWQWiZNYeksneLhiUo4xjh/leTZ53sZzQ4Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
@if($datas->sn != null)
<script>

var progressBar = $('#progress_bar');
  // progressBar.text('0%');
  progressBar.attr('aria-valuenow',0);
  progressBar.css('width',0);



  var __PDF_DOC,
    __CURRENT_PAGE,
    __TOTAL_PAGES,
    __PAGE_RENDERING_IN_PROGRESS = 0,
    __CANVAS = $('#pdf-canvas').get(0),
    __CANVAS_CTX = __CANVAS.getContext('2d');
    
  pdfjsLib.GlobalWorkerOptions.workerSrc = '{{ asset("assets/js/plugins/pdf/pdf.worker.19.js") }}';
  $("#pdf-loader").show();
  function showPDF(pdf_url) {
    $("#pdf-loader").show();
  
    var loadingTask = pdfjsLib.getDocument(pdf_url);
    loadingTask.promise.then(function(pdf) {
      __PDF_DOC = pdf;
      __TOTAL_PAGES = __PDF_DOC.numPages;
      
      // Hide the pdf loader and show pdf container in HTML
      $("#pdf-loader").hide();
      $("#pdf-contents").show();
      $("#pdf-total-pages").text(__TOTAL_PAGES);
  
      // Show the first page
      showPage(1);
    });
  }

  
  // showPDF("{{(base64_encode(file_get_contents(storage_path('app/public'.$datas->source)))) }}");
  
  function showPage(page_no) {
    __PAGE_RENDERING_IN_PROGRESS = 1;
    __CURRENT_PAGE = page_no;
  
    // Disable Prev & Next buttons while page is being loaded
    $("#pdf-next, #pdf-prev").attr('disabled', 'disabled');
  
    // While page is being rendered hide the canvas and show a loading message
    $("#pdf-canvas").hide();
    $("#page-loader").show();
  
    // Update current page in HTML
    $("#pdf-current-page").text(page_no);
    
    // Fetch the page
    __PDF_DOC.getPage(page_no).then(function(page) {
      // As the canvas is of a fixed width we need to set the scale of the viewport accordingly
      var scale_required = __CANVAS.width / page.getViewport(1).width;
  
      // Get viewport of the page at required scale
      var viewport = page.getViewport(scale_required);
  
      // Set canvas height
      __CANVAS.height = viewport.height;

      var __default_x1 = 0,
      __default_x2 = 0,
      __default_y1 = 0,
      __default_y2 = 0;
  
      var renderContext = {
        canvasContext: __CANVAS_CTX,
        viewport: viewport
      };
          $('input[name="dokumen_height"]').val(page.getViewport(1).height);
          $('input[name="dokumen_width"]').val(page.getViewport(1).width);
      
      // Render the page contents in the canvas
      page.render(renderContext).then(function() {
        __PAGE_RENDERING_IN_PROGRESS = 0;
  
        // Re-enable Prev & Next buttons
        $("#pdf-next, #pdf-prev").removeAttr('disabled');
  
        // Show the canvas and hide the page loader
        $("#pdf-canvas").show();
        $("#page-loader").hide();
        
        var canvasWidth = document.getElementById('pdf-canvas').clientWidth;
        var canvasHeight = document.getElementById('pdf-canvas').clientHeight;
        
        var canvaspdf = $('#pdf-canvas');

  
        var imgsign = new Image();

			imgsign.onload = function(){
				var signheight = imgsign.height;
				var signwidth = imgsign.width;
				
				$( canvaspdf ).imgAreaSelect({ 
					// aspectRatio: signwidth + ':' + signheight,
					handles: true, 
					show: true,
					onSelectEnd: function (img, selection) {
						var height = parseInt($('input[name="dokumen_height"]').val());
						var width = parseInt($('input[name="dokumen_width"]').val());
						var scale = width / (canvasWidth - 1);

						var lower_left_x = selection.x1 * scale,
							lower_left_y = height - (selection.y2 * scale),
							upper_right_x = selection.x2 * scale,
							upper_right_y = height - (selection.y1 * scale);
						
						var diff_x = Math.abs(lower_left_x - upper_right_x),
							diff_y = Math.abs(lower_left_y - upper_right_y)
						
						if (diff_x < 1 && diff_y < 1) {
							$( canvaspdf ).imgAreaSelect({ 
								x1 : $('input[name="x1"]').val(), 
								y1 : $('input[name="y1"]').val(),
								x2 : $('input[name="x2"]').val(),
								y2 : $('input[name="y2"]').val()
							});
						} else {						
							$('input[name="x1"]').val(parseInt(selection.x1));
							$('input[name="x2"]').val(parseInt(selection.x2));
							$('input[name="y1"]').val(parseInt(selection.y1));
							$('input[name="y2"]').val(parseInt(selection.y2));
							$('input[name="lower_left_x"]').val(parseInt(lower_left_x));
							$('input[name="lower_left_y"]').val(parseInt(lower_left_y));
							$('input[name="upper_right_x"]').val(parseInt(upper_right_x));
							$('input[name="upper_right_y"]').val(parseInt(upper_right_y));
              // 
              $('#txt_lower_left_x').text(" Lower Left X : " +parseInt(lower_left_x));
              $('#txt_lower_left_y').text(" Lower Left Y : " + parseInt(lower_left_y));
              $('#txt_upper_right_x').text(" Upper Right X : " + parseInt(upper_right_x));
              $('#txt_upper_right_y').text(" Upper Right Y : " + parseInt(upper_right_y)+" ");
						}
					},
					zIndex: -2,
					borderWidth: 4
				});
				
				var is_visible_sign = $('#is_visible_sign').val();
				if(is_visible_sign == 'True'){
					var wdth = 150;
					var hgth = (signheight * wdth) / signwidth;
					
					var height = parseInt($('input[name="dokumen_height"]').val());
					var width = parseInt($('input[name="dokumen_width"]').val());
					var scale = width / (canvasWidth - 1);

					var x1 = 10;
					var x2 = 10 + wdth;
					var y1 = canvasHeight - hgth - 10;
					var y2 = canvasHeight - 10;
					
					var lower_left_x = x1 * scale,
						lower_left_y = height - (y2 * scale),
						upper_right_x = x2 * scale,
						upper_right_y = height - (y1 * scale);
					$('input[name="x1"]').val(parseInt(x1));
					$('input[name="x2"]').val(parseInt(x2));
					$('input[name="y1"]').val(parseInt(y1));
					$('input[name="y2"]').val(parseInt(y2));
					$('input[name="lower_left_x"]').val(parseInt(lower_left_x));
					$('input[name="lower_left_y"]').val(parseInt(lower_left_y));
					$('input[name="upper_right_x"]').val(parseInt(upper_right_x));
					$('input[name="upper_right_y"]').val(parseInt(upper_right_y));
          // 
          $('#txt_lower_left_x').text(" Lower Left X : " +parseInt(lower_left_x));
					$('#txt_lower_left_y').text(" Lower Left Y : " + parseInt(lower_left_y));
					$('#txt_upper_right_x').text(" Upper Right X : " + parseInt(upper_right_x));
					$('#txt_upper_right_y').text(" Upper Right Y : " + parseInt(upper_right_y));
					
					$( canvaspdf ).imgAreaSelect({ 
						x1 : x1, 
						y1 : y1,
						x2 : x2,
						y2 : y2
					});
          $('#dokumen_page').val(page_no);
				}
            // console.log(is_visible_sign);
         
          var url = imgsign.src;
          $('.imgareaselect-selection').css({'background':'url(' + url + ') center/100% 100% no-repeat'});
        }
        imgsign.src = $('#digital_signature_path').val();
      });
      // console.log(__PAGE_RENDERING_IN_PROGRESS);
    });
     $('#response').hide();
  }


 

  showPDF("{{ asset('storage'.$datas->source) }}");

  progressBar.css('width','100%');
  // Upon click this should should trigger click on the #file-to-upload file input element
  // This is better than showing the not-good-looking file input element
  $("#upload-button").on('click', function() {
    $("#file-to-upload").trigger('click');
  });
  
  // When user chooses a PDF file
  $("#file-to-upload").on('change', function() {
    // Validate whether PDF
      if(['application/pdf'].indexOf($("#file-to-upload").get(0).files[0].type) == -1) {
          alert('Error : Not a PDF');
          return;
      }
  
    // Send the object url of the pdf
    showPDF(URL.createObjectURL($("#file-to-upload").get(0).files[0]));
  });
  // first page of the PDF
  $("#pdf-first").on('click', function() {
    if(__CURRENT_PAGE != 1)
      showPage(1);
  });
  // Previous page of the PDF
  $("#pdf-prev").on('click', function() {
    if(__CURRENT_PAGE != 1)
      showPage(--__CURRENT_PAGE);
  });
  
  // Next page of the PDF
  $("#pdf-next").on('click', function() {
    if(__CURRENT_PAGE != __TOTAL_PAGES)
      showPage(++__CURRENT_PAGE);
  });

  // last page of the PDF
  $("#pdf-last").on('click', function() {
    if(__CURRENT_PAGE != __TOTAL_PAGES)
      showPage(__TOTAL_PAGES);
  });
   // first page of the PDF
   $("#pdf-first-b").on('click', function() {
    if(__CURRENT_PAGE != 1)
      showPage(1);
  });
  // Previous page of the PDF
  $("#pdf-prev-b").on('click', function() {
    if(__CURRENT_PAGE != 1)
      showPage(--__CURRENT_PAGE);
  });
  
  // Next page of the PDF
  $("#pdf-next-b").on('click', function() {
    if(__CURRENT_PAGE != __TOTAL_PAGES)
      showPage(++__CURRENT_PAGE);
  });

  // last page of the PDF
  $("#pdf-last-b").on('click', function() {
    if(__CURRENT_PAGE != __TOTAL_PAGES)
      showPage(__TOTAL_PAGES);
  });


  toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-bottom-full-width",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  }
 
  
  var total =0;
  $('#doStemp').on('click',(e)=>{
           var name = $('#name').val();  
           var message = $('#message').val();  
           var input_x1 = $('input[name="lower_left_x"]').val();  
           var input_y1 = $('input[name="lower_left_y"]').val();  
           var input_x2 = $('input[name="upper_right_x"]').val();  
           var input_y2 = $('input[name="upper_right_y"]').val();  
           if(name == '' || message == '' || input_x1 == '' || input_x2 == '' || input_y1 == '' || input_y2 == '')  
           {  
                $('#text-response').html('<span class="text-danger">All Fields are required</span>');  
                toastr["warning"]("Please specify the position of the Materai ", "Warning");
           }  
           else  
           {  
                $('#progress-holder').removeClass('d-none')
                var progressBar = $('#progress_bar');
                progressBar.text('0%');
                progressBar.attr('aria-valuenow',0);
                progressBar.css('width',0);
                $.ajax({  
                     url:"{{ route('stemp.stemp') }}",  
                     method:"POST",  
                     data:$('#submit_form').serialize(),  
                     beforeSend:function(e){  
                      console.log(e.upload);
                          $('#text-response').html('<br>Loading Stamp Process...');
                          $('#response').show();   
                     },
                      xhr: function(){
                      var xhr = $.ajaxSettings.xhr();
      
                      xhr.upload.addEventListener('progress', function(e){
                          if(e.lengthComputable){
                              var completed = e.loaded/e.total;
                              var perc = Math.floor(completed * 100);
                              console.log("Upload:", perc)
                              progressBar.text(perc+'%');
                              progressBar.attr('aria-valuenow',perc);
                              progressBar.css('width',perc+'%');
                          }
                      }, false)
      
                      xhr.addEventListener('progress', function(e){
                          if(e.lengthComputable){
                              var completed = e.loaded/e.total;
                              var perc = Math.floor(completed * 100);
                              console.log("Download:",perc)
                              progressBar.text(perc+'%');
                              progressBar.attr('aria-valuenow',perc);
                              progressBar.css('width',perc+'%');
                              console.log(completed);
                              total = completed;
                          }
                          setTimeout(function(){  
                               $('#response').fadeOut("slow");  
                          }, total); 
                      }, false)
                      return xhr;
                  },
                     success:function(data){  
                      console.log(data);
                          $('form').trigger("reset");  
                          //$('#text-response').fadeIn().html(data);  
                          obj = JSON.parse(data);
                          if(obj.status=='True'){
                            toastr["success"]("Stamp Process Successful ", "Success");
                            window.location.href = '{{ route("success") }}';
                          }
                          if(obj.status != 'True'){
                            toastr["error"]("Stamp Process Failed <br> Code : "+ obj.errorCode +"<br>Message : "+ obj.errorMessage, "Failed");
                            window.location.href = '#';
                          }
                          setTimeout(function(){  
                               $('#response').fadeOut("slow");  
                          }, total);  
                     },
                     error: function(XMLHttpRequest, textStatus, errorThrown) { 
                      var errM = '';
                      var errN = '';
                      if(XMLHttpRequest.responseJSON.errorMessage){
                        errM = XMLHttpRequest.responseJSON.errorMessage +"<br>";
                        errN = XMLHttpRequest.responseJSON.errorMessage +"<br>";
                      }
                      toastr["error"]("Stamp Process Failed <br>"+ 
                                  errN + errM +
                                  XMLHttpRequest.responseJSON.message,
                                   "Failed");
                     }  
                });  
           }  
  }); 
  </script>
  @endif
</body>
</html>
