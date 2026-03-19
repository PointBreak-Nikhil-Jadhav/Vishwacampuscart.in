<?php

session_start();


$APP_NAME = 'VIT Campus Cart';
$COLLEGE_NAME = 'VIT College, Pune';
$CONTACT_NUM = '8806288365';
$CONTACT_MAIL = 'sawant.infotech.14@gmail.com';

$SERVER_NAME = 'localhost';
$USER = 'root';
$PASS = '';
$DATABASE = 'VIT_CAMPUS_CART';

$conn =  new mysqli($SERVER_NAME, $USER, $PASS, $DATABASE);

// Check the connection
if ($conn->connect_error) {
    // die("Connection failed: " . $conn->connect_error);
}
