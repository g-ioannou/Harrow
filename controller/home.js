let uploaded_files = {};
let uploaded_selected_files = {};

$(document).ready(function () {
  // const handler = new UploadHandler()

  $.ajax({
    type: "GET",
    url: "/harrow/model/admin.php",

    success: function (response) {
      if (response == "success") {
        $("#admin-btn").show();
      }
    },
  });

  $(document).on("change", "#file-select", function (event) {
    event.preventDefault();

    let id = $(this).parent().parent().attr("id");

    let is_selected = uploaded_files[id].selected;

    if (is_selected == 0) {
      uploaded_files[id].select = 1;
      uploaded_selected_files[id] = uploaded_files[id];
    } else {
      uploaded_files[id].select = 0;
      delete uploaded_selected_files[id];
    }

    let select_files_cnt = get_json_len(uploaded_selected_files);
    if (select_files_cnt == 0) {
      $("#delete-multiple-new-btn").attr("disabled", true);
      $("#download-multiple-new-btn").attr("disabled", true);
      $("#save-to-server-btn").attr("disabled", true);
      $("#selected-uploaded-files-msg").css({
        color: "gray",
      });
    } else {
      $("#delete-multiple-new-btn").removeAttr("disabled");
      $("#download-multiple-new-btn").removeAttr("disabled");
      $("#save-to-server-btn").removeAttr("disabled");
      $("#selected-uploaded-files-msg").css({
        color: "green",
      });
    }

    $("#selected-uploaded-files-number").html(select_files_cnt);
  });

  $(document).on("click", "#hidden-display", function () {
    $(".no-files").hide();
    $(".new-files").show();
  });

  $("#upload-btn").change(function () {
    const files = $("#upload-btn");
    fileList = this.files;

    for (let i = 0; i < fileList.length; i++) {
      uploadFile(fileList[i]);
    }
  });

  $("#download-multiple-new-btn").click(function (e) {
    e.preventDefault();

    for (id in uploaded_selected_files) {
      const file = uploaded_selected_files[id];
      file.download();
    }
  });

  $("#delete-multiple-new-btn").click(function (e) {
    e.preventDefault();

    let id_list = [];
    for (id in uploaded_selected_files) {
      id_list.push(id);
      delete uploaded_files[id];
    }

    for (let i = 0; i < id_list.length; i++) {
      const id = id_list[i];
      delete uploaded_selected_files[id];
      $(`#${id}`).fadeOut(300);
    }
  });

  $(document).on("click", ".file-dow-btn", function () {
    let id = $(this).attr("id");

    uploaded_files[id].download();
  });

  $(document).on("click", ".file-dlt-btn", function () {
    let id = $(this).attr("id");
    deleteFile(id);
    $(this)
      .parent()
      .parent()
      .fadeOut(300, function () {
        $(this).remove();
      });
    if (get_json_len(uploaded_selected_files) == 0) {
      $("#delete-multiple-new-btn").attr("disabled", true);
      $("#download-multiple-new-btn").attr("disabled", true);
      $("#save-to-server-btn").attr("disabled", true);
    }
  });
});

function uploadFile(file) {
  let fr = new FileReader();
  current_id = uploaded_files.length;
  fr.onload = function () {
    try {
      let current_id = new Date().valueOf();
      let harFile = new HARfile(
        current_id,
        file.name,
        file.size,
        JSON.parse(fr.result)
      );
      notify("success", `<b>Successfully uploaded</b> ${file.name}`);
      uploaded_files[current_id] = harFile;
      $("#hidden-display").click();
    } catch (e) {
      if (e instanceof SyntaxError) {
        notify(
          "error",
          `<b>This file seems corrupted and can't be uploaded</b>. Details: <br>${e}`
        );
      } else {
        notify("error", `<b>Could not load file</b>. Unexpected error: ${e}`);
      }
    }
  };
  fr.readAsBinaryString(file);
}

function deleteFile(file_id) {
  try {
    delete uploaded_files[file_id];
  } catch (e) {}

  try {
    delete uploaded_selected_files[file_id];
  } catch (e) {}
}

function get_json_len(json) {
  return Object.keys(json).length;
}

class HARfile {
  constructor(id, name, size, contents) {
    this.id = id;
    this.name = name;
    this.size = size;
    this.contents = this.clean_contents(contents.log.entries);
    this.shown = 0;
    this.selected = 0;
  }

  get select() {
    return this.selected;
  }

  set select(value) {
    this.selected = value;
  }

  download() {
    try {
      let a = document.createElement("a");
      let dataStr =
        "data:text/json;charset=utf-8," +
        encodeURIComponent(JSON.stringify(this.contents, null, 4));
      //   let file = new Blob([this.contents],{type: 'text'})
      a.href = dataStr;
      a.download = "cleaned_" + this.name;
      a.click();
    } catch (e) {
      notify("error", `<b>Unable to download file</b>. <br> Error: ${e}`);
    }
  }

  displayHTML() {
    this.shown = 1;
    let html = `<tr id="${this.id}" class="uploaded-file">
                <td><input type="checkbox" id="file-select"></td>
                <td><i class="fal fa-file"></i>&nbsp;&nbsp; ${this.name}</td>
                <td>${(this.size / Math.pow(10, 6)).toFixed(1)} MB</td>
                <td><button class="btn file-dlt-btn" id="${
                  this.id
                }"><i class="fal fa-trash-alt"></i></button></td>
                <td><button class="btn file-dow-btn" id="${
                  this.id
                }"><i class="fal fa-file-download"></i></button></td>
            </tr>
            `;
    return html;
  }

  clean_contents(contents) {
    let cleaned_entries = [];

    for (let i = 0; i < contents.length; i++) {
      const entry = contents[i];

      const getHostName = (url) => {
        return new URL(url).hostname;
      };

      let cleaned_entry = {
        startedDateTime: entry.startedDateTime,
        timings: {
          wait: entry.timings.wait,
        },
        serverIPAddress: entry.serverIPAddress,
        request: {
          method: entry.request.method,
          url: getHostName(entry.request.url),
          headers: cleanHeaders(entry.request.headers),
        },
        response: {
          status: entry.response.status,
          statusText: entry.response.statusText,
          headers: cleanHeaders(entry.response.headers),
        },
      };
      cleaned_entries.push(cleaned_entry);
    }

    return cleaned_entries;

    function cleanHeaders(headers) {
      let cleaned_headers = [];
      for (let i = 0; i < headers.length; i++) {
        const header = headers[i];
        let name = header.name.toLowerCase();

        if (
          name == "content-type" ||
          name == "cache-control" ||
          name == "pragma" ||
          name == "expires" ||
          name == "age" ||
          name == "last-modified" ||
          name == "host"
        ) {
          cleaned_headers.push(header);
        }
      }
      return cleaned_headers;
    }
  }
}
