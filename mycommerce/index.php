<?php
ob_start();
 session_start();
$pageTitle = 'Home';

 include'init.php';

?>
        <?php 
        if($_SERVER['REQUEST_METHOD']=='POST'){
                   
                    $name = $_POST["item_Name"];
                    $sql = "SELECT items.*,categories.Name,  users.username 
                            FROM  items
                            INNER JOIN  categories
                            ON  categories.ID = items.Cat_ID 
                            INNER JOIN users 
                            ON  users.userID = items.Member_ID
                            WHERE item_Name LIKE :item_Name";
                    $stmt = $con->prepare($sql);
                    $stmt ->execute(['item_Name'=>$name]);
                if(!$stmt->rowCount() == 0){
                    while($row = $stmt->fetch()){ ?>
    <div class="container">         
    <div class="row">
         <div class="col-sm-3">
            <div class="card">
              <div class="card-body">
                <img class="card-img-top" src="img.png" alt="Card image cap">
                <h5 class="card-title"><a href="items.php?Itemid=<?php echo $row['item_id'] ?>" ><?php echo $row['item_Name']?></a> </h5>
                <p class="card-text"><?php echo $row['item_Description']?></p>
                <p class="card-text">$<?php echo $row['price']?></p>
                  <div class="date"><?php echo $row['Add_Date']?></div>
              </div>
            </div>
          </div>
        </div>
        </div>

    <?php            }
            }
        }else{
            
        ?>
       <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                <input class="form-control" type="text" name="item_Name" placeholder="search For a Item name"/>
                <input type="submit" style="color:white;background-color:#00b;"Value="Search" class="form-control"/>
        </form>
<div class="container">         
<div class="row">
     <?php 
    $allItems = getAllFrom('*','items','WHERE Approve = 1',' ','item_id');
     foreach($allItems as $Item){  ?>

          <div class="col-sm-3">
            <div class="card">
              <div class="card-body">
                  <?php if(!empty($Item['image'])){
                                echo'<img class="card-img-top" src="uploads/images/'.$Item['image'].'" alt="Card image cap">';
                    }else{
                                echo'<img class="card-img-top" src="img.png" alt="Card image cap">';
                         } ?>
                <h5 class="card-title"><a href="items.php?Itemid=<?php echo $Item['item_id'] ?>" ><?php echo $Item['item_Name']?></a> </h5>

                <p class="card-text"><?php echo $Item['item_Description']?></p>
                <p class="card-text">$<?php echo $Item['price']/100?></p>
                  <a href="payment.php?Itemid=<?php echo $Item['item_id'] ?>" class="btn btn-success"><i class="fa fa-tag"></i> Buy</a>
                  <div class="date"><?php echo $Item['Add_Date']?></div>
              </div>
            </div>
          </div>
   <?php  } ?>
</div>
</div>
   <?php } ?>
 <?php 
include $tpl .'footer.php'; 
ob_end_flush()
?>