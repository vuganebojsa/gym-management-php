
<?php
    require_once 'config.php';

    $username = "nebojsa";
    $password = "Nebojsa123";
    $hashed_pw = password_hash($password, PASSWORD_DEFAULT);

    $sql = "insert into admins(username, password) values(?, ?)";

    $run = $conn->prepare($sql);
    $run->bind_param("ss", $username, $hashed_pw);

    $run->execute();

    $conn->close();
?>