<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once('config/db.php');
require_once('lib/pdo_db.php');
require_once('models/customer.php');

//Instantiate Customer
$customer = new customer();

//Get Customer
$customers = $customer->getCustomers();


?>


<!DOCTYPE html>
<html>
<head>
    <title>View Customers</title>
    <meta  charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>    
    <body>
        <div class="container mt-4">
            <div class="btn-group" role="group">
                <a href="customers.php" class="btn btn-primary">Customers</a>
              <a href="transactions.php" class="btn btn-secondry">transactions</a>
            </div>
          <h2>Customers</h2>    
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>CustomerID</th>
                        <th>Name</th>
                       <th>Email</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                  <?php foreach($customers as $C): ?>
                        <tr>
                            <td><?php echo $C->id; ?></td>
                            <td><?php echo $C->first_name;
                                echo $C->Last_name;?></td>
                            <td><?php echo $C->email; ?></td>
                            <td><?php echo $C->Created_at; ?></td>
                        </tr>
                      
                   <?php endforeach; ?>
                </tbody>
            </table>
            <br>
            <p><a href="index.php">Pay Page</a></p>
        </div>
  
 </body>
</html>