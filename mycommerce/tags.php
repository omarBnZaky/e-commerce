<?php
session_start();
include'init.php'; 
    $category = isset($_GET['name'])&& is_numeric($_GET['name'])?intval($_GET['name']):0; 
   $tag = $_GET['name'];
?> 
 <div class="container">
 <h1 class="text-center"><?php echo $tag ?></h1>
     <div class="row">
    
  <?php   
     $TagItems= getAllFrom("*","items","WHERE Tags LIKE '%$tag%'", " AND Approve = 1","item_id");
     foreach($TagItems as $Item){       
    ?>
          <div class="col-sm-3">
            <div class="card">
              <div class="card-body">
                <img class="card-img-top" src="img.png" alt="Card image cap">
                <h5 class="card-title"><a href="items.php?Itemid=<?php echo $Item['item_id'] ?>" ><?php echo $Item['item_Name']?></a> </h5>
                <p class="card-text"><?php echo $Item['item_Description']?></p>
                <p class="card-text">$<?php echo $Item['price']?></p>
                  <div class="date"><?php echo $Item['Add_Date']?></div>
              </div>
            </div>
          </div>
   <?php  } ?>
</div>

<?php include $tpl .'footer.php'; ?>
     