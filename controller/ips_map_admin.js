// map admin style
var mymap = L.map("mapid", {
	zoomControl: false,
}).setView([0, 0], 3);
L.tileLayer(
	"https://api.mapbox.com/styles/v1/gioannou/cksrvxxau2j6l18o5z2pjigy0/tiles/256/{z}/{x}/{y}@2x?access_token=pk.eyJ1IjoiZ2lvYW5ub3UiLCJhIjoiY2tzOGVuZWhmMTlyMDMxczN4aXhlaTFvbSJ9.orSKOqbjH3hFv4LAPLJqRw",
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

//map functionality (ip)

$(document).ready(function () {
	$("#back-to-home").on("click", function () {
		window.location.replace("/harrow/view/home_admin/home_admin.php");
	});

	$.ajax({
		type: "GET",
		url: "/harrow/model/ips_map_admin.php",

		success: function (response) {
			let ip_pairs = JSON.parse(response);

			let strength = [];

			for (let i = 0; i < ip_pairs.length; i++) {
				const ip_array = ip_pairs[i];
				let current_strength = ip_array[2];
				strength.push(current_strength);
			}

			let maximum = Math.max(...strength); // ... unpacks the object e.g. ...[1,2,3,4] == 1,2,3,4
			let minimum = Math.min(...strength);

			for (let i = 0; i < ip_pairs.length; i++) {
				const ip_array = ip_pairs[i];

				// when (promises are returned) proceed with the two results
				$.when(getPoint(ip_array[0]), getPoint(ip_array[1])).done(function (
					ip1_result,
					ip2_result
				) {
					let lat1 = ip1_result["latitude"];
					let lon1 = ip1_result["longitude"];

					let lat2 = ip2_result["latitude"];
					let lon2 = ip2_result["longitude"];

					let pointA = new L.LatLng(lat1, lon1);
					let pointB = new L.LatLng(lat2, lon2);

					let pointList = [pointA, pointB];

					let weight = normalize(ip_array[2], minimum, maximum);

					if (weight < 1) {
						weight = 1;
					}
					let polyline = new L.Polyline(pointList, {
						color: "#F0A93C",
						weight: weight,
						opacity: 1,
						smoothFactor: 10,
					});
					polyline.addTo(mymap);

					let home_address_icon = L.icon({
						iconUrl: "/harrow/view/images/map-home.png",
						iconSize: [30, 30],
						popupAnchor: [-3, -76],
						iconAnchor: [20, 20],
					});
					let server_address_icon = L.icon({
						iconUrl: "/harrow/view/images/map-server.png",
						iconSize: [30, 30],
						popupAnchor: [-3, -76],
					});
					L.marker(pointB, { icon: home_address_icon })
						.addTo(mymap)
						.bindPopup(`IP address: ${ip_array[1]}`);
					L.marker(pointA, { icon: server_address_icon })
						.addTo(mymap)
						.bindPopup(`IP address: ${ip_array[0]}`);
				});
			} // end of ip iterations
		},

		error: function (response) {
			console.log(response);
		},
	}); //end of sql querry ajax
});

function normalize(number, min, max) {
	let normalized = ((number - min) / (max - min)) * 20;

	return normalized;
}

// returns a promise
async function getPoint(ip_address) {
	let url = `http://api.ipstack.com/${ip_address}?access_key=94257e497e5ef89f67bcc18fb759ed74`;
	return $.ajax({
		type: "POST",
		url: url,
		success: function (response) {},
	});
}
