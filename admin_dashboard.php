<?php
require_once 'config.php';

if(!isset($_SESSION['admin_id'])){
    header('location: index.php');
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="icon" href="assets/gym.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <title>Admin Dashboard</title>
  </head>
<body>
<?php if(isset($_SESSION['success_message'])) : ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?php 
        echo $_SESSION['success_message'];
        unset($_SESSION['success_message']);
    ?>
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

</div>
<?php endif; ?>
<div class="container">

<a href="export.php?what=members" class="btn btn-success btn-sm">Export</a>
</div>
<div class="container">

    <div class="row text-center">
        <div class="col-12">
            <h2> Clanovi </h2>
            <table class="table table-striped">
                <thead>
                    <tr>

                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Created At</th>
                    <th>Trainer</th>
                    <th>Training Plan</th>
                    <th>Action</th>
                    <th>Access Card</th>
                    <th>Photo</th>
                    
                    
                </tr>    

            </thead>
            <tbody>
        <?php
        $sql = "select members.member_id as mid, members.name as mname, members.email as memail, members.phone_number as mphone_number, members.created_at as mcreated_at, 
        trainers.name as tname, training_plans.name as tpname, members.access_card_pdf_path as maccess_card_pdf_path, members.photo_path as mphoto_path  from members left join trainers on members.trainer_id = trainers.trainer_id 
        left join training_plans on members.training_plan_id = training_plans.training_plan_id";
        $results = $conn->query($sql);
        $results = $results->fetch_all(MYSQLI_ASSOC);

        $conn->close();

        foreach($results as $result):?>
        <tr>
        <td><?php echo $result['mname']; ?></td>
        <td><?php echo $result['memail']; ?></th>
        <td><?php echo $result['mphone_number']; ?></td>
        <td><?php 
        
        $create_ate =  strtotime($result['mcreated_at']);
        $new_date = date("F, jS Y", $create_ate);
        echo $new_date;
        ?></td>
        <td><?php echo $result['tname']; ?></td>
        <td><?php echo $result['tpname']; ?></td>
        <td>
            <form action="delete_member.php" method="POST">
            <input type="hidden" name="member_id" value="<?php echo $result['mid']?>">
            <button type="submit">DELETE</button>
        </form>
        </td>
        <td><a href="<?php echo $result['maccess_card_pdf_path']; ?>" target="_blank">Access Card</a></td>
        <td><img src="<?php echo $result['mphoto_path']?>" style="width=50px;height:50px;"></td>
        </tr>

        <?php endforeach; 
        ?>

</tbody>
            </table>
        </div>
    </div>

</div>
<div class="container register-member-form m-2 p-3">

    <div class="row text-center">

        <div class="col-md-6 col-12">
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
                    Broj Telefona: <input type="text" class="form-control" name="phone_number">

                    </div>
                    <div class="col-12 mb-2">
                        <h4>Plan Treninga:</h4>
                        <select class="form-control" name="training_plan_id">
                            <option value="" disabled selected>Plan Treninga</option>
                            <?php
                                $sql = "select training_plan_id, name from training_plans";
                                $run = $conn->query($sql);
                                $results = $run->fetch_all(MYSQLI_ASSOC);
                                foreach($results as $result){
                                    echo "<option value='" .$result['training_plan_id'] . "'>" . $result['name'] . "</option>";
                                }
                                $conn->close();
                            ?>
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
        

        <div class="col-md-6 col-12">
            <h3> Registruj Trenera </h3>
            <form action="register_trainer.php" method="post">
                <div class="row">
                    <div class="col-12">
                        Ime: <input type="text" class="form-control" name="trainer_name">
                    </div>
                    <div class="col-12">
                    Email: <input type="email" class="form-control" name="trainer_email">

                    </div>
                    <div class="col-12">
                    Broj Telefona: <input type="text" class="form-control" name="trainer_phone_number">

                    </div>
                    <div class="col-12">
                        <input class="btn btn-primary mt-3" type="submit" value="Registruj Trenera">

                    </div>
                    
                </div>

            </form>
        </div>
    </div>

</div>



<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script>

    Dropzone.options.dropzoneUpload = {
        url:"upload_photo.php",
        paramName: "photo",
        maxFileSize: 20, //MB
        acceptedFiles: "image/*",
        init: function(){
            this.on("success", function(file, response){

                const jsonResp = JSON.parse(response);
                if(jsonResp.success){
                    document.getElementById('photoPathInput').value =jsonResp.photo_path;

                }else{
                    console.error(jsonResp.error);
                }
            });
        }
    }

</script>
</body>
</html>
