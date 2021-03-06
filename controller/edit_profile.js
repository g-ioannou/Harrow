$(document).ready(function () {
  let avatar_selector = 0; //hidden
  $("#customize-avtr").on("click", function () {
    $(".avatar-selector").html(
      '<span id="choose-avtr-msg">Choose your new avatar </span>'
    );
    if (avatar_selector == 0) {
      avatar_selector = 1;
      $(".avatar-selector").fadeIn(300);
      for (let i = 0; i < 32; i++) {
        let random_seed = Math.round(Math.random() * 1000000);
        let html = `<img id="${random_seed}" class="avatar-img avatar-new" src="https://avatars.dicebear.com/api/avataaars/:${random_seed}.svg?mood[]=happy" /> <br>`;

        $(".avatar-selector").append(html);
      }
    } else {
      avatar_selector = 0;
      $(".avatar-selector").fadeOut(300);
    }
  });

  $(document).on("click", ".avatar-new", function () {
    let avatar_seed = $(this).attr("id");

    $.ajax({
      type: "POST",
      url: "/harrow/model/edit_profile.php",
      data: { type: "change_avatar", avatar_seed: avatar_seed },
      success: function (response) {
        let html = `<img class="avatar-img avatar-new" src="https://avatars.dicebear.com/api/avataaars/:${avatar_seed}.svg?mood[]=happy" /> <br>`;
        let profile_btn_html = `<img class="avatar-top-bar" src="https://avatars.dicebear.com/api/avataaars/:${avatar_seed}.svg?mood[]=happy" />`;
        
        if (response=='success') {
          $("#avatar-img").html(html);
          $("#profile-btn").html(profile_btn_html);
          $(".avatar-selector").fadeOut(300);
          avatar_selector=0;
        }
      },
      error: function (e) {
        console.log(e);
      },
    });
  });

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
    } else {
      if (new_username.length < 6 || new_username.indexOf(" ") !== -1) {
        $("#username_error").html(
          "Invalid username. Username must contain at least 6 characters and no spaces."
        );
        $("#username_error").show();
      } else if (username == new_username) {
        $("#username_error").html("New and old usernames are the same.");
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
            } else if (response == "fail_exists") {
              $("#username_error").html("Username already exists.");
            } else {
              $("#username_error").html("Invalid username or password.");
              $("#username_error").css({ color: "red" });
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
      $("#pass_error").html("Please fill all the fields.");
      $("#pass_error").show();
      $("#pass_error").css({ color: "red" });
    } else if (old_password == new_password) {
      $("#pass_error").html("Please use a different password");
      $("#pass_error").show();
      $("#pass_error").css({ color: "red" });
    } else if (new_password != password_re) {
      $("#pass_error").html(
        "New password and re-enter password fields don't match"
      );
      $("#pass_error").show();
      $("#pass_error").css({ color: "red" });
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
            $("#pass_error").html("Invalid username or password");
            $("#pass_error").show();
            $("#pass_error").css({ color: "red" });
          } else {
            if (response == "success") {
              $("#pass_error").html("Password changed successfully");
              $("#pass_error").show();
              $("#pass_error").css({ color: "green" });
            }
          }
        },
      });
    }
  });
});
