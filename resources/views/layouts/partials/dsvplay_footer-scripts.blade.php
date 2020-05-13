<script>
    /* Nav bar */
    let mainNav = document.getElementById("js-menu");
    let navBarToggle = document.getElementById("js-navbar-toggle");

    navBarToggle.addEventListener("click", function() {
        mainNav.classList.toggle("active");
    });

    /* New Search */
    $('.search-input').focus(function(){
        $(this).parent().addClass('focus');
    }).blur(function(){
        $(this).parent().removeClass('focus');
    })

</script>
