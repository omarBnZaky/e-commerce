<?php
ob_start();
session_start();
$pageTitle ="login";

if(isset($_SESSION['user'])){
    header('location:index.php');
}
        include'init.php';

      if($_SERVER['REQUEST_METHOD'] == 'POST'){
          if(isset($_POST['login'])){
        $user = $_POST['username'];
        $pass = $_POST['password'];
        $HashedPass = sha1($pass);
   //check if user exist in database
        $stmt = $con->prepare("SELECT 
                                    userID, username, password 
                                FROM 
                                    users                                          
                                WHERE 
                                    username = ? 
                                AND 
                                    password = ?  ");
        $stmt->execute(array($user,$HashedPass));
        $get = $stmt->fetch();
        $count = $stmt->rowCount();

        //IF count > 0 this mean That DB has arecord about this username
      if($count > 0){
          
          $_SESSION['user'] = $user;//register session name
          $_SESSION['uid']  = $get['userID']; //register userID in session
          
          header('location: index.php');//redirect to HOMEpage
          exit();
      }
        }else{
              $FormErrors = array();
              
              $username   = $_POST['username'];
              $password   = $_POST['password'];
              $password2  = $_POST['password2'];
              $Email      = $_POST['email'];
              
              if(isset($username)){
                  $filteredUser = filter_var($username,FILTER_SANITIZE_STRING);
                  if(strlen($filteredUser) < 3){
                      $FormErrors[] = "username must be larger than 3 characters";
                  }
              }
              
                 if(isset($password) && isset($password2)){
                     if(empty($password)){
                         
                         $FormErrors[] ="password can't be Empty";
                     }
                      
                     if(sha1($password) !== sha1($password2)){
                         $FormErrors[] ="sorry password isn't Match";
                     }
              }
              
                 if(isset($Email)){
                 $filteredEmail = filter_var($Email,FILTER_SANITIZE_EMAIL);
                     
                  if(filter_var($filteredEmail,FILTER_VALIDATE_EMAIL) != true ){
                      
                      $FormErrors[] = "you Must Enter A valid Email";
                  }
              }
              
              //if empty form error proceed the user add
              if(empty($FormErrors)){
                  //check if ser exist in db
                                $check = CheckItem('username','users', $username);

                                    if($check == 1){
                                        $FormErrors[] = 'sorry  this user is exsist';
                                       
                                    }else{
                                        
                                    //insert the userinfo in db
                                    $stmt = $con->prepare("INSERT INTO 
                                                                    users(username, password, Email, RegStatues, Date)
                                                                   VALUES(:zuser, :zpass, :zmail, 0, now() )");
                                     $stmt->execute(array(
                                         'zuser'  => $username,
                                         'zpass'  => sha1($password2),
                                         'zmail'  => $Email
                                       
                                     ));
                                       //echo succes messege
                                       $TheSuccess = "Congrats ou are Now registerd user";

                                       
                                    }
                            }
                     }
                   } 
?>
<div class="container  login-page">
    <h1 class="text-center">
        <span data-class="login">Login</span> | <span data-class="signUp">signUp</span>
    </h1>
     <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <input  
               class="form-control"
               type="text" 
               name="username" 
               autocomplete="off"
                placeholder="Type Your username"
               />
         
        <input  class="form-control" 
               type="password"
               name="password" 
               autocomplete="new-password"
                placeholder="Type Your password "/>
         
        <input  class="btn btn-primary btn-block"
               type="submit" 
               name="login"
               value="login"/>

    </form>
    
    
         <form class="signUp" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <input pattern=".{3,8}"
               title="Username Must be between 3 & 8 Characters"
               class="form-control"
               type="text" 
               name="username" 
               autocomplete="off"
               placeholder="Type Your username "
               required="required"/>
         
        <input  class="form-control" 
               type="password"
               name="password" 
               autocomplete="new-password"
               placeholder="Type a Complex Password"
               required="required"/>
             
         <input  class="form-control" 
               type="password"
               name="password2" 
               autocomplete="new-password"
               placeholder="Type The Password Again"
                 required="required"/>
                      
        <input  class="form-control" 
               type="email"
               name="email" 
               autocomplete="on"
               placeholder="Type a Vaild E-mail"
                required="required"/>
         
        <input  class="btn btn-success btn-block"
               type="submit" 
               name="signUp"
               value="signUp"/>

    </form>

    <div class="the_errors text-center">
        <?php 
            echo"<div class='container'style='max-width: 400px;'>";
         if(!empty($FormErrors)){
           
             foreach($FormErrors as $error){
                 echo "<div class='alert alert-danger'>".$error."</div>";
             }
              
         }
           if(isset($TheSuccess)){
            echo "<div class='alert alert-info'>".$TheSuccess."</div>";
           }
           echo"</div>";
        ?>
    </div>

</div>


<?php
 include $tpl .'footer.php'; 
ob_end_flush();
?>
