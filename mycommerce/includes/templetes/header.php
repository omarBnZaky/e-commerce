<!DOCTYPE html>
<html>
  <head>
      <meta charset="utf-8"/>
      <title><?php getTitle() ?></title>
      <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css"/>
      <link rel="stylesheet" href="<?php echo $css; ?>font-awesome.min.css"/>
      <link rel="stylesheet" href="<?php echo $css; ?>frontEnd.css"/>
 </head>
<body>
    <div class="upper-bar">
        <div class="container">
            <?php
            if(isset($_SESSION['user'])){ ?>
                <!-- Split button -->

<div class="dropdown">
                <img src="img.png"  width="42px" height="42px" class="rounded-circle" alt="Cinque Terre">

  <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <?php echo $sessionUser; ?>
  </a>

  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
    <a class="dropdown-item" href="profile.php">pofile</a>
    <a class="dropdown-item" href="newAd.php">New ad</a>
    <a class="dropdown-item" href="logout.php">Logout</a>
    <a class="dropdown-item" href="profile.php#my-ads">My Ads</a>
  </div>
</div>
             <a class="dropdown-item" href="profile.php">pofile</a>
    <a class="dropdown-item" href="newAd.php">New ad</a>
    <a class="dropdown-item" href="logout.php">Logout</a>
    <a class="dropdown-item" href="profile.php#my-ads">My Ads</a>
<!--<a href="profile.php"> pofile</a>
   <a href="logout.php"> logout</a>             
<a href="newAd.php"> New ad</a>        
 <a href="profile.php#my-ads">My Ads</a> -->      
                <?php $userStatus = CheckUserStats($_SESSION['user']);
                if($userStatus == 1){
                    echo"you need to be activated by admin";
                }
            }else{
                
            ?>
         <a href="login.php">
             <span class="text-center">Login/Signup</span>
            </a>
            <?php  } ?>
        </div>
    </div>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="index.php"><?php echo lang('HOME_USER') ?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

        
<div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav right">
        <?php
      $myCats = getAllFrom("*","categories","WHERE parent = 0","","ID","ASC");
       foreach($myCats as $Cat){
      echo '<li class="nav-item "><a class="nav-link" href="categories.php?pageid='.$Cat['ID'].'&pagename='.str_replace(' ','-',$Cat['Name']).'">'
          .$Cat['Name'].
          '</a>
          </li>';
       } ?>
    </ul>
  </div>
</nav>
