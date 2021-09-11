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
	return selected_elements;
}

function get_data(data_array, type) {
	if (data_array.length > 0) {
		$.ajax({
			type: "POST",
			url: "/harrow/model/tables_data.php",
			data: { type: type, data_array },
			success: function (response) {
				let data = JSON.parse(response);

				let chart_colors = [];
				let pie_colors = [];

				for (const content_type in data.ttl_data) {
					let color = random_color();
					chart_colors.push(color);
					if ($.inArray(content_type, data_array) != -1) {
						pie_colors.push(color);
					}
				}

				create_histogram(data.ttl_data, "ttl_chart", pie_colors);

				create_pie(
					data.cacheability_data,
					"cacheability_pie",
					pie_colors,
					data_array
				);
			},
		});
	} else {
		create_histogram({}, "ttl_chart", []);
		create_pie({}, "cacheability_pie",[],[]);
	}
}

function create_pie(data, div, colors, selected) {
	let parent_id = $(`#${div}`).parent().attr("id");
	try {
		$(`#${div}`).remove();
		$(`#${parent_id}`).append(
			`<canvas id="${div}" class="chart"></canvas>`
		);
	} catch (e) {}

	let grouped_data = {};
	let others_percentage = 100; // total % percentage is 100
	

	for (const content_cache in data) {
		const content = data[content_cache];

		let content_title = content[0];

		grouped_data[content_title] = {
			private: 0,
			public: 0,
			no_cache: 0,
			no_store: 0,
			color: "grey",
		};
	}



	for (const content_cache in data) {
		const content = data[content_cache];

		let content_title = content[0];
		let content_cache_title = content[1].replace("-", "_");
		let content_value = parseFloat(content[4]);

		grouped_data[content_title][content_cache_title] += content_value;
	}

	let labels = [];
	let chart_data = {
		backgroundColor: [],
		borderColor: [],
		data: [],
	};

	console.log("------------");
	console.log(grouped_data);
	let i = 0;
	for (const content in grouped_data) {
		const obj = grouped_data[content];
		if ($.inArray(content, selected) != -1) {
			let label = `${content}:private`;
			labels.push(label);
			chart_data.data.push(obj["private"]);

			label = `${content}:public`;
			labels.push(label);
			chart_data.data.push(obj["public"]);

			label = `${content}:no_cache`;
			labels.push(label);
			chart_data.data.push(obj["no_cache"]);

			label = `${content}:no_store`;
			labels.push(label);
			chart_data.data.push(obj["no_store"]);

			obj["color"] = colors[i];
			i++;
			for (let i = 0; i < 4; i++) {
				chart_data.backgroundColor.push(obj["color"]);
				chart_data.borderColor.push("white");
			}

			others_percentage -= obj["private"];
			others_percentage -= obj["public"];
			others_percentage -= obj["no_cache"];
			others_percentage -= obj["no_store"];
		}
	}

	console.log(chart_data);

	labels.push("other");
	chart_data.backgroundColor.push("grey");
	chart_data.borderColor.push("grey");
	chart_data.data.push(others_percentage);

	let ctx = document.getElementById(div).getContext("2d");
	var myChart = new Chart(ctx, {
		type: "pie",
		data: {
			labels: labels,
			datasets: [chart_data],
		},
		options: {
			title: {
				display: true,
				text: "Cacheability per content type",
			},
			elements:{arc:{borderWidth:0.2}},
			responsive: true,
		},
	});
}

function create_histogram(data, div, colors) {
	let parent_id = $(`#${div}`).parent().attr("id");
	try {
		$(`#${div}`).remove();
		$(`#${parent_id}`).append(
			`<canvas id="${div}" class="chart"></canvas>`
		);
	} catch (e) {}
	let max_val = data.max;
	let min_val = data.min;
	delete data.min;
	delete data.max;
	let bucket_width = (max_val - min_val) / 10;

	let datasets = [];

	let labels = [
		`${min_val} - ${bucket_width - 1}`,
		`${bucket_width} - ${2 * bucket_width - 1}`,
		`${2 * bucket_width} - ${3 * bucket_width - 1}`,
		`${3 * bucket_width} - ${4 * bucket_width - 1}`,
		`${4 * bucket_width} - ${5 * bucket_width - 1}`,
		`${5 * bucket_width} - ${6 * bucket_width - 1}`,
		`${7 * bucket_width} - ${8 * bucket_width - 1}`,
		`${9 * bucket_width} - ${max_val}`,
	];

	let color_ctr = 0;
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

		let dataset = {
			label: content_type,
			data: chart_data,
			backgroundColor: colors[color_ctr],
			borderColor: colors[color_ctr],
			borderWidth: 1,
		};
		color_ctr++;
		datasets.push(dataset);
	}

	console.log(datasets);

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
