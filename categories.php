<?php 

session_start();
include('functions/userfunctions.php');

    include('includes/header.php');

?>
<style>
    .equal{
        min-height: 150px;
        max-height: 150px;
    }
</style>
<div class="py-3 bg-dark">
    <div class="container">
        <a href="index.php" class="text-white" style="text-decoration:none">Home / </a><a href="categories.php" class="text-white" style="text-decoration:none" >Collections</a>
    </div>
</div>
<div class="py-5 container">
    <div class="row">
        <div class="col-md-12">
                <h1>Our Collections</h1>
                <hr>
                <div class="row">
                    <?php
                        $categories = getAllActive("categories");

                        if(mysqli_num_rows($categories) > 0)
                        {
                            foreach($categories as $item)
                            {
                                ?>
                                <div class="col-md-3 mb-2">
                                    <a href="products.php?category=<?= $item['slug']; ?>">
                                        <div class="card shadow" style="width: 18rem; height: 23rem;">
                                            <div class="card-body">
                                                <img src="uploads/<?= $item['image']; ?>" alt="category image" class="w-100 " style="height: 18rem; object-fit: cover;">
                                                <h4 class="text-center pt-3"><?= $item['name']; ?></h4>
                                                
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                   
                                <?php
                            }
                        }
                        else {
                            echo "no category available";
                        }
                    ?>
                </div>
                
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>