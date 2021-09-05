$(document).ready(function () {
    let menu_active = 1;
    $(".toggle").on("click", function () {
        if (menu_active == 1) {
            $(".logo_container").html('<img src="../../view/images/tab_icon.png" class="logo">');
            menu_active = 0;
        }
        else {
            $(".logo_container").html('<img src="../../view/images/logo.png" class="logo">');
            menu_active = 1;
        }
 
    });

    $(document).on("click",".avatar-top-bar", function () {
        window.location.replace("/harrow/view/home_admin/home_admin.php")
    });

});