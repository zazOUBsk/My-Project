<?php

include('functions/userfunctions.php');
?>
<?php 
session_start() ;
if(isset($_SESSION['auth'])){
    header('Location: index.php');
    exit();
}
 include('includes/header.php'); ?>


 
<div class="container py-5">
    <div class="row justify-content-center pt-5">
        <div class="col-md-6">
            <?php   
            if(isset($_SESSION['message'])) { 
                 ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Hey! </strong><?= $_SESSION['message']; ?>.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

            
            <?php 
            unset($_SESSION['message']);
            }
                ?>
            <div class="card">
                <div class="card-header">
                    <h4>Login Form</h4>
                </div>


                <div class="card-body">
                    <form action="functions/authcode.php" method="POST">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email address</label>
                                <input type="email" name="email" placeholder="exemple@gmail.com" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" name="password" placeholder="Enter Password" class="form-control" id="exampleInputPassword1">
                        </div>
                        <button type="submit" name="login_btn" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


    <?php include('includes/footer.php'); ?>