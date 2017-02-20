This Address book Project using REST API based on core.php. Clients can post the data via Postman
this application will handle the request and gives a response

To Run the Program

1. Download all the files and put under the xampp/wampp Folder

2. Install PostMan REST client in Chrome and Insert the SQL gpayments.sql in to the database

3. Consider that your host is localhost then via POSTMAN access the following url
   http://localhost/contacts/v1/api/person.create
   You can see the response

Please note all request should contain the below parameters in the Header 
apiKey : randomKey
Content-Type : application/json

To get the current apiKey please run the data.php script

For more detail Documentation read API_Document.pdf

@author : Annamalai
Any feedback or concern please email me to annamalai19@gmail.com
