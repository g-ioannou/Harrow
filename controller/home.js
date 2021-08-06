let har_list = []

$(document).ready(function () {
    // const handler = new UploadHandler()
    

    $.ajax({
        type: "GET",
        url: "/harrow/model/admin.php",
        
        success: function (response) {
            if (response=='success'){
                $("#admin-btn").show();
            }
        }
    });

    //let files = $("#upload-btn").prop('files')
    $("#upload-btn").change(function(){
        const files = $("#upload-btn");
        fileList = this.files;
        
        for (let i = 0; i < fileList.length; i++) {
            uploadFile(fileList[i])
        }
    })
});


function uploadFile(file) {
    let fr = new FileReader()
    current_id = har_list.length
    fr.onload=function(){
        try {
            let harFile = new HARfile(current_id,
                                    file.name,
                                    file.size,
                                    JSON.parse(fr.result));
            har_list.push(harFile)
        } catch(error){
            console.log(error);
        }
    }
    fr.readAsBinaryString(file)
}

class HARfile{
    constructor(id,name,size,contents){
        this.id = id
        this.name = name
        this.size = size
        this.contents = this.clean_contents(contents.log.entries)
    }

    clean_contents(contents){
        let cleaned_entries = []

        for (let i = 0; i < contents.length; i++) {
            const entry = contents[i];

            const getHostName = (url) => {
                return new URL(url).hostname;
            }
            
           
            let cleaned_entry = {
                'startedDateTime':entry.startedDateTime,
                'timings':{
                    'wait':entry.timings.wait
                },
                "serverIPAddress":entry.serverIPAddress,
                "request":{
                    'method':entry.request.method,
                    'url': getHostName(entry.request.url),
                    'headers': cleanHeaders(entry.request.headers)
                },
                "response":{
                    "status":entry.response.status,
                    "statusText":entry.response.statusText,
                    "headers": cleanHeaders(entry.response.headers)
                }
            }
            cleaned_entries.push(cleaned_entry)  
        }
        console.log(cleaned_entries);
        return cleaned_entries

        function cleanHeaders(headers) {
            let cleaned_headers = []
            for (let i = 0; i < headers.length; i++) {
                const header = headers[i];
                let name = header.name.toLowerCase();

                if (name == "content-type" || 
                    name == "cache-control"||
                    name == "pragma"       ||
                    name == "expires"      ||
                    name == "age"          ||
                    name == "last-modified"||
                    name == "host"         ){
                        cleaned_headers.push(header)
                    }
                
            }
            return cleaned_headers 
        }
    }
}