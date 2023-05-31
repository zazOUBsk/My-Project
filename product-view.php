<?php 

session_start();

    include('functions/userfunctions.php');
    include('includes/header.php');
    
if(isset($_GET['product']))
{
    $product_slug = $_GET['product'];
    $product_data = getSlugActive("products",$product_slug);
    $product = mysqli_fetch_array($product_data);

    if($product){
        ?>
        <div class="py-3 bg-dark">
            <div class="container">
                
                    <a href="index.php" class="text-white" style="text-decoration:none">Home / </a>
                    <a href="categories.php" class="text-white" style="text-decoration:none" >Collections / </a>
                    <a href="#" class="text-white" style="text-decoration:none"><?= $product['name'];?></a>
                
            </div>
        </div>
            <div class="container mt-3 bg-light product-data">
                <div class="row p-5">
                    <div class="col-md-4 shadow">
                        <img src="uploads/<?= $product['image']; ?>" alt="product image" class="w-100">
                    </div>
                    <div class="col-md-8">
                        <h4 class="fw-bold"><?= $product['name'];?>
                            <span class="float-end text-danger"><?= $product['trending'] ? "Trending" : "" ?></span>
                        </h4>
                        <hr>
                        <p><?= $product['small_description'];?></p>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <H4> $ <span class="text-success fw-bold"> <?= $product['selling_price']; ?></span></H4>
                            </div>
                            <div class="col-md-6">
                                <H5 class ="mt-2"> $ <s class="text-danger"><?= $product['original_price']; ?></s></H5>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                            <div class="input-group mb-3" style="width:130px">
                                <button class="input-group-text decrement-btn">-</button>
                                <input type="text" class="form-control bg-white text-center qty-input" value="1"  >
                                <button class="input-group-text increment-btn">+</button>
                            </div>
                            </div> 
                        <div class="row mt-3">
                            <div class="col-md-6">
                            <form action="product-view.php?product=<?= $product['slug']; ?>" method="post" class="add-to-cart-form">
                                                    <input type="hidden" name="prod_id" value="<?= $product['id']; ?>">
                                                    <button type="submit" class="btn btn-primary add-to-cart-btn " name="add_to_cart">
                                                        <i class="fa-solid fa-cart-shopping"></i> Add to cart
                                                    </button>
                                                </form>

                            </div>
                           
                        </div>
                        <h6 class="fw-bold mt-5">Product Description :</h6>
                        <hr>
                        <p><?= $product['description'];?></p>
                    </div>
                </div>
            </div>
        <?php
    }
    else
    {
    echo "Product not found";   
    }
}
else
{
    echo "SOMETHING WENT WRONG";
}
?>
</div>
<?php 
include('includes/footer.php'); ?>