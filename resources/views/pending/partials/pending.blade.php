<article data-presentation-card class="presentation-card">
    <div class="presentation-card-media">
        @include('home.partials.img')
        @include('home.partials.icons')
    </div>
    <div class="presentation-card-body">
        @include('home.partials.title')
        <div class="presentation-card-metadata">
            @include('home.partials.presenters')
            @include('home.partials.studyadmin')
            @include('home.partials.courses')
        </div>
        @include('home.partials.description')
        @include('pending.partials.progress')
    </div>
</article>
