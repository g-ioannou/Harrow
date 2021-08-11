//show box for validate password
$(document).ready(function () {
  let showpass = 0;
  $(document).on("click", ".show-pass-btn", function () {
    if (showpass == 0) {
      $("#password_log,#password_reg").attr("type", "text");
      $(".show-pass-btn").css({ color: "white" });
      showpass = 1;
    } else {
      $("#password_log,#password_reg").attr("type", "password");
      $(".show-pass-btn").css({ color: "black" });
      showpass = 0;
    }
  });

  $("#password_reg")
    .keyup(function () {
      var password_reg = $("#password_reg").val();

      let valid_html = '<i class="fas fa-check"></i>';
      let invalid_html = '<i class="fas fa-times"></i>';
      //validate the length
      if (password_reg.length < 8) {
        $("#length").removeClass("valid").addClass("invalid");
        $("#pass-icon-eight").html(invalid_html);
      } else {
        $("#length").removeClass("invalid").addClass("valid");
        $("#pass-icon-eight").html(valid_html);
      }
      //validate lowercase letter
      if (password_reg.match(/[A-z]/)) {
        $("#letter").removeClass("invalid").addClass("valid");
        $("#pass-icon-lower").html(valid_html);
      } else {
        $("#letter").removeClass("valid").addClass("invalid");
        $("#pass-icon-lower").html(invalid_html);
      }

      //validate capital letter
      if (password_reg.match(/[A-Z]/)) {
        $("#capital").removeClass("invalid").addClass("valid");
        $("#pass-icon-upper").html(valid_html);
      } else {
        $("#capital").removeClass("valid").addClass("invalid");
        $("#pass-icon-upper").html(invalid_html);
      }

      //validate number
      if (password_reg.match(/\d/)) {
        $("#number").removeClass("invalid").addClass("valid");
        $("#pass-icon-number").html(valid_html);
      } else {
        $("#number").removeClass("valid").addClass("invalid");
        $("#pass-icon-number").html(invalid_html);
      }

      //validate symbol
      if (password_reg.match(/[!@#$%^&*]/)) {
        $("#symbol").removeClass("invalid").addClass("valid");
        $("#pass-icon-special").html(valid_html);
      } else {
        $("#symbol").removeClass("valid").addClass("invalid");
        $("#pass-icon-special").html(invalid_html);
      }
    })
    .focus(function () {
      $("#password_reg_info").show();
    })
    .blur(function () {
      $("#password_reg_info").hide();
    });
});
