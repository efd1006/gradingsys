<?php
$hostname = "localhost";
$username = "root";
$password ="";
$database = "cs302";

$c = new mysqli($hostname,$username,$password,$database);

if($c->connect_error)
{
    die("Connection failed: ". $c->connect_error);
}
?>