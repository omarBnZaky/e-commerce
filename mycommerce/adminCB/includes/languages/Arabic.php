<?php

function lang($phrase){
    
    static $lang = array(
        
        'MESSAGE' => 'اهلا',
         'ADMIN'  => 'ايها المدير'
    
    
    );
    return $lang[$phrase];
}

