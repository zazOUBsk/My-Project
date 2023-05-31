<?php 

session_start();

    include('functions/userfunctions.php');
    include('includes/header.php');
if(isset($_GET['category']))
{
    $category_slug = $_GET['category'];
    $category_data = getSlugActive("categories",$category_slug);
    $category = mysqli_fetch_array($category_data);
    if($category)
    {
        $cid = $category['id'];
        ?>
        <div class="py-3 bg-dark">
            <div class="container">
                
                    <a href="index.php" class="text-white" style="text-decoration:none">Home / </a>
                    <a href="categories.php" class="text-white" style="text-decoration:none" >Collections / </a>
                    <a href="#" class="text-white" style="text-decoration:none"><?= $category['slug'];?></a>
                
            </div>
        </div>
        <div class="py-3 container">
            <div class="row">
                <div class="col-md-12">
                        <h3>Our Collections</h3>
                        <hr>
                        <div class="row">
                            <?php
                                $products = getProdByCategory($cid);

                                if(mysqli_num_rows($products) > 0)
                                { ?>
                                    <div class="container mt-3 bg-light product-data">
                                    <div class="row">
                                    <?php foreach($products as $item) :?>
                                        <div class="col-md-4 mb-2">
                                            <a style="text-decoration:none;" href="product-view.php?product=<?= $item['slug']; ?>">
                                                <div class="card shadow-sm">
                                                    <img src="uploads/<?= $item['image']; ?>" alt="<?= $item['name']; ?> image" class="card-img-top">
                                                    <div class="card-body">
                                                        <h4 class="card-title text-center"><?= $item['name']; ?></h4>
                                                        <?php if($item['trending']): ?>
                                                            <span class="badge bg-danger">Trending</span>
                                                        <?php endif; ?>
                                                        <p class="card-text text-center"> 
                                                            Price : $ <span class="text-danger fw-bold"><s><?= $item['original_price']; ?></s></span> 
                                                            <span class="text-success fw-bold"> <?= $item['selling_price']; ?></span>
                                                        </p>
                                                        
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <?php  endforeach; ?>

                                    </div>
                                </div> 
                                        <?php
                                    }
                                }
                                else {
                                    echo "no product available in this category";
                                }
                            ?>
                        </div>
                        
                </div>
            </div>
        </div>

<?php 
    }
    else
    {
    echo "SOMETHING WENT WRONG";
    }

include('includes/footer.php'); ?>