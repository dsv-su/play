@extends('layouts.dsvplay')
@section('content')
    <div class="wrapper">
        <!--Header-->
        <section class="top_section">
            <!-- Navigation bar -->
            <nav class="navbar">
                <div class="logo-container">
                    <a href="{{route('home')}}" class="tracking-in-contract-bck logo">Play</a>
                </div>

                <ul class="main-nav" id="js-menu">
                    <li>
                        <a href="{{route('list')}}" class="nav-links">[Lista alla]</a>
                    </li>
                    <li>
                         <i class="navbar-toggle fas fa-bars" id="js-navbar-toggle"></i>
                    </li>
                    <li>
                        <a href="#" class="nav-links">Hantera uppspelning</a>
                    </li>
                    <li>
                        <a href="#" class="nav-links">Manual</a>
                    </li>
                    <li>
                        <div class="nav-links">{{$play_user}}</div>
                    </li>
                </ul>
            </nav>
            <!-- Search -->
            <div class="search_header">

                <div class="con-tooltip top">

                        <form class="search-form"  action="{{ route('search') }}" method="POST" >
                        @csrf
                    <div class="tooltip">
                        <p>Filtrera din sökning</p>
                    </div>
                    <div class="searchtext">
                        <input type="text" name="query" placeholder="Sök" class="search-input" autocomplete="off">
                    </div>


                    <button type="submit" class="search-button">
                        <i class="fas fa-search"></i>
                    </button>
                    <div class="search-option">
                        <div>
                            <input name="type" type="radio" value="type-lectures" id="type-lectures">
                            <label for="type-lectures">
                                <i class="far fa-user"></i>
                                <span>Föreläsare</span>
                            </label>

                        </div>

                        <div>
                            <input name="type" type="radio" value="type-category" id="type-category">
                            <label for="type-category">
                                <i class="fas fa-broadcast-tower"></i>
                                <span>Kategori</span>
                            </label>
                        </div>
                        <div>
                            <input name="type" type="radio" value="type-course" id="type-course">
                            <label for="type-cource">
                                <i class="fas fa-book-open"></i>
                                <span>Kurser</span>
                            </label>
                        </div>
                        <div>
                            <input name="type" type="radio" value="type-latest" id="type-latest">
                            <label for="type-latest">
                                <i class="far fa-clock"></i>
                                <span>Senaste</span>
                            </label>
                        </div>
                    </div>

                </form>

                </div>
                <!-- -->
            </div>

        </section> <!--end Top section -->
        <!-- Search result -->
        <section class="content_section">
            @if ($search == 1)
                <div class="playlist_one">
                    <p class="playlist_title">{{ $searchResults->count() }} resultat för "{{ request('query') }}"</p>
                    @foreach($searchResults->groupByType() as $type => $modelSearchResults)
                        <p>under <strong>{{ ucfirst($type) }}</strong></p>
                    <br>
                    <div class="videos">

                            @foreach($modelSearchResults as $searchResult)
                                <div class="video" style="background-image: url({{$searchResult->searchable->image}})">
                                    <div class="title">{{ $searchResult->title }}</div>
                                    <a href="{{ $searchResult->url }}"><i class="fas fa-play-circle"></i></a>
                                    <p> {{$searchResult->searchable->length}} </p>
                                    <div class="footer">
                                        Title: {{$searchResult->title}}
                                    </div>
                                </div>

                            @endforeach
                        @endforeach

                    </div>
                </div>
            @elseif ($search == 2)
                @if($searchResults->count() != 0)
                <div class="playlist_one">
                    <p class="playlist_title">{{ $searchResults->count() }} resultat för "{{ request('query') }}"</p>
                    @foreach($searchResults->groupByType() as $type => $modelSearchResults)
                        <p>under <strong>{{ ucfirst($type) }}</strong></p>
                        <br>
                        <div class="videos">

                            @foreach($modelSearchResults as $searchResult)
                                <div class="video" style="background-image: url({{$searchResult->searchable->image}})">
                                    <div class="title">{{ $searchResult->title }}</div>
                                    <a href="{{ $searchResult->url }}"><i class="fas fa-play-circle"></i></a>
                                    <p> {{$searchResult->searchable->length}} </p>
                                    <div class="footer">
                                        Title: {{$searchResult->title}}
                                    </div>
                                </div>

                            @endforeach
                    @endforeach

                        </div>
                </div>

                <div class="space"></div>
                <div class="playlist_two">
                @else
                <div class="playlist_one">
                @endif
                    @if($searchCategoryRelations->count() !=0)
                    <p class="playlist_title">{{ $category_videos->count() }} resultat för "{{ request('query') }}"</p>
                    @foreach($searchCategoryRelations->groupByType() as $type => $modelSearchResults)
                        <p>under <strong>{{ ucfirst($type) }}</strong></p>
                        <br>
                        <div class="videos">

                            @foreach($category_videos as $searchResult)
                                <div class="video" style="background-image: url({{$searchResult->image}})">
                                    <div class="title">{{ $searchResult->title }}</div>
                                    <a href="{{ route('player', $searchResult->id) }}"><i class="fas fa-play-circle"></i></a>
                                    <p> {{$searchResult->length}} </p>
                                    <div class="footer">
                                        Title: {{$searchResult->title}}
                                    </div>
                                </div>

                            @endforeach
                    @endforeach

                        </div>
                    @endif
                </div>

                @if($searchResults->count() != 0 && $searchCategoryRelations->count() !=0)
                    <div class="spacelist"></div>
                    <div class="playlist_three">
                @elseif($searchResults->count() != 0 || $searchCategoryRelations->count() !=0)
                    <div class="space"></div>
                    <div class="playlist_two">
                @else
                    <div class="playlist_one">
                @endif
                        <p class="playlist_title">{{ $course_videos->count() }} resultat för "{{ request('query') }}"</p>
                        @foreach($searchCourseRelations->groupByType() as $type => $modelSearchResults)
                            <p>under <strong>{{ ucfirst($type) }}</strong></p>
                            <br>
                            <div class="videos">

                                @foreach($course_videos as $searchResult)
                                    <div class="video" style="background-image: url({{$searchResult->image}})">
                                        <div class="title">{{ $searchResult->title }}</div>
                                        <a href="{{ route('player', $searchResult->id) }}"><i class="fas fa-play-circle"></i></a>
                                        <p> {{$searchResult->length}} </p>
                                        <div class="footer">
                                            Title: {{$searchResult->title}}
                                        </div>
                                    </div>

                                @endforeach
                        @endforeach

                            </div>
                    </div>



            @elseif ($search == 3)
                <div class="playlist_one">
                    <p class="playlist_title">{{ $searchResults->count() }} resultat för "{{ request('query') }}"</p>
                    <br>
                    <div class="videos">

                        @foreach($searchResults as $searchResult)
                                <div class="video" style="background-image: url({{$searchResult->image}})">
                                    <div class="title">{{ $searchResult->title }}</div>
                                    <a href="{{ route('player', $searchResult->id) }}"><i class="fas fa-play-circle"></i></a>
                                    <p> {{$searchResult->length}} </p>
                                    <div class="footer">
                                        Title: {{$searchResult->title}}
                                    </div>
                                </div>

                        @endforeach

            @else
             <!-- Show latest -->
                <div class="playlist_one">
                    <h4 class="playlist_title">Senast uppladdade</h4>
                    <br>
                    <div class="videos">
                        @foreach ($latest as $video)
                        <div class="video" style="background-image: url({{ $video->image }})">
                            <div class="title">{{ $video->title }}</div>
                            <a href="{{ route('player', ['video' => $video]) }}"><i class="fas fa-play-circle"></i></a>
                            <p> {{$video->length}} </p>
                            <div class="footer">
                                Kurs: {{$video->course->course_name}} {{$video->course->semester}} {{$video->course->year}}
                                <br>
                                Kategori: {{$video->category->category_name}}
                            </div>
                        </div>

                        @endforeach
                    </div>

                </div>
            @endif
        </section> <!-- End content -->
    </div> <!-- end Wrapper -->


@endsection
