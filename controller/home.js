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
  let select_all = 0;
  $(document).on("click", "#select-all", function () {
    if (select_all == 0) {
      let ctr = 0;
      $(".file-list")
        .find(":checkbox")
        .each(function () {
          $(":checkbox").prop("checked", true);
          ctr++;
        });

      $("#selected-uploaded-files-number").html(ctr);
      if (ctr > 0) {
        uploaded_selected_files = uploaded_files;
        $("#select-all").html("Unselect all");
      }
      select_all = 1;
    } else {
      $(".file-list")
        .find(":checkbox")
        .each(function () {
          $(":checkbox").prop("checked", false);
        });
      $("#select-all").html("Select all");
      select_all = 0;
      uploaded_selected_files = {};
      $("#selected-uploaded-files-number").html("0");
    }
    checkNewFilesBtn();
  });

  $(document).on("change", ".new-files :checkbox", function () {
    uploaded_selected_files = {};
    $(".file-list")
      .find(":checkbox:checked")
      .each(function () {
        let id = $(this).attr("id");
        uploaded_selected_files[id] = uploaded_files[id];
      });

    let selected_files_ctr = get_json_len(uploaded_selected_files);
    $("#selected-uploaded-files-number").html(selected_files_ctr);
    checkNewFilesBtn();
  });

  

  $(document).on("click", "#hidden-display", function () {
    $(".no-files").hide();
    $(".new-files").show();
  });

  $("#upload-btn").change(function () {
    const files = $("#upload-btn");
    let all_files_uploaded = false;
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

    $("#selected-uploaded-files-number").html("0");
    $("#selected-uploaded-files-msg").css({ color: "gray" });
    $("#delete-multiple-new-btn").attr("disabled", true);
    $("#download-multiple-new-btn").attr("disabled", true);
    $("#save-to-server-btn").attr("disabled", true);
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
          `<b>File ${file.name} seems corrupted and can't be uploaded</b>. Details: <br>${e}`
        );
      } else {
        notify(
          "error",
          `<b>Could not load file ${file.name}</b>. Unexpected error: ${e}`
        );
      }
    }
  };
  fr.readAsBinaryString(file);
}

function deleteFile(file_id) {
  let file_name = uploaded_files[file_id].name;
  try {
    delete uploaded_files[file_id];
  } catch (e) {}

  try {
    delete uploaded_selected_files[file_id];
    let count = get_json_len(uploaded_selected_files);
    $("#selected-uploaded-files-number").html(count);
  } catch (e) {}
  notify("delete", `File <b>${file_name}</b> deleted.`);
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
                <td><input type="checkbox" class="file-select" id="${
                  this.id
                }" ></td>
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

      let year_date = entry.startedDateTime.split("T")[0];
      let hours = entry.startedDateTime.replace(year_date + "T", "");
      hours = hours.split("+")[0].split(".")[0];

      let final_date_time = year_date + " " + hours;

      let cleaned_entry = {
        startedDateTime: final_date_time,
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
        let cleaned_header = {};
        if (
          name == "content-type" ||
          name == "cache-control" ||
          name == "pragma" ||
          name == "expires" ||
          name == "age" ||
          name == "last-modified" ||
          name == "host"
        ) {
          cleaned_header[name] = header["value"].replace("-", "_");
          cleaned_headers.push(cleaned_header);
        }
      }
      return cleaned_headers;
    }
  }
}
