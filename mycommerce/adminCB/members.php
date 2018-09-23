<?php
/*
================================================
== Manage members page
== You can Add | Edit | Delete Membes from here
================================================
*/
    session_start();
    
    $pageTitle = 'Members';
    if(isset($_SESSION['username'])){
            
        include'init.php';
                
        $Reqaction = isset($_GET['do'])?$_GET['do']:'Manage';

        //start manage page
        
        if ($Reqaction == 'Manage') {  //Manage page member
            $query='';
            if(isset($_GET['page'])&&$_GET['page'] == 'Pending'){
                $query = 'AND RegStatues = 0';
            }
            
            //Select All users except the admin
            $stmt = $con->prepare("SELECT * FROM users WHERE GroupID !=1 $query ORDER BY userID DESC");
            
            //Excute the Statement
            $stmt->execute();
            
            //Assign vars
            $rows = $stmt->fetchAll();
            ?>
            <form action="members.php?do=SearchMembers" method="post">
                <input class="form-control" type="text" name="username" placeholder="search For a Member name"/>
                  <input class="form-control" type="text" name="userID" placeholder="search For  a Member id"/>
                <input type="submit" style="color:white;background-color:#00b;"Value="Search" class="form-control"/>
        </form>
            <h1 class="text-center">Manage Members</h1>
            <div class="container">
                <div class="table-responsive">
                <table class='main-table manage-members text-center table table-bordered'>
                    <tr>
                        <td>#ID</td>
                        <td>Avatar</td>
                        <td>Username</td>
                        <td>Email</td>
                        <td>Full Name</td>
                        <td>Registred date</td>
                        <td>Control</td>
                    </tr>
                    <?php
                        foreach($rows as $row){
                            
                            echo'<tr>';
                            echo'<td>'.$row['userID'].'</td>';
                            echo'<td>';
                            if(empty($row['avatar'])){
                                echo'<img src="img.png"/>';
                            }else{
                             echo'<img src="uploads/avatars/'.$row['avatar'].'"  alt =" " />';

                            }
                            echo'</td>';
                            echo'<td>'.$row['username'].'</td>';
                            echo'<td>'.$row['Email'].'</td>';
                            echo'<td>'.$row['FullName'].'</td>';
                            echo'<td>'.$row['Date'].'</td>';
                            echo'<td>
                                <a href="members.php?do=Edit&userid='.$row['userID'].'" class="btn btn-success"><i class= "fa fa-edit"></i>Edit</a>
                                <a href="members.php?do=Delete&userid='.$row['userID'].'" class="btn btn-danger confirm"><i class ="fa fa-close"></i>Delete</a>';
                                if($row['RegStatues'] == 0){
                           echo'<a href="members.php?do=Activate&userid='.$row['userID'].'" class="btn btn-info activate"><i class ="fa fa-check"></i>Activate</a>';         
                                }
                              echo'</td>'  ;
                            echo'</tr>';
                        }
                        
                        ?>
                    
                </table>
            </div>
            <a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i>Add new member</a>
        </div>


       <?php }elseif($Reqaction =='SearchMembers'){
            
                if($_SERVER['REQUEST_METHOD']=='POST'){
                    $id = $_POST["userID"];
                    $name = $_POST["username"];
                    $sql = "SELECT * FROM users WHERE username LIKE :username OR userID LIKE :userID";
                    $stmt = $con->prepare($sql);
                    $stmt ->execute(['username'=>$name,
                                    'userID'=>$id]);
                    if(!$stmt->rowCount() == 0){
                        while($row = $stmt->fetch()){
                            
            echo '<div class="container">';
                 echo '<div class="table-responsive">';
                 echo "<table class='main-table manage-members text-center table table-bordered'>";
                   echo" <tr>
                        <td>#ID</td>
                        <td>Avatar</td>
                        <td>Username</td>
                        <td>Email</td>
                        <td>Full Name</td>
                        <td>Registred date</td>
                        <td>Control</td>
                    </tr>";
                               echo'<tr>';
                            echo'<td>'.$row['userID'].'</td>';
                            echo'<td>';
                            if(empty($row['avatar'])){
                                echo'<img src="img.png"/>';
                            }else{
                             echo'<img src="uploads/avatars/'.$row['avatar'].'"  alt =" " />';

                            }
                            echo'</td>';
                            echo'<td>'.$row['username'].'</td>';
                            echo'<td>'.$row['Email'].'</td>';
                            echo'<td>'.$row['FullName'].'</td>';
                            echo'<td>'.$row['Date'].'</td>';
                            echo'<td>
                                <a href="members.php?do=Edit&userid='.$row['userID'].'" class="btn btn-success"><i class= "fa fa-edit"></i>Edit</a>
                                <a href="members.php?do=Delete&userid='.$row['userID'].'" class="btn btn-danger confirm"><i class ="fa fa-close"></i>Delete</a>';
                                if($row['RegStatues'] == 0){
                           echo'<a href="members.php?do=Activate&userid='.$row['userID'].'" class="btn btn-info activate"><i class ="fa fa-check"></i>Activate</a>';         
                                }
                              echo'</td>';
                            echo'</tr>';
                            echo'</table>
                            </div>
                            </div>';
                        }
                    }else{
                        echo"<div class='container'>
                        <div class='alert alert-danger text-center'>there is no such <strong>member</strong></div>
                        </div>";
                    }
                }else{
                    echo"you can't enter";
                }
             }elseif($Reqaction == 'Add'){//Add members page?>
            
             <h1 class="text-center">Add Member</h1>
                <div class="container">
                    <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
                               <!--start username field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label">Username</label>
                             <div class="col-sm-10"> 
                                <input type="text" 
                                       name="username" 
                                       class="form-control" 
                                       autocomplete='off'
                                       placeholder="Username To login into shop"
                                       required="required"/>
                            </div>
                        </div>
                        <!--end username field-->

                      <!--start password field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label">password</label>
                             <div class="col-sm-10"> 
                                <input type="password" 
                                       name="password" 
                                       class="Pass form-control" 
                                       autocomplete='new-password'
                                       placeholder="Password must be complex"
                                       required="required"/>
                                 <i class="show-password fa fa-eye fa-2x"></i>
                            </div>
                        </div>
                        <!--end password field-->

                          <!--start Email field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label">Email</label>
                             <div class="col-sm-10"> 
                                <input type="email"
                                       name="email" 
                                       class="form-control" 
                                       placeholder="Email must be valid"
                                       autocomplete='off'
                                       required="required"/>
                            </div>
                        </div>
                        <!--end Email field-->

                          <!--start Fullname field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label">Fullname</label>
                             <div class="col-sm-10"> 
                                <input type="text" 
                                       name="full" 
                                       class="form-control" 
                                       autocomplete='off'
                                       placeholder="Full Name appers in your profile page"
                                       required="required"/>
                            </div>
                        </div>
                        <!--end Fullname field-->
                            <!--start Avatar field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label">User Avatar</label>
                             <div class="col-sm-10"> 
                                <input type="file" 
                                       name="avatar" 
                                       class="form-control" 
                                       required="required"/>
                            </div>
                        </div>
                        <!--end Avatar field-->

                          <!--start Submit field-->
                        <div class="form-group">
                             <div class="co-sm-offset-2 col-sm-10"> 
                                <input type="submit" value="save" class="btn btn-primary"/>
                            </div>
                        </div>
                        <!--end Submit field-->
                    </form>
                  
                </div>
        <?php }elseif($Reqaction == 'Insert'){ //insert page members


              
               echo"<h1 class='text-center'>Insert member</h1>";
                echo'<div class ="container" >';
                if($_SERVER['REQUEST_METHOD']=='POST'){
                            
                            //upload vars
                    
                           $AvatarName = $_FILES['avatar']['name'];
                           $AvatarSize = $_FILES['avatar']['size'];
                           $AvatarTmpname = $_FILES['avatar']['tmp_name'];
                           $AvatarType = $_FILES['avatar']['type'];
                           
                    //list of allowed extension
                            $AvatarAllowedExtension= array("jpeg","jpg","png","gif");
                    //get avatar extension
                            $AvatarExtension = strtolower(end(explode('.',$AvatarName)));
                    
                          
                            //Get vars from the form
                          
                            $user   = $_POST['username'];
                            $email  = $_POST['email'];
                            $name   = $_POST['full'];
                            $Pass   = $_POST['password'];
                            $HashedPass = sha1($Pass);

                            //validate the form


                            $FormErrors =array();

                            if(strlen($user) < 3){
                                 $FormErrors[]="username cannot be less than  <strong> 3 </strong>charachters";

                              }
                            if(strlen($user) > 10){
                                  $FormErrors[]="username cannot be more than  <strong> 10 </strong>charachters";
                              }

                            if(empty($user)){
                                    $FormErrors[]="username cannot be <strong> empty</strong>";
                             }



                            if(empty($email)){
                                    $FormErrors[]="email cannot be <strong>empty</strong> ";
                            }

                              if(empty($name)){
                                   $FormErrors[]="fullname cannot be <strong> empty</strong>";

                              }
                            if (!empty($AvatarName) && ! in_array($AvatarExtension, $AvatarAllowedExtension)) {
                                $FormErrors[]='Sorry this type isnot <strong>allowed</strong>';
                            }
                            
                            if(empty($AvatarName)){
                                $FormErrors[]='Avatar is <strong>required</strong>';
                            }
                            if($AvatarSize > 4194304){
                                    $FormErrors[]='Avatar cannot be largr than <strong>4MB</strong>';
                            }
                            foreach($FormErrors as $Error){
                                echo  "<div class ='alert alert-danger'>".$Error."</div>" ;
                            }
                                  if(empty($FormErrors)){
                                      $avatar = rand(0,100000)."_".$AvatarName;
                                       move_uploaded_file($AvatarTmpname,"uploads\avatars\\".$avatar);
                                      
                                $check =CheckItem('username','users', $user);

                                    if($check == 1){
                                        $TheMsg ='<div class ="alert alert-danger">sorry this User Is Exist</div>';
                                        redirectHome($TheMsg,'back');
                                    }else{
                                    //insert the userinfo in db
                                    $stmt = $con->prepare('INSERT INTO 
                                                                    users(username, password, email, FullName,RegStatues, Date, avatar)
                                                                   VALUES(:zuser, :zpass, :zmail, :zname, 1, now(), :zavatar )');
                                     $stmt->execute(array(
                                         'zuser'   => $user,
                                         'zpass'   => $HashedPass,
                                         'zmail'   => $email, 
                                         'zname'   => $name,
                                         'zavatar' => $avatar
                                     ));
                                       //echo succes messege
                                       $TheMsg = '<div class="alert alert-success">'. $stmt->rowCount().'record Inserted</div>';

                                       redirectHome($TheMsg,'back');
                                    }                                 

                            }
                            
                         }else{
                             $TheMsg ='<div class="alert alert-danger">sorry you cannot enter this page directly</div>';

                             redirectHome($TheMsg,'back',3);
                        }


                               echo'</div>';             ?>

            
       <?php }elseif($Reqaction == 'Edit'){ //edit page 
            
            
            //Check if GET request is numeric & get the INT value of it
            
            $userid= isset($_GET['userid'])&& is_numeric($_GET['userid'])?intval($_GET['userid']):0;
            
            //select All Data Depend on this ID
             $stmt = $con->prepare("SELECT * FROM users WHERE userid = ?");
            
            //excute query
            
             $stmt->execute(array($userid));
            
            //fecth the data
            
             $row = $stmt->fetch();
            
            //the row count
            
             $count = $stmt->rowCount();
            
            //if there is id in the form
             if($stmt->rowCount()>0){ ?>

                <h1 class="text-center">Edit Member</h1>
                <div class="container">
                    <form class="frm-horizontal" action="?do=update" method="POST">
                        <input type="hidden" name="userid"  value="<?php echo $userid; ?>" />    
                               <!--start username field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label">Username</label>
                             <div class="col-sm-10"> 
                                <input type="text" 
                                       name="username" 
                                       class="form-control" 
                                       value="<?php echo $row['username'];?>" 
                                       autocomplete='off'
                                       required="required"/>
                            </div>
                        </div>
                        <!--end username field-->

                      <!--start password field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label">password</label>
                             <div class="col-sm-10"> 
                                <input type="password" 
                                       name="password" 
                                       class="form-control" 
                                       placeholder="leave blank if you don't want to change"
                                       autocomplete='new-password'/>
                            </div>
                        </div>
                        <!--end password field-->

                          <!--start Email field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label">Email</label>
                             <div class="col-sm-10"> 
                                <input type="email"
                                       name="email" 
                                       class="form-control" 
                                       value="<?php echo $row['Email'];?>"
                                       required="required"/>
                            </div>
                        </div>
                        <!--end Email field-->

                          <!--start Fullname field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label">Fullname</label>
                             <div class="col-sm-10"> 
                                <input type="text" 
                                       name="full" 
                                       class="form-control" 
                                       value="<?php echo $row['FullName'];?>"
                                       required="required"/>
                            </div>
                        </div>
                        <!--end Fullname field-->
                           <!--start avatar field-->
                        
          
                      <?php if(isset($row['avatar'])){
                    echo '<img src="uploads/avatars/'.$row['avatar'].'" style="   
                      width: 50px;
                      height: 50px;
                      border-radius: 50px 50px;"  alt =" " />';
                        echo"<a href='?do=EditAva&userid=".$row['userID']."&avatar=".$row['avatar']."'>changeAvatar</a>";
             
                    } ?>
                
                        <!--end avatar field-->
                        

                          <!--start Submit field-->
                        <div class="form-group">
                             <div class="co-sm-offset-2 col-sm-10"> 
                                <input type="submit" value="save" class="btn btn-primary"/>
                            </div>
                        </div>
                        <!--end Submit field-->
                    </form>
                  
                </div>
            }
    <?php     
        //if there is no such id show error messege
        }else{
                 echo'<div class = "container">';
              $TheMsg ='<div class = "alert alert-danger">There is no such Id</div>';
              redirectHome($TheMsg,'back',3);
                 echo'</div>';
        }
        
             
     }elseif($Reqaction == 'EditAva'){
            $userid= isset($_GET['userid'])&& is_numeric($_GET['userid'])?intval($_GET['userid']):0;
            
            
            
            //select All Data Depend on this ID
             $stmt = $con->prepare("SELECT * FROM users WHERE userid = ? ");
            
            //excute query
            
             $stmt->execute(array($userid));
            
            //fecth the data
            
             $row = $stmt->fetch();
            
            //the row count
            
             $count = $stmt->rowCount();
            
            //if there is id in the form
                          $AvatarName = $_FILES['avatar']['name'];
                           $AvatarSize = $_FILES['avatar']['size'];
                           $AvatarTmpname = $_FILES['avatar']['tmp_name'];
                           $AvatarType = $_FILES['avatar']['type'];
            //list of allowed extension
                            $AvatarAllowedExtension= array("jpeg","jpg","png","gif");
                    //get avatar extension
                            $AvatarExtension = strtolower(end(explode('.',$AvatarName)));
                            $avatar = rand(0,100000)."_".$AvatarName;
                                       move_uploaded_file($AvatarTmpname,"uploads\avatars\\".$avatar);
                           
             echo"<div class='container text-center'>";
                    echo"<h1>Your recent Avatar is ". $row['avatar']."</h1>";
                    
                    echo '<img src="uploads/avatars/'.$row['avatar'].'" style="   
                      width: 300px;
                      height: 300px;
                      border-radius: 300px 300px;"  alt =" " />';
        
        
            echo"</div>";
                     ?>
            <!--start Avatar field-->
<hr>        
                   <form class="form-horizontal" action="?do=UpdateAva" method="POST" enctype="multipart/form-data">
                             <input type="hidden" name="userid"  value="<?php echo $userid; ?>" />    
                        <div class="form-group">
                         <label class="col-sm-2 control-label">User Avatar</label>
                             <div class="col-sm-10"> 
                                <input type="file" 
                                       name="avatar" 
                                       class="form-control" 
                                       />
                            </div>
                        </div>
                           <!--start Submit field-->
                        <div class="form-group">
                             <div class="co-sm-offset-2 col-sm-10"> 
                                <input type="submit" value="save" class="btn btn-primary"/>
                            </div>
                        </div>
                        <!--end Submit field-->
                  <!--end Avatar field-->
</form>
         
            
            
            
           
            
      <?php  }elseif($Reqaction == 'UpdateAva'){
            if($_SERVER['REQUEST_METHOD']=='POST'){
                
                            $id = $_POST['userid'];
                            $AvatarName = $_FILES['avatar']['name'];
                           $AvatarSize = $_FILES['avatar']['size'];
                           $AvatarTmpname = $_FILES['avatar']['tmp_name'];
                           $AvatarType = $_FILES['avatar']['type'];
            //list of allowed extension
                            $AvatarAllowedExtension= array("jpeg","jpg","png","gif");
                    //get avatar extension
                            $AvatarExtension = strtolower(end(explode('.',$AvatarName)));
                            $avatar = rand(0,100000)."_".$AvatarName;
                            move_uploaded_file($AvatarTmpname,"uploads\avatars\\".$avatar);
                    
                                      
                    
                 //update the db with this info
                            $stmt = $con->prepare('UPDATE 
                                                        users 
                                                    SET 
                                                       avatar = ?
                                                    Where 
                                                        userID = ? ');
                             $stmt->execute(array($avatar,$id ));
                               //echo succes messege
                               $TheMsg = '<div class="alert alert-success">'. $stmt->rowCount().'record updated</div>';
                               redirectHome($TheMsg,'back',6);


                        }
                        
                
            
            }elseif($Reqaction == 'update'){//update page?>
            <h1 class="text-center">Update member</h1>

              <?php 
                    echo'<div class ="container" >';
                    if($_SERVER['REQUEST_METHOD']=='POST'){
                        
                
                        //Get vars from the form
                      
                        $id     = $_POST['userid'];
                        $user   = $_POST['username'];
                        $email  = $_POST['email'];
                        $name   = $_POST['full'];
                        $Pass   = $_POST['password'];
                        $HashedPass = sha1($Pass);
                        
                        //validate the form
                        
                                       
                        $FormErrors =array();

                        if(strlen($user) < 3){
                             $FormErrors[]="username cannot be less than  <strong> 3 </strong>charachters";

                          }
                        if(strlen($user) > 10){
                              $FormErrors[]="username cannot be more than  <strong> 10 </strong>charachters";
                          }

                        if(empty($user)){
                                $FormErrors[]="username cannot be <strong> empty</strong>";
                         }
                    


                        if(empty($email)){
                                $FormErrors[]="email cannot be <strong>empty</strong> ";
                        }

                          if(empty($name)){
                               $FormErrors[]="fullname cannot be <strong> empty</strong>";

                          }
                           

                        foreach($FormErrors as $Error){
                            echo  "<div class ='alert alert-danger'>".$Error."</div>" ;
                            }
                           if(empty($FormErrors)){
                                 
                            //update the db with this info
                            $stmt = $con->prepare('UPDATE 
                                                        users 
                                                    SET 
                                                        username = ?, 
                                                        password =?,
                                                        Email = ?, 
                                                        FullName = ?
                                                    Where 
                                                        userID = ? ');
                             $stmt->execute(array($user, $HashedPass, $email, $name ,$id ));
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
            echo'<h1 class="text-center">Delete member</h1>';
            echo'<div class ="container" >';
            //Check if GET request is numeric & get the INT value of it
            
            $userid= isset($_GET['userid'])&& is_numeric($_GET['userid'])?intval($_GET['userid']):0;
            
            //select All Data Depend on this ID
            // $stmt = $con->prepare("SELECT * FROM users WHERE userid = ?");
            
            //excute query
            
             //$stmt->execute(array($userid));
            
            //fecth the data
            
            // $row = $stmt->fetch();
            $ckeck =  CheckItem('userid', 'users',$userid );
            //the row count
            
            //$count = $stmt->rowCount();
            
            //if there is id in the form
             if($ckeck > 0){ 
                  $stmt = $con->prepare("DELETE  FROM users WHERE userid = :zuser");
                  $stmt -> bindParam(':zuser',$userid);
                  $stmt -> execute();
                 
                  $TheMsg = '<div class="alert alert-success">'. $stmt->rowCount().'record Deleted</div>';
                  redirectHome($TheMsg,'back',3);
            }else{
                 $TheMsg = '<div class ="alert alert-danger">This Id isnot exist</div>';
                 redirectHome($TheMsg);
             }
            echo'<div>';
        
         }elseif($Reqaction =='Activate'){
            
            //Activate memebers page
            echo'<h1 class="text-center">Activate member</h1>';
            echo'<div class ="container" >';
            //Check if GET request is numeric & get the INT value of it
            
            $userid= isset($_GET['userid'])&& is_numeric($_GET['userid'])?intval($_GET['userid']):0;
            
            //select All Data Depend on this ID
            
            $ckeck =  CheckItem('userid', 'users',$userid );
            //the row count
            
            
            //if there is id in the form
             if($ckeck > 0){ 
                  $stmt = $con->prepare("UPDATE users SET RegStatues = 1 WHERE userID =? ");
                  $stmt -> execute(array($userid));
                 
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