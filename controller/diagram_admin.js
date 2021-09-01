// $('#select').change(function () { 
//     $(this).find("option").each(function () {
//         console.log("allaksa");
//                 $('#' +  $(this).attr('target')).hide();
//     });
//     $('#' + $(this).attr('target')).show();

// });

$(document).on("click", ".isp_choice",function(){
    let id = $(this).attr('id');
    console.log(id);
    // $.ajax({
    //     type: "POST",
    //     // 
    //     data: {"type" : id},
    
    //     success: function (response) {
            
    //     }
    // });
} )
            let isp_array = [];
            $(document).on("click", ".isp_choice",function(){
                let id = $(this).attr('id');
                let classes = $(this).attr('class').split(' ');

                
                for(let i=0; i<classes.length; i++){
                    const current_class = classes[i];
                    if (current_class == 'unselected'){
                        content_type_array.push(id);
                        $(this).addClass('selected');
                        $(this).removeClass('unselected');
                    }

                    if (current_class == 'selected'){
                        $(this).removeClass('selected');
                        $(this).addClass('unselected');
                        isp_array = isp_array.filter(item => item !== id);
                    }
                }
                $.ajax({
                    type: "POST",
                    url: "../../model/admininfo.php",
                    data: {"type" : "isp", "isp_list": isp_array},
                    success: function (response) {
                        
                    }
                });
            });
    
let content_type_array = [];
$(document).on("click", ".content_type_choice",function(){
    let id = $(this).attr('id');
    let classes = $(this).attr('class').split(' ');

    
    for(let i=0; i<classes.length; i++){
        const current_class = classes[i];
        if (current_class == 'unselected'){
            content_type_array.push(id);
            $(this).addClass('selected');
            $(this).removeClass('unselected');
        }

        if (current_class == 'selected'){
            $(this).removeClass('selected');
            $(this).addClass('unselected');
            content_type_array = content_type_array.filter(item => item !== id);
        }
    } 
    $.ajax({
            type: "POST",
            url: "../../model/admininfo.php",
            data: {"type" : "content_types", "content_list": content_type_array},
            success: function (response) {
                console.log(response);
            }
    });
});



let method_type_array = [];
$(document).on("click", ".method_type_choice", function () {
        let id = $(this).attr('id');
        let classes = $(this).attr('class').split(' ');


        for (let i = 0; i < classes.length; i++) {
            const current_class = classes[i];
            if (current_class == 'unselected') {
                method_type_array.push(id);
                $(this).addClass('selected');
                $(this).removeClass('unselected');
            }

            if (current_class == 'selected') {
                $(this).removeClass('selected');
                $(this).addClass('unselected');
                method_type_array = method_type_array.filter(item => item !== id);
            }
        }
        $.ajax({
            type: "POST",
            url: "../../model/admininfo.php",
            data: { "type": "method_types", "method_list": method_type_array },
            success: function (response) {
                
            }
        });
});

       
$(document).on("click", ".day_choice",function(){
    let id = $(this).attr('id');
    console.log(id);
    // $.ajax({
    //     type: "POST",
    //     // 
    //     data: {"type" : id},
    
    //     success: function (response) {
            
    //     }
    // });
} )

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



