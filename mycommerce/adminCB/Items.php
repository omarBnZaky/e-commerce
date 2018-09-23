<?php
/*
====================================
============Items page===========
====================================
*/
ob_start();
session_start();
    
    $pageTitle = 'Items';
    if(isset($_SESSION['username'])){
            
        include'init.php';
        
        $Reqaction = isset($_GET['do'])?$_GET['do']:'Manage';
        
        
       if ($Reqaction == 'Manage') { 
              //Select All users except the admin
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
                                        ORDER BY item_id DESC");
            
            //Excute the Statement
            $stmt->execute();
            
            //Assign vars
            $items = $stmt->fetchAll();
            ?>
             <form action="Items.php?do=SearchItems&Itemid={$row['item_id']}" method="post">
                <input class="form-control" type="text" name="item_Name" placeholder="search For a Item name"/>
                  <input class="form-control" type="text" name="item_id" placeholder="search For a Item id"/>
                <input type="submit" style="color:white;background-color:#00b;"Value="Search" class="form-control"/>
        </form>
           
            <h1 class="text-center">Manage Items</h1>
            <div class="container">
                <div class="table-responsive">
                <table class='main-table text-center table table-bordered'>
                    <tr>
                        <td>#ID</td>
                        <td>Name</td>
                        <td>Description</td>
                        <td>price</td>
                        <td>Category</td>
                        <td>Username</td>
                        <td>Adding date</td>
                        <td>Control</td>
                    </tr>
                    <?php
                        foreach($items as $item){
                            
                            echo'<tr>';
                            echo'<td>'.$item['item_id'].'</td>';
                            echo'<td>'.$item['item_Name'].'</td>';
                            echo'<td>'.$item['item_Description'].'</td>';
                            echo'<td>$'.$item['price'].'</td>';
                            echo'<td>'.$item['Name'].'</td>';
                            echo'<td>'.$item['username'].'</td>';
                            echo'<td>'.$item['Add_Date'].'</td>';
                            echo'<td>
                                <a href="Items.php?do=Edit&Itemid='.$item['item_id'].'" class="btn btn-success"><i class= "fa fa-edit"></i>Edit</a>
                                <a href="Items.php?do=Delete&Itemid='.$item['item_id'].'" class="btn btn-danger confirm"><i class ="fa fa-close"></i>Delete</a>
                                <a href="Items.php?do=show_com&Itemid='.$item['item_id'].'" class="btn btn-info "><i class ="fa fa-eye"></i>show comments</a>';
                                   if($item['Approve'] == 0){
                           echo'<a href="Items.php?do=Approve&Itemid='.$item['item_id'].'" class="btn btn-info activate"><i class ="fa fa-check"></i>Approve</a>';         
                                }
                              echo'</td>'  ;
                            echo'</tr>';
                        }
                        
                        ?>
                    
                </table>
            </div>
            <a href="Items.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i>Add new Item</a>
        </div>

           
     <?php  }elseif($Reqaction == 'SearchItems'){
           if($_SERVER['REQUEST_METHOD']=='POST'){
                    $id = $_POST["item_id"];
                    $name = $_POST["item_Name"];
                    $sql = "SELECT items.*,categories.Name,  users.username 
                            FROM  items
                            INNER JOIN  categories
                            ON  categories.ID = items.Cat_ID 
                            INNER JOIN users 
                            ON  users.userID = items.Member_ID
                            WHERE item_id LIKE :item_id
                            OR item_Name LIKE :item_Name";
                    $stmt = $con->prepare($sql);
                    $stmt ->execute(['item_Name'=>$name,
                                    'item_id'=>$id]);
                    if(!$stmt->rowCount() == 0){
                      
                        while($row = $stmt->fetch()){ 
                                        
                    ?>
                 
                <div class="container">
                <div class="table-responsive">
                <table class='main-table text-center table table-bordered'>
                    <tr>
                        <td>#ID</td>
                        <td>Name</td>
                        <td>Description</td>
                        <td>price</td>
                        <td>Category</td>
                        <td>Username</td>
                        <td>Adding date</td>
                        <td>Control</td>
                    </tr>
                <?php  
                        echo'<tr>';
                            echo'<td>'.$row['item_id'].'</td>';
                            echo'<td>'.$row['item_Name'].'</td>';
                            echo'<td>'.$row['item_Description'].'</td>';
                            echo'<td>$'.$row['price'].'</td>';
                            echo'<td>'.$row['Name'].'</td>';
                            echo'<td>'.$row['username'].'</td>';
                            echo'<td>'.$row['Add_Date'].'</td>';
                            echo'<td>
                                <a href="Items.php?do=Edit&Itemid='.$row['item_id'].'" class="btn btn-success"><i class= "fa fa-edit"></i>Edit</a>
                                <a href="Items.php?do=Delete&Itemid='.$row['item_id'].'" class="btn btn-danger confirm"><i class ="fa fa-close"></i>Delete</a>
                                <a href="Items.php?do=show_com&Itemid='.$row['item_id'].'" class="btn btn-info "><i class ="fa fa-eye"></i>show comments</a>';
                                   if($item['Approve'] == 0){
                           echo'<a href="Items.php?do=Approve&Itemid='.$row['item_id'].'" class="btn btn-info activate"><i class ="fa fa-check"></i>Approve</a>';         
                                }
                              echo'</td>'  ;
                            echo'</tr>';
                    
                    ?>
                </table>
            </div>
            <a href="Items.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i>Add new Item</a>
            </div>
                    <?php   }
                    }else{
                        echo"there is no such thing";
                    }
                }
           
            }elseif($Reqaction == 'Add'){    ?>
            <h1 class="text-center">Add New Item</h1>
                <div class="container">
                    <form class="form-horizontal" action="?do=Insert" method="POST">
                               <!--start nane field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label">Item Name</label>
                             <div class="col-sm-10"> 
                                <input type="text" 
                                       name="name" 
                                       class="form-control" 
                                       placeholder="name of the Item"
                                       reqiured="required"
                                       <?php echo $item['Tags']; ?>
                                       />
                            </div>
                        </div>
                        <!--end name field-->
                        
                                   <!--start Description field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label">Description</label>
                             <div class="col-sm-10"> 
                                <input type="text" 
                                       name="Description" 
                                       class="form-control" 
                                       placeholder="Description of the Item"
                                       reqiured="required"
                                       />
                            </div>
                        </div>
                        <!--end Description field-->
                        
                             <!--start price field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label">price</label>
                             <div class="col-sm-10"> 
                                <input type="text" 
                                       name="price" 
                                       class="form-control" 
                                       placeholder="price of the Item"
                                      reqiured="required"
                                       />
                            </div>
                        </div>
                        <!--end price field-->
                                    <!--start Country field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label">Country of made</label>
                             <div class="col-sm-10"> 
                                <input type="text" 
                                       name="Country" 
                                       class="form-control" 
                                       placeholder="Country"
                                       reqiured="required"
                                       />
                            </div>
                        </div>
                        <!--end Country field-->
                        
                                         <!--start status field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label"> status</label>
                             <div class="col-sm-10"> 
                                <select class="form-control"name="status" reqiured="required">
                                    <option value="0">....</option>
                                    <option value="1">New</option>
                                    <option value="2">like New</option>
                                    <option value="3">Well Enjoyed</option>
                                    <option value="4">Old</option>
                                 </select>
                            </div>
                        </div>
                        <!--end price field-->
                        
                                             <!--start members field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label"> members</label>
                             <div class="col-sm-10"> 
                                <select class="form-control"name="members">
                                    <option value="0">...</option>
                                    <?php
                                    $AllMember = getAllFrom("*","users","","","userID");
                                    foreach($AllMember as $user){
                                        echo'<option value="'.$user['userID'].'">'.$user['username'].'</option>';
                                    }
                                    
                                    ?>
                                 
                                 </select>
                            </div>
                        </div>
                        <!--end members field-->
                                                    <!--start categories field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label"> categories</label>
                             <div class="col-sm-10"> 
                                <select class="form-control"name="category" reqiured="required">
                                    <option value="0">...</option>
                                    <?php
                                $AllCats= getAllFrom("*","categories","WHERE parent=0","","ID");
                                foreach($AllCats as $cat){
                                  echo'<option value="'.$cat['ID'].'">'.$cat['Name'].'</option>';
                                    $ChildCats = getAllFrom("*","categories","WHERE parent={$cat['ID']}","","ID");
                                        foreach($ChildCats as $Childcat){
                                        echo'<option value="'.$Childcat['ID'].'">--'.$Childcat['Name'].'(Child from '. $cat['Name'].')</option>';    
                                        }
                                    }
                                    
                                    ?>
                                 
                                 </select>
                            </div>
                        </div>
                        <!--end categories field-->
                        
                             <!--start Tags field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label">Tags</label>
                             <div class="col-sm-10"> 
                                <input type="text" 
                                       name="Tags" 
                                       class="form-control" 
                                       placeholder="seperate tgs with comma(,)"
                                       
                                       />
                            </div>
                        </div>
                        <!--end Tags field-->
                              <!--start Submit field-->
                    <div class="form-group">
                         <div class="co-sm-offset-2 col-sm-10"> 
                            <input type="submit" value="Add Item" class="btn btn-primary"/>
                        </div>
                    </div>
                    <!--end Submit field-->
                </form>
<?php  }elseif($Reqaction == 'Insert'){
           
               echo"<h1 class='text-center'>Insert member</h1>";
                echo'<div class ="container" >';
                if($_SERVER['REQUEST_METHOD']=='POST'){

                            //Get vars from the form

                            $name    = $_POST['name'];
                            $desc    = $_POST['Description'];
                            $price   = $_POST['price'];
                            $Country = $_POST['Country'];
                            $status  = $_POST['status'];
                            $member  = $_POST['members'];
                            $category= $_POST['category']; 
                            $Tags    = $_POST['Tags'];
                            //validate the form


                            $FormErrors =array();

                            if(empty($name)){
                                 $FormErrors[]="name cannot  be <strong> Empty </strong>";

                              }
                            if(empty($desc)){
                                  $FormErrors[]="Description cannot be <strong> Empty </strong>";
                              }

                            if(empty($price)){
                                    $FormErrors[]="price cannot be <strong> Empty</strong>";
                             }



                            if(empty($Country)){
                                    $FormErrors[]="price cannot be <strong>Empty</strong> ";
                            }

                              if($status == 0){
                                   $FormErrors[]="You must choose the <strong> status</strong>";

                              }
                              if($member == 0){
                                   $FormErrors[]="You must choose the <strong> member</strong>";

                              }
                               if($category == 0){
                                   $FormErrors[]="You must choose the <strong> category</strong>";

                              }
                            foreach($FormErrors as $Error){
                                echo  "<div class ='alert alert-danger'>".$Error."</div>" ;
                                }
                               if(empty($FormErrors)){

                                    //insert the userinfo in db
                                    $stmt = $con->prepare('INSERT INTO 
                                                                    items(item_Name, item_Description, price, Country_Made,statues, Add_Date, Cat_ID, Member_ID,Tags)
                                                                   VALUES(:zitem_Name, :zitem_Description, :zprice, :zCountry_Made, :zstatues, now(), :zCat, :zmember, :zTags )');
                                     $stmt->execute(array(
                                         'zitem_Name'         => $name,
                                         'zitem_Description'  => $desc,
                                         'zprice'             => $price, 
                                         'zCountry_Made'      => $Country,
                                         'zstatues'           => $status,
                                         'zCat'               => $category,
                                         'zmember'            => $member,
                                         'zTags'              => $Tags
                                     ));
                                       //echo succes messege
                                       $TheMsg = '<div class="alert alert-success">'. $stmt->rowCount().'record Inserted</div>';

                                       redirectHome($TheMsg,'back');
                                    }
                            
       
                         }else{
                             $TheMsg ='<div class="alert alert-danger">sorry you cannot enter this page directly</div>';

                             redirectHome($TheMsg,'back',3);
                        }


                               echo'</div>'; 
       }elseif($Reqaction == 'Edit'){
              //Check if GET request is numeric & get the INT value of it
            
            $itemID= isset($_GET['Itemid'])&& is_numeric($_GET['Itemid'])?intval($_GET['Itemid']):0;
            
            //select All Data Depend on this ID
             $stmt = $con->prepare("SELECT * FROM items WHERE item_id = ?");
            
            //excute query
            
             $stmt->execute(array($itemID));
            
            //fecth the data
            
             $item = $stmt->fetch();
            
            //the row count
            
             $count = $stmt->rowCount();
            
            //if there is id in the form
             if($stmt->rowCount()>0){ ?>

                
                          <h1 class="text-center">Edit Item</h1>
                <div class="container">
                    <form class="form-horizontal" action="?do=update" method="POST">
                    <input type="hidden" name="Itemid"  value="<?php echo $itemID ?>"/>    
   

                               <!--start nane field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label">Item Name</label>
                             <div class="col-sm-10"> 
                                <input type="text" 
                                       name="name" 
                                       class="form-control" 
                                       placeholder="name of the Item"
                                       value ="<?php echo $item['item_Name'] ?>"
                                       />
                            </div>
                        </div>
                        <!--end name field-->
                        
                                   <!--start Description field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label">Description</label>
                             <div class="col-sm-10"> 
                                <input type="text" 
                                       name="Description" 
                                       class="form-control" 
                                       placeholder="Description of the Item"
                                        value ="<?php echo $item['item_Description'] ?>"
                                       />
                            </div>
                        </div>
                        <!--end Description field-->
                        
                             <!--start price field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label">price</label>
                             <div class="col-sm-10"> 
                                <input type="text" 
                                       name="price" 
                                       class="form-control" 
                                       placeholder="price of the Item"
                                       value ="<?php echo $item['price'] ?>"
                                       />
                            </div>
                        </div>
                        <!--end price field-->
                                    <!--start Country field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label">Country of made</label>
                             <div class="col-sm-10"> 
                                <input type="text" 
                                       name="Country" 
                                       class="form-control" 
                                       placeholder="Country made"
                                        value ="<?php echo $item['Country_Made'] ?>"
                                       />
                            </div>
                        </div>
                        <!--end Country field-->
                        
                                         <!--start status field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label"> status</label>
                             <div class="col-sm-10"> 
                                <select class="form-control" name="status">
                                    <option value="1" <?php if($item['statues'] == 1 ){echo'selected'; } ?>>New</option>
                                    <option value="2" <?php if($item['statues'] == 2 ){echo'selected'; } ?>>like New</option>
                                    <option value="3" <?php if($item['statues'] == 3 ){echo'selected'; } ?>>Well Enjoyed</option>
                                    <option value="4" <?php if($item['statues'] == 4 ){echo'selected'; } ?>>Old</option>
                                 </select>
                            </div>
                        </div>
                        <!--end price field-->
                        
                                             <!--start members field-->
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
                                        if( $item['Member_ID'] == $user['userID'] ){ echo'selected'; }
                                        echo ">".$user['username'].'</option>';
                                    }
                                    
                                    ?>
                                 
                                 </select>
                            </div>
                        </div>
                        <!--end members field-->
                                                    <!--start categories field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label"> category</label>
                             <div class="col-sm-10"> 
                                <select class="form-control"name="category">
                                    <option value="0">...</option>
                                    <?php
                                    $stmt =$con->prepare("SELECT* FROM categories");
                                    $stmt ->execute();
                                    $cats =$stmt->fetchAll();
                                    foreach($cats as $cat){
                                        echo'<option value="'.$cat['ID'].'"';
                                        if( $item['Cat_ID'] == $cat['ID'] ){ echo'selected'; }
                                           echo ">" .$cat['Name'].'</option>';
                                    }
                                    
                                    ?>
                                 
                                 </select>
                            </div>
                        </div>
                               <!--start Tags field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label">Tags</label>
                             <div class="col-sm-10"> 
                                <input type="text" 
                                       name="Tags" 
                                       class="form-control" 
                                       placeholder="seperate tgs with comma(,)"
                                       value = "<?php echo $item["Tags"] ?>"
                                       />
                            </div>
                        </div>
                        <!--end Tags field-->
                        <!--end categories field-->
                              <!--start Submit field-->
                    <div class="form-group">
                         <div class="co-sm-offset-2 col-sm-10"> 
                            <input type="submit" value="save Item" class="btn btn-primary"/>
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

                        ?>
           
      <?php }elseif($Reqaction == 'update'){  ?>
       
             <h1 class="text-center">Update Item</h1>

              <?php 
                    echo'<div class ="container" >';
                    if($_SERVER['REQUEST_METHOD']=='POST'){
                        
                        //Get vars from the form
                      
                        $id       = $_POST['Itemid'];
                        $name     = $_POST['name'];
                        $desc     = $_POST['Description'];
                        $price    = $_POST['price'];
                        $Country  = $_POST['Country'];
                        $status   = $_POST['status'];
                        $member   = $_POST['member'];
                        $cat      = $_POST['category'];
                        $Tags     = $_POST['Tags'];
                       
                        
                        //validate the form
                        
                                       
                      
                            $FormErrors =array();

                            if(empty($name)){
                                 $FormErrors[]="name cannot  be <strong> Empty </strong>";

                              }
                            if(empty($desc)){
                                  $FormErrors[]="Description cannot be <strong> Empty </strong>";
                              }

                            if(empty($price)){
                                    $FormErrors[]="price cannot be <strong> Empty</strong>";
                             }



                            if(empty($Country)){
                                    $FormErrors[]="price cannot be <strong>Empty</strong> ";
                            }

                              if($status == 0){
                                   $FormErrors[]="You must choose the <strong> status</strong>";

                              }
                              if($member == 0){
                                   $FormErrors[]="You must choose the <strong> member</strong>";

                              }
                               if($cat == 0){
                                   $FormErrors[]="You must choose the <strong> category</strong>";

                              }
                            foreach($FormErrors as $Error){
                                echo  "<div class ='alert alert-danger'>".$Error."</div>" ;
                                }
                           if(empty($FormErrors)){
                            //update the db with this info
                            $stmt = $con->prepare("UPDATE 
                                                        items 
                                                    SET 
                                                        item_Name = ?, 
                                                        item_Description = ?,
                                                        price = ?, 
                                                        Country_Made = ?,
                                                        statues = ?,
                                                        Member_ID = ?,
                                                        Cat_ID = ?,
                                                         Tags = ?
                                                    WHERE 
                                                        item_id = ? ");
                             $stmt->execute(array($name, $desc, $price, $Country, $status, $member, $cat, $Tags, $id));
                               //echo succes messege
                               $TheMsg = '<div class="alert alert-success">'. $stmt->rowCount().'record updated</div>';
                               redirectHome($TheMsg,'back',6);

                        }
                        
                 }else{
                     $TheMsg ='<div class ="alert alert-danger">sorry you cannot enter this page directly</div>';
                        redirectHome($TheMsg,'back',3);
                }


                       echo'</div>';             ?>        
          
       <?php }elseif($Reqaction =='Delete'){
              
            //Delete memebers page
            echo'<h1 class="text-center">Delete member</h1>';
            echo'<div class ="container" >';
            //Check if GET request is numeric & get the INT value of it
            
            $itemID= isset($_GET['Itemid'])&& is_numeric($_GET['Itemid'])?intval($_GET['Itemid']):0;
            
            //select All Data Depend on this ID
            // $stmt = $con->prepare("SELECT * FROM users WHERE userid = ?");
            
            //excute query
            
             //$stmt->execute(array($userid));
            
            //fecth the data
            
            // $row = $stmt->fetch();
            $ckeck =  CheckItem('item_id', 'items', $itemID );
            //the row count
            
            //$count = $stmt->rowCount();
            
            //if there is id in the form
             if($ckeck > 0){ 
                  $stmt = $con->prepare("DELETE  FROM items WHERE item_id = :zid");
                  $stmt -> bindParam(':zid',$itemID);
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
            echo'<h1 class="text-center">Approve Item</h1>';
            echo'<div class ="container" >';
            //Check if GET request is numeric & get the INT value of it
            
            $itemID= isset($_GET['Itemid'])&& is_numeric($_GET['Itemid'])?intval($_GET['Itemid']):0;
            
            //select All Data Depend on this ID
            
            $ckeck =  CheckItem('item_id', 'items',$itemID );
            //the row count
            
            
            //if there is id in the form
             if($ckeck > 0){ 
                  $stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE item_id = ? ");
                  $stmt -> execute(array($itemID));
                 
                  $TheMsg = '<div class="alert alert-success">'. $stmt->rowCount().'record Approved</div>';
                  redirectHome($TheMsg,'back',3);
            }else{
                 $TheMsg = '<div class ="alert alert-danger">This Id isnot exist</div>';
                 redirectHome($TheMsg);
             }
            echo'</div>';
           
       }elseif($Reqaction == 'show_com' ){
                       
                        $itemID= isset($_GET['Itemid'])&& is_numeric($_GET['Itemid'])?intval($_GET['Itemid']):0;


             $stmt = $con->prepare("SELECT 
                                        comments.*, users.username AS member
                                   FROM 
                                        comments
                                  
                                   INNER JOIN
                                        users
                                    ON
                                        users.userID = comments.user_id
                                        
                                    WHERE item_id = ?
                                         ");
            
            //Excute the Statement
            $stmt->execute(array($itemID));
            
            //Assign vars
            $rows = $stmt->fetchAll();
           if(!empty($rows)){
            ?>

            <h1 class="text-center">Manage | <?php echo $item['item_Name']; ?> | comments</h1>
            <div class="container">
                <div class="table-responsive">
                <table class='main-table text-center table table-bordered'>
                    <tr>
                        <td>comment</td>
                        <td>Adding date</td>
                        <td>User Name</td>
                        <td>Control</td>
                    </tr>
                    <?php
                        foreach($rows as $row){
                            
                            echo'<tr>';
                            echo'<td>'.$row['comment'].'</td>';
                            echo'<td>'.$row['comment_date'].'</td>';
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
           }else{
               echo "<div class='container'>
               <div class ='alert alert-info'>there is no records to show</div>
               <div>";
           }
                        ?>
                    
                </table>
            </div>
        </div>
                    
    <?php
       }
        include $tpl .'footer.php';
        
    } else {
    
         header('location: index.php');
        
         exit();
    }
ob_end_flush();
?>