<?php
ob_start();
 session_start();

$pageTitle = 'Payment page';

 include'init.php';

             $itemID= isset($_GET['Itemid'])&& is_numeric($_GET['Itemid'])?intval($_GET['Itemid']):0;

  $stmt = $con->prepare("SELECT * FROM  items  WHERE item_id = ?");
  $stmt->execute(array($itemID));
  $count = $stmt -> rowCount();
            
            if($count >0 ){
            //fecth the data
             $item = $stmt->fetch();
                
 

\Stripe\Stripe::setApiKey('sk_test_43FBvaCuBKkL7t3cKFhpOSkq');

//sanitizinh
$first_Name  = filter_var($_POST['first_name'],FILTER_SANITIZE_STRING);
$Last_Name   = filter_var($_POST['Last_name'],FILTER_SANITIZE_STRING);
$email       = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
$token       = filter_var($_POST['stripeToken'],FILTER_SANITIZE_STRING);


//create customer in stripe
$customer = \Stripe\Customer::create(array(
  "email" => $email,
  "source" => $token
));

//charge customer

$charge = \Stripe\Charge::create(array(
    "amount" => $item['price'],
  "currency" => "usd",
  "description" => $item['item_Name'],
  "customer" => $customer->id
));
//customer data
$customerData = [
    'id'          => $charge->customer,
    'first_name' => $first_Name,
    'Last_name' => $Last_Name,
    'email'       => $email
];

//instantiate customer
$customer = new customer();

//add customer to db
$customer->addCustomer($customerData);

//customer data
$TransactionData = [
    'id'          => $charge->id,
    'customer_id' => $charge->customer,
    'product'     => $charge->description,
    'amount'      => $charge->amount,
    'currency'    => $charge->currency,
    'status'      => $charge->status
];

//instantiate customer
$Transaction = new Transaction();

//add customer to db
$Transaction->addTransaction($TransactionData);

//redirect to success
header('location:success.php?tid='.$charge->id.'&product='.$charge->description);




}
include $tpl .'footer.php'; 
ob_end_flush();
?>