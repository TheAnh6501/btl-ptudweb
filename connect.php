<?php
$conn = new PDO('mysql:host=localhost;dbname=school', 'root' ,'');
if ($conn) {
   // echo "Connected successfully";
}else{
    echo "Connection failed";
}
?>