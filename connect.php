<?php
$conn = mysqli_connect("localhost", "root", "", "BNCC_CRUD");

if(!$conn){
    die("GAGAL : " . mysqli_connect_error());
}
?>