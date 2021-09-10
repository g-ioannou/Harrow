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
				$(".content-choices").append(html);
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

    if(data_array.length > 0){
        $.ajax({
            type: "POST",
            url: "/harrow/model/tables_data.php",
            data: { type: type, data_array },
            success: function (response) {
                let ttl_data = JSON.parse(response);
				console.log(ttl_data);
            },
        });
    }
}

