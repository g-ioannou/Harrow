$(document).ready(function () {
  $("#fake-upload").click(function (e) {
    $("#upload-btn").click();
  });

  $(document).on("click", ".close-notification", function (event) {
    event.preventDefault();
    $(this).parent().remove();
  });

  $("#hidden-display").click(function (e) {
    e.preventDefault();

    for (id in uploaded_files) {
      if (uploaded_files[id].shown == 0) {
        $(".file-table").append(uploaded_files[id].displayHTML());
      }
    }
  });

  $("#test").click(function (e) {
    e.preventDefault();
    notify("error", "This is an error");
    notify(
      "tip",
      "Thisddddd dddddddd ddddddddd ddddddd dddddddddd dddddddddddddddddddddddddddddddddddd is a tsdfsdf"
    );
    notify("success", "Success!");
  });
});

function notify(type, msg) {
  let css_class = "";
  let icon = "";

  if (type == "success") {
    icon = '<i class="fas fa-check-circle"></i>';
    css_class = "success";
  }

  if (type == "error") {
    icon = '<i class="fas fa-exclamation"></i>';
    css_class = "error";
  }

  if (type == "tip") {
    icon = '<i class="fas fa-question"></i>';
    css_class = "tip";
  }

  let notification_id = new Date().valueOf();

  let html =
    '<div id="' +
    notification_id +
    '"class="notification ' +
    css_class +
    '"><button class="close-notification btn"><i class="fas fa-times"></button></i><span class="notification-sign">' +
    icon +
    '</span><span class="notification_msg">' +
    msg +
    "</span></div>";
  console.log(html);

  let new_div = $(html).hide();

  $(".notifications").append(new_div);
  new_div.slideDown("fast");

  setTimeout(() => {
    $(`#${notification_id}`).fadeOut(2000);
  }, 5000);
}
