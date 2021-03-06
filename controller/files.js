let uploaded_files = {};
let uploaded_selected_files = {};
let user_files = {};
let user_selected_files = {};

$(document).ready(function () {
	// const handler = new UploadHandler()
	update_uploaded_files();

	//  1. select-all new files button functionality
	// 1. is binded with 3. with an event listener (check 3.)
	let select_all = 0;
	$(document).on("click", "#select-all-new", function () {
		if (select_all == 0) {
			let ctr = 0;
			$(".new-files") //find all checkboxes checked inside .new-files
				.find(":checkbox")
				.each(function () {
					$(".new-files :checkbox").prop("checked", true);
					ctr++;
				}); // make all checkboxes of new files checked

			$("#selected-uploaded-files-number").html(ctr); // update the message
			if (ctr > 0) {
				// if files are found (table rows) are found inside the new files
				uploaded_selected_files = uploaded_files;
				$("#select-all-new").html("Unselect all");
			}
			select_all = 1; // will enter the else block on next click
		} else {
			// unchecking

			$(".new-list") // will find all the checkboxes and uncheck them
				.find(":checkbox")
				.each(function () {
					$(":checkbox").prop("checked", false);
				});
			$("#select-all-new").html("Select all");
			select_all = 0;
			uploaded_selected_files = {};
			$("#selected-uploaded-files-number").html("0");
		}
		checkNewFilesBtn();
	});

	// 2. same as 1. but is binded with 4.
	let select_all_old = 0;
	$(document).on("click", "#select-all-old", function () {
		if (select_all_old == 0) {
			let ctr = 0;
			$(".old-files")
				.find(":checkbox")
				.each(() => {
					$(".old-files :checkbox").prop("checked", true);
					ctr++;
				});
			if (ctr > 0) {
				user_selected_files = user_files;
				$("#select-all-old").html("Unselect all");
			}
			select_all_old = 1;
		} else {
			$(".old-list")
				.find(":checkbox")
				.each(function () {
					$(":checkbox").prop("checked", false);
				});
			$("#select-all-old").html("Select all");
			select_all_old = 0;
			user_selected_files = {};
			$("#selected-saved-files-number").html("0");
		}
		checkOldFilesBtn();
	});

	//3. listens for a change on the checkboxes of the new files table
	$(document).on("change", ".new-files :checkbox", function () {
		// if a change happens it clears the uploaded_SELECTED_files
		uploaded_selected_files = {};

		$(".new-files") // then finds all the selected files again
			.find(":checkbox:checked")
			.each(function () {
				let id = $(this).attr("id");
				uploaded_selected_files[id] = uploaded_files[id]; // updates the uploaded_selected_files with the selected files
			});

		let selected_files_ctr = get_json_len(uploaded_selected_files);
		$("#selected-uploaded-files-number").html(selected_files_ctr); // refreshes the files selected number html
		checkNewFilesBtn(); // makes checks for making buttons disabled or enabled
	});

	// 4. same as 3. but for files inluced the "Your files" table
	$(document).on("change", ".old-files :checkbox", function () {
		user_selected_files = {};
		$(".old-files")
			.find(":checkbox:checked")
			.each(function () {
				let id = $(this).attr("id");
				user_selected_files[id] = user_files[id];
			});

		let selected_files_ctr = get_json_len(user_selected_files);
		$("#selected-saved-files-number").html(selected_files_ctr);
		checkOldFilesBtn();
	});

	$(document).on("click", "#hidden-display", function () {
		$(".no-files").hide();
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

	$("#download-multiple-old-btn").click(function (e) {
		e.preventDefault();

		for (const id in user_selected_files) {
			const file = user_selected_files[id];
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
		$("#delete-multiple-new-btn").attr("disabled", true);
		$("#download-multiple-new-btn").attr("disabled", true);
		$("#save-to-server-btn").attr("disabled", true);
	});

	$("#delete-multiple-old-btn").click(function (e) {
		e.preventDefault();
		let id_list = [];
		for (const id in user_selected_files) {
			id_list.push(id);
			deleteFile(id);
			delete user_files[id];
		}

		for (let i = 0; i < id_list.length; i++) {
			const id = id_list[i];
			delete uploaded_selected_files[id];
			$(`#${id}`).fadeOut(300);
		}
	});

	$(document).on("click", ".file-dow-btn", function () {
		let id = $(this).attr("id");
		try {
			uploaded_files[id].download();
		} catch (e) {}

		try {
			user_files[id].download();
		} catch (e) {}
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

function update_uploaded_files() {
	$("#old-files-table").fadeOut(300);
	$(".saved-file").remove();
	$.ajax({
		type: "GET",
		url: "/harrow/model/get_file_user.php",

		success: function (response) {
			let files = JSON.parse(response);
			for (const f in files) {
				const file = files[f];
				let current_id = new Date().valueOf();
				$(".server-file").remove();
				current_id = current_id + Math.floor(Math.random() * 10000000);
				harFile = new HARfile(
					current_id,
					file.name,
					file.size,
					file.contents,
					1
				);
        

				user_files[current_id] = harFile;
				harFile.db_id = file.db_id;

				let html = harFile.displayHTML();

				$("#old-files-table").append(html);
			}
			$("#old-files-table").fadeIn(300);
		},

		error: function (response) {
			console.log(response);
		},
	});
}

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
				JSON.parse(fr.result),
				0
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
	let file_name = "";

	try {
		file_name = uploaded_files[file_id].name;
		delete uploaded_files[file_id];
		notify("delete", `Localy uploaded file <b>${file_name}</b> deleted.`);
	} catch (e) {}

	try {
		delete uploaded_selected_files[file_id];
		let count = get_json_len(uploaded_selected_files);
		$("#selected-uploaded-files-number").html(count);
	} catch (e) {}

	try {
		file_name = user_files[file_id].name;
		file_db_id = user_files[file_id].db_id;

		$.ajax({
			type: "POST",
			data: { file_id: file_db_id },
			url: "/harrow/model/delete_file_user.php",
			success: function (response) {
				delete user_files[file_id];
				notify("delete", `File <b>${file_name}</b> deleted from server.`);
				console.log(response);
			},
			error: function (error) {
				console.error(error);
			},
		});
	} catch (e) {}
}

function get_json_len(json) {
	return Object.keys(json).length;
}

class HARfile {
	constructor(id, name, size, contents, is_cleaned) {
		this.id = id;
		this.name = name;
		this.size = size;

		if (is_cleaned == 0) {
			this.contents = this.clean_contents(contents.log.entries);
			let current_size = (this.size / Math.pow(10, 6)).toFixed(1);
			this.size_display = `${current_size} MB`;
			if (this.size <= 1) {
				current_size = this.size / Math.pow(10, 3);
				this.size_display = `${current_size} KB`;
			}
		} else {
			this.contents = contents;
			let size_calc = new TextEncoder().encode(this.contents).length;
			this.size = size_calc;
			let current_size = this.size / Math.pow(10, 6);
			this.size_display = `${current_size} MB`;

			if (current_size <= 10000) {
				current_size = this.size / Math.pow(10, 3);
				this.size_display = `${current_size.toFixed(1)} KB`;
			}
		}
		this.db_id = 0;
		this.shown = 0;
		this.selected = 0;
	}

	get select() {
		return this.selected;
	}

	set select(value) {
		this.selected = value;
	}

	get file_size() {
		let size = new TextEncoder().encode(JSON.stringify(this.contents)).length;
		return size;
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
			a.remove();
		} catch (e) {
			notify("error", `<b>Unable to download file</b>. <br> Error: ${e}`);
		}
	}

	displayHTML() {
		this.shown = 1;

		let html = `<tr id="${this.id}" class="uploaded-file">
                <td><input type="checkbox" class="file-select" id="${this.id}" ></td>
                <td><i class="fal fa-file"></i>&nbsp;&nbsp; ${this.name}</td>
                <td>${this.size_display}</td>
                <td><button class="btn file-dlt-btn" id="${this.id}" class="${this.id}"><i class="fal fa-trash-alt"></i></button></td>
                <td><button class="btn file-dow-btn" id="${this.id}" class="${this.id}"><i class="fal fa-file-download"></i></button></td>
            </tr>
            `;
		if (this.db_id != 0) {
			html = `<tr id="${this.id}" class="saved-file">
                <td><input type="checkbox" class="file-select" id="${this.id}" ></td>
                <td><i class="fal fa-file"></i>&nbsp;&nbsp; ${this.name}</td>
                <td>${this.size_display}</td>
                <td><button class="btn file-dlt-btn file-dlt-btn-old" id="${this.id}" class="${this.id}"><i class="fal fa-trash-alt"></i></button></td>
                <td><button class="btn file-dow-btn" id="${this.id}" class="${this.id}"><i class="fal fa-file-download"></i></button></td>
            </tr>
            `;
		}

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
			// let temp_IP = entry.serverIPAddress.replace("[", "");
			// temp_IP = temp_IP.replace("]", "");

			let cleaned_entry = {
				startedDateTime: final_date_time,
				timings: {
					wait: entry.timings.wait,
				},
				serverIPAddress: entry.serverIPAddress
					.replace("[", "")
					.replace("]", ""),
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
					cleaned_header[name] = header["value"]
						.replace("-", "_")
						.split(";")[0];

					cleaned_headers.push(cleaned_header);
				}
			}
			return cleaned_headers;
		}
	}
}
