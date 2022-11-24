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
                <li><a wire:click="wiplay" style="cursor: pointer;">{{__("What is DSVPlay?")}}</a></li>
                <li><a wire:click="language" style="cursor: pointer;">{{__("Language")}}</a></li>
                <li><a wire:click="rap" style="cursor: pointer;">{{__("Roles and permissions")}}</a></li>
            </ul>
        </li>
        <li><a wire:click="navigate" style="cursor: pointer;">{{__("Navigate")}}</a></li>
        <li><a wire:click="player" style="cursor: pointer;">{{__("The player")}}</a></li>
        <li><a wire:click="upload" style="cursor: pointer;">{{__("Upload")}}</a></li>
        <li><a wire:click="download" style="cursor: pointer;">{{__("Download")}}</a></li>
        <!--
        <li><a href="#search">{{__("Search")}}</a></li>
        -->

        <!-- Manage for staff -->
        @if($role_staff)
        <li class="dropdown">
            <a href="#manage" class="dropdown-toggle" data-toggle="dropdown">{{__("Manage")}}<span class="caret"></span></a>
            <ul class="dropdown-menu animated fadeInLeft" role="menu">
                <li><a href="#presentations">{{__("Manage presentations")}}</a></li>
                <li><a href="#courses">{{__("Manage courses")}}</a></li>
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
        <li><a href="#admin"></a></li>


    </ul>
</nav>
