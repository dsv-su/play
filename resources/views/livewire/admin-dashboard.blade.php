<div>
    <div class="grey-bg container-fluid">
        <section id="external-api" class="tab-content">
            <div class="row">
                <div class="col-12 mt-3 mb-1">
                    <h4 class="text-uppercase">External API statuses</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-center">
                                        <!-- Play Store -->
                                        @if($store_status)
                                            <i class="fas fa-plug"></i>
                                        @else
                                            Offline
                                        @endif
                                    </div>
                                    <div class="media-body text-right">
                                        <h4>
                                            <span
                                                @if($store_status)
                                                class="badge badge-success"
                                                @else
                                                class="badge badge-danger"
                                                            @endif>
                                                    Play-store
                                            </span>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-center">
                                        <!-- Daisy DB-->
                                        @if($daisy_status)
                                            <i class="fas fa-plug"></i>
                                        @else
                                            Offline
                                        @endif
                                    </div>
                                    <div class="media-body text-right">
                                        <h4>
                                            <span
                                                @if($daisy_status)
                                                class="badge badge-success"
                                                @else
                                                class="badge badge-danger"
                                                @endif>
                                                Daisy DB
                                            </span>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-center">
                                        <!-- Daisy API -->
                                        @if($daisy_ok_status)
                                            <i class="fas fa-plug"></i>
                                        @else
                                            Offline
                                        @endif

                                    </div>
                                    <div class="media-body text-right">
                                        <h4><span
                                                @if($daisy_ok_status)
                                                class="badge badge-success"
                                                @else
                                                class="badge badge-danger"
                                                @endif>
                                                Daisy
                                            </span>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-center">
                                        <i class="fas fa-plug"></i>
                                    </div>
                                    <div class="media-body text-right">
                                        <h4><span class="badge badge-success">N/A</span></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cattura -->
            <div class="row" wire:poll.30s="checkStats">
                <div class="col-12 mt-3 mb-1">
                    <h4 class="text-uppercase">Cattura recorders</h4>
                </div>

                @foreach($cattura as $key => $unit)

                    <div class="col-xl-3 col-sm-6 col-12">
                        <a href="{{$unit['url']}}">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="align-self-center">
                                                @if($unit['status'] == 'CHECKING')
                                                    @include('layouts.partials.pulse_spinner')
                                                @elseif($unit['status'] == 'ERROR')
                                                    <span style="color:red;"><i class="fas fa-video-slash"></i></span>
                                                @elseif($unit['status'] == 'IDLE')
                                                    <i class="fas fa-video-slash"></i>
                                                @else
                                                    <i class="fas fa-video"></i>
                                                @endif

                                            </div>

                                            <div class="media-body text-right">
                                                <h4>
                                                <span
                                                    @if($unit['status'] == 'CHECKING')
                                                    class="badge badge-warning"
                                                    @elseif($unit['status'] == 'ERROR')
                                                    class="badge badge-danger"
                                                    @elseif($unit['status'] == 'IDLE')
                                                    class="badge badge-warning"
                                                    @else
                                                    class="badge badge-success"
                                                    @endif>
                                                    {{$unit['recorder']}} {{$unit['status']}}
                                                </span>
                                                </h4>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @if($loop->index == 3)
            </div>
            <p></p>
            <div class="row" wire:poll.30s="checkStats">
                @endif
                @endforeach

            </div>
        </section>
        <section id="stats">
            <!-- Stats -->
            <div class="row">
                <div class="col-12 mt-3 mb-1">
                    <h4 class="text-uppercase">Stats</h4>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="media-body text-left">
                                        <h2><span style="color:blue;">{{$stats_mediasite}}</span></h2>
                                    </div>
                                    <div class="media-body text-right">
                                        <h4><span>Mediasite presentations</span></h4>
                                    </div>
                                </div>
                                <div class="progress mt-1 mb-0" style="height: 7px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{$percent_mediasite}}%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div><small>{{round($percent_mediasite, 0)}}%</small></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="media-body text-left">
                                        <h2><span style="color:blue;">{{$stats_mediasite_folders}}</span></h2>
                                    </div>
                                    <div class="media-body text-right">
                                        <h4><span>Mediasite folders</span></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="media-body text-left">
                                        <h2><span style="color:blue;">{{$this->stats_cattura}}</span></h2>
                                    </div>
                                    <div class="media-body text-right">
                                        <h4><span>Cattura presentations</span></h4>
                                    </div>
                                </div>
                                <div class="progress mt-1 mb-0" style="height: 7px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{$this->percent_cattura}}%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div><small>{{round($this->percent_cattura, 0)}}%</small></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="media-body text-left">
                                        <h2><span style="color:blue;">{{$stats_manual}}</span></h2>
                                    </div>
                                    <div class="media-body text-right">
                                        <h4><span>Manual presentations</span></h4>
                                    </div>
                                </div>
                                <div class="progress mt-1 mb-0" style="height: 7px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{$percent_manual}}%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div><small>{{round($percent_manual, 0)}}%</small></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course stats -->
            <div class="row">
                <div class="col-12 mt-3 mb-1">
                    <h4 class="text-uppercase">Courses</h4>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="media-body text-left">
                                        <h2><span style="color:blue;">{{$courses_2022}}</span></h2>
                                    </div>
                                    <div class="media-body text-right">
                                        <h4><span>2022</span></h4>
                                    </div>
                                </div>
                                <div class="progress mt-1 mb-0" style="height: 7px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{$percent_courses_2022}}%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div><small>{{round($percent_courses_2022, 0)}}%</small></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="media-body text-left">
                                        <h2><span style="color:blue;"> {{$courses_2021}}</span></h2>
                                    </div>
                                    <div class="media-body text-right">
                                        <h4><span>2021</span></h4>
                                    </div>
                                </div>
                                <div class="progress mt-1 mb-0" style="height: 7px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{$percent_courses_2021}}%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div><small>{{round($percent_courses_2021, 0)}}%</small></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="media-body text-left">
                                        <h2><span style="color:blue;"> {{$courses_2020}}</span></h2>
                                    </div>
                                    <div class="media-body text-right">
                                        <h4><span>2020</span></h4>
                                    </div>
                                </div>
                                <div class="progress mt-1 mb-0" style="height: 7px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{$percent_courses_2020}}%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div><small>{{round($percent_courses_2020, 0)}}%</small></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="media-body text-left">
                                        <h2><span style="color:blue;"> {{$courses_2019}}</span></h2>
                                    </div>
                                    <div class="media-body text-right">
                                        <h4><span>2019</span></h4>
                                    </div>
                                </div>
                                <div class="progress mt-1 mb-0" style="height: 7px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{$percent_courses_2019}}%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div><small>{{round($percent_courses_2019, 0)}}%</small></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="actions">
            <div class="row">
                <div class="col-12 mt-3 mb-1">
                    <h4 class="text-uppercase">Manage</h4>
                </div>

                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card border">
                        <div class="card-content">
                            <div class="card-body">
                                {{--}}<h6 class="media-body text-right">Init: {{$init_uploads}}</h6>{{--}}
                                <h6 class="media-body text-right">Pending: {{$pending_uploads}}</h6>
                                <h6 class="media-body text-right">Sent: {{$sent_uploads}}</h6>
                                {{--}}<h6 class="media-body text-right">Stored: {{$stored_uploads}}</h6>{{--}}
                                <a href="{{route('uploads')}}" class="btn btn-outline-primary">
                                    <div class="media d-flex">
                                        <div class="media-body text-left">
                                            <h2 class="primary">{{$total_uploads}}</h2>
                                            <div class="align-self-center">
                                                <span>Manage Uploads</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card border">
                        <div class="card-content">
                            <div class="card-body">
                                <h6 class="media-body text-right">Requested: {{$requested_downloads}}</h6>
                                <h6 class="media-body text-right">Stored: {{$stored_downloads}}</h6>
                                <a href="{{route('downloads')}}" class="btn btn-outline-primary">
                                    <div class="media d-flex">
                                        <div class="media-body text-left">
                                            <h2 class="primary">{{$total_downloads}}</h2>
                                            <div class="align-self-center">
                                                <span>Manage Downloads</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card border">
                        <div class="card-content">
                            <div class="card-body">
                                <h6 class="media-body text-right">Presentations: {{$stats_mediasite}}</h6>
                                <h6 class="media-body text-right">Folders: {{$stats_mediasite_folders}}</h6>
                                <a href="{{route('mediasite_admin')}}" class="btn btn-outline-primary">
                                    <div class="media d-flex">
                                        <div class="media-body text-left">
                                            <h2 class="primary">{{$stats_mediasite}}</h2>
                                            <div class="align-self-center">
                                                <span>Manage Mediasite</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="permissions">
            <div class="row">
                <div class="col-12 mt-3 mb-1">
                    <h4 class="text-uppercase">Group Permissions</h4>
                </div>
            </div>
            <div class="row">
                <!-- Permission stats -->
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="media-body text-left">
                                        <h2><span style="color:blue;">{{$stats_permissions_dsv}}</span></h2>
                                    </div>
                                    <div class="media-body text-right">
                                        <h4>Students and Staff</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="media-body text-left">
                                        <h2><span style="color:blue;">{{$stats_permissions_staff}}</span></h2>
                                    </div>
                                    <div class="media-body text-right">
                                        <h4><span>DSV Staff</span></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="media-body text-left">
                                        <h2><span style="color:blue;">{{$stats_permissions_public}}</span></h2>
                                    </div>
                                    <div class="media-body text-right">
                                        <h4><span>Public</span></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="media-body text-left">
                                        <h2><span style="color:blue;">{{$stats_permissions_private}}</span></h2>
                                    </div>
                                    <div class="media-body text-right">
                                        <h4><span>Custom</span></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <p></p>
            <!-- Group permission actions -->
            <div class="row">
                <div class="col-xl-6 col-md-12">
                    <div class="card border">
                        <div class="card-content">
                            <div class="card-body">
                                <a href="{{route('add_permission')}}" class="btn btn-outline-primary">
                                    <div class="media d-flex">
                                        <div class="media-body text-left">
                                            <h2 class="primary">{{$stats_permissions}}<small> set</small></h2>
                                            <div class="align-self-center">
                                                <span>Manage Group Permissions</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{route('videopermission')}}" class="btn btn-outline-primary">
                                    <div class="media d-flex">
                                        <div class="media-body text-left">
                                            <h2 class="primary">{{$total_set}}</h2>
                                            <div class="align-self-center">
                                                <span>Presentation Permissions</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </section>
        <section id="backup">
            <div class="row">
                <div class="col-12 mt-3 mb-1">
                    <h4 class="text-uppercase">Backup</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6 col-md-12">
                    <div class="card overflow-hidden">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">JSON Backup ({{ $json_files }})</div>
                                    </div>
                                    <div class="col-auto">
                                        <a role="button" class="btn btn-outline-info" href="{{route('backup_json')}}"><i class="far fa-hdd"></i> Create json</a>
                                        <a role="button" class="btn btn-outline-danger"  href="{{route('reload_json')}}"><i class="far fa-hdd"></i> Reload json</a>
                                        <a role="button" class="btn btn-outline-info" href="{{route('download_json')}}"><i class="far fa-hdd"></i> Download</a>
                                    </div>
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><small>Note! This is mainly only for use during development. Reloading json notifications should only be done when db restored (empty). </small></div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-12">
                    <div class="card overflow-hidden">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">DB Backup</div>
                                    </div>
                                    <div class="col-auto">
                                        <a role="button" class="btn btn-outline-primary" href="{{route('backup_db')}}"><i class="far fa-hdd"></i> Backup</a>
                                        <a role="button" class="btn btn-outline-primary" href="{{route('restore_db')}}"><i class="far fa-hdd"></i> Restore</a>
                                    </div>
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><small>This feature is under development.</small></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <p>-</p>
    </div>

</div>
