
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/imgareaselect/0.9.10/css/imgareaselect-animated.css" integrity="sha512-VOWGVItJ5anAaHwRzNFPo8YGbAGDl34AkUq0/Dkn4UJxK0ag95IZQWoitH6xM7Bq6C3i2VW5oFzkL1+wYkLdmQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
#upload-button {
  margin: 20px auto;
}

#file-to-upload {
  display: none;
}

#pdf-main-container {
  width: 100%;
  margin: 20px auto;
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
  float: right;
  font-size: 15pt;
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
  border: 1px solid rgba(0,0,0,0.2);
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
</style>
<div class="card p-2">
  <div class="card-head">
      <h6>Stamp Position Placement</h6>
      {{$datas[0]->company->name}}
      {{$datas[0]->name}}
  </div>
  <div class="row">
    <div class="col-md-12">
      <a  class="btn btn-primary btn-block btn-sm col-12" id="upload-button">Pilih File PDF</a> 
      <div class="row">
        <div class="col-md-3">
          <font style="font-weight: bold"><strong>Lower Left X</strong></font>
          <input type="text" class="form-control" name="lower_left_x" value="" style="width: 100%"/>
        </div>
        <div class="col-md-3">
          <font style="font-weight: bold"><strong>Lower Left Y</strong></font>
          <input type="text" class="form-control" name="lower_left_y" value="" style="width: 100%"/>
        </div>
        <div class="col-md-3">
          <font style="font-weight: bold"><strong>Upper Right X</strong></font>
          <input type="text" class="form-control" name="upper_right_x" value="" style="width: 100%"/>
        </div>
        <div class="col-md-3">
          <font style="font-weight: bold"><strong>Upper Right Y</strong></font>
          <input type="text" class="form-control" name="upper_right_y" value="" style="width: 100%"/>
        </div>
      </div>
      <form action="{{route('stemp.store')}}" method="POST" enctype="multipart/form-data" >
        @csrf
        <input type="file" name="file" id="file-to-upload"  accept="application/pdf"/>

        <input type="hidden" name="company_name" value="{{$datas[0]->company->name}}" required/>
        <input type="hidden" name="company" value="{{$datas[0]->company->id}}" required/>
        <input type="hidden" name="directory_name" value="{{$datas[0]->name}}" required/>
        <input type="hidden" name="directory" value="{{$datas[0]->id}}" required/>
        <input type="hidden" name="x1" value="" required/>
        <input type="hidden" name="x2" value="" required />
        <input type="hidden" name="y1" value="" required />
        <input type="hidden" name="y2" value="" required />
        <input type="hidden" name="dokumen_height" value="" required="required" />
        <input type="hidden" name="dokumen_width" value="" required="required" />
        <input type="hidden" name="dokumen_page" id="dokumen_page" required>
        <input type="hidden" name="digital_signature_path" id="digital_signature_path" width: 100px; height: 100px; value="{{asset('assets/img/meterai.png') }}">
        <input type="hidden" name="is_visible_sign" id="is_visible_sign" value="True">
        
      <div id="pdf-main-container">
        <div id="pdf-loader">Loading document ...</div>
        <div id="pdf-contents">
          <div id="pdf-meta" class="p-0 mb-0"></div>
            <div class="row mb-0">
              <div id="pdf-buttonss" class="btn-group btn-group-sm mb-0" role="group" aria-label="Page Control">
                <a id="pdf-first" class="btn btn-secondary btn-sm">First</a>
                <a id="pdf-prev" class="btn btn-secondary btn-sm"><i class="fa fa-step-backward" aria-hidden="true"></i> Prev</a>
                <div id="page-count-container" class="btn disabled" >Page <div id="pdf-current-page" class="p-0 mb-0"></div> of <div id="pdf-total-pages"></div></div>
                {{-- <div id="page-count-container">Page <div id="pdf-current-page"></div> of <div id="pdf-total-pages"></div></div> --}}
                <a id="pdf-next" class="btn btn-secondary btn-sm">Next <i class="fa fa-step-forward" aria-hidden="true"></i></a>
                <a id="pdf-last" class="btn btn-secondary btn-sm">Last</a>
              </div>
            </div>
          {{-- <canvas id="pdf-canvas" width="1000"></canvas> --}}
          <canvas id="pdf-canvas"  width="1000"></canvas>
          <div id="page-loader">Loading page ...</div>
          <div class="row mb-0">
            <div id="pdf-buttonss" class="btn-group btn-group-sm mb-0" role="group" aria-label="Page Control">
              <a id="pdf-first-b" class="btn btn-secondary btn-sm">First</a>
              <a id="pdf-prev-b" class="btn btn-secondary btn-sm"><i class="fa fa-step-backward" aria-hidden="true"></i> Prev</a>
              <div id="page-count-container" class="btn disabled" >Page <div id="pdf-current-page" class="p-0 mb-0"></div> of <div id="pdf-total-pages"></div></div>
              {{-- <div id="page-count-container">Page <div id="pdf-current-page"></div> of <div id="pdf-total-pages"></div></div> --}}
              <a id="pdf-next-b" class="btn btn-secondary btn-sm">Next <i class="fa fa-step-forward" aria-hidden="true"></i></a>
              <a id="pdf-last-b" class="btn btn-secondary btn-sm">Last</a>
            </div>
          </div>
          <div class="row p-3">
            <button type="submite" class="btn btn-primary btn-sm">Save</button>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- jQuery 3 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{-- <script src="https://e-form.peruri.co.id/pdfviewer/bower_components/jquery/dist/jquery.min.js"></script> --}}
{{-- <script src="https://e-form.peruri.co.id/pdfviewer/dist/js/new/pdf.js"></script> --}}
<script src="{{ asset("assets/js/plugins/pdf/pdf.19.js") }}"></script>
<script src="{{ asset("assets/js/plugins/pdf/pdf.worker.19.js") }}"></script>
{{-- <script src="https://e-form.peruri.co.id/pdfviewer/dist/js/new/pdf.worker.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/imgareaselect/0.9.10/js/jquery.imgareaselect.min.js" integrity="sha512-59swnhUs+9AinrKlTPqsoO5ukNPPFbPXFyaf41MAgiTG/fv3LBZwWQWiZNYeksneLhiUo4xjh/leTZ53sZzQ4Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
  var __PDF_DOC,
    __CURRENT_PAGE,
    __TOTAL_PAGES,
    __PAGE_RENDERING_IN_PROGRESS = 0,
    __CANVAS = $('#pdf-canvas').get(0),
    __CANVAS_CTX = __CANVAS.getContext('2d');
    
  pdfjsLib.GlobalWorkerOptions.workerSrc = '{{ asset("assets/js/plugins/pdf/pdf.worker.19.js") }}';
  
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
              }
            },
            zIndex: -2,
            borderWidth: 4
          });
          
          var is_visible_sign = $('#is_visible_sign').val();
          if(is_visible_sign == 'True'){
            var wdth = 100; //default 50
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
            $('input[name="dokumen_page"]').val(parseInt(__CURRENT_PAGE));
            
            
            $( canvaspdf ).imgAreaSelect({ 
              x1 : x1, 
              y1 : y1,
              x2 : x2,
              y2 : y2
            });
          }
          
          var url = imgsign.src;
  
          $('.imgareaselect-selection').css({'background':'url(' + url + ') center/100% 100% no-repeat'})
        }
  
        imgsign.src = $('#digital_signature_path').val();
      });
    });
  }
  
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
  </script>