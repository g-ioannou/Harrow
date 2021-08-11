let notifications_timeout = setTimeout(function () {
  $(".notifications-side").fadeOut(300);
}, 5000);

$(document).ready(function () {
  $("#fake-upload").click(function (e) {
    $("#upload-btn").click();
  });

  $(document).on("click", ".close-notification", function (event) {
    event.preventDefault();
    $(this)
      .parent()
      .fadeOut(300, function () {
        $(this).remove();
      });
    notification_glow();
  });

  $(".notifications-side").hover(function (e) {
    clearTimeout(notifications_timeout);
  });

  $(document).on("click", "#clear-notifications", function () {
    $(".notifications").empty();
    notification_glow();
  });

  $("#hidden-display").click(function (e) {
    e.preventDefault();

    for (id in uploaded_files) {
      if (uploaded_files[id].shown == 0) {
        $(".file-table").append(uploaded_files[id].displayHTML());
      }
    }
  });

  $(document).on("click", "#close-side-notifications", function () {
    $(".notifications-side").fadeOut(300);
  });

  $(document).on("click", ".notification-list-btn", function () {
    $(".notifications-side").fadeIn(300);
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

  if (type == "upload") {
    icon = `<i class="fas fa-cloud-upload"></i>`;
    css_class = "upload";
  }

  if (type == "delete") {
    icon = '<i class="fas fa-trash"></i>';
    css_class = "delete";
  }

  let notification_id = new Date().valueOf();

  let html_perma_notification =
    '<div id="perm_' +
    notification_id +
    '"class="notification-perma ' +
    css_class +
    '"><button class="close-notification btn"><i class="fas fa-times"></button></i><span class="notification-sign">' +
    icon +
    '</span><span class="notification_msg">' +
    msg +
    "</span></div>";

  $(".notifications").prepend(html_perma_notification);
  $(".notifications-side").fadeIn(300);

  notifications_timeout;
  notification_glow();

  return `perm_${notification_id}`;
}

function notification_glow() {
  if ($(".notifications").is(":empty")) {
    $(".notification-list-btn").css({ color: "black" });
  } else {
    $(".notification-list-btn").css({ color: "green" });
  }
}

function checkNewFilesBtn() {
  let count = get_json_len(uploaded_selected_files);

  if (count > 0) {
    $("#delete-multiple-new-btn").removeAttr("disabled");
    $("#download-multiple-new-btn").removeAttr("disabled");
    $("#save-to-server-btn").removeAttr("disabled");
  } else {
    $("#delete-multiple-new-btn").attr("disabled", true);
    $("#download-multiple-new-btn").attr("disabled", true);
    $("#save-to-server-btn").attr("disabled", true);
  }
}
