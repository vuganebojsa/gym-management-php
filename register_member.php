<?php

require_once 'config.php';
require_once 'fpdf/fpdf.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $training_plan_id = $_POST['training_plan_id'];
    $photo_path = $_POST['photo_path'];
    $trainer_id = 0;
    $access_card_pdf_path = "";
    $sql = "insert into members(name, email, phone_number, photo_path, 
 access_card_pdf_path, trainer_id, training_plan_id) 
values(?, ?, ?, ?, ?, ?, ?)";

$run = $conn->prepare($sql);
$run->bind_param("sssssii",$name, $email, $phone_number, $photo_path, 
$access_card_pdf_path, $trainer_id, $training_plan_id);

    $run->execute();
    
    $member_id = $conn->insert_id;

    
    $pdf = new FPDF();

    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(40, 10, 'Access card');
    $pdf->Ln();
    $pdf->Cell(40, 10, "Member ID: " . $member_id);
    $pdf->Ln();
    $pdf->Cell(40, 10, "Member name: " . $name);
    $pdf->Ln();
    $pdf->Cell(40, 10, "Member email: " . $email);

    $filename = 'access_cards/access_card_' . $member_id . '.pdf';
    $pdf->Output('F', $filename);

    $sql = "update members set access_card_pdf_path = ? where member_id = ?";
    $run = $conn->prepare($sql);
    $run->bind_param("si", $filename, $member_id);
    $run->execute();
    $conn->close();
    $_SESSION['success_message'] = 'Uspesna registracija novog clana teretane';
    header('location: admin_dashboard.php');
    exit();
}


?>