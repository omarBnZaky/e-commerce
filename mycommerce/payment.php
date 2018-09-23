<?php
ob_start();
 session_start();

$pageTitle = 'Payment page';

 include'init.php';

             $itemID= isset($_GET['Itemid'])&& is_numeric($_GET['Itemid'])?intval($_GET['Itemid']):0;

  $stmt = $con->prepare("SELECT * FROM  items  WHERE item_id = ?");
  $stmt->execute(array($itemID));
  $count = $stmt -> rowCount();
            
            if($count >0 ){
                
            
            
            //fecth the data
            
             $item = $stmt->fetch();
 ?>


    <div class="container" style="background-color:white;margin-bottom:30px;margin-top:30px;height:370px;">
       <h1 class="text-center" style="margin-bottom:50px;"><?php echo $item['item_Name']; ?> [$<?php echo $item['price']; ?>]</h1>
     <form action="charge.php?Itemid=<?php echo $item['item_id'];?>" method="post" id="payment-form">
              <div class="form-row">
                  
                <input type="text" name="first_name" class="form-control mb-3 StripeElement StripeElement--empty"
                placeholder="First Name" />      
                  
                <input type="text" name="Last_name" class="form-control mb-3 StripeElement StripeElement--empty"
                placeholder="last Name" />              
                  
                <input type="email" name="email" class="form-control mb-3 StripeElement StripeElement--empty"
                placeholder="Email" />
                  
                  
                  
                <div id="card-element" class="form-control">
                  <!-- A Stripe Element will be inserted here. -->
                </div>

                <!-- Used to display form errors. -->
                <div id="card-errors" role="alert"></div>
              </div>

              <button  class="btn btn-primary btn-block mt-4"style="margin-top:20px;">Submit Payment</button>
        </form>
</div>
<?php 

            }


include $tpl .'footer.php'; 
ob_end_flush();
?>