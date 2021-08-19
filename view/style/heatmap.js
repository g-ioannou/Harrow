var mymap = L.map("map", { zoomControl: false }).setView([0, 0], 3);
let selected_files = {};
let user_files = {};
L.tileLayer(
  "https://api.mapbox.com/styles/v1/gioannou/cks8ff9v377p418kczsuiexno/tiles/256/{z}/{x}/{y}@2x?access_token=pk.eyJ1IjoiZ2lvYW5ub3UiLCJhIjoiY2tzOGVuZWhmMTlyMDMxczN4aXhlaTFvbSJ9.orSKOqbjH3hFv4LAPLJqRw",
  {
    maxZoom: 18,
    tileSize: 512,
    zoomOffset: -1,
  }
).addTo(mymap);

mymap.options.minZoom = 3;
mymap.options.maxBoundsViscosity = 1;
L.control
  .zoom({
    position: "bottomright",
  })
  .addTo(mymap);
let southWest = L.latLng(-89.98155760646617, -180),
  northEast = L.latLng(89.99346179538875, 180);
let bounds = L.latLngBounds(southWest, northEast);

mymap.options.maxBounds = bounds;

$(document).ready(function () {
  let legend_hidden = 1;
  $("#legend-tip").on("click", function () {
    if (legend_hidden == 1) {
      $(".legend-info").fadeIn(300);
      legend_hidden = 0;
    } else {
      $(".legend-info").fadeOut(300);
      legend_hidden = 1;
    }
  });

  let all_selected = 0;
  $("#select-all").click(function () {
    if (all_selected == 0) {
      heat = clearHeatmap();
      $("input:checkbox").prop("checked", true);
      selected_files = user_files;
      displayOnHeatmap(heat);
      all_selected = 1;
      $(this).html("Unselect all");
    } else {
      selected_files = {};
      clearHeatmap(heat);
      $("input:checkbox").prop("checked", false);
      $(this).html("Select all");
      all_selected = 0;
    }
  });

  $.ajax({
    type: "GET",
    url: "/harrow/model/get_file_user.php",
    success: function (response) {
      let files = JSON.parse(response);
      for (const id in files) {
        const file = files[id];
        let html = `<tr id="${file.db_id}" class="table-file">
                        <td><input type="checkbox" class="file-select" id="${file.db_id}"></td>
                        <td>${file.name}</td></tr>`;

        $(".file-list").append(html);
        user_files[file.db_id] = file;
      }
    },
  });

  $("#back-to-home").on("click", function () {
    window.location.replace("/harrow/view/home_user/home.php");
  });

  $("#close-side-panel").on("click", function () {
    $(".side-panel").fadeOut(300);
  });

  $("#open-panel").on("click", function () {
    $(".side-panel").fadeIn(300);
  });

  clearHeatmap();
  $(document).on("change", ".side-panel :checkbox", function () {
    selected_files = {};
    heat = clearHeatmap(heat);
    $(".side-panel")
      .find(":checkbox:checked")
      .each(function () {
        let id = $(this).attr("id");
        selected_files[id] = user_files[id];
      });
    displayOnHeatmap(heat);
  });
});

// this gets ip data only for 1 file
function displayOnHeatmap(heat) {
  try {
    let unique_addresses = new Set();
    let all_ip_addresses = [];
    let ctr = 0;
    let entry_ctr = 0;

    for (const id in selected_files) {
      const file = selected_files[id];

      $.ajax({
        type: "GET",
        url: "/harrow/model/get_file_ip.php",
        data: { file_id: file.db_id },
        success: function (response) {
          ctr++;

          let ip_addresses = JSON.parse(response);

          for (let i = 0; i < ip_addresses.length; i++) {
            const ip_obj = ip_addresses[i];
            unique_addresses.add(ip_obj["serverIpAddress"]);
            all_ip_addresses.push(ip_obj["serverIpAddress"]);
            entry_ctr++;
          }

          if (ctr == get_json_len(selected_files)) {
            let ip_addresses_count = {};

            for (const ip of unique_addresses) {
              ip_addresses_count[ip] = { count: 0 };
            }

            for (let i = 0; i < all_ip_addresses.length; i++) {
              const ip = all_ip_addresses[i];
              ip_addresses_count[ip]["count"]++;
            }

            for (const ip in ip_addresses_count) {
              let url = `http://api.ipstack.com/${ip}?access_key=29e960169862b3a0809ce40d9bb6acbc`;
              $.ajax({
                type: "GET",
                url: url,

                success: function (response) {
                  let latidude = response["latitude"];
                  let longitude = response["longitude"];
                  let strength = ip_addresses_count[ip]["count"];

                  heat.addLatLng([latidude, longitude, strength]);
                },
              });
            }
          }
        },
      });
    }
  } catch (e) {}
}
function get_json_len(json) {
  return Object.keys(json).length;
}

function get_json_keys(json) {
  console.log(Object.keys(json));
}

function clearHeatmap(heat) {
  try {
    mymap.removeLayer(heat);
  } catch (e) {}
  let new_heat = L.heatLayer([], {
    minOpacity: 1,
    gradient: {
      0.05: "lightgreen",
      0.1: "lime",
      0.2: "lightyellow",
      0.3: "yellow",
      0.4: "orange",
      0.5: "darkorange",
      0.6: "lightblue",
      0.7: "blue",
      0.8: "darkblue",
      0.85: "purple",
      0.93: "red",
    },
    radius: 12,
    blur: 25,
    max: 1,
  }).addTo(mymap);

  return new_heat;
}
