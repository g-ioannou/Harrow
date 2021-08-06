$(document).ready(function () {
    
    let height = $(".top-bar").height()
    let margin = parseInt($(".top-bar").css("padding-bottom"))
    
    if (height>0) {
        $(".main").css('padding-top', height+3*margin)
    }

    $("#fake-upload").click(function (e) { 
        
        $("#upload-btn").click();

    });
});

