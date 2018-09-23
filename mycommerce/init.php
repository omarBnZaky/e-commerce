<?php
ini_set('display_errors','On');
error_reporting(E_ALL);

include 'adminCB/connect.php';

$sessionUser = '';

if(isset($_SESSION['user'])){
    
    $sessionUser = $_SESSION['user'];
}
//Routes to directories

$lngs   = 'includes/languages/';   //Languages Directory
$tpl    = 'includes/templetes/';   //Templetes Directory
$func   = 'includes/functions/';   //Functions Directry
$libs   = 'includes/libs/';        //Libraries Directory
$models = 'includes/models/';    //Models Directory
$config = 'includes/config/';    //config Directory
$vendor = 'includes/vendor/';    //Vendor Directory
$css    = 'layout/css/';           //CSS Directory
$js     = 'layout/js/';            //JS Directory


//include important files
  include $vendor.'autoload.php';
  include $config .'db.php';
  include $libs.'pdo_db.php';
  include $models.'customer.php';
  include $models.'transaction.php';
  include $func . 'functions.php';
  include $lngs . 'english.php';
  include $tpl  . 'header.php';


