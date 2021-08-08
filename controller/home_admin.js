$.ajax({
    type: "GET",
    url: "../../model/home_admin.php",
    success: function (response) {
        $("#numbers").append(response);
        
    }
});