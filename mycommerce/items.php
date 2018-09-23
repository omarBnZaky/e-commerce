<?php
ob_start();
 session_start();

$pageTitle = 'Show Items';

 include'init.php';

              //Check if GET request is numeric & get the INT value of it

             $itemID= isset($_GET['Itemid'])&& is_numeric($_GET['Itemid'])?intval($_GET['Itemid']):0;
            
            //select All Data Depend on this ID
             $stmt = $con->prepare("SELECT items.*,
                                        categories.Name, 
                                        users.username 
                                    FROM 
                                        items
                              INNER JOIN 
                                        categories
                                     ON 
                                        categories.ID = items.Cat_ID 
                              INNER JOIN 
                                        users 
                                     ON 
                                        users.userID = items.Member_ID
                                        WHERE
                                        item_id = ?");
            
            //excute query
            
             $stmt->execute(array($itemID));
             $count = $stmt -> rowCount();
            
            if($count >0 ){
                
            
            
            //fecth the data
            
             $item = $stmt->fetch();
   ?>       
<h1 class="text-center"><?php echo $item['item_Name'] ?></h1>

    <div class ="container">
        <div class="row">
        <div class="col-md-3">
            <img class="card-img-top" src="img.png" alt="Card image cap">

            </div>
        <div class="col-md-9 item-info">
            <h2><?php echo $item['item_Name'] ?></h2>
            <p><?php echo $item['item_Description'] ?></p>
            <ul class="list-unstyled">
                <li> <i class="fa fa-calendar fa-fw"></i>
                    <span>Added Date</span> : <?php echo $item['Add_Date'] ?>
                </li>
                
                <li> <i class="fa fa-money fa-fw"></i>
                    <span>price</span> : $<?php echo $item['price'] ?>
                </li>
                
                    <li> <i class="fa fa-building fa-fw"></i>
                        <span>Made In</span>: <?php echo $item['Country_Made'] ?>
                </li>
                
                <li> <i class="fa fa-tags fa-fw"></i>
                    <span>Category</span>:<a href="categories.php?pageid=<?php echo $item['Cat_ID'] ?>&pagename=<?php echo $item['Name'] ?>">  <?php echo $item['Name'] ?> </a>
                </li>
                
                    <li> <i class="fa fa-user fa-fw"></i>
                        <span>Added By</span>: <a href="members.php?Mid=<?php echo $item['Member_ID'] ?>&Mname=<?php echo $item['username'] ?>"> <?php echo $item['username'] ?> </a> 
                </li>
                   <li class="tag-items"> <i class="fa fa-unlock-alt fa-fw"></i>
                        <span>Tags</span>:  
                       <?php $Alltags = explode(",", $item['Tags']); 
                            foreach($Alltags as $Tag){
                                $Tag = str_replace(" ","",$Tag);
                                $lowerTag = strtolower($Tag);
                                if(! empty($Tag)) {
                                echo "<a href='tags.php?name={$lowerTag}'>".$Tag."</a>";
                            }  
                         }
                        ?> 
                </li>
            </ul>
            </div>
        </div>
        <hr class="custom-hr">
        <!--start add comment-->
        <?php 
        if(isset($_SESSION['user'])){ ?>
        <div class="row">
         <div class="col-md-9">
            <h4>Add your comment</h4>
             <form action="<?php echo $_SERVER['PHP_SELF'].'?Itemid='.$item['item_id'] ?>" method="POST">
                <textarea class="form-control" name="comment" style="height:120px;"></textarea>
                 
                 <input  class="btn btn-primary"type="submit" style="margin-top:10px;" value="Add comment">
             </form>
             <?php
              if($_SERVER['REQUEST_METHOD'] == 'POST'){
                 $comment = filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
                 $itemid  = $item['item_id'];
                 $userid  = $_SESSION['uid'];
                  
                  if(! empty($comment)){
                      $stmt =$con->prepare("INSERT INTO comments(comment, c_status, comment_date, item_id, user_id )
                                                        VALUES(:zcomment, 0, NOW(), :zitemid, :zuserid)");
                      $stmt->execute(array(
                          'zcomment'=> $comment,
                          'zitemid' => $itemid,
                          'zuserid' => $userid
                      ));
                      
                       if($stmt){
                      echo"<div class='alert alert-success'>comment Added</div>";
                  }
                  }elseif(empty($comment)){
                       echo"<div class='alert alert-danger'>comment Cannot be empty</div>";
                  }
                 
              }
            ?>
             
            </div>
        </div>
         <!--end add comment-->
       <?php   }else{
                echo"<div class='alert alert-info'><a href='login.php'>Login</a> or <a href='login'>Register</a> to Add a Comment</div>";
            } ?>
        <hr class="custom-hr">
          <?php 
                  
                        $stmt = $con->prepare("SELECT 
                                        comments.*, users.username AS member
                                   FROM 
                                        comments
                                   INNER JOIN
                                        users
                                    ON
                                        users.userID = comments.user_id
                                    WHERE item_id = ?
                                    AND c_status = 1
                                    ORDER BY
                                       c_id DESC ");
            
                    //Excute the Statement
                    $stmt->execute(array($item['item_id']));

                    //Assign to vars
                    $comments = $stmt->fetchAll();
               
                  
        ?>
        
               
         <?php 
                       foreach($comments as $comment){
                    echo "<div class='comment-box'>";
                        echo "<div class='row'>";
                                echo"<div class='col-sm-2 text-center'>";
                                echo "<img class='img-thumbnail rounded-circle ' src='img.png' alt='Card image cap'>";
                                echo  $comment['member']."</div>";
                                echo "<div class='col-md-10'><p class='lead'>". $comment['comment']." </p></div>";
                        echo "</div>";
                    echo "</div>";
           echo "<hr class='custom-hr'>";         
                    } ?>
           
        
    </div>
       

<?php
           
       }else{
        echo "there is no such id";
            }
include $tpl .'footer.php'; 


ob_end_flush();
?>


