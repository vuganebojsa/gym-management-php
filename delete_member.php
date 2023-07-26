<?php
    require_once 'config.php';

    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $sql = "delete from members where member_id = ?";
        $run = $conn->prepare($sql);
        $run->bind_param("i", $_POST['member_id']);
        $message = "";
        if($run->execute()){
            $message =  "Clan obrisan";
        }else{
            $message = "Clan nije obirsan";
        }

        $_SESSION['success_message'] = $message;
        header('location: admin_dashboard.php');
        exit();
    }

?>