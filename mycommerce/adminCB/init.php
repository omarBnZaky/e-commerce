<?php
include 'connect.php';

//Routes to directories

$lngs = 'includes/languages/';  //Languages Directory
$tpl  = 'includes/templetes/';  //Templetes Directory
$func = 'includes/functions/';  //Functions Directry
$css  = 'layout/css/';          //CSS Directory
$js   = 'layout/js/';           //JS Directory


//include important files
  include $func . 'functions.php';
  include $lngs . 'english.php';
  include $tpl  . 'header.php';
//include nav in all pages expect the ones $NoNavbar

if(!isset($NoNavbar)){ include $tpl  . 'navbar.php'; }
