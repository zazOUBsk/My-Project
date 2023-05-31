<?php   

if(!isset($_SESSION)){
    session_start();
}
include('../config/dbcon.php');

if(isset($_POST['register_btn']))
{$name = mysqli_real_escape_string($con,$_POST['name']);
    $phone = mysqli_real_escape_string($con,$_POST['phone']);
    $email = mysqli_real_escape_string($con,$_POST['email']);
    $password = mysqli_real_escape_string($con,$_POST['password']);
    $cpassword = mysqli_real_escape_string($con,$_POST['cpassword']);


    $_SESSION['input_values'] = $_POST;

    // Validation
    if (empty($name)) {
        $_SESSION['message'] = "Name cannot be empty";
        header('Location: ../register.php');
        exit();
    }

    if (empty($phone)) {
        $_SESSION['message'] = "Phone cannot be empty";
        header('Location: ../register.php');
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message'] = "Email is not valid";
        header('Location: ../register.php');
        exit();
    }

    if (strlen($password) < 6) {
        $_SESSION['message'] = "Password should be at least 6 characters";
        header('Location: ../register.php');
        exit();
    }

    if ($password !== $cpassword) {
        $_SESSION['message'] = "Passwords do not match";
        header('Location: ../register.php');
        exit();
    }
    

    $check_email_query = "SELECT email From users WHERE email='$email'";
    $check_email_query_run = mysqli_query($con, $check_email_query);
    if(mysqli_num_rows($check_email_query_run))
    {
        $_SESSION['message'] = "Email Already registred";
        header('Location: ../register.php');
    }
    else 
    {
        if($password == $cpassword)
        {
            //insert data
            $insert_query = "INSERT INTO users (name,email,phone,password) VALUES('$name','$email','$phone','$password')";
            $insert_query_run = mysqli_query($con, $insert_query);

            if($insert_query_run){
                $_SESSION['message'] = 'Register Successfuly';
                header('Location: ../login.php');
            }
            else{
                $_SESSION['message'] = 'Something Went wrong';
                header('Location: ../register.php');
            }
        }
        else 
        {
            $_SESSION['message'] = "Password do not match";
            header('Location: ../register.php');
        }
    }
    unset($_SESSION['input_values']);

}
else if(isset($_POST['login_btn']))
{
    $email = mysqli_real_escape_string($con,$_POST['email']);
    $password = mysqli_real_escape_string($con,$_POST['password']);

    $login_query = "SELECT * FROM users WHERE email ='$email' AND password ='$password' ";
    $login_query_run = mysqli_query($con, $login_query);

    if(mysqli_num_rows($login_query_run) > 0)
    { 
        $_SESSION['auth'] = true;

        $userdata = mysqli_fetch_array($login_query_run);
        $userid = $userdata['user_id'];

        $_SESSION['user_id'] = $userid;
           
        // Set the cookies with user information
        setcookie("user_id", $userid, time() + (86400 * 30), "/"); // 86400 = 1 day

        $_SESSION['message'] = "Logged In Successfully";
        header('Location: ../index.php');
    }
    else
    {
        $_SESSION['message'] = 'Invalid email or password';
        header('Location: ../login.php');
    }
}
?>
