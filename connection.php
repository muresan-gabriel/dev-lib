<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "auth-dev-lib";
$dbport = "3306";

if(!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname, $dbport));
{
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
}

