<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<style>
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
  background-color: #ebeff7;
}
#dropzone{
  background-color: #d2d6dd;
  border-radius: 16px;
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
        </div>
      </div>
        <div class="row justify-content-center align-items-center g-2">
          <form method="post" action="{{route('doc-upload')}}" enctype="multipart/form-data" 
                  class="dropzone" id="dropzone">
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
          </form>   
        </div>
        <div class="card-footer text-muted text-end p-0 mb-0">
          <div class="row">
              <div class="col-6 text-start mb-0">
                  {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
              </div>
              <div class="col-6 text-end mb-0">
                  <a class="btn btn-danger" href="{{ url()->previous() }}">
                          Close 
                  </a>
              </div>
          </div>
      </div>
    </div>
 

    <script type="text/javascript">
      Dropzone.options.dropzone =
       {
          maxFilesize: 12,
          renameFile: function(file) {
              var dt = new Date();
              var time = Math.ceil(dt.getTime()/1000);
             return time+'_'+file.name;
          },
          acceptedFiles: ".pdf",
          addRemoveLinks: true,
          timeout: 5000,
          success: function(file, response) 
          {
              console.log(response);
          },
          error: function(file, response)
          {
             return false;
          }
};
</script>