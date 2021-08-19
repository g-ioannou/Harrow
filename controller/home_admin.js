$(document).ready(function()
{

    console.log("ok");
var number = $("#numbers").val()

}
);

function regNumbers(){
    var regs;

$.ajax({
    type: "post",
    url: "../../model/admininfo.php",
    data: "regs",
    success: function (response) {
        alert(response);
    }
});
}

function methodNumbers(){
    var methods;

$.ajax({
    type: "post",
    url: "../../model/admininfo.php",
    data: "methods",
    success: function (response) {
        alert(response);
    }
});
}
// $.ajax({
//     type: "GET",
//     url: "../../model/admininfo.php",
//     datatype:"html",
//         success: function (response) {
//         $("#numbers").append(response);
              
//     }
// });
    

// $.ajax({

// $(document).ready(function(){
// $('#numbers').load("../../model/admininfo.php");
//     }
        
//     );

// });