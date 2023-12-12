@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Dashboard'])
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
                                    <p class="mb-0" style="font-size: 12px;">
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
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
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

            
        </div>
        <div class="row mt-4">
            <div class="col-lg-12 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                    <div class="row mb-0">
                        <div class="col-md-9 mb-0">     
                                <h6 class="text-capitalize">User overview</h6>
                        </div>
                        <div class="col-md-3 mb-0 ">
                            <div class="dropdown dropdown-menu-end mb-0">
                                <button class="btn btn-primarys btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                  Select By 
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                  <li>
                                    <a class="dropdown-item" href="{{ route('home') }}?active=true">Active</a>
                                  </li>
                                  <li>
                                    <a class="dropdown-item" href="{{ route('home') }}?active=false">Non Active</a>
                                  </li>
                                  <li><hr class="dropdown-divider"></li>
                                  <li><a class="dropdown-item" href="{{ route('home') }}">Show All Users </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="card-body p-3">
                        
                        <div class="table-responsive">
                            <table class="table table-default">
                                <tbody>
                                    <tr>
                                        <th>User</th>
                                        <th>Email</th>
                                        <th>Service Account</th>
                                    </tr>
                                    @foreach ($users as $no => $s)
                                    <tr class="">
                                        <td>
                                            @if($s->active == 0 )
                                            <span class="text-danger">
                                                <i class="fas fa-shield-halved"></i> {{$s->username}} 
                                            </span>
                                            @else
                                            {{$s->username}}
                                            @endif
                                            
                                            
                                        </td>
                                        <td>
                                            @if($s->active == 0 )
                                            <span class="text-danger">
                                                {{$s->email}} 
                                            </span>
                                            @else
                                                {{$s->email}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($s->active == 1 )
                                                @if($s->pemungut->p_user==null)
                                                <a href="{{route('users.show',$s->id)}}" class="btn btn-sm btn-dark">Setting Account</a>
                                                @else
                                                    {{ $s->pemungut->p_user }}
                                                @endif
                                            @else
                                                <a href="{{route('users.edit',$s->id)}}" class="btn btn-sm btn-danger">User Non Active</a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                   
                                </tbody>
                            </table>
                            {{-- {{ $users->links() }} --}}
                            {{ $users->appends(request()->input())->links() }}
                        </div>
                        
                        {{-- <div class="chart">
                            <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
                        </div> --}}
                    </div>
                </div>
            </div>
                             
            {{--  --}}
            {{-- <div class="col-lg-5">
                <div class="card card-carousel overflow-hidden h-100 p-0">
                    <div id="carouselExampleCaptions" class="carousel slide h-100" data-bs-ride="carousel">
                        <div class="carousel-inner border-radius-lg h-100">
                            <div class="carousel-item h-100 active" style="background-image: url('./img/carousel-1.jpg');
            background-size: cover;">
                                <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                                    <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                                        <i class="ni ni-camera-compact text-dark opacity-10"></i>
                                    </div>
                                    <h5 class="text-white mb-1">Get started with Argon</h5>
                                    <p>There’s nothing I really wanted to do in life that I wasn’t able to get good at.</p>
                                </div>
                            </div>
                            <div class="carousel-item h-100" style="background-image: url('./img/carousel-2.jpg');
            background-size: cover;">
                                <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                                    <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                                        <i class="ni ni-bulb-61 text-dark opacity-10"></i>
                                    </div>
                                    <h5 class="text-white mb-1">Faster way to create web pages</h5>
                                    <p>That’s my skill. I’m not really specifically talented at anything except for the
                                        ability to learn.</p>
                                </div>
                            </div>
                            <div class="carousel-item h-100" style="background-image: url('./img/carousel-3.jpg');
            background-size: cover;">
                                <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                                    <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                                        <i class="ni ni-trophy text-dark opacity-10"></i>
                                    </div>
                                    <h5 class="text-white mb-1">Share with us your design tips!</h5>
                                    <p>Don’t be afraid to be wrong because you can’t learn anything from a compliment.</p>
                                </div>
                            </div>
                        </div>
                        <button class="carousel-control-prev w-5 me-3" type="button"
                            data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next w-5 me-3" type="button"
                            data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div> --}}
            {{--  --}}
        </div>
       
        {{-- @include('layouts.footers.auth.footer') --}}
    </div>
@endsection

@push('js')
    <script src="./assets/js/plugins/chartjs.min.js"></script>
    <script>
        var ctx1 = document.getElementById("chart-line").getContext("2d");

        var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

        // gradientStroke1.addColorStop(1, 'rgba(251, 99, 64, 0.2)');
        // gradientStroke1.addColorStop(0.2, 'rgba(251, 99, 64, 0.0)');
        // gradientStroke1.addColorStop(0, 'rgba(251, 99, 64, 0)');
        // new Chart(ctx1, {
        //     type: "line",
        //     data: {
        //         labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        //         datasets: [{
        //             label: "Mobile apps",
        //             tension: 0.4,
        //             borderWidth: 0,
        //             pointRadius: 0,
        //             borderColor: "#fb6340",
        //             backgroundColor: gradientStroke1,
        //             borderWidth: 3,
        //             fill: true,
        //             data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
        //             maxBarThickness: 6

        //         }],
        //     },
        //     options: {
        //         responsive: true,
        //         maintainAspectRatio: false,
        //         plugins: {
        //             legend: {
        //                 display: false,
        //             }
        //         },
        //         interaction: {
        //             intersect: false,
        //             mode: 'index',
        //         },
        //         scales: {
        //             y: {
        //                 grid: {
        //                     drawBorder: false,
        //                     display: true,
        //                     drawOnChartArea: true,
        //                     drawTicks: false,
        //                     borderDash: [5, 5]
        //                 },
        //                 ticks: {
        //                     display: true,
        //                     padding: 10,
        //                     color: '#fbfbfb',
        //                     font: {
        //                         size: 11,
        //                         family: "Open Sans",
        //                         style: 'normal',
        //                         lineHeight: 2
        //                     },
        //                 }
        //             },
        //             x: {
        //                 grid: {
        //                     drawBorder: false,
        //                     display: false,
        //                     drawOnChartArea: false,
        //                     drawTicks: false,
        //                     borderDash: [5, 5]
        //                 },
        //                 ticks: {
        //                     display: true,
        //                     color: '#ccc',
        //                     padding: 20,
        //                     font: {
        //                         size: 11,
        //                         family: "Open Sans",
        //                         style: 'normal',
        //                         lineHeight: 2
        //                     },
        //                 }
        //             },
        //         },
        //     },
        // });
    </script>
@endpush
