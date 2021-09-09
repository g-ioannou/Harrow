
// ------------------ DAYS ---------------------------
let all_selected_days = 0;
$(document).on("click", "#select-all-day", function () {
  if (all_selected_days == 0) {
    $(".day_choice").addClass("selected");
    all_selected_days = 1;
    $(this).html("Unselect All");
  } else {
    $(".day_choice").removeClass("selected");
    all_selected_days = 0;
    $(this).html("Select All");
  }

  get_selected(".day-selector");
});

$(document).on("click", ".day_choice", function () {
    let id = $(this).attr("id");
    let classes = $(this).attr("class").split(" ");
    
    if ($.inArray("selected", classes) != -1) {
        $(this).removeClass("selected");
    }
    else {
        $(this).addClass("selected");
    }
    get_selected(".day-selector");
      
});

// ------------------ ISP ---------------------------

let all_selected_isp = 0;
$(document).on("click", "#select-all-isp", function () {
  if (all_selected_isp == 0) {
    $(".isp_choice").addClass("selected");
    all_selected_isp = 1;
    $(this).html("Unselect All");
  } else {
    $(".isp_choice").removeClass("selected");
    all_selected_isp = 0;
    $(this).html("Select All");
  }

  selected_isps = get_selected(".isp-selector");
  
  get_data(selected_isps,"isp_chart");
});


$(document).on("click", ".isp_choice", function () {
    let id = $(this).attr("id");
    let classes = $(this).attr("class").split(" ");

    if ($.inArray("selected", classes) != -1) {
        $(this).removeClass("selected");
    }
    else {
        $(this).addClass("selected");
    }
    selected_isps = get_selected(".isp-selector");
    
    get_data(selected_isps,"isp_chart")
});
    
// ------------------ CONTENT-TYPE ---------------------------
let all_selected_content=0;
$(document).on("click", "#select-all-content", function () {
    if (all_selected_content == 0) {
      $(".content_type_choice").addClass("selected");
      all_selected_content= 1;
      $(this).html("Unselect All");
    } else {
      $(".content_type_choice").removeClass("selected");
      all_selected_content = 0;
      $(this).html("Select All");
    }
  
    selected_content_types = get_selected(".content-selector");

    get_data(selected_content_types,"content_type_chart")
});
  

$(document).on("click", ".content_type_choice", function () {
    let id = $(this).attr("id");
    let classes = $(this).attr("class").split(" ");

    if ($.inArray("selected", classes) != -1) {
        $(this).removeClass("selected");
    }
    else {
        $(this).addClass("selected");
    }
    selected_content_types = get_selected(".content-selector");
    
    get_data(selected_content_types, "content_type_chart");

});

// ------------------ METHOD ---------------------------
let all_selected_method=0;
$(document).on("click", "#select-all-method", function () {
  if (all_selected_method == 0) {
    $(".method_type_choice").addClass("selected");
    all_selected_method = 1;
    $(this).html("Unselect All");
  } else {
    $(".method_type_choice").removeClass("selected");
    all_selected_method = 0;
    $(this).html("Select All");
  }

  selected_methods = get_selected(".method-selector");
  
  get_data(selected_methods, "method_chart");
});

$(document).on("click", ".method_type_choice", function () {
    let id = $(this).attr("id");
    let classes = $(this).attr("class").split(" ");

    if ($.inArray("selected", classes) != -1) {
        $(this).removeClass("selected");
    }
    else {
        $(this).addClass("selected");
    }
    selected_methods = get_selected(".method-selector");
  
    get_data(selected_methods, "method_chart");
});


function get_selected(selector_div) {
  let selected_elements = [];
   
    $(selector_div)
      .find(".selected")
      .each(function () {
          selected_elements.push($(this).attr('id'));
      });
    console.log(selected_elements);
    return selected_elements;
}

function get_data(data_array,type){
    $.ajax({
        type: "POST",
        url: "/harrow/model/admininfo.php",
        data: {type:type},
        success: function (response) {
            let time_data = JSON.parse(response);
            console.log(time_data);
        }
    });
}

// $.ajax({
    //     type: "POST",
    //     url: "../../model/admininfo.php",
    //     data: { type: "method_types", method_list: method_type_array },
    //     success: function (response) {},
    // });


// console.log("okk");
//     google.charts.load('current',{packages:['corechart','bar']});
//     google.charts.setOnLoadCallback();
//  console.log("okk");
//     function load_data(avg_wait)
//     {

//     $.ajax({
//         method: "POST",
//         url: "../../model/admininfo.php",
//         data:
//         { type:"chart_area"},
//         dataType:"JSON",
//         success: function (response)
//          {
//            drawChart(response);
//          }
//           });
//     }
//     function drawChart(chart_data)
// {
//     var jsonData = chart_data;
//     var data = new google.visualization.DataTable();
//     data.addColumn('number', 'Day Time');
//     data.addColumn('number', 'Average Wait');
//     $.each(jsonData, function(i, jsonData){
//         var day_time = jsonData.day_time;
//         var avg_wait = parseFloat($.trim(jsonData.avg_wait));
//         data.addRows([[avg_wait, day_time]]);
//     });
//     var options = {

//         hAxis: {
//             title: "Day Time"
//         },
//         vAxis: {
//             title: 'Average Wait'
//         }
//     };

//     var chart = new google.visualization.ColumnChart(document.getElementById('chart_area'));
//     chart.draw(data, options);
// }
