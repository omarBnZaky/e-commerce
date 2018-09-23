<?php

class customer{
    private $db;
    
    public function __construct(){
         $this->db = new Database;
    }
    
    public function addCustomer($data){
        //prepare query
        $this->db->query('INSERT INTO customers(id, first_name, Last_name, Email, Created_at)
                          VALUES(:id, :first_name, :Last_name, :email,  NOW() )');
     $this->db->bind(':id',$data['id']);
     $this->db->bind(':first_name',$data['first_name']);
     $this->db->bind(':Last_name',$data['Last_name']);
     $this->db->bind(':email',$data['email']);
        
    //Execute
    if($this->db->execute()){
        return true;
       }else{
        return false;
    }
  }
    public function getCustomers(){
        $this->db->query('SELECT * FROM customers ORDER BY Created_at DESC');
        
        $result = $this->db->resultset();
        return $result;
    }
}

?>