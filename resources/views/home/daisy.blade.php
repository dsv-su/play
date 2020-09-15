@extends('layouts.dsvplay')
@section('content')

<div class="wrapper">
    <!-- Top section -->
    <section class="top_section">
        <!-- Navigation bar -->
        <header class="page-header">
            <h1>
                <a href="{{route('home')}}" class="logo"><img src="{{asset('./images/su_logo_play.png')}}" alt="Stockholms universitet">
                    <div class="logotext"> Play&nbsp;<i class="fas fa-play"></i></div>
                </a>
            </h1>
            <div class="buttons clear">
                <ul>
                    <li>
                        <a href="#profile" class="menu-button">
                            <span class="hidden-at-start">Profil</span>
                            <span class="inner">
						            <span class="closed-state" style="top: 0; opacity: 1;">
							            <i class="far fa-user fa-lg"></i>
						            </span>
					            </span>
                            <span class="inner open">
						            <span class="open-state" style="top: -20px; opacity: 0;">
							            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17"><path fill="#585858" d="M17 2.1L14.9 0 8.5 6.4 2.1 0 0 2.1l6.4 6.4L0 14.9 2.1 17l6.4-6.4 6.4 6.4 2.1-2.1-6.4-6.4z"></path></svg>
						            </span>
					            </span>
                        </a>
                    </li>
                    <li>
                        <a href="#manage" class="menu-button">
                            <span class="hidden-at-start">Hantera uppspelning</span>
                            <span class="inner">
						            <span class="closed-state" style="top: 0; opacity: 1;">
							            <i class="far fa-file-video"></i>
                                        <span>Redigera</span>
							            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="4" viewBox="0 0 8 4"><path fill="#5A595A" d="M0 0l4 4 4-4z"></path><path fill="#585858" d="M0 0l4 4 4-4z"></path></svg>
						            </span>
					            </span>
                            <span class="inner open">
						            <span class="open-state" style="top: -20px; opacity: 0;">
							            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17"><path fill="#585858" d="M17 2.1L14.9 0 8.5 6.4 2.1 0 0 2.1l6.4 6.4L0 14.9 2.1 17l6.4-6.4 6.4 6.4 2.1-2.1-6.4-6.4z"></path></svg>
						            </span>
					            </span>
                        </a>
                    </li>
                    <li>
                        <a href="#nav-menu" class="menu-button main">
                            <span class="hidden-at-start">Meny</span>
                            <span class="inner">
                                    <span class="closed-state" style="top: 0; opacity: 1;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="17" viewBox="0 0 22 17"><g fill="#0000ff"><path d="M0 0h22v3H0zM0 7h22v3H0zM0 14h22v3H0z"></path></g></svg>
                                    </span>
					            </span>
                            <span class="inner open">
						            <span class="open-state" style="top: -20px; opacity: 0;">
							            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17"><path fill="#0000ff" d="M17 2.1L14.9 0 8.5 6.4 2.1 0 0 2.1l6.4 6.4L0 14.9 2.1 17l6.4-6.4 6.4 6.4 2.1-2.1-6.4-6.4z"></path></svg>
						            </span>
					            </span>
                        </a>
                    </li>
                </ul>
            </div>

            <nav class="nav-menu board no-flicker" id="nav-menu" style="opacity: 0; margin-top: 0; height: 0;">
                <div class="inner">
                    <h2 class="hidden-at-start">Main menu</h2>
                    <ul>
                        <li><a class="menu-item current" href="/">Hem</a></li>
                    </ul>

                    <nav class="navmenu panel animated">
                        <a href="#"><span class="triangle-origin">Avdelning 1 </span></a>
                        <a href="#"><span class="triangle-origin">Avdelning 2 </span></a>
                        <a href="#"><span class="triangle-origin">Avdelning 3 </span></a>
                        <a href="#"><span class="triangle-origin">Avdelning 4 </span></a>
                        <a href="#"><span class="triangle-origin">Avdelning 5 </span></a>
                        <a href="#"><span class="triangle-origin">Avdelning 6 </span></a>

                        <hr>
                        <a href="#"><span class="triangle-origin">Forskning</span></a>
                        <a href="#"><span class="triangle-origin">Samverkan</span></a>
                        <hr>
                        <a href="#" class="no-panel"><span class="triangle-origin">Kategori</span></a>
                        <!-- Avdelning 1 -->
                        <article class="panel">
                            <div class="column">
                                <section class="titled-group">
                                    @foreach($daisys as $daisy)
                                    <header>{{$daisy}}</header>
                                    <a href="#">kurs ht2020</a>
                                    <a href="#">kurs ht2020</a>
                                    <a href="#">[Alla]</a>
                                    @endforeach
                                </section>
                                <section class="titled-group">
                                    <header>VT 2020</header>
                                    <a href="#">kurs vt2020</a>
                                    <a href="#">kurs vt2020</a>
                                    <a href="#">kurs vt2020</a>
                                    <a href="#">[Alla]</a>
                                </section>
                            </div>
                            <div class="column">
                                <section class="titled-group">
                                    <header>HT 2019</header>
                                    <a href="#">kurs ht2019</a>
                                    <a href="#">kurs ht2019</a>
                                    <a href="#">kurs ht2019</a>
                                    <a href="#">[Alla]</a>
                                </section>
                                <section class="titled-group">
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
                        <!-- Avdelning 2 -->
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
                        <!-- Avdelning 3 -->
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
                        <!-- Avdelning 4 -->
                        <article class=panel>
                            <div class=column>
                                <section class=titled-group>
                                    <header>A4HT 2020</header>
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
                        <!-- Avdelning 5 -->
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
                        <!-- Avdelning 6 -->
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

                        <!-- Forskning -->
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
                        <!-- Samverkan -->
                        <article class="panel">
                            <div class="column">
                                <section class="titled-group">
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
                        <article class="panel">
                            @foreach( $categories->chunk(3) as $chunk)
                                <div class="column">
                                    <section class="titled-group">
                                        @foreach( $chunk as $cat)
                                            <header>K{{$cat->category_name}}</header>
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

            </nav>

            <nav class="manage-menu board no-flicker" id="manage" style="opacity: 0; margin-top: 0; height: 0;">
                <div class="inner">
                    <h2>Actions</h2>
                    <ul>
                        <li><a class="menu-item" href="#" >Hantera uppspelning</a></li>
                        <li><a class="menu-item" href="{{ route('mediasite') }}" >Retrive from Mediasite</a></li>
                    </ul>
                </div>
            </nav>

            <section class="profile board no-flicker" id="profile" style="opacity: 0; margin-top: 0; height: 0;">
                <div class="inner">
                    <h2 class="hidden-at-start">Profil</h2>

                    <div class="empty-profile">Logga in via SU</div>
                </div>
            </section>

            <div class="menu-bg" style="height: 0;"><div class="bg-inner" style="background: none 0 0 / auto repeat scroll padding-box border-box rgb(249, 249, 249);"></div></div>

        </header>

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
<div style="margin: auto;padding-top: 20px;">


<form action="{{ route('search') }}" method="POST">
    @csrf
    <input type="text" name="query" />
    <input type="submit" value="Search" />
</form>
    <div class="container">
        <div>
            <div>
                <div>
                    <div>Daisy output</div>

                    <div>

                        <table>
                            <thead>
                            <tr>
                                <th>Video</th>
                                <th>Category</th>
                                <th>Course</th>
                                <th>Added on</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($daisys as $daisy)
                                <tr>
                                    <td>{{ $daisy }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

@endsection
