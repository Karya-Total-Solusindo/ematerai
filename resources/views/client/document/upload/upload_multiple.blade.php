<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<style>
.dropzone{
min-height: 300px;
}
.dropzoner{
  border-radius: 13px;
}
.upload_dropZone {
  color: #0f3c4b;
  background-color: var(--colorPrimaryPale, #c8dadf);
  outline: 2px dashed var(--colorPrimaryHalf, #c1ddef);
  outline-offset: -12px;
  transition:
    outline-offset 0.2s ease-out,
    outline-color 0.3s ease-in-out,
    background-color 0.2s ease-out;
}
.upload_dropZone.highlight {
  outline-offset: -4px;
  outline-color: var(--colorPrimaryNormal, #0576bd);
  background-color: var(--colorPrimaryEighth, #c8dadf);
}
.upload_svg {
  fill: var(--colorPrimaryNormal, #0576bd);
}
.btn-upload {
  color: #fff;
  background-color: var(--colorPrimaryNormal);
}
.btn-upload:hover,
.btn-upload:focus {
  color: #fff;
  background-color: var(--colorPrimaryGlare);
}
.upload_img {
  width: calc(33.333% - (2rem / 3));
  object-fit: contain;
}
#dropzone:hover{
  background-color: #cad3ff54;
}
#dropzone{
  background-color: #d2d6dd;
  border-radius: 16px;
  
}
#dropzoner2{
  max-height: 500px !important;
    overflow-x: auto !important;
    background: none;
    border: solid 1px !important;
    padding: 10px !important;
    display: flex;
    flex-direction: column-reverse;
}
.dropzone-previews > .dz-preview > .dz-success-mark,
.dropzone-previews > .dz-preview > .dz-error-mark{
  position: absolute;
  top: 0px;
  right: 0px;
}
.dropzone-previews > .dz-preview > .dz-success-mark{
  right: 21px;
}
.dropzone-previews > .dz-preview > .dz-error-mark{
  top: 15px;
  right: 21px;
}
.dropzone-previews > .dz-preview > .dz-success-mark > span{
  color: green;
}
.dropzone-previews > .dz-preview > .dz-error-mark > span {
  color: red;
}
.dz-error-message > span {
  /* position: absolute; */
  /* top: 24px; */
  color:red;
  font-size: 12px !important;
  margin: 0px 5px;
}
.dz-progress{
    width: 100%;
    background: #efefef;
    height: 5px;
}
.dz-progress > span.dz-upload{
    width: 0%;
    height: 5px;
    position: absolute;
    border-radius: 20px;
    background: rgb(255,89,89);
    background: linear-gradient(45deg, rgba(255,89,89,0.9920343137254902) 24%, rgba(249,209,201,0.9730742638852417) 98%);
    /* animation: progressAnimation 6s; */
}
@keyframes progressAnimation {
  0%   { width: 5%; background-color: #f6c1a7;}
  100% { width: 50%; background-color: #ffb06f; }
  100% { width: 85%; background-color: #7fcf9c; }
}

.dz-error{
  background: rgb(255 235 235);
  /* border-radius: 7px; */
  margin-bottom: 0px;
}
</style>
<div class="card text-start">
    {{-- <img class="card-img-top" src="holder.js/100px180/" alt="Title"> --}}
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <h4 class="card-title">Document Upload</h4>
        </div>
        <div class="text-end col-md-6">
          {{ $directorys->companyName }} / <b>{{ $directorys->name }}</b>
          <a class="btn btn-sm btn-danger" href="{{ url()->previous() }}"> Close  </a>
        </div>
      </div>
        <div class="row justify-content-center align-items-center g-2">
          <form method="post" action="{{route('doc-upload')}}" enctype="multipart/form-data" class="dropzone" id="dropzone">
              @csrf
              <input type="hidden" name="company_name" value={{ $directorys->companyName }}>
              <input type="hidden" name="company" value={{ $directorys->company_id }}>
              <input type="hidden" name="directory_name" value={{  $directorys->name }}>
              <input type="hidden" name="directory" value={{  $directorys->id }}>
              <input type="hidden" name="x1" value={{  $directorys->x1 }}>
              <input type="hidden" name="x2" value={{  $directorys->x2 }}>
              <input type="hidden" name="y1" value={{  $directorys->y1 }}>
              <input type="hidden" name="y2" value={{  $directorys->y2 }}>
              <input type="hidden" name="dokumen_height" value={{  $directorys->height }}>
              <input type="hidden" name="dokumen_width" value={{  $directorys->width }}>
              <input type="hidden" name="dokumen_page" value={{  $directorys->page }}>
              <center>
                <i class="fas fa-cloud-arrow-up" style="font-size:12em;"></i>
              </center>
          </form>   
        </div>
        {{-- footer --}}
        <div class="card-footer text-muted text-end p-0 mb-0">
          <div class="row">
              <div class="col-6 text-start mb-0">
                <span class="upliad-info">
                  <span id="file-total"></span>
                  <span id="file-success"></span>
                  <span id="file-error"></span>
                </span>
              </div>
              <div class="col-6 text-end mb-0">
                  <a class="btn btn-sm btn-danger" href="{{ url()->previous() }}"> Close  </a>
              </div>
          </div>
      </div>
      {{-- end footer --}}
    </div>
  </div>

    <div class="card" id="card-dropzone" style="display: none;">
      <div class="card-body">
        <span id="view-total-process" style="opacity: 0;">
          <div id="total-progress" class="progress active" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
            <div class="progress-bar progress-bar-striped progress-bar-success" role="progressbar" style="width: 0%" data-dz-uploadprogress=""></div>
          </div>
        </span>

        <div class="dropzoner dropzone-previews" id="dropzoner2" style="opacity: 0; max-height: 500px; overflow-x: auto;">
            <div class="dz-preview dz-file-preview" id="template">  
              <!-- template for images -->
              <div class="dz-details dztemplate mb-0 d-flex align-items-center ">
                <div class="dz-number mx-2 w-auto"></div>
                <div class="dz-filename px-1"><span data-dz-name></span></div>
                <div class="dz-size px-1"  data-dz-size></div>
              </div>
              <div class="dz-progress"  aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" >
                <span class="dz-upload" data-dz-uploadprogress></span>
              </div>
              <div class="dz-success-mark" style="opacity: 0;"><span>✔</span></div>
              <div class="dz-error-mark" style="opacity: 0;"><span>✘</span></div>
              <div class="dz-error-message mb-0 px-1 d-flex align-items-center text-danger" style="opacity: 0;"><span data-dz-errormessage></span></div>
                {{-- <a href="#" class="dropdown-item" data-dz-remove> Remove</a> --}}
              <hr class="horizontal my-1 dark">
            </div>
        </div>
        <!-- Drop Zone Area -->

      </div>
    </div>
    @if(config('app.debug'))
    <script type="text/javascript">
      const dev = true;  
    </script>
    @else
    <script type="text/javascript">
      const dev = false;  
    </script>
    @endif
    <script type="text/javascript">
      var totFile=0,totSuccess=0,totError=0;
      var totProgress= 0;
      var totActionFile =0;
      var numberFile =1;
      var previewNode = document.querySelector("#template");
      previewNode.id = "";
      var previewTemplate = previewNode.parentNode.innerHTML;
      previewNode.parentNode.removeChild(previewNode);

      Dropzone.options.dropzone =
       {
          maxFilesize: 16,
          renameFile: function(file) {
              var dt = new Date();
              var time = Math.ceil(dt.getTime()/1000);
              if(dev==false){
                  return time+'_'+file.name;
              }
              return file.name;
          },
          acceptedFiles: ".pdf",
          addRemoveLinks: false,
          createImageThumbnails:false,
          // timeout: 100000,
          previewTemplate: previewTemplate,
          previewsContainer: "#dropzoner2",
          // forceFallback:false,
          init: function() {
            let myDropzone = this;
                this.on("addedfile", file => {
                  document.getElementById("card-dropzone").style.display = "block";
                  document.getElementById("dropzoner2").style.background = "none";
                  console.log("A file has been added");
                  document.querySelector("#total-progress .progress-bar").style.width = 0 + "%";
                  document.querySelector("#view-total-process").style.opacity = "1";
                  document.querySelector("#dropzoner2").style.opacity = "1";
                  document.querySelector("#file-success").innerHTML  = 'Success : '+totSuccess;
                  document.querySelector("#file-error").innerHTML  = 'Error : '+totError;
                  totFile++;
                  totActionFile++;
                  document.querySelector("#file-total").innerHTML  ='Total : '+ totFile;
                  file.previewElement.querySelector(['.dz-number']).innerHTML = numberFile++ +"."; 
                  console.log(file.previewElement);
                  // numberFile++;
                });
                // upload the uploadprogress
                this.on("uploadprogress", function(file, progress, bytesSent) {
                  file.previewElement.querySelectorAll("[data-dz-uploadprogress]");
                  // console.log(progress);
                    console.log(file.previewElement.querySelectorAll("[data-dz-uploadprogress]"));
                  if (file.previewElement) {
                    for (let node of file.previewElement.querySelectorAll("[data-dz-uploadprogress]"
                    )) {
                      node.nodeName === "SPAN"
                        ? (node.value = progress)
                        : (node.style.width = `${progress}%`);
                        console.log(node.nodeName);
                        console.log(progress);
                    }
                  }
                });
                // Update the total progress bar
                this.on("totaluploadprogress", function(progress) {
                  console.log('TOTAL PROGRESS ',Math.ceil(progress));
                  totProgress = progress;
                  document.querySelector("#total-progress .progress-bar").style.width = Math.ceil(totProgress) + "%";
                  // totProgress =  Math.ceil((progress*totActionFile)/totActionFile);
                  // document.querySelector("#total-progress .progress-bar").style.width = totProgress + "%";
                });
                this.on("sending", function(file,progress) {
                  console.log(file,progress);
                  if (file.previewElement) {
                    for (let node of file.previewElement.querySelectorAll("[data-dz-uploadprogress]"
                    )) {
                      node.nodeName === "SPAN"
                        ? (node.value = progress)
                        : (node.style.width = `${progress}%`);
                        console.log(node.nodeName);
                        console.log(progress);
                    }
                  }
                  // file.previewElement.querySelector(['.dz-number']).innerHTML = numberFile++; 
                  // Show the total progress bar when upload starts
                  
                  // And disable the start button
                  // file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
                });
                //this.on("sendingmultiple", function() {
                  // Gets triggered when the form is actually being sent.
                  // Hide the success button or the complete form.
                  // console.log('sendingmultiple ',response);
                //});
                //this.on("successmultiple", function(files, response) {
                  // Gets triggered when the files have successfully been sent.
                  // Redirect user or notify of success.
                  // console.log('successmultiple ',response);
                //});
                //this.on("errormultiple", function(files, response) {
                  // Gets triggered when there was an error sending the files.
                  // Maybe show form again, and notify user of error
                  // document.querySelector(".dz-error-message").style.opacity = "1";
                  //console.log('errormultiple ',response);
                //});
                this.on("complete", function(file,response) {
                  // console.log('complete ',file,response);
                  file.previewElement.querySelector(['.dz-progress']).style.opacity = "0";  
                });
                //this.on("canceledmultiple", function(files) {
                  //console.log('canceledmultiple ',files);
                //});
                // this.on("processing", function (file) {
                //   console.log('processing ',file);
                // });
                this.on("success", function (file, response) {
                    console.log("success ",response);
                    if(response.error){
                      if(response.error=='file exists'){
                        var filepath = response.message.replace('file exists /app/public','');
                        file.previewTemplate.querySelector(['.dz-filename']).innerHTML = "<span style='color:red;'> <a href='/storage"+filepath+"' target='_blank' >"+file.name+"</a><span>";
                      }else{
                        file.previewTemplate.querySelector(['.dz-filename']).innerHTML = "<span style='color:red;'>"+file.name+"<span>";
                      }
                      file.previewTemplate.querySelector(['.dz-error-message']).innerHTML = "<span style='color:red;'><i class='fas fa-warning'></i> "+response.error+" "+ file.name +"<span>";
                      file.previewElement.querySelector(['.dz-success-mark']).style.opacity = "0"; 
                      file.previewElement.querySelector(['.dz-error-mark']).style.opacity = "1"; 
                      file.previewElement.querySelector([".dz-error-message"]).style.opacity = "1";
                      // file.previewElement.querySelector(".dz-preview").css = "dz-error";
                      // file.previewElement.querySelector(['.dz-preview']).classList.remove('dz-success');
                      file.previewElement.classList.remove('dz-success');
                      file.previewElement.classList.add('dz-error');
                      $s=file.previewElement;
                      console.log($s);
                      totError++;
                    }else{
                      totSuccess++;
                      var filepath = response.path.replace('/app/public','');
                      file.previewTemplate.querySelector(['.dz-filename']).innerHTML = "<span><i class='fas fa-file-pdf'></i>  <a href='/storage"+filepath+"' target='_blank' >"+file.name+"</a><span>";
                      file.previewElement.querySelector(['.dz-success-mark']).style.opacity = "1"; 
                    }
                    // var ficheiro = {  name: file.name, link: response[0] };
                    file.previewElement.querySelector(['.dz-progress']).style.display = "none";   
                    
                    document.querySelector("#total-progress").style.opacity = "1";
                    document.querySelector("#file-success").innerHTML  = 'Success : '+totSuccess;
                });
                this.on("error", function (file, error, xhr) {
                    // console.error(file, error, xhr);
                    // var fileError = { name: name.name, status: file.status, statusText: error, error: error };
                    file.previewElement.setAttribute(['dz-preview'],'error');
                    file.previewTemplate.querySelector(['.dz-filename']).innerHTML = "<span style='color:red;'> "+file.name+"<span>";
                    file.previewTemplate.querySelector(['.dz-error-message']).innerHTML = "<span style='color:red;'><i class='fas fa-warning'></i> "+error+"<span>";
                    file.previewElement.querySelector(['.dz-error-mark']).style.opacity = "1"; 
                    file.previewElement.querySelector(".dz-error-message").style.opacity = "1";
                    file.previewElement.querySelector(['.dz-progress']).style.opacity = "0"; 
                    file.previewElement.querySelector(['.dz-progress']).style.display = "none";                   
                    totError++;
                    document.querySelector("#file-error").innerHTML  = 'Error : '+totError;
                    // $scope.$apply($scope.errorFiles.push(ficheiro));
                });
                // Hide the total progress bar when nothing's uploading anymore
                this.on("queuecomplete", function() {
                      console.log('queuecomplete');
                      document.querySelector("#total-progress").style.opacity = "0";
                      document.querySelector("#view-total-process").style.opacity = "0";
                      document.querySelector("#file-success").innerHTML  = 'Success : '+totSuccess;
                      document.querySelector("#file-error").innerHTML  = 'Error : '+totError;
                      console.info(totFile,totSuccess,totError);
                      totActionFile =0;
                      totProgress=0;

                });
                // let fileCountOnServer = 2;
                // myDropzone.options.maxFiles = myDropzone.options.maxFiles - fileCountOnServer;
          },
          // success: function(file, response) 
          // {
          //     console.log(response);
          // },
          // error: function(file, response)
          // {
          //    return false;
          // }
};
</script>

<script language="JavaScript">
  window.onbeforeunload = confirmExit;
  function confirmExit() {
      return "You have attempted to leave this page. Are you sure?";
  }
</script>
