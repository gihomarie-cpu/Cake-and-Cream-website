<?php
$servername="localhost";
$username="root";
$password="";
$dbname="cake_shop";

$conn=new mysqli($servername,$username,$password,$dbname);
if($conn->connect_error){
    die("connection failed" . $conn->connect_error);
}

// for get form data
$cake_size = $_POST["cake_size"];
$cake_flavor = $_POST["cake_flavor"];
$cake_name = $_POST["cake_name"];
$cake_number = $_POST["cake_number"];
$email = $_POST["email"];
$telephone = $_POST["telephone"];
$location = $_POST["location"];
$payment_method = $_POST["payment_method"];
$delivery_time = $_POST["delivery_time"];

$sql= "INSERT INTO orders(cake_size,
cake_flavor,
cake_name,
cake_number,
email,
telephone,
location,
payment_method,
delivery_time)VALUES('$cake_size',
'$cake_flavor',
'$cake_name',
'$cake_number',
'$email',
'$telephone',
'$location',
'$payment_method',
'$delivery_time')";
if($conn->query($sql) === TRUE) {

    echo"orders submitted successfully!";
}
else{
    echo"error: ". $conn->error;
}

$conn->close();
?>