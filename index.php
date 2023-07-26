<?php

    require_once 'config.php';
    if(isset($_SESSION['admin_id'])){
        header('location: admin_dashboard.php');
    }
    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "select admin_id, password from admins where username = ?";

        $run = $conn->prepare($sql);
        $run->bind_param("s", $username);
        $run->execute();

        $results = $run->get_result();
        if($results->num_rows == 1){
            $admin = $results->fetch_assoc();
           
            if(password_verify($password, $admin['password'])){
                $_SESSION['admin_id'] = $admin['admin_id'];
                header('location: admin_dashboard.php');
            }
            else{
                $_SESSION['error'] = "Username ili lozinka su neispravni.";
                header('location: index.php');
                exit;
            }

        }else{
            $_SESSION['error'] = "Username ili lozinka su neispravni.";
            header('location: index.php');
            exit;
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="icon" href="assets/gym.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Gym Management Login</title>
  </head>
<body>
<?php

    if(isset($_SESSION['error'])){
        echo $_SESSION['error'] . "<br>";
        unset($_SESSION['error']);
    }
?>

<form action="" method="post">
    <div class="row text-center m-5">

        <div class="col-12 my-2">
        Username: <input type="text" name="username">
        </div>
        <div class="col-12 my-2">
        Password: <input type="password" name="password">

        </div>
        <div class="col-12 my-2">
        <input type="submit" value="Login">
        
        </div>

    </div>

</form>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
