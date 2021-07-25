

$(document).ready(function () {

    $.ajax({
        type: "GET",
        url: "/harrow/model/admin.php",
        
        success: function (response) {
            if (response=='success'){
                $("#admin-btn").show();
            }
            
        }
    });


});