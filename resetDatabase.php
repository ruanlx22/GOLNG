<?php
//resetDatabase.php
//error report
ini_set('display_errors',1);
ini_set('display_startup_errors' ,1);
error_reporting(E_ALL);
//ensure user name and password fit for your phpadmin
$server = "localhost";
$userName = "root";
$password = "";

//connect to database
$connection = mysqli_connect($server, $userName, $password);

// die if connection is invalid
if (!$connection){
  die("Connection to DB failed :" . mysqli_connect_error() . "</br>");
}

echo  "Successfully connected to DB!" . "</br>";

//Dropping old database
$sql = "DROP DATABASE IF EXISTS GOLNG";
if ($connection->query($sql) === TRUE){
    echo "Database dropped successfully!" . "</br>";
} else {
    echo "Error droppping database!" . $connection->error . "</br>" ;
}

//Create new database
$sql  = "CREATE DATABASE GOLNG CHARACTER SET utf8 COLLATE utf8_general_ci";
if ($connection->query($sql) === TRUE){
    echo "Database created successfully!" . "</br>";
} else {
    echo "Error creating database!" . $connection->error . "</br>" ;
}

//Grant access to the db user
$sql = "GRANT ALL ON GOLNG.* TO 'GOLNG'@'localhost' IDENTIFIED BY 'GOLNG'";
if ($connection->query($sql) === TRUE){
    echo "Access granted successfully!" . "</br>";
} else {
    echo "Error granting access database!" . $connection->error . "</br>";
}

//select GOLNG database
mysqli_select_db($connection,"GOLNG");

//Tables-Begin
//Add table here

//user_table
$sql = "CREATE TABLE userinfo (
id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
name varchar(100) DEFAULT NULL,
password varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";

if ($connection->query($sql) === true) {
    echo "userinfo table created successfully" . "</br>";
} else {
    echo "Error in creating userinfo table " . $connection->error . "</br>";
}

//company table 
$sql = "CREATE TABLE company (
id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
name varchar(100) DEFAULT NULL,
lat float DEFAULT NULL,
lon float DEFAULT NULL,
decription text NOT NULL,
url varchar(255) NOT NULL,
image varchar(255) NOT NULL,
category varchar(50) NOT NULL
)ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";

if ($connection->query($sql) === true) {
    echo "company table created successfully" . "</br>";
} else {
    echo "Error in creating company table " . $connection->error . "</br>";
}

$sql = "INSERT INTO `company` (`id`, `name`, `lat`, `lon`, `decription`, `url`, `image`, `category`) VALUES (NULL, 'WhiteSmoke AB', '57.688543', '11.906423', 'White Smoke run a consultacy business under the brand name White Smoke Consulting. The consulting part of White Smoke assist clients with technical, commersial and regulatory expertise as well as project management services related to LNG as marine fuel and LNG Bunkering. White Smoke is also a part owner of White Smoke Shipping AB, a company dedicated to the supply of LNG feedering and bunkering services.', 'http://www.whitesmoke.se', 'http://www.whitesmoke.se/images/WS1%20low%20wide%20small%202%20text.jpg', 'Consulting');";

if ($connection->query($sql) === true) {
    echo "Company added successfully" . "</br>";
} else {
    echo "Error in adding company data" . $connection->error . "</br>";
}


?> 


