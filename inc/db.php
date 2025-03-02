<?php 
// Database configuration 
$dbHost     = "localhost"; 
$dbUsername = "vecs00"; 
$dbPassword = file_get_contents("../secrets/dbPassword"); 
$dbName     = "vecs00"; 
 
// Create database connection 
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName); 

// // Check connection 
if ($db->connect_error) { 
    die("Connection failed: " . $db->connect_error); 
}

