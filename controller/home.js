let har_list = [];

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

  //let files = $("#upload-btn").prop('files')
  $("#upload-btn").change(function () {
    const files = $("#upload-btn");
    fileList = this.files;

    for (let i = 0; i < fileList.length; i++) {
      uploadFile(fileList[i]);
    }
  });
  $(document).on("click", ".file-dow-btn", function () {
    let id = $(this).attr("id");
    for (let i = 0; i < har_list.length; i++) {
      const file = har_list[i];

      if (file.id == id) {
        file.download();
      }
    }
  });

  $(document).on("click", ".file-dlt-btn", function () {
    let id = $(this).attr("id");
    deleteFile(id)
    $(this).parent().parent().fadeOut(300);
  });

  $(document).on("change", "#file-select", function () {
    let id = $(this).parent().parent().attr("id");

    for (let i = 0; i < har_list.length; i++) {
      const file = har_list[i];

      if (id == file.id) {
        if (file.checked == 0) {
          file.checked = 1;
        } else {
          file.checked = 0;
        }
      }
    }
  });
});

function uploadFile(file) {
  let fr = new FileReader();
  current_id = har_list.length;
  fr.onload = function () {
    try {
      let harFile = new HARfile(
        current_id,
        file.name,
        file.size,
        JSON.parse(fr.result)
      );
      har_list.push(harFile);
      $("#hidden-display").click();
    } catch (error) {
      console.log(error);
    }
  };
  fr.readAsBinaryString(file);
}

function deleteFile(file_id) {
    let pos = -1;
    for (let i = 0; i < har_list.length; i++) {
      const file = har_list[i];
      if (file.id == file_id) {
        pos = i;
      }
    }
    har_list.pop(pos);
}

class HARfile {
  constructor(id, name, size, contents) {
    this.id = id;
    this.name = name;
    this.size = size;
    this.contents = this.clean_contents(contents.log.entries);
    this.shown = 0;
    this.checked = 0;
  }

  download() {
    let a = document.createElement("a");
    let dataStr =
      "data:text/json;charset=utf-8," +
      encodeURIComponent(JSON.stringify(this.contents, null, 4));
    //   let file = new Blob([this.contents],{type: 'text'})
    a.href = dataStr;
    a.download = "cleaned_" + this.name;
    a.click();
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
