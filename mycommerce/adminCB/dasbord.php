<?php
    ob_start();
    session_start();
    
    
    if(isset($_SESSION['username'])){
        $pageTitle = 'dashbord';
            
        include'init.php';

      
        ?>
        <div class="container home-stats text-center">
            <h1>Dashbord</h1>
            <div class="row">
                <div class="col-md-3">
                    <div class="stat st-members">
                         <i class="fa fa-users"></i>
                        Total members
                    <span><a href="members.php"><?php echo countItems('userID','users')?></a></span>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="stat st-pending">
                         <i class="fa fa-user-plus"></i>
                        Pending members
                        <span><a href="members.php?do=Manage&page=Pending"><?php echo CheckItem('RegStatues','users',0)?></a></span>
                    </div>
                </div>
                
                 <div class="col-md-3">
                    <div class="stat st-Items">
                         <i class="fa fa-tag"></i>
                        Total Items
                       <span><a href="Items.php"><?php echo countItems('item_id','items')?></a></span>
                     </div>
                </div>
                
                <div class="col-md-3">
                    <div class="stat st-Comments">
                          <i class="fa fa-comments"></i>
                        Total Comments
                       <span><a href="comments.php"><?php echo countItems('c_id','comments')?></a></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="container latest">
             <div class="row">
                 <div class="col-sm-6">
                     <div class="card">
                         <?php $NumUsers = 5; ?>
                         <div class="card-header">
                           <i class="fa fa-users"></i>Latest <?php echo $NumUsers; ?> Registerd users
                         </div>
                         <div class="card-body">
                              <ul class="list-unstyled latest-users">
                            <?php
                            
                        $theLatestUsers = getLatest("*","users","userID",$NumUsers);
                                if(! empty($theLatestUsers)){
        
                                foreach($theLatestUsers as $user){
                                    echo"<li>";
                                    echo $user['username'];
                                    echo '<a href="members.php?do=Edit&userid='.$user['userID'].' ">';
                                    echo"<span class='btn btn-success pull-right'>";
                                    echo"<i class = 'fa fa-edit'></i>Edit";
                                    if($user['RegStatues'] == 0){
                                        echo'<a href="members.php?do=Activate&userid='.$user['userID'].'" class="btn btn-info activate pull-right"><i class ="fa fa-check"></i>Activate</a>';           
                                            }
                                    echo"</span>";
                                    echo"</a>";
                                    echo"</li>";
                                    } 
                                }else{
                                    echo"there is no records to show";
                                }
                                ?>
                             </ul>  
                         </div>
                     </div>
                 </div>
                 
                   <div class="col-sm-6">
                     <div class="card">
                          <?php $NumItems= 5; ?>
                         <div class="card-header">
                           <i class="fa fa-tag"></i>Latest <?php echo $NumItems; ?> items
                         </div>
                         <div class="card-body">
                              <ul class="list-unstyled latest-users">
                            <?php
                                $theLatestItems = getLatest("*","items","item_id",$NumItems);
                                
                                foreach($theLatestItems as $Item){
                                    echo"<li>";
                                    echo $Item['item_Name'];
                                    echo '<a href="Items.php?do=Edit&Itemid='.$Item['item_id'].' ">';
                                    echo"<span class='btn btn-success pull-right'>";
                                    echo"<i class = 'fa fa-edit'></i>Edit";
                                    if($Item['Approve'] == 0){
                                        echo'<a href="Items.php?do=Approve&Itemid='.$Item['item_id'].'" class="btn btn-info activate pull-right"><i class ="fa fa-check"></i>Approve</a>';           
                                    }
                                    echo"</span>";
                                    echo"</a>";
                                    echo"</li>";
                                }
                                ?>
                             </ul>  
                         </div>
                     </div>
                 </div>
                 
                <div class="col-sm-10" style="margin-left:100px;
                                              margin-top:10px;">
                     <div class="card">
                          <?php $Numcoms= 5; ?>
                         <div class="card-header">
                           <i class="fa fa-comments"></i>Latest  <?php echo $Numcoms; ?>  comments
                         </div>
                         <div class="card-body">
                              <ul class="list-unstyled latest-users">
                            <?php
                                    
             $stmt = $con->prepare("SELECT 
                                        comments.*, users.username AS member
                                   FROM 
                                        comments
                                  
                                   INNER JOIN
                                        users
                                    ON
                                        users.userID = comments.user_id ");
            
            //Excute the Statement
            $stmt->execute();
            
            //Assign vars
            $coms = $stmt->fetchAll();
                                
                                foreach($coms as $com){
                                    echo"<li>";
                                    echo"<div class='comment-box'>";
                                    echo "<span class ='member-n'>".$com['member'] . "</span>";
                                    echo "<p class ='member-c'>".$com['comment']. "</p>";
                                    echo'<a href="comments.php?do=Edit&com_id='.$com['c_id'].' ">';
                                    echo"<span class='btn btn-success pull-right'>";
                                    echo"<i class = 'fa fa-edit'></i>Edit";
                                    if($com['c_status'] == 0){
                                        echo'<a href="comments.php?do=Approve&com_id='.$com['c_id'].'" class="btn btn-info activate pull-right"><i class ="fa fa-check"></i>Approve</a>';           
                                    }
                                    echo"</span>";
                                    echo"</a>";
                                     echo"</div>";
                                    echo"</li>";
                                      echo'<hr>';
                                    
                                }
                                ?>
                             </ul>  
                         </div>
                     </div>
                 </div>
                 
                 
             </div>
        </div>
       <?php  include $tpl .'footer.php';
        
    } else {
        
         header('location: index.php');
         exit();
    }
  ob_end_flush();
