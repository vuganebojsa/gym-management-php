<?php

    require_once 'config.php';

    if(isset($_GET['what'])){
        $csv_cols = [];
        $sql = "";
        if($_GET['what'] == 'members'){
            $sql = "select member_id, name, email, phone_number, created_at, training_plan_id, trainer_id from members";
            $csv_cols = [
                "member_id",
                "name",
                "email",
                "phone_number",
                "created_at",
                "training_plan_id",
                "trainer_id"
            ];
        }else{
            $sql = "select * from trainers";
        }

        $run = $conn->query($sql);
        $results = $run->fetch_all(MYSQLI_ASSOC);
        
        $output = fopen('php://output', 'w');
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . $_GET['what'] . ".csv");
        fputcsv($output, $csv_cols);
        foreach($results as $result){
            fputcsv($output, $result);
        }
        fclose($output);
    }
?>