<?php
/*
====================================
============category page===========
====================================
*/
ob_start();//output buffering start
session_start();
    
$pageTitle = 'categories';
if(isset($_SESSION['username'])){
            
        include'init.php';
        
        $Reqaction = isset($_GET['do'])?$_GET['do']:'Manage';
        
        
       if ($Reqaction == 'Manage') { 
           $sort_array = array('ASC','DESC');
           if(isset($_GET['sort']) && in_array($_GET['sort'],$sort_array)){
              $sort =  $_GET['sort'];
           }
           
           $stmt4 = $con->prepare("SELECT * FROM  categories WHERE parent = 0 ORDER BY Ordering $sort");
           $stmt4 -> execute();
           $cats = $stmt4->fetchAll();?>
         <form action="categories.php?do=SearchCat" method="post">
                <input class="form-control" type="text" name="Name" placeholder="search For a Category name"/>
                  <input class="form-control" type="text" name="ID" placeholder="search For  a Category id"/>
                <input type="submit" style="color:white;background-color:#00b;"Value="Search" class="form-control"/>
        </form>
           <h1 class="text-center">Manage Categories </h1>
           <div class="container">
              <div class="card">
                   <div class="card-header">Manage Categories
                  <div class="ordering pull-right">
                      Ordering :
                  <a class="<?php if ($sort == 'ASC'){ echo'active'; }?>"href="categories.php?sort=ASC">ASC</a> |
                  <a class="<?php if ($sort == 'DESC'){ echo'active'; }?>"href="categories.php?sort=DESC">DESC</a>
                     </div>
                       </div>
                
                   <div class="card-body categories">
                   <?php
                        foreach($cats as $cat){
                        echo "<div class='cat'>";
                            echo"<div class='hidden-buttons'>";
                              echo"<a href = 'categories.php?do=Edit&catid=".$cat['ID']."' class='btn-sm btn-primary'><i class='fa fa-edit'></i>edit</a>";
                              echo"<a href = 'categories.php?do=Delete&catid=".$cat['ID']."' class='confirm btn-sm btn-danger'><i class='fa fa-close'></i>delete</a>";
                            echo"</div>";
                            echo "<h2>".$cat['Name']."</h2>";
                            echo"<div class='full-view'>";
                            echo "<p>";if(empty ($cat['Description'])){echo"this category has no discreption";}else{ echo $cat['Description']; }echo"</p>";
                            if($cat['Visibility'] == 1){ echo"<span class='badge badge-danger'><i class='fa fa-eye'></i>Hidden</span>"; }
                            if($cat['Allow_Comment'] == 1){ echo"<span class='badge badge-secondary'><i class='fa fa-close'></i>Comment Disabled</span>"; }
                            if($cat['Allow_Ads'] == 1){ echo"<span class='badge badge-danger'><i class='fa fa-close'></i>Ads disabeled</span>"; }
                        echo "</div>";
                    echo "</div>";
                
                    //Get Child Categories        
                    
             $ChildCats = getAllFrom("*","categories","WHERE parent = {$cat['ID']}","","ID","ASC");
                if(!empty($ChildCats)){
                echo"<h4 class='Child-head'>Child Categories</h4>";
                echo"<ul class ='list-unstyled Child-cats'>";
               foreach($ChildCats as $C){
                   echo "<li>
                   <a href = 'categories.php?do=Edit&catid=".$C['ID']."'>".$C['Name']."</a> 
                   <a href = 'categories.php?do=Delete&catid=".$C['ID']."' class='confirm btn-sm btn-danger'><i class='fa fa-close'></i>delete</a>
                   </li>";
               } 
             echo"</ul>";
           }                 
            echo"<hr>";
         }
     ?>
                  </div>
               </div>
               <a href="categories.php?do=Add" class="btn btn-primary" style="margin-bottom:30px;margin-top:30px;"><i class="fa fa-plus"></i>Add a New Category</a>
               
            </div>
           
    <?php  }elseif($Reqaction =='SearchCat'){
              if($_SERVER['REQUEST_METHOD']=='POST'){
                    $id = $_POST["ID"];
                    $name = $_POST["Name"];
                    $sql = "SELECT * FROM categories WHERE Name LIKE :Name OR ID LIKE :ID";
                    $stmt = $con->prepare($sql);
                    $stmt ->execute(['Name'=>$name,
                                    'ID'=>$id]);
                    if(!$stmt->rowCount() == 0){
                        while($row = $stmt->fetch()){
                            echo'<div class="container">
                                    <div class="card">';
                            echo'<div class="card-body categories">';
                                echo "<div class='cat'>";
                            echo"<div class='hidden-buttons'>";
                              echo"<a href = 'categories.php?do=Edit&catid=".$row['ID']."' class='btn-sm btn-primary'><i class='fa fa-edit'></i>edit</a>";
                              echo"<a href = 'categories.php?do=Delete&catid=".$row['ID']."' class='confirm btn-sm btn-danger'><i class='fa fa-close'></i>delete</a>";
                            echo"</div>";
                            echo "<h2>".$row['Name']."</h2>";
                            echo"<div class='full-view'>";
                            echo "<p>";if(empty ($row['Description'])){echo"this category has no discreption";}else{ echo $row['Description']; }echo"</p>";
                            if($row['Visibility'] == 1){ echo"<span class='badge badge-danger'><i class='fa fa-eye'></i>Hidden</span>"; }
                            if($row['Allow_Comment'] == 1){ echo"<span class='badge badge-secondary'><i class='fa fa-close'></i>Comment Disabled</span>"; }
                            if($row['Allow_Ads'] == 1){ echo"<span class='badge badge-danger'><i class='fa fa-close'></i>Ads disabeled</span>"; }
                        echo "</div>";
                    echo "</div>";
                       echo "</div>";
                
                    //Get Child Categories        
                    
             $ChildCats = getAllFrom("*","categories","WHERE parent = {$row['ID']}","","ID","ASC");
                if(!empty($ChildCats)){
                echo"<h4 class='Child-head'>Child Categories</h4>";
                echo"<ul class ='list-unstyled Child-cats'>";
               foreach($ChildCats as $C){
                   echo "<li>
                   -<a href = 'categories.php?do=Edit&catid=".$C['ID']."'>".$C['Name']."</a> 
                   <a href = 'categories.php?do=Delete&catid=".$C['ID']."' class='confirm btn-sm btn-danger'><i class='fa fa-close'></i>delete</a>
                   </li>";
               } 
             echo"</ul>";
           }                 
            echo"<hr>";
                            
           echo "</div>";
                       echo "</div>";             }
                    }
              }
         }elseif($Reqaction == 'Add'){ ?>
          <h1 class="text-center">Add New category</h1>
                <div class="container">
                    <form class="form-horizontal" action="?do=Insert" method="POST">
                               <!--start nane field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label">name</label>
                             <div class="col-sm-10"> 
                                <input type="text" 
                                       name="name" 
                                       class="form-control" 
                                       autocomplete='off'
                                       placeholder="name of the category"
                                       required="required"/>
                            </div>
                        </div>
                        <!--end name field-->

                      <!--start Description field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label">Description</label>
                             <div class="col-sm-10"> 
                                <input type="text" 
                                       name="description" 
                                       class=" form-control" 
                                       placeholder="describe the category"
                                      />
                                 
                            </div>
                        </div>
                        <!--end Description field-->

                          <!--start ordering field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label">ordering</label>
                             <div class="col-sm-10"> 
                                <input type="number"
                                       name="ordering" 
                                       class="form-control" 
                                       placeholder="Number to arrange categories"
                                      />
                            </div>
                        </div>
                        <!--end ordering field-->
                        
                        <!--start category type -->
                         <div class="form-group">
                         <label class="col-sm-2 control-label">Parent?</label>
                             <div class="col-sm-10"> 
                                <select name="parent">
                                 <option value="0">None</option>
                                     <?php
                                           $allCats = getAllFrom("*","categories","WHERE parent = 0","","ID","DESC");
                                           foreach($allCats as $cat){
                                             echo "<option value='".$cat['ID']."'>".$cat['Name']."</option>";
                                           }



                                        ?>
                                 </select>
                            </div>
                        </div>
                        <!--end category type -->
                        
                          <!--start Visibilty field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label">Visibile</label>
                             <div class="col-sm-10"> 
                                <input id="vis-yes"
                                       type="radio" 
                                       name="Visibilty" 
                                       value="0"
                                       checked/>
                                <label for="vis-yes">Yes</label>       
                            </div>
                             <div class="col-sm-10"> 
                                    <input id="vis-no"
                                           type="radio" 
                                           name="Visibilty" 
                                           value="1"
                                          />
                                    <label for="vis-no">no</label>       
                                </div>
                        </div>
                        <!--end Visibilty field-->
                        
                             <!--start commenting field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label">Allow commenting</label>
                             <div class="col-sm-10"> 
                                <input id="com-yes"
                                       type="radio" 
                                       name="commenting" 
                                       value="0"
                                       checked/>
                                <label for="com-yes">Yes</label>       
                            </div>
                             <div class="col-sm-10"> 
                                    <input id="com-no"
                                           type="radio" 
                                           name="commenting" 
                                           value="1"
                                          />
                                    <label for="com-no">no</label>       
                                </div>
                        </div>
                        <!--end commenting field-->

                        <!--start ADS field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label">Allow ADs</label>
                             <div class="col-sm-10"> 
                                <input id="Ads-yes"
                                       type="radio" 
                                       name="Ads" 
                                       value="0"
                                       checked/>
                                <label for="Ads-yes">Yes</label>       
                            </div>
                             <div class="col-sm-10"> 
                                    <input id="Ads-no"
                                           type="radio" 
                                           name="Ads" 
                                           value="1"
                                          />
                                    <label for="Ads-no">no</label>       
                                </div>
                        </div>
                        <!--end ADS field-->
                          <!--start Submit field-->
                        <div class="form-group">
                             <div class="co-sm-offset-2 col-sm-10"> 
                                <input type="submit" value="Add category" class="btn btn-primary"/>
                            </div>
                        </div>
                        <!--end Submit field-->
                    </form>
                  
                </div>
          
       <?php }elseif($Reqaction == 'Insert'){
                  echo"<h1 class='text-center'>Insert member</h1>";
                echo'<div class ="container" >';
                if($_SERVER['REQUEST_METHOD']=='POST'){

                            //Get vars from the form

                            $name      = $_POST['name'];
                            $desc      = $_POST['description'];
                            $Parent    = $_POST['parent'];
                            $order     = $_POST['ordering'];
                            $visible   = $_POST['Visibilty'];
                            $comment   = $_POST['commenting'];
                            $ads       = $_POST['Ads'];
     
                                    //CHECK function
                                    $check =CheckItem('Name','categories', $name);

                                    if($check == 1){
                                        $TheMsg ='<div class ="alert alert-danger">sorry this User Is Exist</div>';
                                        redirectHome($TheMsg,'back');
                                    }else{
                                    //insert the userinfo in db
                                    $stmt = $con->prepare("INSERT INTO 
                                       categories(Name, Description, parent, Ordering, Visibility,Allow_Comment, Allow_Ads)
                                       VALUES(:zname, :zdesc, :zparent, :zorder, :zvisible, :zcomment, :zads )");
                                     $stmt->execute(array(
                                         'zname'    => $name,
                                         'zdesc'    => $desc,
                                         'zparent'  => $Parent,
                                         'zorder'   => $order, 
                                         'zvisible' => $visible,
                                         'zcomment' => $comment,
                                         'zads'     => $ads
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
            $catid= isset($_GET['catid'])&& is_numeric($_GET['catid'])?intval($_GET['catid']):0;
            
            //select All Data Depend on this ID
             $stmt = $con->prepare("SELECT * FROM categories WHERE ID = ?");
            
            //excute query
            
             $stmt->execute(array($catid));
            
            //fecth the data
            
             $cat = $stmt->fetch();
            
            //the row count
            
             $count = $stmt->rowCount();
            
            //if there is id in the form
             if($stmt->rowCount()>0){?>
                     <h1 class="text-center">Edit Category</h1>
                <div class="container">
                    <form class="form-horizontal" action="?do=update" method="POST">
                    <input type="hidden"  name="catid" value="<?php echo $catid ?>">
                               <!--start nane field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label">name</label>
                             <div class="col-sm-10"> 
                                <input type="text" 
                                       name="name" 
                                       class="form-control" 
                                       placeholder="name of the category"
                                       value="<?php echo $cat['Name']?>"
                                       required="required"/>
                            </div>
                        </div>
                        <!--end name field-->

                      <!--start Description field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label">Description</label>
                             <div class="col-sm-10"> 
                                <input type="text" 
                                       name="description" 
                                       class=" form-control" 
                                       placeholder="describe the category"
                                       value="<?php echo $cat['Description']?>"
                                      />
                                 
                            </div>
                        </div>
                        <!--end Description field-->

                          <!--start ordering field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label">ordering</label>
                             <div class="col-sm-10"> 
                                <input type="number"
                                       name="ordering" 
                                       class="form-control" 
                                       placeholder="Number to arrange categories"
                                       value="<?php echo $cat['Ordering']?>"
                                      />
                            </div>
                        </div>
                        <!--end ordering field-->
                        
                                  <!--start category type -->
                         <div class="form-group">
                         <label class="col-sm-2 control-label">Parent? <?php echo $cat['parent']; ?></label>
                             <div class="col-sm-10"> 
                                <select name="parent">
                                 <option value="0">None</option>
                                     <?php
                                           $allCats = getAllFrom("*","categories","WHERE parent = 0","","ID","DESC");
                                           foreach($allCats as $c){
                                             echo "<option value='".$c['ID']."'";
                                               if($cat['parent']== $c['ID']){echo "selected";}
                                            echo  ">". $c['Name']."</option>";
                                           }



                                        ?>
                                 </select>
                            </div>
                        </div>
                        <!--end category type -->
                          <!--start Visibilty field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label">Visibile</label>
                             <div class="col-sm-10"> 
                                <input id="vis-yes"
                                       type="radio" 
                                       name="Visibilty" 
                                       value="0"
                                       <?php if($cat['Visibilty'] == 0){
                                       echo'checked'; } ?>
                                       />
                                <label for="vis-yes">Yes</label>       
                            </div>
                             <div class="col-sm-10"> 
                                    <input id="vis-no"
                                           type="radio" 
                                           name="Visibilty" 
                                           value="1"
                                            <?php if($cat['Visibilty'] == 1){
                                       echo'checked'; } ?>
                                          />
                                    <label for="vis-no">no</label>       
                                </div>
                        </div>
                        <!--end Visibilty field-->
                        
                             <!--start commenting field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label">Allow commenting</label>
                             <div class="col-sm-10"> 
                                <input id="com-yes"
                                       type="radio" 
                                       name="commenting" 
                                       value="0"
                                               <?php if($cat['Allow_Comment'] == 0){
                                       echo'checked'; } ?>
                                       />
                                <label for="com-yes">Yes</label>       
                            </div>
                             <div class="col-sm-10"> 
                                    <input id="com-no"
                                           type="radio" 
                                           name="commenting" 
                                           value="1"
                                            <?php if($cat['Allow_Comment'] == 1){
                                       echo'checked'; } ?>
                                          />
                                    <label for="com-no">no</label>       
                                </div>
                        </div>
                        <!--end commenting field-->

                        <!--start ADS field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label">Allow ADs</label>
                             <div class="col-sm-10"> 
                                <input id="Ads-yes"
                                       type="radio" 
                                       name="Ads" 
                                       value="0"
                                            <?php if($cat['Allow_Ads'] == 0){
                                       echo'checked'; } ?>
                                       />
                                <label for="Ads-yes">Yes</label>       
                            </div>
                             <div class="col-sm-10"> 
                                    <input id="Ads-no"
                                           type="radio" 
                                           name="Ads" 
                                           value="1"
                                            <?php if($cat['Allow_Ads'] == 1){
                                       echo'checked'; } ?>
                                          />
                                    <label for="Ads-no">no</label>       
                                </div>
                        </div>
                        <!--end ADS field-->
                          <!--start Submit field-->
                        <div class="form-group">
                             <div class="co-sm-offset-2 col-sm-10"> 
                                <input type="submit" value="Save" class="btn btn-primary"/>
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
        
             
      
       }elseif($Reqaction == 'update'){ ?>
        <h1 class="text-center">Update member</h1>

              <?php 
                    echo'<div class ="container" >';
                    if($_SERVER['REQUEST_METHOD']=='POST'){
                        
                        //Get vars from the form
                      
                        $id        = $_POST['catid'];
                        $name      = $_POST['name'];
                        $Parent    = $_POST['parent'];
                        $desc      = $_POST['Description'];
                        $order     = $_POST['Ordering'];
                        $visible   = $_POST['Visibilty'];
                        $comment   = $_POST['commenting'];
                        $ads   = $_POST['Ads'];                        
                        //validate the form
                        
                                       
                   
                            //update the db with this info
                            $stmt = $con->prepare('UPDATE 
                                                        categories 
                                                    SET 
                                                        Name = ?, 
                                                        Description =?,
                                                        Ordering = ?, 
                                                        parent = ?,
                                                        Visibility = ?, 
                                                        Allow_Comment =?,
                                                        Allow_Ads =?
                                                    WHERE 
                                                        ID = ? ');
                             $stmt->execute(array($name, $desc, $order,$Parent, $visible, $comment, $ads, $id ));
                               //echo succes messege
                               $TheMsg = '<div class="alert alert-success">'. $stmt->rowCount().'record updated</div>';
                               redirectHome($TheMsg,'back');

                        
                        
                 }else{
                     $TheMsg ='<div class ="alert alert-danger">sorry you cannot enter this page directly</div>';
                        redirectHome($TheMsg,'back',3);
                }


                       echo'</div>';  ?>    
       <?php }elseif($Reqaction =='Delete'){
                  //Delete memebers page
            echo'<h1 class="text-center">Delete Category</h1>';
            echo'<div class ="container" >';
            //Check if GET request is numeric & get the INT value of it
            
            $catid= isset($_GET['catid'])&& is_numeric($_GET['catid'])?intval($_GET['catid']):0;
          
            $ckeck =  CheckItem('ID', 'categories',$catid );
         
             if($ckeck > 0){ 
                  $stmt = $con->prepare("DELETE  FROM categories WHERE ID = :zID");
                  $stmt -> bindParam(':zID',$catid);
                  $stmt -> execute();
                 
                  $TheMsg = '<div class="alert alert-success">'. $stmt->rowCount().'record Deleted</div>';
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
       
ob_end_flush();

?>