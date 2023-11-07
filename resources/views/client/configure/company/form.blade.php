<div class="card mb-4">
    {{-- <div class="card-header">
        Configure
    </div> --}}
    <form action="{{ Route('company.store') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <div class="card-body">
            <h4 class="card-title">Create Company</h4>
            {{-- <p class="card-text">Text</p> --}}
            <div class="col-md-12">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $data->name??'') }}" required>
                <span></span>
            </div>
            <div class="col-md-12">
                <label for="detail" class="form-label">desciptions</label>
                <input type="text" class="form-control" name="detail" id="detail" value="{{ old('detail', $data->detail??'') }}">
                <span></span>
            </div>
        </div>
        <div class="card-footer text-muted text-end">
            <div class="row">
                <div class="col-6 text-start">
                </div>
                <div class="col-6 text-end">
                    <a class="btn btn-danger" href="{{ route('company.index') }}"> Close </a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
                </div>
            </div>
        </div>
    </form>
</div>