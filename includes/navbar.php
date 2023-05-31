<?php
include("config/dbcon.php");

$search = "";
if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $sql = "SELECT * FROM products WHERE name LIKE '%$search%'";
    $result = mysqli_query($con, $sql);
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0) {
        // go to index.php and display the results of the search using the url 
       header("location: index.php?search=$search");
        
    }
}
function searchByName($products, $search)
{
    $search = strtolower($search);
    $products = array_filter($products, function ($product) use ($search) {
        return strpos(strtolower($product['name']), $search) !== false || strpos(strtolower($product['small_description']), $search) !== false;
    });
    return $products;
}

?> <!--================Header Menu Area =================-->
<header class="header_area">
  
 <!-- Navigation-->
 <div class="main_menu">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light w-100">
        <a class="navbar-brand logo_h" href="index.php">
            <img src="img/iris.png" alt="Logo" style="height: 1.5em; width: auto; vertical-align: middle;">
        </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="collapse navbar-collapse offset w-100" id="navbarSupportedContent">
                <div class="row w-100 mr-0">
                    <div class="col-lg-7 pr-0">
                        <ul class="nav navbar-nav center_nav pull-right">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="categories.php">Collections</a>
                            </li>
                            
                            
                            <?php
                            if (isset($_SESSION['auth'])) {
                            ?>
                                
                                <li class="nav-item">
                                <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i> Cart</a>
                            </li>
                            <li class="nav-item">
                                    <a class="nav-link" href="logout.php">Logout</a>
                                </li>
                            <?php
                            } else {
                            ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="register.php">Register</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="login.php">Login</a>
                                </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="col-lg-5 pr-0">
                        <ul class="nav navbar-nav navbar-right right_nav pull-right">
                            <li class="nav-item">
                                <a href="#" class="icons">
                                    <i class="ti-search" aria-hidden="true"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</div>

  </header>
 