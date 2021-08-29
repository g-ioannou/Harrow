$(document).ready(function()
{

    console.log("ok");
   var number = $("#numbers").val();



   console.log("ok");

    var regs;
    console.log("ok");
 $.ajax({
    method: "POST",
    url: "../../model/admininfo.php",
    data:{ 
        type:   "regs"},
  
    success: function (response) {
        console.log("ok");
        $('#numbers').html(response).show;
    },
    error: function () {
        alert('Not Okay');
    }
      });
                        


    var methods;

$.ajax({
    method: "POST",
    url: "../../model/admininfo.php",
    data:
    { type: "methods"},
    success: function (response) {
        $('#methods').html(response).show;
    }
      });


      $.ajax({
        method: "POST",
        url: "../../model/admininfo.php",
        data:
        { type: "status"},
        success: function (response) {
                    
            $('#status').html(response).show;
        }
          });    

          $.ajax({
            method: "POST",
            url: "../../model/admininfo.php",
            data:
            { type: "domain"},
            success: function (response) {
                        
                $('#domain').html(response).show;
            },
            error: function () {
                alert('Not Okay');
            }
              });   

              $.ajax({
                method: "POST",
                url: "../../model/admininfo.php",
                data:
                { type: "isps"},
                success: function (response) {
                            
                    $('#isps').html(response).show;
                },
                error: function () {
                    alert('Not Okay');
                }
                  });   

                      
                    }
)