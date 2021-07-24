//show password text in change user 
$(document).ready(function(){
    $('#check_user').click(function () {
        var password_user = $("#password_user").val();
        if ($('#password_user').attr('type') == 'text') {
            $('#password_user').attr('type', 'password');
        } else {
            $('#password_user').attr('type', 'text');
        }   
    });
}); 

//show password text in change password 
$(document).ready(function(){
    $('#check_old').click(function () {
        var old_password = $("#old_password").val();
        if ($('#old_password').attr('type') == 'text') {
            $('#old_password').attr('type', 'password');
        } else {
            $('#old_password').attr('type', 'text');
        }   
    });
}); 

$(document).ready(function(){
    $('#check_new').click(function () {
        var new_password = $("#new_password").val();
        if ($('#new_password').attr('type') == 'text') {
            $('#new_password').attr('type', 'password');
        } else {
            $('#new_password').attr('type', 'text');
        }   
    });
}); 


$(document).ready(function(){
    $('#check_re').click(function () {
        var password_re = $("#password_re").val();
        if ($('#password_re').attr('type') == 'text') {
            $('#password_re').attr('type', 'password');
        } else {
            $('#password_re').attr('type', 'text');
        }   
    });
}); 





$(document).ready(function () {

    // for choosing change username or password
    $("#change_username").hide();
    $('#main_password').on('click', function () {
        $("#change_password").show();
        $("#change_username").hide();
    });
    $('#main_username').on('click', function () {
        $("#change_username").show();
        $("#change_password").hide();
    });


    //validation and change username 
    $("#edit_user_btn").click(function () {
        var username = $("#username_u").val();
        var new_username = $("#new_username").val();
        var password = $("#password_user").val();
        
        
        if (username == "" || new_username == "" || password == "") {
            $("#username_error").html("Please fill the fields.");
                
        }
        else {
            if (username == new_username) {
                $("#username_error").html("You can't put the same username.");
            }
            else {
                $.ajax({                      //ERROR
                    method: "post",
                    url: "edit_profile.php",
                    data: {
                        type: 3,
                        username: username,
                        new_username: new_username,
                        password: password
                    },
                    success: function (response) {
                        // $("#login_error").html(data);
                        if (response == "success") {
                            $("#username_error").html("Username changed successfully. Your new username is " + new_username, ".");
                        }
                        else {
                            $("#username_error").html("Invalid username or password.");
                        }
                    }
                });
                //return true;
            }
        }
    });
    
        
    //validation and change username
    
    $("#edit_pass_btn").click(function () {
        var username_p = $("#username_p").val();
        var old_password = $("#old_password").val();
        var new_password = $("#new_password").val();
        var password_re = $("#password_re").val();

        if (username_p == "" || old_password == "" || new_password == "" || password_re == "") {
            $("#pass_error").html("Please fill the fields.");
            $("#pass_error").show();    
        }
        else if (old_password == new_password) {
            $("#pass_error").html("Please put a different password");
            $("#pass_error").show();
        }
        else if (new_password != password_re) {
            $("#pass_error").html("Different new and re enter password");
            $("#pass_error").show();
        }
        else {
            $.ajax({
                method: "post",
                url: "edit_profile.php",
                data: {
                    type: 4,
                    username_p: username_p,
                    old_password: old_password,
                    new_password: new_password,
                    password_re: password_re,
                },
                success: function (response) {
                    if (response == "fail_pass") {
                        $("#pass_error").html("Invalid password");
                        $("#pass_error").show();
                    }
                    else {
                        if (response == "success") {
                            $("#pass_error").html("Password changed");
                            $("#pass_error").show();
                        }
                    }
                }


            });
        }
    
    });



});
