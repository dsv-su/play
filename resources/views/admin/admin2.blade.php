@extends('layouts.suplay')
@section('content')
    <div class="container">
        <!-- Page Wrapper -->
        <div id="wrapper">

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <!-- Statusbar -->
                    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    @if(app()->make('store_status') == 'on')

                            <button type="button" class="btn btn-outline-primary">
                                <i class="fas fa-plug"></i> <span class="badge badge-success">Play-store</span>
                            </button>
                    @else
                            <button type="button" class="btn btn-outline-primary">
                                Offline <span class="badge badge-danger">Play-store</span>
                            </button>
                    @endif

                    @if(app()->make('daisy_db_status') == 'on')
                            <button type="button" class="btn btn-outline-primary">
                                <i class="fas fa-plug"></i> <span class="badge badge-success">Daisy DB</span>
                            </button>
                    @else
                            <button type="button" class="btn btn-outline-primary">
                                Offline <span class="badge badge-danger">Daisy DB</span>
                            </button>
                    @endif

                    @if(app()->make('daisy_ok_status') == 'on')
                            <button type="button" class="btn btn-outline-primary">
                                <i class="fas fa-plug"></i> <span class="badge badge-success">Daisy OK</span>
                            </button>
                        @else
                            <button type="button" class="btn btn-outline-primary">
                                Offline <span class="badge badge-danger">Daisy OK</span>
                            </button>
                    @endif

                   @foreach($cattura as $recorder)
                            <a href="{{$recorder['url']}}">
                                <button type="button" class="btn btn-outline-primary">
                                    @if(!$recorder['status'] == 'IDLE')
                                        <i class="fas fa-video"></i>
                                    @else
                                        <i class="fas fa-video-slash"></i>
                                    @endif
                                    {{$recorder['recorder']}} <span
                                        @if($recorder['status'] == 'ERROR') class="badge badge-danger"
                                        @elseif($recorder['status'] == 'IDLE') class="badge badge-warning"
                                        @else class="badge badge-success"
                            @endif >{{$recorder['status']}}</span>
                                </button>
                            </a>
                    @endforeach
                        <!-- Statusbar -->
                    </nav>
                    <!-- End of Statusbar -->

                    <!-- Begin Page Content -->
                    <div class="container-fluid">

                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">DSVPlay Stats</h1>
                        </div>

                        <!-- Content Row -->
                        <div class="row">

                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Uploads</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$uploads}}</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-upload fa-2x text-color-grey"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Downloads</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">NN</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-download fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Cattura
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">NN</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-video fa-2x text-color-grey"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Presentations</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{app()->make('total_videos')}}</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-comments fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Content Row -->

                        <div class="row">

                            <!-- Permissions -->
                            <div class="col-xl-8 col-lg-7">
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Dropdown -->
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Permission management</h6>
                                        <div class="dropdown no-arrow">
                                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                                 aria-labelledby="dropdownMenuLink">
                                                <div class="dropdown-header">Permissions:</div>
                                                <a class="dropdown-item" href="#">Modify presentation</a>
                                                <a class="dropdown-item" href="#">Modify or Add permission</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <button type="button" class="btn btn-outline-primary">Modify presentation</button>
                                        <button type="button" class="btn btn-outline-primary">Modify or Add</button>

                                    </div>
                                </div>
                            </div>

                            <!-- Course stats -->
                            <div class="col-xl-4 col-lg-5">
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Dropdown -->
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Courses</h6>
                                        <div class="dropdown no-arrow">
                                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                                 aria-labelledby="dropdownMenuLink">
                                                <div class="dropdown-header">Reload courses</div>
                                                <a class="dropdown-item" href="{{route('playboot')}}">2018-2021</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <div class="mt-4 text-center small">
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-secondary"></i> 2018
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-success"></i> 2019
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-info"></i> 2020
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-primary"></i> 2021
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->

            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#top-spacer">
            <i class="fas fa-angle-up"></i>
        </a>

    </div>

@endsection
