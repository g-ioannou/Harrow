$(document).ready(function () {
  // for choosing login or registration
  $("#registration").hide();
  $("#main_login").on("click", function () {
    $("#login").show();
    $("#registration").hide();
  });
  $("#main_register").on("click", function () {
    $("#registration").show();
    $("#login").hide();
  });

  //validation and log in
  $("#login_btn").click(function () {
    console.log("ok");
    let email_log = $("#email_log").val();
    let password_log = $("#password_log").val();
    let email_regex = /^[\w%_\-.\d]+@[\w.\-]+.[A-Za-z]{2,6}$/; // regex email check
    let password_regex =
      /^(?=.*\d)(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,32}$/; //regex password check

    if (email_log == "" || password_log == "") {
      $("#login_error").html("Please fill all the fields.");
      $("#email_log,#password_log").css({ border: "1px solid red" });
    } else {
      if (!email_regex.test(email_log)) {
        $("#login_error").html("Invalid e-mail");
      } else if (!password_regex.test(password_log)) {
        $("#login_error").html("Invalid password");
      } else {
        $.ajax({
          method: "POST",
          url: "/harrow/model/login_form.php",
          data: {
            type: "login",
            email: email_log,
            password: password_log,
          },
          success: function (response) {
            console.log(response);
            if (response == "success") {
              window.location.replace("/harrow/view/home_user/home.php");
            } else {
              $("#login_error").html("E-mail not found.");
            }
          },
          error: function (error) {
            console.log(error);
          },
        });
      }
    }
  });

  //validation and register
  $("#register_btn").click(function () {
    let firstname = $("#firstname").val();
    let lastname = $("#lastname").val();
    let username = $("#username").val();
    let email = $("#email_reg").val();
    let password = $("#password_reg").val();
    let email_regex = /^[\w%_\-.\d]+@[\w.\-]+.[A-Za-z]{2,6}$/; // regex email check
    let password_regex =
      /^(?=.*\d)(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,32}$/; //regex password check
    let valid = true;
    let regName = /^[a-zA-Z ]+$/;
    //let regName = /^[a-zA-Z]+ [a-zA-Z]+$/; //regex firstname and lastname check

    $("#register_error").hide();
    $("#email_error_message").hide();
    $("#password_error_message").hide();
    $("#username_error_message").hide();
    $("#lastname_error_message").hide();
    $("#firstname_error_message").hide();

    if (
      firstname == "" ||
      lastname == "" ||
      username == "" ||
      email == "" ||
      password == ""
    ) {
      $("#register_error").html("Please fill all the fields.");
      $("#register_error").show();
      $("#firstname,#lastname,#username,#email_reg,#password_reg").css({
        border: "1px solid red",
      });

      setTimeout(function () {
        $("#firstname,#lastname,#username,#email_reg,#password_reg").css({
          border: "none",
        });
        $("#register_error").fadeOut(3000);
      }, 3000);
      valid = false;
    } else {
      if (username.length < 6 || username.indexOf(" ") !== -1) {
        $("#username_error_message").html(
          "Username must be longer than 6 characters."
        );
        $("#username_error_message").show();
        $("#username").css({ border: "1px solid red" });
        valid = false;
      }
      if (!email_regex.test(email)) {
        $("#email_error_message").html("Invalid email form.");
        $("#email_error_message").show();
        $("#email_reg").css({ border: "1px solid red" });
        valid = false;
      }
      if (!password_regex.test(password)) {
        $("#password_error_message").html("Invalid password.");
        $("#password_error_message").show();
        $("#password_reg").css({ border: "1px solid red" });
        valid = false;
      }
      if (!regName.test(firstname)) {
        $("#firstname_error_message").html(
          "Firstname can't contain invalid characters."
        );
        $("#firstname_error_message").show();
        $("#firstname").css({ border: "1px solid red" });
        valid = false;
      }
      if (!regName.test(lastname)) {
        $("#lastname_error_message").html(
          "Lastname can't contain invalid characters."
        );
        $("#lastname").css({ border: "1px solid red" });
        $("#lastname_error_message").show();
        valid = false;
      }
    }
    if (valid == true) {
      $("#email_error_message").hide();
      $("#password_error_message").hide();
      $("#username_error_message").hide();
      $("#lastname_error_message").hide();
      $("#firstname_error_message").hide();
      $.ajax({
        method: "post",
        url: "/harrow/model/login_form.php",
        data: {
          type: "register",
          firstname: firstname,
          lastname: lastname,
          username: username,
          email: email,
          password: password,
        },
        success: function (response) {
          console.log(response);
          if (response == "fail_user") {
            $("#register_error").html(
              "An account with this username already exists."
            );
            $("#register_error").show();
          } else if (response == "fail_email") {
            $("#register_error").html(
              "An account with this e-mail already exists."
            );
            $("#register_error").show();
          } else {
            $("#register_error").html(
              "Registration success! Taking you back to log in."
            );
            $("#register_error").css({ color: "rgb(7, 219, 7)" });
            $("#register_error").show();

            //clear input fields
            $("#firstname").val("");
            $("#lastname").val("");
            $("#username").val("");
            $("#email_reg").val("");
            $("#password_reg").val("");

            setTimeout(function () {
              window.location.replace("/harrow/view/login/login.html");
            }, 2000);
          }
        },
        error: function (error) {
          console.log(error);
        },
      });
    }
  });
});
