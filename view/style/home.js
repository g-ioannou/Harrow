$(document).ready(function () {
  let height = $(".top-bar").height();
  let margin = parseInt($(".top-bar").css("padding-bottom"));

  if (height > 0) {
    $(".main").css("padding-top", height + 3 * margin);
  }

  $("#fake-upload").click(function (e) {
    $("#upload-btn").click();
  });

  $("#hidden-display").click(function (e) {
    e.preventDefault();
    for (let i = 0; i < har_list.length; i++) {
      const file = har_list[i];
        if (file.shown==0){
            $(".file-table").append(file.displayHTML());
        }
    }
  });
});
