$(document).ready(function () {
	$.ajax({
		type: "POST",
		url: "/harrow/model/admininfo.php",
		data: {
			type: "initial_choices_content_type",
		},
		success: function (response) {
			// $(".content-selector").append(html);

			let content_responses = JSON.parse(response);

			for (const content_array in content_responses) {
				const content_type = content_responses[content_array][0];

				let html = `<button id="${content_type}" class="content_type_choice">${content_type}</button>`;
				$(".content-selector  > .table-card > .buttons").append(html);
			}
		},
	});

	// ------------------ CONTENT-TYPE ---------------------------
	let all_selected_content = 0;
	$(document).on("click", "#select-all-content", function () {
		if (all_selected_content == 0) {
			$(".content_type_choice").addClass("selected");
			all_selected_content = 1;
			$(this).html("Unselect All");
		} else {
			$(".content_type_choice").removeClass("selected");
			all_selected_content = 0;
			$(this).html("Select All");
		}

		selected_content_types = get_selected(".content-selector");

		get_data(selected_content_types, "content_type_histogram");
	});

	$(document).on("click", ".content_type_choice", function () {
		let id = $(this).attr("id");
		let classes = $(this).attr("class").split(" ");

		if ($.inArray("selected", classes) != -1) {
			$(this).removeClass("selected");
		} else {
			$(this).addClass("selected");
		}
		selected_content_types = get_selected(".content-selector");

		get_data(selected_content_types, "content_type_histogram");
	});
});

function get_selected(selector_div) {
	let selected_elements = [];

	$(selector_div)
		.find(".selected")
		.each(function () {
			selected_elements.push($(this).attr("id"));
		});
	console.log(selected_elements);
	return selected_elements;
}

function get_data(data_array, type) {
	if (data_array.length > 0) {
		$.ajax({
			type: "POST",
			url: "/harrow/model/tables_data.php",
			data: { type: type, data_array },
			success: function (response) {
				let ttl_data = JSON.parse(response);
				create_histogram(ttl_data, "ttl_chart");
			},
		});
	}
}

function create_histogram(data, div) {
	let max_val = data.max;
	let min_val = data.min;
	delete data.min;
	delete data.max;
	let bucket_width = (max_val - min_val) / 10;

	let datasets = [];

	let labels = [
		`${min_val}-${bucket_width - 1}`,
		`${bucket_width}-${2 * bucket_width - 1}`,
		`${2 * bucket_width} - ${3 * bucket_width - 1}`,
		`${3 * bucket_width} - ${4 * bucket_width - 1}`,
		`${4 * bucket_width} - ${5 * bucket_width - 1}`,
		`${5 * bucket_width} - ${6 * bucket_width - 1}`,
		`${7 * bucket_width} - ${8 * bucket_width - 1}`,
		`${9 * bucket_width} - ${max_val}`,
	];

	for (const content_type in data) {
		let buckets = {
			0: 0,
			1: 0,
			2: 0,
			3: 0,
			4: 0,
			5: 0,
			6: 0,
			7: 0,
			8: 0,
			9: 0,
		};
		let content_data = data[content_type];
		console.log(content_data);
		for (let i = 0; i < content_data.length; i++) {
			const ttl = content_data[i][1];

			let ttl_bucket = get_data_bucket(ttl, bucket_width, min_val);
			buckets[ttl_bucket]++;
		}

		let chart_data = [];
		for (const bucket in buckets) {
			const bucket_count = buckets[bucket];
			chart_data.push(bucket_count);
		}

		let color = random_color();
		let dataset = {
			label: content_type,
			data: chart_data,
			backgroundColor: color,
			borderColor: color,
			borderWidth: 1,
		};
		datasets.push(dataset);
	}
	console.log(datasets);
	let parent_id = $(`#${div}`).parent().attr("id");
	try {
		$(`#${div}`).remove();
		$(`#${parent_id}`).append(
			`<canvas id="${div}" class="chart"></canvas>`
		);
	} catch (e) {}

	var ctx = document.getElementById(div).getContext("2d");

	var myChart = new Chart(ctx, {
		type: "bar",
		data: {
			labels: labels,
			datasets: datasets,
		},
		options: {
			scales: {
				y: {
					beginAtZero: true,
				},
			},
		},
	});
}

function get_data_bucket(value, bucket_width, min) {
	let bucket_width_upper = bucket_width;
	let bucket_width_lower = min;

	let bucket = 0;
	for (let i = 0; i <= 10; i++) {
		if (value >= bucket_width_lower && value <= bucket_width_upper) {
			bucket = i;
		}
		bucket_width_lower = bucket_width_upper;
		bucket_width_upper += bucket_width;
	}

	if (bucket == 10) {
		bucket = 9;
	}

	return bucket;
}

function random_color() {
	let color = `rgb(${Math.round(Math.random() * 255)},${Math.round(
		Math.random() * 255
	)},${Math.round(Math.random() * 255)})`;

	return color;
}

function get_datasets() {
	let datasets = {};
	for (let i = 0; i < 10; i++) {
		datasets[i] = {
			label: i,
			data: [],
			backgroundColor: "darkorange",
			borderColor: "darkorange",
			borderWidth: 1,
		};
	}
	return datasets;
}
