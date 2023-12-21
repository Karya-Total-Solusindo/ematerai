@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Dashboard'])
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js">
    <link rel="stylesheet" href="https://cdn.datatables.net/autofill/2.6.0/css/autoFill.bootstrap5.min.css">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3 mb-0">
                        <div class="row mb-0">
                            <div class="col-8 mb-0">
                                <div class="numbers mb-0">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Files</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $datas['COUNT_DOCUMENT'] }}
                                        <span style="font-size:3vh;">sheet</span>
                                    </h5>
                                    <p class="mb-0" style="font-size: 12px;">
                                        {{-- <span class="text-success text-sm font-weight-bolder">+55%</span> --}}
                                        since yesterday
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end mb-0">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body p-3 mb-0">
                        <div class="row mb-0">
                            <div class="col-8 mb-0">
                                <div class="numbers mb-0">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">NOT STAMPED</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{$datas['NOT_STAMPED']}}
                                        <span style="font-size:3vh;">sheet</span>
                                    </h5>
                                    <p class="mb-0" style="font-size: 12px;">
                                        {{-- <span class="text-success text-sm font-weight-bolder">+5%</span> than last month --}}
                                        since last quarter
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                    <i class="ni ni-archive-2 text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3 mb-0">
                        <div class="row mb-0">
                            <div class="col-8 mb-0">
                                <div class="numbers mb-0">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Failed</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $datas['COUNT_FAILUR'] }}
                                        <span style="font-size:3vh;">sheet</span>
                                    </h5>
                                    <p class="mb-0"  style="font-size: 12px;">
                                        {{-- <span class="text-success text-sm font-weight-bolder">+3%</span> --}}
                                        since last quarter
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-12 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3 mb-0">
                        <div class="row mb-0">
                            <div class="col-8 mb-0">
                                <div class="numbers mb-0">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">CERTIFIED</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{-- {{rand(200000,900000)}}  --}}
                                        {{ $datas['COUNT_SUCCESS'] }}
                                        <span style="font-size:3vh;">sheet</span>
                                    </h5>
                                    <p class="mb-0" style="font-size: 12px;">
                                        {{-- <span class="text-danger text-sm font-weight-bolder">-2%</span> --}}
                                        since last quarter
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3 mb-0">
                        <div class="row mb-0">
                            <div class="col-8 mb-0">
                                <div class="numbers mb-0">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Materai Balance</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{-- {{rand(200000,900000)}}  --}}
                                        {{ $datas['COUNT_MATERAI'] }}
                                        <span style="font-size:3vh;"></span>
                                    </h5>
                                </div>
                                
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle">
                                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                            <p class="mb-0"  style="font-size: 12px;">
                                {{ Auth::user()->pemungut->p_user }}
                                </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card" title="Jumlah saldo pada Portal POS">
                    <div class="card-body p-3 mb-0">
                        <div class="row mb-0">
                            <div class="col-8 mb-0">
                                <div class="numbers mb-0">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Materai Unused</p>
                                    <h5 class="font-weight-bolder mb-0" title="Jumlah saldo pada Portal POS">
                                        {{-- {{rand(200000,900000)}}  --}}
                                        {{ $datas['COUNT_MATERAI_NOTSTAMP'] }}
                                        <span style="font-size:3vh;"></span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                            <p class="mb-0"  style="font-size: 12px;">~</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3 mb-0">
                        <div class="row mb-0">
                            <div class="col-8 mb-0">
                                <div class="numbers mb-0">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Materai Used</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{-- {{rand(200000,900000)}}  --}}
                                        {{ $datas['COUNT_MATERAI_STAMP'] }}
                                        <span style="font-size:3vh;"></span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                            <p class="mb-0"  style="font-size: 12px;">~</p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>


        <div class="row mt-4">
            <div class="col-lg-12 mb-lg-4 mb-4 ">
                <div class="card z-index-2 h-100 ">
                    <div class="card-header pb-0 pt-3 bg-transparent row">
                        <div class="col-6 text-start">
                            <h6 class="text-capitalize">Serial Number</h6>

                        </div>
                        <div class="col-6 text-end">
                            {{-- <button id="getStamp" value="STAMP" class="btn btn-success">STAMP</button> --}}
                            {{-- <button id="getNotStamp" value="NOTSTAMP" class="btn btn-primary">Not STAMP</button> --}}
                        </div>

                    </div>
                    <div class="card-body m-2 p-3 mb-2">
                            {{-- TODO tabel serial  --}}
                            <table id="TebelSerial" class="table align-items-center">
                                <thead>
                                    <tr>
                                        <th>By</th>
                                        {{-- <th>SERIALNUMBER</th> --}}
                                        <th>STATUS</th>
                                        <th>File</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>




            <div class="col-lg-12 mb-lg-4 mb-4 ">
                <div class="card z-index-2 h-100 ">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Overview of stamp</h6>
                        {{-- <p class="text-sm mb-0">
                            <i class="fa fa-arrow-up text-success"></i>
                            <span class="font-weight-bold">4% more</span> in 2021
                        </p> --}}
                    </div>
                    <div class="card-body p-0 mb-0">
                        <div class="table-responsive">
                            <table class="table align-items-center ">
                                <tbody>
                                    @foreach ($datas['STAMPTING'] as $stemp)
                                    <tr>
                                        <td class="w-30">
                                            <div class="d-flex px-3 py-1 mb-0 align-items-center">
                                                <div>
                                                    <i class="fa fa-file-pdf"></i>
                                                </div>
                                                <div class="ms-4">
                                                    <p class="text-xs font-weight-bold mb-0">File Name:</p>
                                                    <h6 class="text-sm mb-0">{{ $stemp->filename }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">Stemp date:</p>
                                                <p class="text-xs font-weight-bold mb-0">{{ $stemp->updated_at->format('d/m/Y') }}</p>
                                                {{-- <h6 class="text-sm mb-0">{{ $stemp->updated_at->format('d/m/Y') }}</h6> --}}
                                            </div>
                                        </td>
                                        <td class="align-middle text-sm">
                                            <div class="col text-center">
                                                <p class="text-xs font-weight-bold mb-0">Status:</p>
                                                <span class="badge badge-sm min-vw-20 bg-gradient-success">{{ $stemp->certificatelevel }}</span>
                                            </div>
                                        </td>
                                    </tr>    
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer pb-0 pt-3 bg-transparent">
                        {{ $datas['STAMPTING']->links() }}    
                    </div>
                </div>
            </div>
            <div class="col-lg-12 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Overview of stamp process</h6>
                        {{-- <p class="text-sm mb-0">
                            <i class="fa fa-arrow-up text-success"></i>
                            <span class="font-weight-bold">4% more</span> in 2021
                        </p> --}}
                    </div>
                    <div class="card-body p-0 mb-0">
                        <div class="table-responsive">
                            <table class="table align-items-center ">
                                <tbody>
                                    @foreach ($datas['NOT_STAMPTING'] as $stemp)
                                    <tr>
                                        <td class="w-30">
                                            <div class="d-flex px-2 py-1 mb-0 align-items-center">
                                                <div>
                                                    <i class="fa fa-file-pdf"></i>
                                                </div>
                                                <div class="ms-4 w-100" id="data-{{$stemp->id}}">
                                                    <p class="text-xs font-weight-bold mb-0">File Name:</p>
                                                    <h6 class="text-sm mb-0">{{ $stemp->filename }}</h6>
                                                    <div class="text-xs font-weight-bold mb-0">
                                                        @switch($stemp->certificatelevel)
                                                            @case('NOT_CERTIFIED')
                                                                <span class="badge badge-sm min-vw-20 bg-gradient-light">NOT CERTIFIED</span>
                                                                @break
                                                            @case('FAILUR')
                                                                <span class="badge badge-sm min-vw-20 bg-gradient-danger">{{ $stemp->certificatelevel }}</span>
                                                                @break
                                                            @case('INPROGRESS')
                                                                <span class="badge badge-sm min-vw-20 bg-gradient-info">{{ $stemp->certificatelevel }}</span>
                                                                @break    
                                                                @default
                                                                <span class="badge badge-sm min-vw-20 bg-gradient-success">{{ $stemp->certificatelevel }}</span>
                                                        @endswitch
                                                        <span class="float-end" style="font-size: smaller !important; bottom: -9px;">
                                                            {{ $stemp->updated_at->format('d/m/Y H:i:s') }} 
                                                            <i class="fas fa-clock"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>    
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer row">
                        {{ $datas['NOT_STAMPTING']->onEachSide(0)->links()}}    
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>
    @endsection
    
    {{-- {{ config('sign-adapter.API_CHECK_SERIAL_NUMBER') }} --}}

@push('js')
        <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/autofill/2.6.0/js/dataTables.autoFill.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
        <script>
            $( document ).ready(function() {
                let ststusSN = 'stamp';
                //?start=0&length=10&status=NOTSTAMP&notEncrypt=true
                let url = '{{route("checkDaftarSerial")}}';
                var tableSerial = $('#TebelSerial').DataTable( {
                        // deferLoading: 1,
                        // dom: '<"top"i>rt<"bottom"><"clear">',
                        // order: [[5, 'desc']],
                        searchDelay: 500,
                        processing: true,
                        serverSide: true,
                        dom: '<"row"<"col-sm-4"l><"col-sm-4"B><"col-sm-4"f> > <"table-responsive"rt> <"bottom"ip><"clear">',
                        ajax: {
                            url: url,
                            dataType: "json",
                            type: "GET",                  
                        }, 
                        buttons:[
                            //{
                                // text: 'Reload',
                                // className: 'btn btn-secondary',
                                // action: function ( e, dt, node, config ) {
                                //     dt.ajax.reload();
                                // }
                            //},
                            {
                                text: 'STAMP',
                                className: 'btn btn-success',
                                action: function ( e, dt, node, config ) {
                                    dt.ajax.url(url+"?status=STAMP").load();
                                }
                            },
                            {
                                text: 'NOTSTAMP',
                                className: 'btn btn-primary',
                                action: function ( e, dt, node, config ) {
                                    dt.ajax.url(url+"?status=NOTSTAMP").load();
                                }
                            }
                        ],
                        columnDefs:[{
                            orderable: false,
                            targets: ['all']
                        }
                        ],
                        columns: [
                            { data: 'user'},
                            // { data: 'serialnumber'},
                            { data: 'status'},
                            { data: 'file'},
                            { data: 'tgl'},
                        ],                        
                    });
                    tableSerial.buttons().container()
                    .appendTo( $('.col-sm-6:eq(0)', tableSerial.table().container() ) );
                    $('#getStamp').on('click', function(e){
                        tableSerial.ajax.url(url+"?status=STAMP").load();
                        ststusSN = 'STAMP';
                    });
                    $('#getNotStamp').on('click', function(e){
                        tableSerial.ajax.url(url+"?status=NOTSTAMP").load();
                        ststusSN = 'NOTSTAMP';
                    }); 
            });
        </script>
        @endpush

