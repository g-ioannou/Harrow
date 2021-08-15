$(document).ready(function () {
  $.ajax({
    type: "GET",
    url: "/harrow/model/get_user_isps.php",
    success: function (response) {
      let upload_isps_count = JSON.parse(response);

      for (let i = 0; i < upload_isps_count.length; i++) {
        const isp = upload_isps_count[i];
        let html = `<tr> <td>${isp["isp"]}</td><td>${isp["file_count"]}</td></tr>`;

        $("#isp-count-table").append(html);
      }
    },
  });
});
