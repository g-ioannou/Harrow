// map admin style
var mymap = L.map("mapid", {
        zoomControl: false
    }).setView([0, 0], 3);
    L.tileLayer("https://api.mapbox.com/styles/v1/gioannou/cksrvxxau2j6l18o5z2pjigy0/tiles/256/{z}/{x}/{y}@2x?access_token=pk.eyJ1IjoiZ2lvYW5ub3UiLCJhIjoiY2tzOGVuZWhmMTlyMDMxczN4aXhlaTFvbSJ9.orSKOqbjH3hFv4LAPLJqRw", {
        maxZoom: 18,
        tileSize: 512,
        zoomOffset: -1,
    }).addTo(mymap);


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

    
//map functionality (ip)
let user_ip = {};

$(document).ready(function () {

    $.ajax({
        type: "GET",
        url: "/harrow/model/ips_map_admin.php",

        success: function (response) {
            console.log(response);
        },

        error: function (response) {
            console.log(response);
        }
    })
    });
