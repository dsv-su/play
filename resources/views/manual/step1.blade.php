@extends('layouts.suplay_upload')
@section('content')
    <div class="container">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                Fel på inmatningen!.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
            <div class="row">
            <h2>Manuell uppladdning - steg 2</h2>
            </div>
            <br>
            <div class="row">
                <div>
                    <div class="icon">4</div>
                    <br>
                    <h4 class="title">Generera en miniatyr (thumb)</h4>
                    <p class="description">
                        Generera en miniatyr (thumb) för visning av presentationen på webbsidan.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="card mb-3" style="max-width: 640px;">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            @if($thumb == null)
                                <svg class="bd-placeholder-img" width="100%" height="250" xmlns="http://www.w3.org/2000/svg" aria-label="Placeholder: Image" preserveAspectRatio="xMidYMid slice" role="img"><title>Placeholder</title><rect width="100%" height="100%" fill="#868e96"/><text x="50%" y="50%" fill="#dee2e6" dy=".3em">Ingen bild</text></svg>
                            @else
                                <img id="thumb" class="bd-placeholder-img" width="100%" height="250" src="{{'/storage/'.$local.'/image/primary_thumb'.$id.'.png'}}">
                            @endif

                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">Titel: {{$title}}</h5>
                                <form method="post" action="{{route('gen_thumb', $id)}}">
                                    @csrf
                                <p class="card-text">Längd på primärvideo: {{ $durationInSeconds }} sek.</p>
                                <p class="card-text"><small class="text-muted">Antalet sekunder in i videon:</small></p>
                                    <input type="number" name="seconds"  min="1" max="{{$durationInSeconds}}">
                                    @if($thumb == null)
                                    <button type="submit" class="btn btn-primary btn-sm">Generera</button>
                                    @else
                                        <button type="submit" class="btn btn-primary btn-sm">Regenerera</button>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($thumb != null)
                <div class="row">
                    <div>
                        <div class="icon">5</div>
                        <br>
                        <h4 class="title">Generera en affisch (poster) för varje video</h4>
                        <p class="description">
                            En affisch har skapats för varje uppladdad video. Affischen används av spelaren.
                        </p>
                    </div>
                </div>
                <div class="row">
                @foreach($sources as $source)
                    <div class="card" style="width: 18rem;">
                        @if($thumb == null)
                        <svg class="bd-placeholder-img card-img-top" width="100%" height="180" xmlns="http://www.w3.org/2000/svg" aria-label="Placeholder: Image cap" preserveAspectRatio="xMidYMid slice" role="img"><title>Placeholder</title><rect width="100%" height="100%" fill="#868e96"/><text x="50%" y="50%" fill="#dee2e6" dy=".3em">Ingen bild</text></svg>
                        @else
                            <img class="bd-placeholder-img" width="100%" height="180" src="{{'/storage/'.$local.'/image/poster_'.($loop->index+1).'.png'}}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">Poster {{($loop->index+1)}}</h5>
                            <form method="post" action="{{route('gen_poster', $id)}}">
                                @csrf
                                <p class="card-text">Längd på primärvideo: {{ $durationInSeconds }} sek.</p>
                                <p class="card-text"><small class="text-muted">Antalet sekunder in i videon:</small></p>
                                <input type="number" name="seconds"  min="1" max="{{$durationInSeconds}}">
                                <input type="hidden" name="poster"  value="{{($loop->index+1)}}">
                                <button type="submit" class="btn btn-primary btn-sm">Regenerera</button>
                            </form>
                        </div>
                    </div>

                @endforeach
                </div>
                <br>

                <a href="{{route('manual_step3', $id)}}" role="button" class="btn btn-primary btn-lg float-right">Nästa <i class="fas fa-forward"></i></a>
            @endif
    </div>

    <script>

    </script>

@endsection

