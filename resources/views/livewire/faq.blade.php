<div>
    <div id="wrapper" @if($toggle)class="toggled" @endif>

    @include('faq.sidebar.index')
    <!-- /#sidebar-wrapper -->

        <div id="faq-container">
            {{--}}
            <h1>{{$intended}}</h1>
            {{--}}

            <!-- Overview -->
            @if($start)
                @include('faq.start')
            @endif
            <!-- What is play -->
            @if($wiplay)
                @include('faq.wiplay')
            @endif
            <!-- Language -->
            @if($language)
                @include('faq.language')
            @endif
            <!-- Roles and permissions -->
            @if($rap)
                @include('faq.rap')
            @endif
            <!-- Navigate -->
            @if($navigate)
                @include('faq.navigate')
            @endif
            <!-- Player -->
            @if($player)
                @include('faq.player')
            @endif
            <!-- Upload -->
            @if($upload)
                @include('faq.upload')
            @endif
            <!-- Download -->
            @if($download)
                @include('faq.download')
            @endif

            @if($admin)
            <article class="main-article webb2021-article main-column-left js-anchor-links-headers-container col-12 col-lg-8 main-column-padding-right">


            </article>
            @endif

            <div class="webb2021-article-info">
                <p>{{__("Last updated:")}} 2022-11-22</p>
            </div>

        </div>
    </div>


</div>

<script>
    $(document).ready(function (e) {
        var trigger = $('.hamburger'),
            overlay = $('.overlay'),
            wrapper = $('#wrapper'),
            isClosed = false;
        hamburger_init();

        function hamburger_init() {
            //overlay.hide();
            trigger.removeClass('is-closed');
            trigger.addClass('is-open');
            //overlay.show();
            trigger.removeClass('is-closed');
            trigger.addClass('is-open');
            isClosed = true;
            wrapper.addClass('toggled');
            /*$('#wrapper').toggleClass('toggled');*/
        }
    });

</script>
