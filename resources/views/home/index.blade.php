@extends('layouts.dsvplay')
@section('content')

    <div class="wrapper">

        <!--Header-->
        <section class="top_section">

            <!-- Navigation bar -->
            <nav class="navbar">
                <div class="logo-container">
                    <a href="{{route('home')}}" class="logo">Play</a>
                </div>

                <ul class="main-nav" id="js-menu">
                    <li>
                        <a href="{{route('list')}}" class="nav-links">[Lista alla]</a>
                    </li>
                    <li>
                         <i class="navbar-toggle fas fa-bars" id="js-navbar-toggle"></i>
                    </li>
                    <li>
                        <a href="#" class="nav-links"><i class="far fa-file-video"></i> Hantera uppspelning</a>
                    </li>
                    <li>
                        <a href="#" class="nav-links"><i class="far fa-file-alt"></i> Manual</a>
                    </li>
                    <li>
                        <div class="nav-links"><i class="far fa-user"></i> {{$play_user}}</div>
                    </li>
                </ul>
            </nav>
            <!-- Search -->
            <div class="search_header">
                <div class="navbutton">
                    <input id="navmenu_toggle" type="checkbox" name="navmenu-open" class="hidden">
                    <label class="navmenu toggle" for="navmenu_toggle" accesskey="1">
                        <header><span class="heavy">&#x2630;</span> Navigera <i class="fas fa-sort-down"></i></header>
                    </label>
                    <div class="hide-at-start-wrapper">
                        <nav class="navmenu panel animated">
                            <a href="#"><span class="triangle-origin">Avdelning 1</span></a>
                            <a href="#"><span class="triangle-origin">Avdelning 2</span></a>
                            <a href="#"><span class="triangle-origin">Avdelning 3</span></a>
                            <a href="#"><span class="triangle-origin">Avdelning 4</span></a>
                            <a href="#"><span class="triangle-origin">Avdelning 5</span></a>
                            <a href="#"><span class="triangle-origin">Avdelning 6</span></a>
                            <a href="#"><span class="triangle-origin">Avdelning 7</span></a>
                            <hr>
                            <a href="#"><span class=triangle-origin>Forskning</span></a>
                            <a href="#"><span class=triangle-origin>Samverkan</span></a>
                            <hr>
                            <a class=no-panel href="#">Kategori</a>

                            <article class=panel>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>HT 2020</header>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>VT 2020</header>
                                        <a href="#">kurs vt2020</a>
                                        <a href="#">kurs vt2020</a>
                                        <a href="#">kurs vt2020</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                </div>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>HT 2019</header>
                                        <a href="#">kurs ht2019</a>
                                        <a href="#">kurs ht2019</a>
                                        <a href="#">kurs ht2019</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>VT 2019</header>
                                        <a href="#">kurs vt2019</a>
                                        <a href="#">kurs vt2019</a>
                                        <a href="#">kurs vt2019</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                </div>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>HT 2018</header>
                                        <a href="#">kurs ht2018</a>
                                        <a href="#">kurs ht2018</a>
                                        <a href="#">kurs ht2018</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>VT 2018</header>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                </div>

                            </article>

                            <article class=panel>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>HT 2020</header>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>

                                        <a href="#">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>VT 2020</header>
                                        <a href="#">kurs vt2020</a>
                                        <a href="#">kurs vt2020</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                </div>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>HT 2019</header>
                                        <a href="#">kurs ht2019</a>
                                        <a href="#">kurs ht2019</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>VT 2019</header>
                                        <a href="#">kurs vt2019</a>
                                        <a href="#">kurs vt2019</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                </div>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>HT 2018</header>
                                        <a href="#">kurs ht2018</a>
                                        <a href="#">kurs ht2018</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>VT 2018</header>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                </div>
                            </article>
                            <article class=panel>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>HT 2020</header>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>VT 2020</header>
                                        <a href="#">kurs vt2020</a>
                                        <a href="#">kurs vt2020</a>
                                        <a href="#">kurs vt2020</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                </div>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>HT 2019</header>
                                        <a href="#">kurs ht2019</a>
                                        <a href="#">kurs ht2019</a>
                                        <a href="#">kurs ht2019</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>VT 2019</header>
                                        <a href="#">kurs vt2019</a>
                                        <a href="#">kurs vt2019</a>
                                        <a href="#">kurs vt2019</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                </div>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>HT 2018</header>
                                        <a href="#">kurs ht2018</a>
                                        <a href="#">kurs ht2018</a>
                                        <a href="#">kurs ht2018</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>VT 2018</header>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                </div>
                            </article>
                            <article class=panel>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>HT 2020</header>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>

                                        <a href="#">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>VT 2020</header>
                                        <a href="#">kurs vt2020</a>
                                        <a href="#">kurs vt2020</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                </div>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>HT 2019</header>
                                        <a href="#">kurs ht2019</a>
                                        <a href="#">kurs ht2019</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>VT 2019</header>
                                        <a href="#">kurs vt2019</a>
                                        <a href="#">kurs vt2019</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                </div>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>HT 2018</header>
                                        <a href="#">kurs ht2018</a>
                                        <a href="#">kurs ht2018</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>VT 2018</header>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                </div>
                            </article>
                            <article class=panel>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>HT 2020</header>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>

                                        <a href="#">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>VT 2020</header>
                                        <a href="#">kurs vt2020</a>
                                        <a href="#">kurs vt2020</a>
                                        <a href="#">kurs vt2020</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                </div>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>HT 2019</header>
                                        <a href="#">kurs ht2019</a>
                                        <a href="#">kurs ht2019</a>
                                        <a href="#">kurs ht2019</a>
                                        <a href="#">kurs ht2019</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>VT 2019</header>
                                        <a href="#">kurs vt2019</a>
                                        <a href="#">kurs vt2019</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                </div>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>HT 2018</header>
                                        <a href="#">kurs ht2018</a>
                                        <a href="#">kurs ht2018</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>VT 2018</header>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                </div>
                            </article>
                            <article class=panel>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>HT 2020</header>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>

                                        <a href="#">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>VT 2020</header>
                                        <a href="#">kurs vt2020</a>
                                        <a href="#">kurs vt2020</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                </div>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>HT 2019</header>
                                        <a href="#">kurs ht2019</a>
                                        <a href="#">kurs ht2019</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>VT 2019</header>
                                        <a href="#">kurs vt2019</a>
                                        <a href="#">kurs vt2019</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                </div>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>HT 2018</header>
                                        <a href="#">kurs ht2018</a>
                                        <a href="#">kurs ht2018</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>VT 2018</header>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                </div>
                            </article>
                            <article class=panel>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>HT 2020</header>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>

                                        <a href="#">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>VT 2020</header>
                                        <a href="#">kurs vt2020</a>
                                        <a href="#">kurs vt2020</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                </div>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>HT 2019</header>
                                        <a href="#">kurs ht2019</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>VT 2019</header>
                                        <a href="#">kurs vt2019</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                </div>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>HT 2018</header>
                                        <a href="#">kurs ht2018</a>
                                        <a href="#">kurs ht2018</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>VT 2018</header>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                </div>
                            </article>
                            <article class=panel>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>Forskning 1</header>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>

                                        <a href="#">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>Forskning 2</header>
                                        <a href="#">kurs vt2020</a>
                                        <a href="#">kurs vt2020</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                </div>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>Forskning 3</header>
                                        <a href="#">kurs ht2019</a>
                                        <a href="#">kurs ht2019</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>Forskning 4</header>
                                        <a href="#">kurs vt2019</a>
                                        <a href="#">kurs vt2019</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                </div>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>Forskning 5</header>
                                        <a href="#">kurs ht2018</a>
                                        <a href="#">kurs ht2018</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>Forskning 6</header>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                </div>
                            </article>
                            <article class=panel>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>Samverkan 1</header>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">kurs ht2020</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>Samverkan 2</header>
                                        <a href="#">kurs vt2020</a>
                                        <a href="#">kurs vt2020</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                </div>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>Samverkan 3</header>
                                        <a href="#">kurs ht2019</a>
                                        <a href="#">kurs ht2019</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>Samverkan 4</header>
                                        <a href="#">kurs vt2019</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                </div>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>Samverkan 5</header>
                                        <a href="#">kurs ht2018</a>
                                        <a href="#">kurs ht2018</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>Samverkan 6</header>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">[Alla]</a>
                                    </section>
                                </div>
                            </article>
                            <!--Categories-->
                            <article class=panel>
                                @foreach( $categories->chunk(3) as $chunk)
                                <div class=column>
                                    <section class=titled-group>
                                        @foreach( $chunk as $cat)
                                        <header>{{$cat->category_name}}</header>
                                        <a href="#">Kurser ht2020</a>
                                        <a href="#">Kurser vt2020</a>
                                        <a href="#">Kurser ht2019</a>
                                        <a href="#">Kurser vt2019</a>
                                        <a href="#">[Alla]</a>
                                        @endforeach
                                    </section>
                                </div>
                                @endforeach
                            </article>

                        </nav>
                    </div>
                </div>
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
