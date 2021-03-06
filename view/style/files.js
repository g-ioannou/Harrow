

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


  $(document).on("change",".file-table :checkbox", function () {
    
    $(".file-list").find(":checkbox:checked").each(function () {
      let id = $(this).attr('id');
      $(this).parent().parent().css({color:"orange"});
      $(`#${id}`).css({color:"orange"});


    });
    $(".file-list")
      .find(":checkbox:not(:checked)")
      .each(function () {
        let id = $(this).attr("id");
        $(this).parent().parent().css({ color: "white" });
        $(`#${id}`).css({ color: "white" });
      });
  });
  

  $(document).on("click", "#clear-notifications", function () {
    $(".notifications").empty();
    notification_glow();
  });

  $("#hidden-display").click(function (e) {
    e.preventDefault();

    for (id in uploaded_files) {
      if (uploaded_files[id].shown == 0) {
        $("#new-files-table").append(uploaded_files[id].displayHTML());
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

 
  notification_glow();
  setTimeout(function () {
    $(".notifications-side").fadeOut(300);
  }, 2000);

  return `perm_${notification_id}`;
}

function notification_glow() {
  if ($(".notifications").is(":empty")) {
    $(".notification-list-btn").css({ color: "black" });
  } else {
    $(".notification-list-btn").css({ color: "orange" });
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

function checkOldFilesBtn() {
  
  let count = get_json_len(user_selected_files);
  console.log(count);
  if (count > 0) {
    $("#delete-multiple-old-btn").removeAttr("disabled");
    $("#download-multiple-old-btn").removeAttr("disabled");
  } else {
    $("#delete-multiple-old-btn").attr("disabled", true);
    $("#download-multiple-old-btn").attr("disabled", true);
  }
}
