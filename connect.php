<?php
$db_name="countries";
$db_username="testcountry";
$db_password="passcountry";

$connect= mysqli_connect('localhost', $db_username, $db_password,$db_name);

if ($connect===false){
    die("Error encountered accessing database!" .mysqli_connect_error());
}
?>