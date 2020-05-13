@extends('layouts.dsvplay')
@section('content')
<div class="wrapper">
    <!--Header-->
    <section class="top_section">
        <nav class="navbar">
                        <span class="navbar-toggle" id="js-navbar-toggle">
                                <i class="fas fa-bars"></i>
                            </span>
            <a href="#" class="logo">DSVPlay</a>
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
                    <div class="button_wrapper">
                        <button class="button_round">Senaste</button>
                        <button class="button_round">Kategori</button>
                        <button class="button_round">Kurs</button>
                        <button class="button_round">Föreläsare</button>
                    </div>
        </div>
        <header>
            <div class="search_wrapper">
                <form action="{{ route('search') }}" method="POST">
                    @csrf
                    <div class="search-icon"><i class="fas fa-search"></i></div>
                    <input class="search" name="query" placeholder="Sök" type="text" >
                    <div class="clear-icon"><i class="far fa-times-circle"></i></div>
                </form>
            </div>
        </header>





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
                    <a href="player.html"><i class="fas fa-play-circle"></i></a>
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
