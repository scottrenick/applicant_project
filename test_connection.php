<?php

include('DBConnection.php');

$conn = DBConnection::get();
$res = mysqli_query($conn, "SELECT * from contacts");
$row = mysqli_fetch_assoc($res);
var_dump($row);
