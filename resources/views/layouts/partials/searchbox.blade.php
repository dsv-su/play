<!-- Flash Message section -->
@if(session()->has('message'))
    <div class="container align-self-center">
        <div class="alert @if (session('success')) alert-success @elseif (session('warning')) alert-warning @elseif (session('error')) alert-danger @else alert-info @endif">
            {{ session('message') }}
        </div>
    </div>
@endif

<!-- Search box section -->
<div class="container align-self-center">
    <form class="form-inline form-main-search d-flex justify-content-between"
          id="header-main-search-form" name="header-main-search-form"
          action="/search" method="GET" data-search="/s%C3%B6k"
          role="search">
        @csrf
        <label for="header-main-search-text" class="sr-only">{{ __("Search") }}</label>
        <input class="form-control w-100 mx-auto" type="search"
               id="header-main-search-text" name="q" autocomplete="off"
               aria-haspopup="true"
               placeholder="{{ __("Search") }}"
               @if (isset($q)) value="{{$q}}" @endif
               aria-labelledby="header-main-search-form">
    </form>
</div>

<script>
    $('#header-main-search-form').on('submit', function(e){
        e.preventDefault();
        window.location.href = '/search/' + $('#header-main-search-text').val();
    });
</script>