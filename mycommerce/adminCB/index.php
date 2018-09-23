<?php
    session_start();
    $NoNavbar = '';
    $pageTitle = 'login';
    if(isset($_SESSION['username'])){
        header('location: dasbord.php');
    }
    include'init.php';

    //Check if user coming from HTTP post request

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = $_POST['user'];
        $password = $_POST['pass'];
        $HashedPassword = sha1($password);
        
        //check if user exist in database
        $stmt = $con->prepare("SELECT 
                                    UserID, username, password 
                                FROM 
                                    users                                          
                                WHERE 
                                    username = ? 
                                AND 
                                    password = ? 
                                AND 
                                    GroupID = 1
                               ");
        $stmt->execute(array($username,$HashedPassword));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        //IF count > 0 this mean That DB has arecord about this username
      if($count > 0){
          
          $_SESSION['username'] = $username;//register session name
          $_SESSION['ID'] =$row['UserID'];
          header('location: dasbord.php');//redirect to page
          exit();
      }
    } 
?>
<form class="login" 
      action="<?php echo $_SERVER['PHP_SELF']?>" 
      method='POST'>
<h4 class="text-center">Admin Login</h4>
    
<input class="form-control"
       type="text"
       name="user" 
       placeholder="username" 
       autocomplete="off"/>
    
<input class="form-control"
       type="password" 
       name="pass" 
       placeholder="Password" 
       autocomplete="new-password"/>
    
<input class="btn btn-primary btn-block"
       type="submit" 
       value="login"/>
</form>
            
<?php include $tpl .'footer.php';?>