<?php 
error_reporting(E_ALL);
ini_set("display_errors", 1);
if(!empty($_GET['tid'] && !empty($_GET['product']))){
    
        $tid = filter_var($_GET['tid'],FILTER_SANITIZE_STRING);
       $product = filter_var($_GET['product'],FILTER_SANITIZE_STRING);

}else{
    header('location:index.php');
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Thanks</title>
    <meta  charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>    
    <body>
        <div class="container mt-4">
          <h2>Thank you for purchasing <?php echo $product ;?></h2>
            <hr>
            <p>Your Transaction id is <?php echo $tid; ?></p>
            <p><a href="index.php" class="btn btn-light mt-2">Go Back</a></p>
        </div>
  
 </body>
</html>