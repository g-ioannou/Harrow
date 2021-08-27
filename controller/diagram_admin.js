$(document).ready(function()
{
    $.ajax({
        method: "POST",
        url: "../../model/admininfo.php",
        data:
        { type: "average"},
        success: function (response) {
                    
            $('#average').html(response).show;
        }
          });   
})