<?php
ob_start();
 session_start();

$pageTitle = 'Create a New Advertise';

 include'init.php';

if(isset($_SESSION['user'])){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $FormErrors = array();
        
        $ImageName = $_FILES['image']['name'];
        $ImageSize = $_FILES['image']['size'];
        $ImageTmpname = $_FILES['image']['tmp_name'];
        $ImageType = $_FILES['image']['type'];
                    //list of allowed extension
       $ImageAllowedExtension= array("jpeg","jpg","png","gif");
                    //get avatar extension
        $ImageExtension = strtolower(end(explode('.',$ImageName)));
        
        $Tilte    = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
        $Desc     = filter_var($_POST['Description'],FILTER_SANITIZE_STRING);
        $price    = filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
        $country  = filter_var($_POST['Country'],FILTER_SANITIZE_STRING);
        $status   = filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
        $category = filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);
        $Tags     = filter_var($_POST['Tags'],FILTER_SANITIZE_STRING);
        if(strlen($Tilte) < 3){
                      $FormErrors[] = "Item Title must must be at least 3 characters";
                  }
          if(strlen($Desc) < 10){
                      $FormErrors[] = "Item Description must must be at least 10 characters";
                  }
          if(strlen($country) < 2){
                      $FormErrors[] = "Item Country made must must be at least 2 characters";
                  }
          if(empty($price)){
                      $FormErrors[] = "Item Price Cann't be empty";
          }
        if($price < 50){
            $FormErrors[] = "Item Price Cann't be Less Than 50";
        }
          if(empty($status)){
                      $FormErrors[] = "Item status Cann't be empty";
          }
          if(empty($category)){
                      $FormErrors[] = "Item category Cann't be empty";
          }
        
         if (!empty($ImageName) && ! in_array($ImageExtension, $ImageAllowedExtension)) {
                                $FormErrors[]='Sorry this type isnot <strong>allowed</strong>';
                            }
                            
                            if(empty($ImageName)){
                                $FormErrors[]='image is <strong>required</strong>';
                            }
                            if($ImageSize > 4194304){
                                    $FormErrors[]='image cannot be largr than <strong>4MB</strong>';
                        }
                        if(empty($FormErrors)){
                                    $Image = rand(0,100000)."_".$ImageName;
                                       move_uploaded_file($ImageTmpname,"uploads\images\\".$Image);
                                    //insert the ITEM in db
                                    $stmt = $con->prepare('INSERT INTO 
                                                                    items(item_Name, item_Description, price, Country_Made,image,statues, Add_Date, Cat_ID, Member_ID, Tags)
                                                                   VALUES(:zitem_Name, :zitem_Description, :zprice, :zCountry_Made, :zimage, :zstatues, now(), :zCat, :zmember, :zTags )');
                                     $stmt->execute(array(
                                         'zitem_Name'         => $Tilte,
                                         'zitem_Description'  => $Desc,
                                         'zprice'             => $price, 
                                         'zCountry_Made'      => $country,
                                         'zimage'             => $Image,
                                         'zstatues'           => $status,
                                         'zCat'               => $category,
                                         'zmember'            => $_SESSION['uid'],
                                         'zTags'              => $Tags
                                     )); 
                                       //IF  $stmt had done echo succes messege
                                        if($stmt){
                                            echo " item added";
                                        }
                                    }
    }
   ?>       
<h1 class="text-center">Create a New Ad</h1>
<div class="container">
<div class="create-ad block">
    <div class="card">
      <div class="card-header">
          <h5>Create a New Ad</h5>
      </div>
      <div class="card-body">
      <div class="row">
          <div class="col-md-8">
                <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                               <!--start nane field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label">Item Name</label>
                             <div class="col-sm-10 "> 
                                <input pattern=".{3,}"
                                       title="This Field require At Least 3 Characters"
                                       type="text" 
                                       name="name" 
                                       class="form-control live-name" 
                                       placeholder="name of the Item"
                                       required
                                       />
                            </div>
                        </div>
                        <!--end name field-->
                        
                                   <!--start Description field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label">Description</label>
                             <div class="col-sm-10"> 
                                <input type="text" 
                                       pattern=".{10,}"
                                       title="Item Description must must be at least 10 characters"
                                       name="Description" 
                                       class="form-control live-desc" 
                                       placeholder="Description of the Item"
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
                                       class="form-control live-price" 
                                       placeholder="price of the Item"
                                       required
                                       />
                            </div>
                        </div>
                        <!--end price field-->
                                    <!--start Country field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label">Country of made</label>
                             <div class="col-sm-10"> 
                                <input type="text" 
                                       pattern=".{2,}"
                                       title="Item Country made must must be at least 2 characters"
                                       name="Country" 
                                       class="form-control live-country" 
                                       placeholder="Country"
                                       required
                                       />
                            </div>
                        </div>
                        <!--end Country field-->
                        
                                         <!--start status field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label"> status</label>
                             <div class="col-sm-10"> 
                                <select class="form-control"name="status" required>
                                    <option value="">....</option>
                                    <option value="1">New</option>
                                    <option value="2">like New</option>
                                    <option value="3">Well Enjoyed</option>
                                    <option value="4">Old</option>
                                 </select>
                            </div>
                        </div>
                        <!--end price field-->
                        

                                                    <!--start categories field-->
                        <div class="form-group">
                         <label class="col-sm-2 control-label"> categories</label>
                             <div class="col-sm-10"> 
                                <select class="form-control"name="category" required>
                                    <option value="">...</option>
                                    <?php
                                    $cats = getAllFrom("*","categories","","","ID");
                                    foreach($cats as $cat){
                                        echo'<option value="'.$cat['ID'].'">'.$cat['Name'].'</option>';
                                    }
                                    
                                    ?>
                                 
                                 </select>
                            </div>
                        </div>
                    <!--start image field-->
                     <div class="form-group">
                         <label class="col-sm-2 control-label">User image</label>
                             <div class="col-sm-10"> 
                                <input type="file" 
                                       name="image" 
                                       class="form-control" 
                                       required="required"/>
                            </div>
                        </div>
                        <!--end image field-->
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
                        <!--end categories field-->
                              <!--start Submit field-->
                    
                    <div class="form-group">
                         <div class="co-sm-offset-2 col-sm-10"> 
                            <input type="submit" value="Add Item" class="btn btn-primary"/>
                        </div>
                    </div>
                    <!--end Submit field-->
                </form>
         </div>
          <div class="col-md-4">
              <div class="thumbnail item-box live-preview">
                   <img class="card-img-top" src="img.png" alt="Card image cap">
                <h3 class="card-title">title </h3>
                <p class="card-text">Description</p>
                  <span class="price-tag">price</span>
                </div>
         </div>
          
        <!--start looping throgh errors-->
          <?php
            if(! empty($FormErrors)){
                foreach($FormErrors as $Error){
                    echo"<div class='alert alert-danger'>".$Error."</div>";
                }
            }
          ?>
      <!--end looping throgh errors-->

     </div>
          
          
      </div>
    </div>
</div>
</div>
 

<?php
    }else{
    header('location:login.php');
    exit();
}
include $tpl .'footer.php'; 


ob_end_flush();
?>