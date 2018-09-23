<?php
/*
================================================
== Manage comments page
== You can Add | Edit | Delete | approve comments from here
================================================
*/
    session_start();
    
    $pageTitle = 'comments';
    if(isset($_SESSION['username'])){
            
        include'init.php';
                
        $Reqaction = isset($_GET['do'])?$_GET['do']:'Manage';

        //start manage page
        
        if ($Reqaction == 'Manage') {  //Manage page member
     
            
            
            //Select All users except the admin
            $stmt = $con->prepare("SELECT 
                                        comments.*,items.item_Name AS Itemname, users.username AS member
                                   FROM 
                                        comments
                                   INNER JOIN
                                        items
                                   ON
                                        items.item_id = comments.item_id
                                        
                                   INNER JOIN
                                        users
                                    ON
                                        users.userID = comments.user_id
                                    ORDER BY
                                       c_id DESC ");
            
            //Excute the Statement
            $stmt->execute();
            
            //Assign vars
            $rows = $stmt->fetchAll();
            ?>

            <h1 class="text-center">Manage comments</h1>
            <div class="container">
                <div class="table-responsive">
                <table class='main-table text-center table table-bordered'>
                    <tr>
                        <td>#ID</td>
                        <td>comment</td>
                        <td>Adding date</td>
                        <td>Item Name</td>
                        <td>User Name</td>
                        <td>Control</td>
                    </tr>
                    <?php
                        foreach($rows as $row){
                            
                            echo'<tr>';
                            echo'<td>'.$row['c_id'].'</td>';
                            echo'<td>'.$row['comment'].'</td>';
                            echo'<td>'.$row['comment_date'].'</td>';
                            echo'<td>'.$row['Itemname'].'</td>';
                            echo'<td>'.$row['member'].'</td>';
                            echo'<td>
                                <a href="comments.php?do=Edit&com_id='.$row['c_id'].'" class="btn btn-success"><i class= "fa fa-edit"></i>Edit</a>
                                <a href="comments.php?do=Delete&com_id='.$row['c_id'].'" class="btn btn-danger confirm"><i class ="fa fa-close"></i>Delete</a>';
                                if($row['c_status'] == 0){
                           echo'<a href="comments.php?do=Approve&com_id='.$row['c_id'].'" class="btn btn-info activate"><i class ="fa fa-check"></i>Approve</a>';         
                                }
                              echo'</td>'  ;
                            echo'</tr>';
                        }
                        
                        ?>
                    
                </table>
            </div>
        </div>


      
       <?php }elseif($Reqaction == 'Edit'){ //edit page 
            
            //Check if GET request is numeric & get the INT value of it
            
            $comid= isset($_GET['com_id'])&& is_numeric($_GET['com_id'])?intval($_GET['com_id']):0;
            
            //select All Data Depend on this ID
             $stmt = $con->prepare("SELECT * FROM comments WHERE c_id = ?");
            
            //excute query
            
             $stmt->execute(array($comid));
            
            //fecth the data
            
             $row = $stmt->fetch();
            
            //the row count
            
             $count = $stmt->rowCount();
            
            //if there is id in the form
             if($stmt->rowCount()>0){ ?>

                <h1 class="text-center">Edit comment</h1>
                <div class="container">
                    <form class="frm-horizontal" action="?do=update" method="POST">
                        <input type="hidden" name="com_id"  value="<?php echo $comid; ?>" />    
                               <!--start comment field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label">comment</label>
                             <div class="col-sm-10"> 
                                
                                  <textarea class="form-control" name="comment"><?php echo $row['comment'];?></textarea>     
                            </div>
                        </div>
                        <!--end username field-->
                          <div class="form-group">
                         <label class="col-sm-2 control-label"> members</label>
                             <div class="col-sm-10"> 
                                <select class="form-control"name="member">
                                    <option value="0">...</option>
                                    <?php
                                    $stmt =$con->prepare("SELECT* FROM users");
                                    $stmt ->execute();
                                    $users =$stmt->fetchAll();
                                    foreach($users as $user){
                                        echo'<option value="'.$user['userID'].'"';
                                        if( $row['user_id'] == $user['userID'] ){ echo'selected'; }
                                        echo ">".$user['username'].'</option>';
                                    }
                                    
                                    ?>
                                 
                                 </select>
                            </div>
                        </div>
                        <!--end members field-->
                          <!--start Submit field-->
                        <div class="form-group">
                             <div class="co-sm-offset-2 col-sm-10"> 
                                <input type="submit" value="save" class="btn btn-primary"/>
                            </div>
                        </div>
                        <!--end Submit field-->
                    </form>
                  
                </div>
            
    <?php     
        //if there is no such id show error messege
        }else{
                 echo'<div class = "container">';
              $TheMsg ='<div class = "alert alert-danger">There is no such Id</div>';
              redirectHome($TheMsg,'back',3);
                 echo'</div>';
        }
        
             
     }elseif($Reqaction == 'update'){//update page?>
            <h1 class="text-center">Update comment</h1>

              <?php 
                    echo'<div class ="container" >';
                    if($_SERVER['REQUEST_METHOD']=='POST'){
                        
                        //Get vars from the form
                      
                        $comid     = $_POST['com_id'];
                        $comment   = $_POST['comment'];
                        $member    = $_POST['member'];

                        //validate the form
                        
                                       
                        $FormErrors =array();

                        if(empty($comment)){
                                $FormErrors[]="username cannot be <strong> empty</strong>";
                         }
                    


                          if($member == 0){
                                   $FormErrors[]="You must choose the <strong> member</strong>";

                              }

                        foreach($FormErrors as $Error){
                            echo  "<div class ='alert alert-danger'>".$Error."</div>" ;
                            }
                           if(empty($FormErrors)){
                            //update the db with this info
                            $stmt = $con->prepare("UPDATE 
                                                        comments 
                                                    SET 
                                                        comment = ?, 
                                                        user_id =?

                                                    WHERE 
                                                        c_id = ? ");
                             $stmt->execute(array($comment, $member, $comid));
                               //echo succes messege
                               $TheMsg = '<div class="alert alert-success">'. $stmt->rowCount().'record updated</div>';
                               redirectHome($TheMsg,'back',6);

                        }
                        
                 }else{
                     $TheMsg ='<div class ="alert alert-danger">sorry you cannot enter this page directly</div>';
                        redirectHome($TheMsg,'back',3);
                }


                       echo'</div>';             ?>
   <?php  }elseif($Reqaction =='Delete'){
            
            //Delete memebers page
            echo'<h1 class="text-center">Delete comment</h1>';
            echo'<div class ="container" >';
            //Check if GET request is numeric & get the INT value of it
            
            $comid= isset($_GET['com_id'])&& is_numeric($_GET['com_id'])?intval($_GET['com_id']):0;
            
            //select All Data Depend on this ID
            // $stmt = $con->prepare("SELECT * FROM users WHERE userid = ?");
            
            //excute query
            
             //$stmt->execute(array($userid));
            
            //fecth the data
            
            // $row = $stmt->fetch();
            $ckeck =  CheckItem('c_id', 'comments',$comid );
            //the row count
            
            //$count = $stmt->rowCount();
            
            //if there is id in the form
             if($ckeck > 0){ 
                  $stmt = $con->prepare("DELETE  FROM comments WHERE c_id = :zcom");
                  $stmt -> bindParam(':zcom',$comid);
                  $stmt -> execute();
                 
                  $TheMsg = '<div class="alert alert-success">'. $stmt->rowCount().'record Deleted</div>';
                  redirectHome($TheMsg,'back',3);
            }else{
                 $TheMsg = '<div class ="alert alert-danger">This Id isnot exist</div>';
                 redirectHome($TheMsg);
             }
            echo'<div>';
        
         }elseif($Reqaction =='Approve'){
            
            //Activate memebers page
            echo'<h1 class="text-center">Activate member</h1>';
            echo'<div class ="container" >';
            //Check if GET request is numeric & get the INT value of it
            
            $comid= isset($_GET['com_id'])&& is_numeric($_GET['com_id'])?intval($_GET['com_id']):0;
            
            //select All Data Depend on this ID
            
             $ckeck =  CheckItem('c_id', 'comments',$comid );
            //the row count
            
            
            //if there is id in the form
             if($ckeck > 0){ 
                  $stmt = $con->prepare("UPDATE comments SET c_status = 1 WHERE c_id =? ");
                  $stmt -> execute(array($comid));
                 
                  $TheMsg = '<div class="alert alert-success">'. $stmt->rowCount().'record Activated</div>';
                  redirectHome($TheMsg,'back',3);
            }else{
                 $TheMsg = '<div class ="alert alert-danger">This Id isnot exist</div>';
                 redirectHome($TheMsg);
             }
            echo'<div>';
        }
        include $tpl .'footer.php';
        
    } else {
    
         header('location: index.php');
        
         exit();
    }