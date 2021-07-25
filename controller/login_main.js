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
    let email_log = $("#email_log").val();
    let password_log = $("#password_log").val();
    let email_regex = /^[\w%_\-.\d]+@[\w.\-]+.[A-Za-z]{2,6}$/; // regex email check
    let password_regex =
      /^(?=.*\d)(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,32}$/; //regex password check

    if (email_log == "" || password_log == "") {
      $("#login_error").html("Please fill the fields.");
    } else {
      if (!email_regex.test(email_log)) {
        $("#login_error").html("Please fill correct the email.");
      } else {
        $.ajax({
          method: "post",
          url: "/harrow/model/login_form.php",
          data: {
            type: 1,
            email: email_log,
            password: password_log,
          },
          //dataType: "json",
          success: function (response) {
            // $("#login_error").html(data);
            if (response == "success") {
              console.log("OOOOOOOOOOOOOK");
              window.location.href = "/harrow/view/home_user/home.php";
            } else {
              $("#login_error").html("Invalid email or password.");
            }
          },
        });
        //return true;
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
      $("#register_error").html("Please fill the fields.");
      $("#register_error").show();
      valid = false;
    } else {
      if (username.length < 6 || username.indexOf(" ") !== -1) {
        $("#username_error_message").html(
          "Invalid username. Username must contain at least 6 characters and no space."
        );
        $("#username_error_message").show();
        valid = false;
      }
      if (!email_regex.test(email)) {
        $("#email_error_message").html("Invalid email.");
        $("#email_error_message").show();
        valid = false;
      }
      if (!password_regex.test(password)) {
        $("#password_error_message").html("Invalid password.");
        $("#password_error_message").show();
        valid = false;
      }
      if (!regName.test(firstname)) {
        $("#firstname_error_message").html("Invalid firstname.");
        $("#firstname_error_message").show();
        valid = false;
      }
      if (!regName.test(lastname)) {
        $("#lastname_error_message").html("Invalid lastname.");
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
          type: 2,
          firstname: firstname,
          lastname: lastname,
          username: username,
          email: email,
          password: password,
        },
        success: function (response) {
          console.log(response);
          if (response == "fail_user") {
            $("#register_error").html("Username ID already exists.");
            $("#register_error").show();
          } else if (response == "fail_email") {
            $("#register_error").html("Email ID already exists.");
            $("#register_error").show();
          } else {
            if (response == "success") {
              window.location.href = "/harrow/view/home_user/home.php";
            }
            //$("#register_error").html("Registration success. You can login now.");
            //$("#register_error").show();

            //clear input fields
            $("#firstname").val("");
            $("#lastname").val("");
            $("#username").val("");
            $("#email_reg").val("");
            $("#password_reg").val("");
          }
        },
      });
    }
  });
});
