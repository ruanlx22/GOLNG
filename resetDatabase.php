<?php
//resetDatabase.php

//ensure user name and password fit for your phpadmin
$server = "localhost";
$userName = "root";
$password = "";

//connect to database
$connection = mysql_connect($server, $userName, $password);

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

//user table 


