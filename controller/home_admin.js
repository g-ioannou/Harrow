$(document).ready(function () {
  var number = $("#numbers").val();

  var regs;

  $.ajax({
    method: "POST",
    url: "../../model/admininfo.php",
    data: {
      type: "regs",
    },

    success: function (response) {
      console.log("ok");
      $("#numbers").html(response).show;
    },
    error: function () {
      alert("Not Okay");
    },
  });

  var methods;

  $.ajax({
    method: "POST",
    url: "../../model/admininfo.php",
    data: { type: "methods" },
    success: function (response) {
      $("#methods").html(response).show;
    },
  });

  $.ajax({
    method: "POST",
    url: "../../model/admininfo.php",
    data: { type: "status" },
    success: function (response) {
      $("#status").html(response).show;
    },
  });

  $.ajax({
    method: "POST",
    url: "../../model/admininfo.php",
    data: { type: "domain" },
    success: function (response) {
      $("#domain").html(response).show;
    },
    error: function () {
      alert("Not Okay");
    },
  });

  $.ajax({
    method: "POST",
    url: "../../model/admininfo.php",
    data: { type: "isps" },
    success: function (response) {
      $("#isps").html(response).show;
    },
    error: function () {
      alert("Not Okay");
    },
  });
  $.ajax({
    method: "POST",
    url: "../../model/admininfo.php",
    data: { type: "average" },
    success: function (response) {
      let html = `<div class="avg-data">${response}</div>`;
      $("#average").append(html);
      
    },
  });
});
