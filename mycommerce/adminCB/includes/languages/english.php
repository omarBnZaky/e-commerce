<?php

function lang($phrase){
    
    static $lang = array(
        //Homepage
       
        'HOME_ADMIN'=>'Admin ',
        'CAT_ADMIN'  =>'Categories',
        'ITEMS' => 'items',
        'MEMBERS'=>'members',
        'COMMENTS' => 'comemnts',
        'STATISTICS' => 'Statistics',
        'LOGS'=>'logs',
        'COMMENTS' => 'comments'
     
    
    
    );
    return $lang[$phrase];
}

