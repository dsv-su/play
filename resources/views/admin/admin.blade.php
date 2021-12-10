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
                            <h1 class="h3 mb-0 text-gray-800">Stats are cached</h1>
                            <a role="button" class="btn btn-outline-primary" href="{{route('admin_flush')}}"><i class="fas fa-redo"></i> Refresh</a>
                        </div>

                        <!-- Content Row -->
                        <div class="row">
                            <div class=" col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <a href="{{route('uploads')}}">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Uploads</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><small>Init:</small>{{$init_uploads}} <small>Pending:</small>{{$pending_uploads}} <small>Stored:</small>{{$stored_uploads}}</div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-upload fa-2x text-color-grey"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <div class=" col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <a href="{{route('downloads')}}">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Downloads</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><small>Requested: </small>{{$requested_downloads}}| <small>Stored: </small>{{$stored_downloads}}</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-download fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Cattura
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><small>Origin: </small>{{$stats_cattura}}</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-video fa-2x text-color-grey"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class=" col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <a href="{{route('mediasite_admin')}}">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Mediasite
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><small>Origin: </small>{{$stats_mediasite}}| <small>Folders: </small>{{$stats_mediasite_folders}}|</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-video fa-2x text-color-grey"></i>
                                            </div>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                            </div>

                            <div class=" col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Manual
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><small>Origin: </small>{{$stats_manual}}</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-video fa-2x text-color-grey"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class=" col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Presentations</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><small>Total: </small>{{app()->make('total_videos')}}</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-play fa-2x text-gray-300"></i>
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
                                                <a class="dropdown-item" href="{{route('videopermission')}}">Modify presentation</a>
                                                <a class="dropdown-item" href="{{route('add_permission')}}">Modify or Add permission</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Permissions</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><small>Set Permissions: </small>{{$stats_permissions}}| <small>Students and Staff (DSV): </small>{{$stats_permissions_dsv}}| <small>Staff (DSV): </small>{{$stats_permissions_staff}}| <small>Public: </small>{{$stats_permissions_public}}| <small>Private: </small>{{$stats_permissions_private}}|</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-hand-point-right fa-2x text-gray-300"></i>
                                            </div>
                                        </div>

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
                                                <a class="dropdown-item" href="{{route('playboot')}}">2018-2022</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <div class="mt-4 text-center small">
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-secondary"></i> {{$courses_2015}}(2015)
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-secondary"></i> {{$courses_2016}}(2016)
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-secondary"></i> {{$courses_2017}}(2017)
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-secondary"></i> {{$courses_2018}}(2018)
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-secondary"></i> {{$courses_2019}}(2019)
                                        </span>
                                            <span class="mr-2">
                                            <i class="fas fa-circle text-secondary"></i> {{$courses_2020}}(2020)
                                        </span>
                                            <span class="mr-2">
                                            <i class="fas fa-circle text-secondary"></i> {{$courses_2021}}(2021)
                                        </span>
                                            <span class="mr-2">
                                            <i class="fas fa-circle text-secondary"></i> {{$courses_2022}}(2022)
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
