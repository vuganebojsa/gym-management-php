<?php

require_once 'config.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $name = $_POST['trainer_name'];
    $email = $_POST['trainer_email'];
    $phone_number = $_POST['trainer_phone_number'];
   
    $sql = "insert into trainers(name, email, phone_number) 
values(?, ?, ?)";

$run = $conn->prepare($sql);
$run->bind_param("sss",$name, $email, $phone_number);

$run->execute();

$conn->close();
$_SESSION['success_message'] = 'Uspesna registracija novog trenera';
header('location: admin_dashboard.php');
exit();
}


?>