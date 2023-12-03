<div class="card mb-4">
    {{-- <div class="card-header">
        Configure
    </div> --}}
    <form action="{{ Route('configure-store') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <div class="card-body">
            <h4 class="card-title">Create Company Directory</h4>
            <p class="card-text">Text</p>
            <div class="col-md-4">
                <label for="name" class="form-label">Name</label> 
                @error('name') <p class="text-danger text-xs pt-1"> {{$message}} </p>@enderror
                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}"required>
                <span></span>
            </div>
            <div class="col-md-4">
                <label for="category" class="form-label">Category</label>
                <input type="text" class="form-control" name="category" id="category" value="" required>
                <span></span>
                <p>ambil dari API</p>
            </div>
        </div>
        <div class="card-footer text-muted text-end">
            <div class="row">
                <div class="col-6 text-start">
                    <a class="btn btn-danger" href="{{ route('configure') }}">
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