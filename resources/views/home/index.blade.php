@extends('layouts.dsvplay')
@section('content')

    <div class="wrapper">
        <!-- Top section -->
        <section class="top_section">
            <!-- Navigation bar -->
            <header class="page-header">

                <h1>
                    <a href="{{route('home')}}" class="logo"><img src="{{asset('./images/su_logo_play.png')}}"
                                                                  alt="Stockholms universitet">
                        <div class="logotext">DSVPlay&nbsp;</div>
                        <div class="svglogo">
                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 60 60" style="enable-background:new 0 0 60 60;" xml:space="preserve">
                                <g>
                                    <path fill="#fff" d="M45.563,29.174l-22-15c-0.307-0.208-0.703-0.231-1.031-0.058C22.205,14.289,22,14.629,22,15v30
                                        c0,0.371,0.205,0.711,0.533,0.884C22.679,45.962,22.84,46,23,46c0.197,0,0.394-0.059,0.563-0.174l22-15
                                        C45.836,30.64,46,30.331,46,30S45.836,29.36,45.563,29.174z M24,43.107V16.893L43.225,30L24,43.107z"/>
                                    <path fill="#fff" d="M30,0C13.458,0,0,13.458,0,30s13.458,30,30,30s30-13.458,30-30S46.542,0,30,0z M30,58C14.561,58,2,45.439,2,30
                                        S14.561,2,30,2s28,12.561,28,28S45.439,58,30,58z"/>
                                </g>
                            </svg>
                        </div>
                    </a>

                </h1>
                <div class="buttons clear">
                    <ul>
                        <li>
                            <a href="#manage" class="menu-button">
                                <span class="hidden-at-start">Hantera uppspelning</span>
                                <span class="inner">
						            <span class="closed-state" style="top: 0; opacity: 1;">
							            <i class="far fa-file-video fa-lg"></i>
                                        <span>Redigera</span>
							            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                             viewBox="0 0 8 4"><path fill="#5A595A" d="M0 0l4 4 4-4z"></path><path
                                                    fill="#585858" d="M0 0l4 4 4-4z"></path></svg>
						            </span>
					            </span>
                                <span class="inner open">
						            <span class="open-state" style="top: -20px; opacity: 0;">
							            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17"
                                             viewBox="0 0 17 17"><path fill="#585858"
                                                                       d="M17 2.1L14.9 0 8.5 6.4 2.1 0 0 2.1l6.4 6.4L0 14.9 2.1 17l6.4-6.4 6.4 6.4 2.1-2.1-6.4-6.4z"></path></svg>
						            </span>
					            </span>
                            </a>
                        </li>
                        <li>
                            <a href="#nav-menu" class="menu-button main">
                                <span class="hidden-at-start">Meny</span>
                                <span class="inner">
                                    <span class="closed-state" style="top: 0; opacity: 1;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="19"
                                             viewBox="0 0 22 17"><g fill="#0000ff"><path
                                                        d="M0 0h22v3H0zM0 7h22v3H0zM0 14h22v3H0z"></path></g></svg>
                                    </span>
					            </span>
                                <span class="inner open">
						            <span class="open-state" style="top: -20px; opacity: 0;">
							            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17"
                                             viewBox="0 0 17 17"><path fill="#0000ff"
                                                                       d="M17 2.1L14.9 0 8.5 6.4 2.1 0 0 2.1l6.4 6.4L0 14.9 2.1 17l6.4-6.4 6.4 6.4 2.1-2.1-6.4-6.4z"></path></svg>
						            </span>
					            </span>
                            </a>
                        </li>
                    </ul>

                </div>
                <span class="username">{{$play_user ?? 'Not logged in'}}</span>
                <!-- -->
                <nav class="manage-menu board no-flicker" id="manage" style="opacity: 0; margin-top: 0; height: 0;">
                    <div class="inner">
                        <h2>Actions</h2>
                        <ul>
                            <li><a class="menu-item" href="#">Hantera uppspelning</a></li>
                            <li><a class="menu-item" href="{{ route('mediasiteFetch') }}">Sync items from Mediasite</a>
                            </li>
                            <li><a class="menu-item" href="{{ route('mediasite') }}">Retrive from Mediasite</a></li>
                        </ul>
                    </div>
                </nav>
                <!-- -->
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
                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                    <section class="titled-group">
                                        <header>VT 2020</header>
                                        <a href="#">kurs vt2020</a>
                                        <a href="#">kurs vt2020</a>
                                        <a href="#">kurs vt2020</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                </div>
                                <div class="column">
                                    <section class="titled-group">
                                        <header>HT 2019</header>
                                        <a href="#">kurs ht2019</a>
                                        <a href="#">kurs ht2019</a>
                                        <a href="#">kurs ht2019</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                    <section class="titled-group">
                                        <header>VT 2019</header>
                                        <a href="#">kurs vt2019</a>
                                        <a href="#">kurs vt2019</a>
                                        <a href="#">kurs vt2019</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                </div>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>HT 2018</header>
                                        <a href="#">kurs ht2018</a>
                                        <a href="#">kurs ht2018</a>
                                        <a href="#">kurs ht2018</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>VT 2018</header>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
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

                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>VT 2020</header>
                                        <a href="#">kurs vt2020</a>
                                        <a href="#">kurs vt2020</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                </div>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>HT 2019</header>
                                        <a href="#">kurs ht2019</a>
                                        <a href="#">kurs ht2019</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>VT 2019</header>
                                        <a href="#">kurs vt2019</a>
                                        <a href="#">kurs vt2019</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                </div>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>HT 2018</header>
                                        <a href="#">kurs ht2018</a>
                                        <a href="#">kurs ht2018</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>VT 2018</header>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
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
                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>VT 2020</header>
                                        <a href="#">kurs vt2020</a>
                                        <a href="#">kurs vt2020</a>
                                        <a href="#">kurs vt2020</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                </div>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>HT 2019</header>
                                        <a href="#">kurs ht2019</a>
                                        <a href="#">kurs ht2019</a>
                                        <a href="#">kurs ht2019</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>VT 2019</header>
                                        <a href="#">kurs vt2019</a>
                                        <a href="#">kurs vt2019</a>
                                        <a href="#">kurs vt2019</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                </div>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>HT 2018</header>
                                        <a href="#">kurs ht2018</a>
                                        <a href="#">kurs ht2018</a>
                                        <a href="#">kurs ht2018</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>VT 2018</header>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
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

                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>VT 2020</header>
                                        <a href="#">kurs vt2020</a>
                                        <a href="#">kurs vt2020</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                </div>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>HT 2019</header>
                                        <a href="#">kurs ht2019</a>
                                        <a href="#">kurs ht2019</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>VT 2019</header>
                                        <a href="#">kurs vt2019</a>
                                        <a href="#">kurs vt2019</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                </div>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>HT 2018</header>
                                        <a href="#">kurs ht2018</a>
                                        <a href="#">kurs ht2018</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>VT 2018</header>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
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

                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>VT 2020</header>
                                        <a href="#">kurs vt2020</a>
                                        <a href="#">kurs vt2020</a>
                                        <a href="#">kurs vt2020</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                </div>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>HT 2019</header>
                                        <a href="#">kurs ht2019</a>
                                        <a href="#">kurs ht2019</a>
                                        <a href="#">kurs ht2019</a>
                                        <a href="#">kurs ht2019</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>VT 2019</header>
                                        <a href="#">kurs vt2019</a>
                                        <a href="#">kurs vt2019</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                </div>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>HT 2018</header>
                                        <a href="#">kurs ht2018</a>
                                        <a href="#">kurs ht2018</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>VT 2018</header>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
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

                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>VT 2020</header>
                                        <a href="#">kurs vt2020</a>
                                        <a href="#">kurs vt2020</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                </div>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>HT 2019</header>
                                        <a href="#">kurs ht2019</a>
                                        <a href="#">kurs ht2019</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>VT 2019</header>
                                        <a href="#">kurs vt2019</a>
                                        <a href="#">kurs vt2019</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                </div>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>HT 2018</header>
                                        <a href="#">kurs ht2018</a>
                                        <a href="#">kurs ht2018</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>VT 2018</header>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
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

                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>Forskning 2</header>
                                        <a href="#">kurs vt2020</a>
                                        <a href="#">kurs vt2020</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                </div>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>Forskning 3</header>
                                        <a href="#">kurs ht2019</a>
                                        <a href="#">kurs ht2019</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>Forskning 4</header>
                                        <a href="#">kurs vt2019</a>
                                        <a href="#">kurs vt2019</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                </div>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>Forskning 5</header>
                                        <a href="#">kurs ht2018</a>
                                        <a href="#">kurs ht2018</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>Forskning 6</header>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
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
                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>Samverkan 2</header>
                                        <a href="#">kurs vt2020</a>
                                        <a href="#">kurs vt2020</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                </div>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>Samverkan 3</header>
                                        <a href="#">kurs ht2019</a>
                                        <a href="#">kurs ht2019</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>Samverkan 4</header>
                                        <a href="#">kurs vt2019</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                </div>
                                <div class=column>
                                    <section class=titled-group>
                                        <header>Samverkan 5</header>
                                        <a href="#">kurs ht2018</a>
                                        <a href="#">kurs ht2018</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
                                    </section>
                                    <section class=titled-group>
                                        <header>Samverkan 6</header>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="#">kurs vt2018</a>
                                        <a href="{{ route('list') }}">[Alla]</a>
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
                                                <a href="{{ route('list') }}">[Alla]</a>
                                            @endforeach
                                        </section>
                                    </div>
                                @endforeach
                            </article>
                        </nav>
                    </div>

                </nav>
                <!-- -->
                <div class="menu-bg" style="height: 0;">
                    <div class="bg-inner"
                         style="background: none 0 0 / auto repeat scroll padding-box border-box rgb(249, 249, 249);"></div>
                </div>

            </header>

            <!-- Search -->
            <div class="search_header">

                <div class="con-tooltip">

                    <form class="search-form" action="{{ route('search') }}" method="POST">
                    @csrf
                    <!--
                            <div class="tooltip">
                                <p>Filtrera din sökning</p>
                            </div>
                            -->
                        <div class="searchtext">
                            <input type="text" id="query" name="query" placeholder="Sök" onfocus="changeOutput()"
                                   class="search-input" autocomplete="off">
                        </div>

                        <button type="submit" class="search-button">
                            <i class="fas fa-search"></i>
                        </button>


                        <div class="search-option">
                            <div id="filtrera" class="filtrera" style="color: blue">Filtrera din sökning</div>
                            <div class="filter">
                                <input name="type" type="radio" value="type-lectures" id="type-lectures"
                                       class="filter-radio">
                                <label for="type-lectures">
                                    <i class="far fa-user"></i>
                                    <span>Föreläsare</span>
                                </label>

                            </div>

                            <div class="filter">
                                <input name="type" type="radio" value="type-category" id="type-category"
                                       class="filter-radio">
                                <label for="type-category">
                                    <i class="fas fa-broadcast-tower"></i>
                                    <span>Kategori</span>
                                </label>
                            </div>
                            <div class="filter">
                                <input name="type" type="radio" value="type-course" id="type-course"
                                       class="filter-radio">
                                <label for="type-cource">
                                    <i class="fas fa-book-open"></i>
                                    <span>Kurser</span>
                                </label>
                            </div>
                            <div class="filter">
                                <input name="type" type="radio" value="type-latest" id="type-latest"
                                       class="filter-radio">
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
                                <div class="video"
                                     style="background-image: url({{ asset($searchResult->searchable->image)}})">
                                    <a href="{{ $searchResult->url }}">
                                        <div class="title">{{ $searchResult->title }}</div>
                                        <i class="fas fa-play-circle"></i>
                                        <p> {{$searchResult->searchable->length}} </p>
                                        <div class="footer">
                                            Title: {{$searchResult->title}}
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                            @endforeach
                        </div>
                </div>
            @elseif ($search == 2)
                @if($searchResults->count() != 0)
                    <div class="playlist_one">
                        <p class="playlist_title">{{ $searchResults->count() }} resultat för "{{ request('query') }}
                            "</p>
                        @foreach($searchResults->groupByType() as $type => $modelSearchResults)
                            <p class="playlist_title">under <strong>{{ ucfirst($type) }}</strong></p>
                            <br>
                            <div class="videos">
                                @foreach($modelSearchResults as $searchResult)
                                    <div class="video"
                                         style="background-image: url({{ asset($searchResult->searchable->image)}})">
                                        <a href="{{ $searchResult->url }}">
                                            <div class="title">{{ $searchResult->title }}</div>
                                            <i class="fas fa-play-circle"></i>
                                            <p> {{$searchResult->searchable->length}} </p>
                                            <div class="footer">
                                                Title: {{$searchResult->title}}
                                            </div>
                                        </a>
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
                                    <p class="playlist_title">{{ $category_videos->count() }} resultat för
                                        "{{ request('query') }}"</p>
                                    @foreach($searchCategoryRelations->groupByType() as $type => $modelSearchResults)
                                        <p class="playlist_title">under <strong>{{ ucfirst($type) }}</strong></p>
                                        <br>
                                        <div class="videos">
                                            @foreach($category_videos as $searchResult)
                                                <div class="video"
                                                     style="background-image: url({{ asset($searchResult->image)}})">
                                                    <a href="{{ route('player', $searchResult->id) }}">
                                                        <div class="title">{{ $searchResult->title }}</div>
                                                        <i class="fas fa-play-circle"></i>
                                                        <p> {{$searchResult->length}} </p>
                                                        <div class="footer">
                                                            Title: {{$searchResult->title}}
                                                        </div>
                                                    </a>
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
                                                    <p class="playlist_title">{{ $course_videos->count() }} resultat för
                                                        "{{ request('query') }}"</p>
                                                    @foreach($searchCourseRelations->groupByType() as $type => $modelSearchResults)
                                                        <p class="playlist_title">under
                                                            <strong>{{ ucfirst($type) }}</strong></p>
                                                        <br>
                                                        <div class="videos">

                                                            @foreach($course_videos as $searchResult)
                                                                <div class="video"
                                                                     style="background-image: url({{ asset($searchResult->image)}})">
                                                                    <a href="{{ route('player', $searchResult->id) }}">
                                                                        <div class="title">{{ $searchResult->title }}</div>
                                                                        <i class="fas fa-play-circle"></i>
                                                                        <p> {{$searchResult->length}} </p>
                                                                        <div class="footer">
                                                                            Title: {{$searchResult->title}}
                                                                        </div>
                                                                    </a>
                                                                </div>

                                                            @endforeach
                                                            @endforeach

                                                        </div>
                                                </div>

                                                @elseif ($search == 3)
                                                    <div class="playlist_one">
                                                        <p class="playlist_title">{{ $searchResults->count() }} resultat
                                                            för "{{ request('query') }}"</p>
                                                        <br>
                                                        <div class="videos">

                                                            @foreach($searchResults as $searchResult)
                                                                <div class="video"
                                                                     style="background-image: url({{ asset($searchResult->image)}})">
                                                                    <a href="{{ route('player', $searchResult->id) }}">
                                                                        <div class="title">{{ $searchResult->title }}</div>
                                                                        <i class="fas fa-play-circle"></i>
                                                                        <p> {{$searchResult->length}} </p>
                                                                        <div class="footer">
                                                                            Title: {{$searchResult->title}}
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                        @endforeach
                                                        @else
                                                            <!-- Show latest -->
                                                                <div class="playlist_one">
                                                                    <h4 class="playlist_title">Senast uppladdade</h4>
                                                                    <br>
                                                                    <div class="videos">
                                                                        @foreach ($latest as $video)
                                                                            <div class="video"
                                                                                 style="background-image: url({{ asset($video->image) }})">
                                                                                <a href="{{ route('player', ['video' => $video]) }}">
                                                                                    <div class="title">{{ $video->title }}</div>
                                                                                    <i class="fas fa-play-circle"></i>
                                                                                    <p> {{$video->length}} </p>
                                                                                </a>

                                                                                <div class="footer">
                                                                                    <a href="/course/{{$video->course->id}}">
                                                                                        Kurs: {{$video->course->course_name}} {{$video->course->semester}} {{$video->course->year}}
                                                                                        <br>
                                                                                        Kategori: {{$video->category->category_name}}
                                                                                    </a>
                                                                                </div>

                                                                            </div>

                                                                        @endforeach
                                                                    </div>

                                                                </div>
                @endif
        </section> <!-- End content -->
    </div> <!-- end Wrapper -->

@endsection
