$(document).ready(function () {
  console.log("ok");
  $("#save-to-server-btn").click(function (e) {
    for (const id in uploaded_selected_files) {
      const file = uploaded_selected_files[id];
      upload_file_to_server(file);
    }
  });
});

function upload_file_to_server(file) {
  notify("upload", `<b>Uploading file: ${file.name}`);

  $.ajax({
    type: "POST",
    url: "/harrow/model/save_file.php",
    data: {
      name: file.name,
      size: file.size,
      contents: JSON.stringify({ contents: file.contents }),
    },
    success: function (response) {
      notify("success", `<b>File ${file.name} uploaded.</b>`);
    },
    error: function (error) {
      notify(
        "error",
        `<b>Couldn't upload ${file.name}</b> <br> Error 500 (internal server error): ${error}`
      );
    },
  });
}
