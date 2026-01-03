<?php
$conn= new mysqli('localhost','root','','savyzdb');
if(!$conn){
    echo "Error!: {$conn->connect_error}";
}



?>