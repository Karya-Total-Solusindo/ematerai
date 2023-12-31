
    @if ($message = session()->has('succes'))
        <div class="px-4 pt-4">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <p class="text-white mb-0">{{ session()->get('succes') }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <script>
                toastr["success"]("Success", "{{ session()->get('succes') }}");
            </script>
        </div>
    @endif
    @if ($message = session()->has('error'))
        <div class="px-4 pt-4">
            <div class="alert alert-danger" role="alert">
                <p class="text-white mb-0">{{ session()->get('error') }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <script>
                toastr["error"]("Error", "{{ session()->get('error') }}");
            </script>
         </div>
    @endif
 
    
    {{-- Javascript --}}
@once  
@pushOnce('js')
    @if ($message = session()->has('warning'))
            <script>
                toastr["warning"]("warning", "{{ session()->get('warning') }}");
            </script>
         </div>
    @endif
    @if ($message = session()->has('info'))
            <script>
                toastr["info"]("info", "{{ session()->get('info') }}");
            </script>
         </div>
    @endif
    @endPushOnce
@endonce
