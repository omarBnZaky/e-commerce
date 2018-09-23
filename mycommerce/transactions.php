<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once('config/db.php');
require_once('lib/pdo_db.php');
require_once('models/transaction.php');

//Instantiate Customer
$Transaction = new Transaction();

//Get Customer
$Transaction= $Transaction->getTransactions();


?>


<!DOCTYPE html>
<html>
<head>
    <title>View Transactions</title>
    <meta  charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>    
    <body>
        <div class="container mt-4">
            <div class="btn-group" role="group">
                <a href="customers.php" class="btn btn-secondry">Customers</a> 
              <a href="transactions.php" class="btn btn-primary">transactions</a>
            </div>
          <h2>transactions</h2>    
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>transactions ID</th>
                        <th>Customer</th>
                        <th>product</th>
                         <th>amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                  <?php foreach($Transaction as $T): ?>
                        <tr>
                            <td><?php echo $T->id; ?></td>
                            <td><?php echo $T->customer_id;?></td>
                            <td><?php echo $T->product; ?></td>
                            <td><?php echo sprintf('%.2f',$T->amount / 100); 
                                echo strtoupper($T->currency);
                                ?>
                            </td>
                            <td><?php echo $T->Created_at; ?></td>
                        </tr>
                      
                   <?php endforeach; ?>
                </tbody>
            </table>
            <br>
            <p><a href="index.php">Pay Page</a></p>
        </div>
  
 </body>
</html>