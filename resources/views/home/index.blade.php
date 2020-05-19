@extends('layouts.dsvplay')
@section('content')
    <div class="wrapper">
        <!--Header-->
        <section class="top_section">
            <nav class="navbar">
                        <span class="navbar-toggle" id="js-navbar-toggle">
                                <i class="fas fa-bars"></i>
                            </span>
                <a href="#" class="logo">Play</a>
                <ul class="main-nav" id="js-menu">
                    <li>
                        <a href="#" class="nav-links">Ladda upp</a>
                    </li>
                    <li>
                        <a href="#" class="nav-links">Hantera uppspelning</a>
                    </li>
                    <li>
                        <a href="#" class="nav-links">Manual</a>
                    </li>
                    <li>
                        <div class="nav-links">UserFirstname UserLastname</div>
                    </li>
                </ul>
            </nav>

            <div class="search_header">
                <h2>Startsida</h2>
                <!-- -->
                <form class="search-form" action="{{ route('search') }}" method="POST" >
                    @csrf
                    <input type="search" name="query" placeholder="Sök" class="search-input">
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

                <!-- -->
            </div>

        </section> <!--end Top section -->
        <!-- Content -->
        <section class="content_section">
            @if ($search == 1)
                <div class="playlist_one">
                    <h4 class="playlist_title">{{ $searchResults->count() }} resultat för "{{ request('query') }}"</h4>
                    <br>
                    <div class="videos">

                        @foreach($searchResults->groupByType() as $type => $modelSearchResults)
                            <h4 class="playlist_title">{{ ucfirst($type) }}</h4>

                            @foreach($modelSearchResults as $searchResult)
                                <div class="video" style="background-image: url(//vjs.zencdn.net/v/oceans.png)">
                                    <div class="title">{{ $searchResult->title }}</div>
                                    <a href="{{ $searchResult->url }}"><i class="fas fa-play-circle"></i></a>
                                    <p> 00:47 </p>
                                    <div class="footer">
                                        Kategori: {{$type}}
                                        <br>
                                        Title: {{$searchResult->title}}
                                    </div>
                                </div>

                            @endforeach
                        @endforeach

                    </div>
                </div>

            @else
                <div class="playlist_one">
                    <h4 class="playlist_title">Senast uppladdade</h4>
                    <br>
                    <div class="videos">
                        <div class="video" style="background-image: url(//vjs.zencdn.net/v/oceans.png)">
                            <div class="title">Oceans testvideo</div>
                            <a href="{{ route('player', $video_id=1) }}"><i class="fas fa-play-circle"></i></a>
                            <p> 00:47 </p>
                            <div class="footer">
                                Kategori: Test
                                <br>
                                Title: Testvideo
                            </div>
                        </div>
                        <div class="video" style="background-image: url(//vjs.zencdn.net/v/oceans.png)">
                            <div class="title">Oceans testvideo</div>
                            <i class="fas fa-play-circle"></i>
                            <p> 00:47 </p>
                            <div class="footer">
                                Kategori: Test
                                <br>
                                Title: Testvideo
                            </div>
                        </div>
                        <div class="video" style="background-image: url(//vjs.zencdn.net/v/oceans.png)">
                            <div class="title">Oceans testvideo</div>
                            <i class="fas fa-play-circle"></i>
                            <p> 00:47 </p>
                            <div class="footer">
                                Kategori: Test
                                <br>
                                Title: Testvideo
                            </div>
                        </div>
                        <div class="video" style="background-image: url(//vjs.zencdn.net/v/oceans.png)">
                            <div class="title">Oceans testvideo</div>
                            <i class="fas fa-play-circle"></i>
                            <p> 00:47 </p>
                            <div class="footer">
                                Kategori: Test
                                <br>
                                Title: Testvideo
                            </div>
                        </div>
                        <div class="video" style="background-image: url(//vjs.zencdn.net/v/oceans.png)">
                            <div class="title">Oceans testvideo</div>
                            <i class="fas fa-play-circle"></i>
                            <p> 00:47 </p>
                            <div class="footer">
                                Kategori: Test
                                <br>
                                Title: Testvideo
                            </div>
                        </div>
                        <div class="video" style="background-image: url(//vjs.zencdn.net/v/oceans.png)">
                            <div class="title">Oceans testvideo</div>
                            <i class="fas fa-play-circle"></i>
                            <p> 00:47 </p>
                            <div class="footer">
                                Kategori: Test
                                <br>
                                Title: Testvideo
                            </div>
                        </div>
                        <div class="video" style="background-image: url(//vjs.zencdn.net/v/oceans.png)">
                            <div class="title">Oceans testvideo</div>
                            <i class="fas fa-play-circle"></i>
                            <p> 00:47 </p>
                            <div class="footer">
                                Kategori: Test
                                <br>
                                Title: Testvideo
                            </div>
                        </div>
                        <div class="video" style="background-image: url(//vjs.zencdn.net/v/oceans.png)">
                            <div class="title">Oceans testvideo</div>
                            <i class="fas fa-play-circle"></i>
                            <p> 00:47 </p>
                            <div class="footer">
                                Kategori: Test
                                <br>
                                Title: Testvideo
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </section> <!-- End content -->
    </div> <!-- end Wrapper -->


@endsection
