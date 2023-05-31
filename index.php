<?php 

session_start();
    include('includes/header.php');
    include('config/dbcon.php');
    include('functions/userfunctions.php');
    
// put the parameters in the $index variable
$link = "http://" . $_SERVER['SERVER_NAME'] . '/2/MB';
// index.php link with the current parameters
$index = $link . "/index.php";
    $sql = "SELECT * FROM products";
    $result = mysqli_query($con, $sql);
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);

    function sortByPrice($products, $sortby)
{
    if ($sortby == "asc") {
        usort($products, function ($a, $b) {
            return $a['selling_price'] - $b['selling_price'];
        });
    } else {
        usort($products, function ($a, $b) {
            return $b['selling_price'] - $a['selling_price'];
        });
    }
    return $products;
}





if (isset($_GET['search'])) {
    $products = searchByName($products, $_GET['search']);
}

if (isset($_GET['sortby'])) {
    $sortby = $_GET['sortby'];
    $products = sortByPrice($products, $sortby);
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
    
    $feedbackMessage = isset($_SESSION['message']) ? $_SESSION['message'] : '';
    
  }
}

?>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="assets/js/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

<script src="assets/js/custom.js"></script>
<!--Alertify Js -->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    
    
   
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- MDB -->
<script
  type="text/javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.1.0/mdb.min.js"
></script>

 <!--================Home Banner Area =================-->
 <section class="home_banner_area">
    <div class="banner_inner d-flex align-items-center">
      <div class="container">
        <div class="banner_content row">
          <div class="col-lg-12">
            <p class="sub text-uppercase">men Collection</p>
            <h3><span>Show</span> Your <br />Personal <span>Style</span></h3>
            <h4>Fowl saw dry which a above together place.</h4>
            <a class="main_btn mt-40" href="categories.php">View Collection</a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--================End Home Banner Area =================-->
  <!-- Start feature Area -->
  <section class="feature-area section_gap_bottom_custom">
    <div class="container">
      <div class="row">
        <div class="col-lg-3 col-md-6">
          <div class="single-feature">
            <a href="#" class="title">
              <i class="flaticon-money"></i>
              <h3>Money back gurantee</h3>
            </a>
            <p>Shall open divide a one</p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="single-feature">
            <a href="#" class="title">
              <i class="flaticon-truck"></i>
              <h3>Free Delivery</h3>
            </a>
            <p>Shall open divide a one</p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="single-feature">
            <a href="#" class="title">
              <i class="flaticon-support"></i>
              <h3>Alway support</h3>
            </a>
            <p>Shall open divide a one</p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="single-feature">
            <a href="#" class="title">
              <i class="flaticon-blockchain"></i>
              <h3>Secure payment</h3>
            </a>
            <p>Shall open divide a one</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End feature Area -->

        
  <section class="banner_area">
    <div class="banner_inner d-flex align-items-center">
        <div class="container">
            <div class="banner_content d-md-flex justify-content-between align-items-center">
                <div class="mb-3 mb-md-0">
                    <h2>Shop Category</h2>
                    <p>Very us move be blessed multiply night</p>
                </div>
                <div class="page_link">
                    <a href="index.html">Home</a>
                    <?php 
                        $categories = getAll("categories");

                        if(mysqli_num_rows($categories) > 0)
                        {
                            foreach($categories as $item)
                            {
                                ?>
                                <a href="products.php?category=<?= $item['slug']; ?>" class="text-black" style="text-decoration:none"><?= $item['name'];?> / </a>
                                <?php
                            }
                        }
                        else
                        {
                            echo "No Category Available";
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="py-5 container mb-0">
    <div class="row">
        <div class="col-md-12">
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
        </div>
    </div>
    <div class="row mt-0">
        <div class="row m-3 mb-5 shadow-lg p-3 mb-5 bg-white rounded">
            <div class="col-sm-8">
                <div class="dropdown ">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                        Sort By defoault
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                    <li><a class="price asc dropdown-item"  href="<?php echo $index . "?sortby=asc" ?>">Asending Price</a></li>
                        <li><a class="price dsc dropdown-item" href=<?php echo $index . "?sortby=dsc" ?>>Desending Price</a></li>
                        
                    </ul>
                </div>
            </div>
            <div class="col-sm-4">
                <form class="form" action=<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?> method="POST">
                    <div class="input-group">
                        <div class="form-outline">
                            <input name="search" value="<?php echo $search ?>" type="search" class="form-control" />
                            <label class="form-label" for="search">Search</label>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
            <section class="cat_product_area section_gap">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9">
                        <div class="row"> <!-- start of product row -->
                        <?php foreach($products as $item) :?>
                            <div class="col-lg-4 col-md-6 mb-2">
                                <div class="single-product">
                                    <div class="product-img">
                                        <img class="card-img" src="uploads/<?= $item['image']; ?>" alt="" />
                                        <div class="p_icon">
                                            <a href="product-view.php?product=<?= $item['slug']; ?>">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <div class="product-btm">
                                                <form action="index.php" method="post" class="add-to-cart-form">
                                                    <input type="hidden" name="prod_id" value="<?= $item['id']; ?>">
                                                    <button type="submit" class="btn btn-primary add-to-cart-btn " name="add_to_cart">
                                                        <i class="fa-solid fa-cart-shopping"></i> Add to cart
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-btm">
                                        <a href="product-view.php?product=<?= $item['slug']; ?>">
                                            <h4><?= $item['name']; ?></h4>
                                        </a>
                                        <div class="mt-3">
                                            <span class="mr-4">$<?= $item['selling_price']; ?></span>
                                            <?php if ($item['original_price'] > $item['selling_price']): ?>
                                                <del>$<?= $item['original_price']; ?></del>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div> <!-- end of product row -->

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>


<?php include('includes/footer.php'); ?>