<?php
require_once 'config.php';

if(!isset($_SESSION['admin_id'])){
    header('location: index.php');
}

$training_plans = [];
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="icon" href="assets/gym.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Admin Dashboard</title>
  </head>
<body>


<div class="container register-member-form m-2 p-3">

    <div class="row text-center">

        <div class="col-12">
            <h3> Registruj Clana </h3>
            <form action="register_member.php" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-12">
                        Ime: <input type="text" class="form-control" name="name">
                    </div>
                    <div class="col-12">
                    Email: <input type="email" class="form-control" name="email">

                    </div>
                    <div class="col-12">
                    Broj Telefona: <input type="email" class="form-control" name="phone_number">

                    </div>
                    <div class="col-12">
                        <h4>Training Plan:</h4>
                        <select class="form-control" name="training_plan_id">
                            <?php foreach($training_plans as $plan): ?>
                                <option value="<?= $plan['plan_id'] ?>">
                                    <?= $plan['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12"> 
                        <input type="hidden" name="photo_path" id="photoPathInput">
                        <div id="dropzone-upload" class="dropzone"></div>

                    </div>
                    <div class="col-12">
                        <input class="btn btn-primary mt-3" type="submit" value="Registruj Clana">

                    </div>
                </div>

            </form>
        </div>

    </div>

</div>



<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
