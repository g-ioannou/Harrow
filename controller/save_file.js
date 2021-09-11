$(document).ready(function () {
	$("#save-to-server-btn").click(function (e) {
		for (const id in uploaded_selected_files) {
			const file = uploaded_selected_files[id];

			$.when(upload_file_to_server(file)).done(function () {
				update_uploaded_files();
			});
		}
	});
});

function upload_file_to_server(file) {
	notify("upload", `<b>Uploading file: ${file.name}`);

	return $.ajax({
		type: "POST",
		url: "/harrow/model/save_file.php",
		data: {
			name: file.name,
			size: file.size,
			contents: JSON.stringify({ contents: file.contents }),
		},

		success: function (response) {
			notify("success", `<b>File ${file.name} uploaded.</b>`);
		},
		error: function (error) {
			console.log(error);
			notify(
				"error",
				`<b>Couldn't upload ${file.name}</b> <br> Error 500 (internal server error): ${error}`
			);
		},
	});
}
