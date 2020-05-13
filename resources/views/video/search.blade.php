<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><b>{{ $searchResults->count() }} resultat för: "{{ request('query') }}"</b></div>

                <div class="card-body">

                    @foreach($searchResults->groupByType() as $type => $modelSearchResults)
                        <h2>{{ ucfirst($type) }}</h2>

                        @foreach($modelSearchResults as $searchResult)
                            <ul>
                                <li><a href="{{ $searchResult->url }}">{{ $searchResult->title }}</a></li>
                            </ul>
                        @endforeach
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
