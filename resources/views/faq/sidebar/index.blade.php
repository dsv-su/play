<nav class="su-background__light navbar navbar-inverse fixed-top" id="sidebar-wrapper">
    <ul class="nav sidebar-nav"  role="tablist">
        <div class="sidebar-header">
            <div class="sidebar-title">
                <a href="#">{{__("Other subjects")}}</a>
            </div>
        </div>
        <li><a wire:click="start" style="cursor: pointer;">{{__("Overview")}}</a></li>
        <li class="dropdown">
            <a href="#play" class="dropdown-toggle" data-toggle="dropdown">DSVPlay <span class="caret"></span></a>
            <ul class="dropdown-menu su-background__light" role="menu">
                <li><a wire:click="wiplay" style="cursor: pointer;@if($wiplay) color:blue; font-weight: bolder;@endif">{{__("What is DSVPlay?")}}</a></li>
                <li><a wire:click="language" style="cursor: pointer;@if($language) color:blue; font-weight: bolder;@endif">{{__("Language")}}</a></li>
                <li><a wire:click="rap" style="cursor: pointer;@if($rap) color:blue; font-weight: bolder;@endif">{{__("Roles and permissions")}}</a></li>
            </ul>
        </li>
        <li><a wire:click="navigate" style="cursor: pointer;@if($navigate) color:blue; font-weight: bolder;@endif">{{__("Navigate")}}</a></li>
        <li><a wire:click="player" style="cursor: pointer;@if($player) color:blue; font-weight: bolder;@endif">{{__("The player")}}</a></li>
        <li><a wire:click="upload" style="cursor: pointer;@if($upload) color:blue; font-weight: bolder; @endif">{{__("Upload")}}</a></li>
        <!--
        <li><a wire:click="download" style="cursor: pointer;">{{__("Download")}}</a></li>
        <li><a href="#search">{{__("Search")}}</a></li>
        -->

        <!-- Manage for staff -->
        @if($role_staff)
        <li class="dropdown">
            <a href="#manage" class="dropdown-toggle" data-toggle="dropdown">{{__("Manage")}}<span class="caret"></span></a>
            <ul class="dropdown-menu animated fadeInLeft" role="menu">
                <li><a wire:click="manage_presentations" style="cursor: pointer;@if($manage_presentations) color:blue; font-weight: bolder;@endif">{{__("Manage presentations")}}</a></li>
                <li><a wire:click="edit" style="cursor: pointer;@if($edit) color:blue; font-weight: bolder;@endif">{{__("Edit presentation")}}</a></li>
                <li><a wire:click="manage_courses" style="cursor: pointer;@if($manage_courses) color:blue; font-weight: bolder;@endif">{{__("Manage courses")}}</a></li>
            </ul>
        </li>
        @endif

        <!-- For Admins -->
        @if($role_admin)
        <li class="dropdown">
            <a href="#admin" class="dropdown-toggle" data-toggle="dropdown">Administrator <span class="caret"></span></a>
            <ul class="dropdown-menu animated fadeInLeft" role="menu">
                <li><a href="#stats">Statistics and settings</a></li>
                <li><a href="#logs">Logs</a></li>
                <li><a href="#sync">Sync items from Mediasite</a></li>
                <li><a href="#retrive">Retrive from Mediasite</a></li>
            </ul>
        </li>
        @endif

        @if(Lang::locale() == 'swe')
            <li><a target="_blank" rel="noopener noreferrer" href="https://releasenotes.blogs.dsv.su.se/archives/category/play">{{__("Release notes")}}</a></li>
        @else
            <li><a target="_blank" rel="noopener noreferrer" href="https://releasenotes.blogs.dsv.su.se/en/archives/category/play-en">{{__("Release notes")}}</a></li>
        @endif

    </ul>
</nav>
