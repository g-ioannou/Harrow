$(document).ready(function () {
  $("#save-to-server-btn").click(function (e) {
    for (const id in uploaded_selected_files) {
      const file = uploaded_selected_files[id];
      upload_file_meta(file);
    }
  });
});

function upload_file_meta(file) {
  
  $.ajax({
    type: "POST",
    url: "/harrow/model/save_file.php",
    data: {
      name: file.name,
      size: file.size,
      contents: JSON.stringify({ contents: file.contents }),
    },
    success: function (response) {
      console.log(response);
      notify("tip", `<b>Uploading file: `);
    },
    error: function (error) {
      console.error(error);
    },
  });
}
