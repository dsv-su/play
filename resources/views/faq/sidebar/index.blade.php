<nav class="navbar navbar-inverse fixed-top" id="sidebar-wrapper">
    <ul class="nav sidebar-nav"  role="tablist">
        <div class="sidebar-header">
            <div class="sidebar-title">
                <a href="#">Related guides</a>
            </div>
        </div>


        <li class="dropdown">
            <a href="#play" class="dropdown-toggle" data-toggle="dropdown">DSVPlay <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li><a wire:click="wiplay" style="cursor: pointer;">What is DSVPlay</a></li>
                <li><a wire:click="language" style="cursor: pointer;">Language</a></li>
                <li><a wire:click="rap" style="cursor: pointer;">Roles and permissions</a></li>
            </ul>
        </li>


        <li><a wire:click="navigate" style="cursor: pointer;">Navigate</a></li>
        <li><a href="#search">Search</a></li>
        <li><a href="#upload">Upload</a></li>
        <li><a href="#download">Download</a></li>


        <li class="dropdown">
            <a href="#manage" class="dropdown-toggle" data-toggle="dropdown">Manage <span class="caret"></span></a>
            <ul class="dropdown-menu animated fadeInLeft" role="menu">
                <li><a href="#presentations">Manage presentations</a></li>
                <li><a href="#courses">Manage courses</a></li>
            </ul>
        </li>

        <li class="dropdown">
            <a href="#admin" class="dropdown-toggle" data-toggle="dropdown">Administrator <span class="caret"></span></a>
            <ul class="dropdown-menu animated fadeInLeft" role="menu">
                <li><a href="#stats">Statistics and settings</a></li>
                <li><a href="#logs">Logs</a></li>
                <li><a href="#sync">Sync items from Mediasite</a></li>
                <li><a href="#retrive">Retrive from Mediasite</a></li>
            </ul>
        </li>

        <li><a href="#admin"></a></li>


    </ul>
</nav>
