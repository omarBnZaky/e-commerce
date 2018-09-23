<?php
ob_start();
 session_start();

$pageTitle = 'profile';

 include'init.php';

if(isset($_SESSION['user'])){
    
    $getUser = $con->prepare("SELECT * FROM users WHERE username = ?");
    
    $getUser -> execute(array($sessionUser));
    
    $UserInfo = $getUser->fetch();
    $userid = $UserInfo['userID'];
  
    
    $customer = new customer();
    //Get Customer
    $customers = $customer->getCustomers();
        //Instantiate Customer
    $Transaction = new Transaction();
    //Get Customer
    $Transaction= $Transaction->getTransactions();
   ?>       
<h1 class="text-center">MyProfile</h1>
<div class="container">
<div class="information block">
    <div class="card">
      <div class="card-header">
          <h5>Myinformation</h5>
      </div>
      <div class="card-body">
        <blockquote class="blockquote mb-0">
          <p><i class="fa fa-unlock-alt fa-fw"></i>Name:  <?php echo $UserInfo['username']; ?></p>
          <p><i class="fa fa-envelope-o fa-fw"></i>Email:  <?php echo $UserInfo['Email']; ?></p>
          <p><i class="fa fa-user fa-fw"></i>FullName:  <?php echo $UserInfo['FullName']; ?></p>
          <p><i class="fa fa-calendar fa-fw"></i>Registerd Date:  <?php echo $UserInfo['Date']; ?></p>

        </blockquote>
      </div>
    </div>
</div>
 

<div id="my-ads" class="ads block">
    <div class="card">
      <div class="card-header">
       <h5>MyAds</h5> 
      </div>
      <div class="card-body">
        <blockquote class="blockquote mb-0">
            
 <?php 
    $myItems = getAllFrom("*","items","WHERE Member_ID = $userid", " ","item_id");
    if(! empty($myItems)) {
       ?>  <div class="card-group">
            <?php
       foreach($myItems as $Item){  ?>
          <div class="col-sm-3">
            <div class="card" >
              <div class="card-body">
                  <?php if($Item['Approve'] == 0 ){ echo "<span class='approve-statues'>Not Approved</span>"; } ?>
                   <img class="card-img-top" src="img.png" alt="Card image cap">
                <h3 class="card-title"><a href="items.php?Itemid=<?php echo $Item['item_id'] ?>" ><?php echo $Item['item_Name'] ?></a> </h3>
                <p class="card-text"><?php echo $Item['item_Description']?></p>
                  <span class="price-tag">$<?php echo $Item['price']?></span>
                  <div class="date"><?php echo $Item['Add_Date']?></div>
                  
              </div>
            </div>
          </div>
   <?php  }  ?>
            </div> 
        <?php }else{
        echo"There is No ADS to Show , <a class='pull-right' href = 'newAd.php'>create a new ad</a>";
           }?>
        </blockquote>
      </div>
    </div>
</div>

<div class="comments block">
    <div class="card">
      <div class="card-header">
      <h5>Mylatest comments</h5>  
      </div>
      <div class="card-body">
        <blockquote class="blockquote mb-0">
      <?php
    $myComments =getAllFrom("comment","comments","WHERE user_id = $userid", " ","c_id");
  
    if(! empty($myComments)){
        foreach($myComments as $comment){
            echo"<p>".$comment['comment']."</p>";
        }
    }else{
        echo"there is no comment to show";
    }
    
    ?>
        
        </blockquote>
      </div>
    </div>
</div>
    
    
    <div class="myCustomers block">
       <table class="table table-striped">
                <thead>
                    <tr>
                        <th>CustomerID</th>
                        <th>Name</th>
                       <th>Email</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                  <?php foreach($customers as $C): ?>
                        <tr>
                            <td><?php echo $C->id; ?></td>
                            <td><?php echo $C->first_name;
                                echo $C->Last_name;?></td>
                            <td><?php echo $C->email; ?></td>
                            <td><?php echo $C->Created_at; ?></td>
                        </tr>
                      
                   <?php endforeach; ?>
                </tbody>
            </table>
    </div>
    <br>
    <div class="myTransactions block">
           <table class="table table-striped">
                <thead>
                    <tr>
                        <th>transactions ID</th>
                        <th>Customer</th>
                        <th>product</th>
                         <th>amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                  <?php foreach($Transaction as $T): ?>
                        <tr>
                            <td><?php echo $T->id; ?></td>
                            <td><?php echo $T->customer_id;?></td>
                            <td><?php echo $T->product; ?></td>
                            <td><?php echo sprintf('%.2f',$T->amount / 100); 
                                echo strtoupper($T->currency);
                                ?>
                            </td>
                            <td><?php echo $T->Created_at; ?></td>
                        </tr>
                      
                   <?php endforeach; ?>
                </tbody>
            </table>   
    </div>
</div>
<br>
<?php
    }else{
    header('location:login.php');
    exit();
}
include $tpl .'footer.php'; 


ob_end_flush();
?>