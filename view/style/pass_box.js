// resetPassword.js

// $(document).ready(function () {
//   $("#check_re").click(function () {
//     //var password_re = $("#password_re").val();
//     if ($("#password_re").attr("type") == "text") {
//       $("#password_re").attr("type", "password");
//     } else {
//       $("#password_re").attr("type", "text");
//     }
//   });
  
  
// });

$(document).ready(function () {
  let showpass = 0;
  $(document).on("click", ".show-pass-btn", function () {
    if (showpass == 0) {
      $("#password_user,#password_re").attr("type", "text");
      $(".show-pass-btn").css({ color: "white" });
      $(".show-pass-btn").html('<i class="fas fa-eye"></i>');
      showpass = 1;
    } else {
      $("#password_user,#password_re").attr("type", "password");
      $(".show-pass-btn").css({ color: "black" });
      $(".show-pass-btn").html('<i class="fas fa-eye-slash"></i>');
      showpass = 0;
    }
  });

  
  let showpass_ch = 0;
  $(document).on("click", ".show-pass-btn-chpass", function () {
    if (showpass_ch == 0) {
      $("#new_password,#old_password,#password_re").attr("type", "text");
      $(".show-pass-btn-chpass").css({ color: "white" });
      $(".show-pass-btn-chpass").html('<i class="fas fa-eye"></i>');
      showpass_ch = 1;
    } else {
      $("#new_password,#old_password,#password_re").attr("type", "password");
      $(".show-pass-btn-chpass").css({ color: "black" });
      $(".show-pass-btn-chpass").html('<i class="fas fa-eye-slash"></i>');
      showpass_ch = 0;
    }
  });
});

