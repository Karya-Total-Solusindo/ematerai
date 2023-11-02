<div class="card mb-4">
    {{-- <div class="card-header">
        Configure
    </div> --}}
    <form action="{{ Route('directory.store') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <div class="card-body">
            <h4 class="card-title">Create Directory</h4>
            <p class="card-text">Text</p>
            <div class="col-md-12">
                    <label for="company" class="form-label">Company</label>
                    <select class="form-select form-select-lg" name="company" id="company" required>
                        <option value="" selected>Select one</option>
                        @foreach ($datas as $data)
                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                        @endforeach
                    </select>
                <span></span>
            </div>
            <div class="col-md-12">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ $data->name }}" required>
                <span></span>
                
            </div>
        </div>
        <div class="card-footer text-muted text-end">
            <div class="row">
                <div class="col-6 text-start">
                    <a class="btn btn-danger" href="{{ route('directory.index') }}">
                            Close 
                    </a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-6 text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>
</div>