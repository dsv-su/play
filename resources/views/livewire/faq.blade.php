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
            <!-- Edit presentation -->
            @if($edit)
                @include('faq.edit')
            @endif
            <!-- Download -->
            @if($download)
                @include('faq.download')
            @endif
            <!-- Manage presentation -->
            @if($manage_presentations)
                @include('faq.manage_presentations')
            @endif
            <!-- Manage courses -->
            @if($manage_courses)
                @include('faq.manage_courses')
            @endif
            <!-- Edit course -->
            @if($edit_course)
                @include('faq.edit_course')
            @endif
            <!-- Search Semester -->
            @if($semester)
                @include('faq.semester')
            @endif
            <!-- Search Course -->
            @if($designation)
                @include('faq.designation')
            @endif
            <!-- Conversion queue -->
            @if($queue)
                @include('faq.queue')
            @endif
            <!-- Logs -->
            @if($logs)
                @include('faq.logs')
            @endif

            @if($admin)
            <article class="main-article webb2021-article main-column-left js-anchor-links-headers-container col-12 col-lg-8 main-column-padding-right">


            </article>
            @endif

            <div class="webb2021-article-info">
                <p>{{__("Last updated:")}} 2023-06-13</p>
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
