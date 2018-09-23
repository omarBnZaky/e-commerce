<?php
ob_start();
 session_start();

$pageTitle = 'Show Items';

 include'init.php';

 $MID= isset($_GET['Mid'])&& is_numeric($_GET['Mid'])?intval($_GET['Mid']):0;
   
    $getUser = $con->prepare("SELECT * FROM users WHERE userID = ?");
    
    $getUser -> execute(array($MID));
    
    $UserInfo = $getUser->fetch();
    $userid = $UserInfo['userID'];
  
   ?>       
<h1 class="text-center"><?php echo $Membername = isset($_GET['Mname'])&& is_string($_GET['Mname'])?strval($_GET['Mname']):0; ?></h1>
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
                  <p class="price-tag">$<?php echo $Item['price']?></p>
                    <?php if(isset($_SESSION['user'])){
                            echo"<a href='payment.php'><div class='btn btn-success'><i class='fa fa-tag'></i>Buy</div></a>";
                        }else{
                                if(! $Item['Approve'] == 0 ){ 
                            echo"<a href='payment.php'><div class='btn btn-success'><i class='fa fa-tag'></i>Buy</div></a> ";
                                }
                    } ?>
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
</div>
        </div>
    </div>
    </div>
</div>

<?php
include $tpl .'footer.php';
ob_end_flush();    
    ?>
