<?php
/*
====================================
============copy templete page===========
====================================
*/
ob_start();
session_start();
    
    $pageTitle = 'Members';
    if(isset($_SESSION['username'])){
            
        include'init.php';
        
        $Reqaction = isset($_GET['do'])?$_GET['do']:'Manage';
        
        
       if ($Reqaction == 'Manage') { 
       
       }elseif($Reqaction == 'Insert'){
           
       }elseif($Reqaction == 'Edit'){
           
       }elseif($Reqaction == 'update'){
           
       }elseif($Reqaction =='Delete'){
           
       }elseif($Reqaction =='Activate'){
           
       }       
        include $tpl .'footer.php';
        
    } else {
    
         header('location: index.php');
        
         exit();
    }
ob_end_flush();
?>