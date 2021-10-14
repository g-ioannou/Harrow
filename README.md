# Harrow

WEB project 2021

The general objective of the project is to develop a complete system of collection, management and
analysis of crowdsourced information concerning HTTP traffic data.
More precisely, the purpose is to build a population collection system of
HAR data in order to provide some basic analysis for each user individually, but also
general analyzes concerning the internet infrastructure in an area (eg Patras).

**Μην χρησιμοποιειτε πολυ το heatmap γιατι κανει API call στο ipstack που εχει limit στα requests (5000)**

**_Αν θελετε να το τεσταρετε για πολλα calls φτιαξτε τζαμπα λογαριασμο στο ipstack.com και θα σας δωσει API key. ΜΕΤΑ πηγαινετε στο `../view/style/heatmap.js` και βαλτε στο YOUR_API_KEY το key σας_**
`` let url = `http://api.ipstack.com/${entry_ip}?access_key=YOUR_API_KEY`; ``

For project were used :
- HTML
- CSS
- JAVASCRIPT
	- Βιβλιοθήκη JQUERY
- PHP
- MySQL
- APIs
	- Font Awesome (Icons)
	- LeafletJS (Maps Functionallity) 
	- Map Box (Base Map Provider for LeafletJS)
	- Leaflet-Heat (Heatmap Layer for LeafletJs)
  	- CHART JS (Graphs)
- Enviroment XAMPP.
- Port 8080 for configuration of APACHE Web Server.
- MySQL port: default
- Model View Controller for file Structure.

Structure of the Database (ER, table schema)

![Στιγμιότυπο οθόνης (686)](https://user-images.githubusercontent.com/66412286/137297659-de1783a4-efc8-46d3-a90b-2ecf47cbf7ba.png)

User:

Log in Page: 

![image](https://user-images.githubusercontent.com/66412286/137298762-be57c807-bf5b-4823-b46e-6055076085cd.png)

![image](https://user-images.githubusercontent.com/66412286/137298834-aa19469b-fa49-4077-bd86-bff5bd3acf68.png)

Forgot Password Page: 

![image](https://user-images.githubusercontent.com/66412286/137299001-1330efc5-dcd5-4550-bc46-26506b5cea65.png)

![image](https://user-images.githubusercontent.com/66412286/137299097-8481db65-7ef1-47f7-aa31-e14ccbe3c18d.png)

![image](https://user-images.githubusercontent.com/66412286/137299999-376f0407-fb43-43a2-94a1-8c79ef57b698.png)

Home Page:

![image](https://user-images.githubusercontent.com/66412286/137300087-f524facb-0b29-43dd-9205-489c989b81bc.png)

Upload Page:

![image](https://user-images.githubusercontent.com/66412286/137300161-46807a1e-7f1b-46f5-b399-aafb26dbe8ba.png)

Heatmap Page:

![image](https://user-images.githubusercontent.com/66412286/137300232-1efccc67-128d-45b0-bc95-2ce72b7d3142.png)


Admin:

Admin Dashboard:

![image](https://user-images.githubusercontent.com/66412286/137300301-8c1e7ebd-9d02-4af0-9064-c1a26d30d000.png)


Admin Avg. Time Analysis:

Filter per Content-Type:

![image](https://user-images.githubusercontent.com/66412286/137300539-45951a6f-b479-40a7-b895-fdec17bcc86d.png)

Filter per Day: 

![image](https://user-images.githubusercontent.com/66412286/137300648-fe8d661d-9fc4-415d-a6b6-513a9a9155cb.png)

Filter per HTTP Method:

![image](https://user-images.githubusercontent.com/66412286/137300786-61f46ae5-a61e-480b-90db-8a9606211c32.png)

Filter per ISP:

![image](https://user-images.githubusercontent.com/66412286/137300980-78240537-794c-4189-b9a4-8f9497359060.png)

Admin Response Analysis:

TTL Histogram:

![image](https://user-images.githubusercontent.com/66412286/137301143-a8a99e58-a4dc-43cc-9d3c-5e5578730b7e.png)

Pie chart: 

![image](https://user-images.githubusercontent.com/66412286/137301247-629618ed-c4d6-4199-8ac7-7069022811f1.png)

Admin IP-Map:

![image](https://user-images.githubusercontent.com/66412286/137301416-4d7ac578-2f8b-4242-815a-ac3df60fa946.png)

