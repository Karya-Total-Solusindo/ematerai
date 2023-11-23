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
                <h4 class=" card-title">My Document </h4>
                <span class="">{{ $datas[0]->company->name ?? '' }} {{ (!empty($datas[0]->directory))?'/':'' }} {{ $datas[0]->directory->name ?? '' }}</span>
                {{ ($datas[0]->directory->template ?? '')}}
            </div>
            <div class="col text-end">
                <a @class(['btn btn-sm btn-danger', 'font-bold' => true]) href="{{ route('directory', $datas[0]->company->id ?? '') }}"> Back</a>
                <a @class(['btn btn-sm btn-primary', 'font-bold' => true]) href="{{ route('add.file', Request::segment(4)) }}"> Create</a>
            </div>
            {{-- <p class="card-text">Text</p> --}}
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
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
                            <th class="text-secondary opacity-7" width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                        <tr>
                            <td>
                                <div class="align-middle text-sm">
                                    {{-- <div>
                                        <img src="/img/team-2.jpg" class="avatar avatar-sm me-3"
                                            alt="user1">
                                    </div> --}}
                                    <div class="">
                                        <h6 class="p-0"><a href="{{ route('stemp.show',$data->id) }}">{{ $data->filename }}</a></h6>
                                        {{-- <p class="text-xs text-secondary mb-0">john@creative-tim.com</p> --}}
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle text-sm">
                                {{-- {{ $data->certificatelevel ?? 'NOT_CERTIFIED' }} --}}
                                {{ $data->sn ?? 'NOT_CERTIFIED' }}
                                {{-- {{ $data->filename }} --}}
                                {{-- @foreach (App\Models\Directory::where('id', $data->directory_id)->get() as $dir)
                                    {{ $dir['name'] }}
                                @endforeach --}}
                                {{-- <span class="badge badge-sm bg-gradient-success"> Online</span> --}}
                            </td>
                            <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">{{ $data->created_at->format('d/m/Y') }}</span>
                            </td>
                            <td class="align-middle text-end ">
                                {{-- <pre>
                                {{var_dump($datas)}} --}}
                                <a href="{{ route('stemp.show',$data->id) }}" class="btn btn-s btn-primary text-white font-weight-bold text-xs"
                                    data-toggle="tooltip" data-original-title="Edit Company">
                                    Detail 
                                </a>
                                {{-- <a href="{{ asset('/docs/'.$data->company->name.'/'.$data->directory->name.'/in/'.$data->filename) }}" class="btn btn-s btn-primary text-white font-weight-bold text-xs"
                                    data-toggle="tooltip" data-original-title="Edit Company">
                                    Open
                                </a> --}}
                                {{-- <button class="btn btn-s btn-primary text-white font-weight-bold text-xs view" data-title="{{$data->filename}}" data-bs-toggle="modal" data-bs-target="#modalId" data-url="{{ asset('/docs/'.$data->company->name.'/'.$data->directory->name.'/in/'.$data->filename) }}">View</button> --}}
                                <button class="btn btn-s btn-primary text-white font-weight-bold text-xs view" data-title="{{$data->filename}}" data-bs-toggle="modal" data-bs-target="#modalId" data-url="{{ route('process',$data->id)}}">View</button>
                               
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                </table>

            </div>
        </div>
        {{ $datas->links() }}
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