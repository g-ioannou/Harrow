// manta
$(document).ready(function () {
  // for choosing change username or password
  $("#change_username").hide();
  $("#main_password").on("click", function () {
    $("#change_password").show();
    $("#change_username").hide();
  });
  $("#main_username").on("click", function () {
    $("#change_username").show();
    $("#change_password").hide();
  });

  //validation and change username
  $("#edit_user_btn").click(function () {
    let username = $("#username_u").val();
    let new_username = $("#new_username").val();
    let password = $("#password_user").val();

    
    if (username == "" || new_username == "" || password == "") {
      $("#username_error").html("Please fill the fields.");
    }
    else {
      if (new_username.length < 6 || new_username.indexOf(" ") !== -1){
        
            $("#username_error").html(
              "Invalid username. Username must contain at least 6 characters and no spaces."
            );
            $("#username_error").show();
          
      } else if(username == new_username) {
        $("#username_error").html("You can't put the same username.");
        
        
      } else {
        $.ajax({
          //ERROR
          method: "post",
          url: "/harrow/model/edit_profile.php",
          data: {
            type: 3,
            username: username,
            new_username: new_username,
            password: password,
          },
          success: function (response) {
            // $("#login_error").html(data);
            console.log(response);
            if (response == "success") {
              $("#username_error").html(
                "Username changed successfully. Your new username is " +
                  new_username,
                "."
              );
            } else if (response == "fail_exists"){
                $("#username_error").html("Username already exists.");
            }else {
                $("#username_error").html("Invalid username or password.");
            }
          },
        });
        //return true;
      }
    }
  });

  //validation and change username

  $("#edit_pass_btn").click(function () {
    let username_p = $("#username_p").val();
    let old_password = $("#old_password").val();
    let new_password = $("#new_password").val();
    let password_re = $("#password_re").val();

    if (
      username_p == "" ||
      old_password == "" ||
      new_password == "" ||
      password_re == ""
    ) {
      $("#pass_error").html("Please fill the fields.");
      $("#pass_error").show();
    } else if (old_password == new_password) {
      $("#pass_error").html("Please put a different password");
      $("#pass_error").show();
    } else if (new_password != password_re) {
      $("#pass_error").html("Different new and re enter password");
      $("#pass_error").show();
    } else {
      $.ajax({
        method: "post",
        url: "/harrow/model/edit_profile.php",
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
          } else {
            if (response == "success") {
              $("#pass_error").html("Password changed");
              $("#pass_error").show();
            }
          }
        },
      });
    }
  });
});
