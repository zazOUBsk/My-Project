<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('config/dbcon.php');
function getAllActive($table)
{
    global $con;
    $query = "SELECT * FROM $table WHERE status='0' ";
   
    return $query_run = mysqli_query($con, $query);
}

function getAll($table)
{
    global $con;
    $query = "SELECT * FROM $table";
   
    return $query_run = mysqli_query($con, $query);
}




function getIDActive($table, $id)
{
    global $con;
    $query = "SELECT * FROM $table WHERE id='$id' AND status='0'";
   
    return $query_run = mysqli_query($con, $query);
}

function getSlugActive($table, $slug)
{
    global $con;
    $query = "SELECT * FROM $table WHERE slug='$slug' AND status='0' LIMIT 1";
   
    return $query_run = mysqli_query($con, $query);
}
function getProdByCategory($category_id)
{
    global $con;
    $query = "SELECT * FROM products WHERE category_id='$category_id' AND status='0'";
   
    return $query_run = mysqli_query($con, $query);
}



function redirect($url, $message)
{
    $_SESSION['message'] = $message;
    header('Location: '.$url);
    exit();
}

function getCartItems()
{
    global $con;
    $userId = $user_id = $_COOKIE['user_id'];

    $query = "SELECT c.id as cid,c.user_id , c.prod_id, c.prod_qty, p.id as pid, p.name, p.image, p.selling_price
                 FROM carts c , products p WHERE c.prod_id = p.id AND c.user_id ='$userId' ORDER BY c.id DESC";
    return $query_run = mysqli_query($con, $query);
}

if (isset($_POST['add_to_cart'])) {
    if (isset($_COOKIE['user_id'])) {
        $user_id = $_COOKIE['user_id'];

        $prod_id = $_POST['prod_id'];
        $prod_qty = 1;

        $query = "SELECT * FROM carts WHERE user_id = $user_id AND prod_id = $prod_id";
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            // Update the cart if the product already exists
            $query = "UPDATE carts SET prod_qty = prod_qty + 1 WHERE user_id = $user_id AND prod_id = $prod_id";
        } else {
            // Insert a new record if the product does not exist in the cart
            $query = "INSERT INTO carts (user_id, prod_id, prod_qty) VALUES ($user_id, $prod_id, $prod_qty)";
        }

        if (mysqli_query($con, $query)) {
            $_SESSION['message'] = 'Product added to cart!';
        } else {
            $_SESSION['message'] = 'Failed to add product to cart!';
        }
    } else {
        $_SESSION['message'] = 'Please log in to add products to your cart.';
    }
}
$feedbackMessage = isset($_SESSION['message']) ? $_SESSION['message'] : '';




?>

