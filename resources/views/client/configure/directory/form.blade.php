<div class="card mb-4">
    {{-- <div class="card-header">
        Configure
    </div> --}}
    <form action="{{ Route('directory.store') }}" method="post">
        @csrf
            <div class="card-body">
            <h4 class="card-title">Create Directory</h4>
            {{-- <p class="card-text">Text</p> --}}
            <div class="col-md-12">
                <label for="company" class="form-label">Company</label>
                <select class="form-select form-select-lg" name="company" id="company" required>
                    @foreach ($datas as $d)
                        <option value="{{ $d->id }}"> {{ $d->name }}</option>
                    @endforeach
                </select>
                <span></span>
            </div>
            <div class="col-md-12">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" autocomplete="off" name="name" id="name" value="{{ $directory->name ?? '' }}" required>
                <span></span>
                
            </div>
        </div>
        <div class="card-footer text-muted text-end">
            <div class="row">
                <div class="col-6 text-start">
                    {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
                </div>
                <div class="col-6 text-end">
                    <a class="btn btn-danger" href="{{ route('directory.index') }}">
                            Close 
                    </a>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </form>
</div>