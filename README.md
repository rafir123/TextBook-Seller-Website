# CIS454_Book_Seller
This project is an implementation of the design document for a Book Selling application that was provided to us via CIS 454 at Syracuse University.

## Contributors
Our team consists of:
* Brian Welsh
* Zijian Chen
* Jiaqi Feng
* Rafiul Rafsan
* Beibei Zhang

## Getting Started

These instructions will outline how to get the environment set up so you can run and test our website. This will outline be for MacOS Platforms.

### Prerequisites
Our codebase is built using PHP, therefore, an apache server is needed to run the code. We elected to use MAMP, though any other program will do. NOTE: this tutorial is for MAMP, but a XAMPP installation is quite similar. To access the database, we chose to use SEQUEL PRO, though there are Windows alternatives available.

Download Links:
* [MAMP](https://www.mamp.info/en/downloads/)
* [Sequel Pro](https://www.sequelpro.com)

### Installation
1. Open up MAMP (NOT MAMP PRO).
2. Click 'Start Servers' and ensure green lights are lit up next to the Apache Server and MySQL Server.
3. Next, navigate to '/Applications/MAMP/htdocs' in a finder window (or terminal). This is where you store code for the Apache server to run.
4. Unzip the CIS454_Book_Seller folder into the folder from step 3. 
5. To ensure everything is working up until this point, open Chrome and navigate to 'http://localhost:8888/CIS454_Book_Seller/public/'. This should display a login form. NOTE: Since we have not configured the database, login will not work. 
6. Open up Sequel Pro. Enter the following connection details and connect.
	* Host: 127.0.0.1
	* Username: root
	* Password: root
	* Port: 8889
7. After connecting, Click 'Choose Database' at the top left and select 'Add Database'. Set the Database name to 'BookSeller', and leave the other fields as default. After creation, select the BookSeller database.
8. Navigate to the 'Query' tab. Copy the entire contents of CIS_454_BookSeller/data/init.sql into the Query tab and execute the statement (NOTE: To execute, select the entire copied contents with CMD+A and press 'Run Selection'). This should build 3 tables: bookinfo, reports, user_info.
9. Now, if you return to the Chrome window, you should be able to login. 3 default credentials for buyer, seller, and admin were created for testing. Their user information is below.
	* Admin Account - username: admin - password: admin
	* Buyer Account - username: buyer - password: buyer
	* Seller Account - username: seller - password: seller
10. All functionality for the website should now be working properly.

## Built With
* PHP
* Apache
* MySQL
* HTML, CSS
* Bootstrap
