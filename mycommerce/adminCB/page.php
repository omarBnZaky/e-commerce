<?php
/*
  Categories => [ manage | Edit | Update | Add | Insert | Delete | Stats]
*/

$Reqaction = isset($_GET['do'])?$_GET['do']:'Manage';
                

//if the page is the main page
                
if ($Reqaction == 'Manage') {
    
    echo 'welcome in  Manage category page'.'</br>';
    echo '<a href ="?do=Add">Add New Category +</a>'.'</br>';
    echo '<a href ="?do=Insert">Insert New Category </a>'.'</br>';

 
} elseif ($Reqaction == 'Add') {
    
        echo 'welcome in Add page';

} elseif ($Reqaction == 'Insert') {
    
        echo 'welcome in Insert page';
 
} else {
    echo'Error There\'s No Page with this Name';
}