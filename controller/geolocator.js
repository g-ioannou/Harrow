let user_geolocation_data = {};

$.ajax({
  method: "GET",
  url: "https://ipapi.co/json/",
  success: function (data) {
    user_geolocation_data = data;
    $.ajax({
      type: "POST",
      url: "/harrow/controller/set_location.php",
      data: data,
      error: function (response) {
        console.error(response);
      },
    });
  },
  error: function (error) {
    console.error(error);
  },
});
