<?php




/*
** Get ALL function v.2
** Function to get All records from any table
*/


function getAllFrom($field,$TableName,$where = NULL, $and = NULL ,$orderField,$ordering="DESC"){
    
    global $con;
  
    $getAll = $con->prepare("SELECT $field FROM $TableName $where $and ORDER BY $orderField $ordering");
    $getAll ->execute();
    $All = $getAll->fetchAll();
    return $All;   
}
//-----------------------------------------------------------------------------------------------------//
//title function v.1
function getTitle(){
    
    global $pageTitle;
    
    if(isset($pageTitle)){
        
        echo $pageTitle;
        
    }else{
        echo 'Default';
    }
}
//-----------------------------------------------------------------------------------------------------//
/*
** HomeRedirect Function v.1
** this function accept parameters
** $TheMsg = echo  messege[ Error | success | warning ]
** $url = the link you want to redirect to
** $seconds = seconds before Redirecing
*/


function redirectHome($TheMsg, $url = null, $seconds = 3 ){
    if($url == null){
        
       $url  = 'index.php';
       
       $link = 'home page';
    }else{
        
        if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !=='' ){
            
           $url = $_SERVER['HTTP_REFERER']; 
            
           $link ='previous page';
            
        }else{
            
            $url  = 'index.php';
            
            $link = 'home page';
        }
        
    }
    echo  $TheMsg ;
    echo"<div class ='alert alert-info'>you will be directed to $link after $seconds seconds";
    header("refresh:$seconds;url=$url");
        exit();
}
//---------------------------------------------------------------------------------------------------------//
/*
**Check items  function v.1
** function to Check Item In Database [ Function accept parameters]
** $select = The Item To select [ Example:user, iten ,category ]
** $from  = The Table To select From [ Example:user, iten ,category ]
** $Value = the Value of Select [ Example:omar, mobile ,Electronics ]
*/


function CheckItem($select, $form, $value){
    global $con;
    $stmt2 = $con->prepare("SELECT $select FROM $form WHERE $select = ?");
    $stmt2 ->execute(array($value));
    $count = $stmt2->rowCount();
    return $count;
}

//---------------------------------------------------------------------------------------------------------//
/*
** count Number of Items Function v1.0
** function to count Number of Items Rows
** $item = The Item to count
** $table = the table to choose from
*/

function countItems($Item,$Table){
      global $con;
    
      $stmt3 = $con->prepare("SELECT COUNT($Item) FROM $Table");
    
      $stmt3 ->execute();
    
      return $stmt3->fetchColumn();
    
}
//---------------------------------------------------------------------------------------------------------//

/*
**
**
**
*/

function getLatest($select, $table, $order, $limit = 5){
    global $con;
    $getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
    $getStmt->execute();
    $rows = $getStmt->fetchAll();
    return $rows;
    
     
}