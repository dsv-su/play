<h2 id="rap">{{__("Roles and permissions")}}</h2>
<span class="su-theme-anchor mb-4"></span>
<article class="main-article webb2021-article main-column-left js-anchor-links-headers-container col-12 col-lg-8 main-column-padding-right">
    <p>{{__("When you log in the DSVPLAY platform will know what your role is. There are four different roles for DSVPLAY users with varying permissions:")}}</p>
    <ul>
        <li>{{__("STUDENT: navigate & play")}}</li>
        <li>{{__("STAFF: navigate & play")}}</li>
        <li>{{__("UPLOADER: navigate & play, upload and edit presentation settings")}}</li>
        <li>{{__("COURSE ADMIN: navigate & play, upload, edit presentation settings and edit course settings")}}</li>
    </ul>
    <button type="button" class="btn btn-primary">
        {{__("Your role is:")}} <span class="badge badge-light">{{app()->make('play_role')}}</span>
    </button>
</article>
<br>
<br>

