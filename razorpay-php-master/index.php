<?php
// Include Razorpay PHP SDK
require_once('razorpay.php');

use Razorpay\Api\Api;

if(isset($_POST['sub'])){
    // Razorpay API key and secret
$keyId = 'rzp_test_igWcu0vvCwZk1f';
$keySecret = 'GvXBzPZLevOVxMX4H80wGp3w';

// Create a new instance of the API class
$api = new Api($keyId, $keySecret);

// Amount to be charged in paisa
$amount = $_POST['amount'] * 100; // Rs. 100 will convert paisa into rupees

// Payment currency
$currency = 'INR';

// Payment receipt ID
$receiptId = 'RECEIPT_ID';

// Payment options
$options = array(
    'amount' => $amount,
    'currency' => $currency,
    'receipt' => $receiptId,
);

// Create a new Razorpay order
$order = $api->order->create($options);

// Get the order ID and other details
$orderId = $order['id'];
$orderAmount = $order['amount'];
$orderCurrency = $order['currency'];

// Razorpay checkout options
$checkoutOptions = array(
    'key' => $keyId,
    'amount' => $orderAmount,
    'name' => 'Om Chutiya He',
    'description' => 'YOUR_PRODUCT_DESCRIPTION',
    'image' => 'YOUR_LOGO_URL',
    'order_id' => $orderId,
    'prefill' => array(
        'name' => 'CUSTOMER_NAME',
        'email' => 'CUSTOMER_EMAIL',
        'contact' => 'CUSTOMER_PHONE',
    ),
    'notes' => array(
        'address' => 'CUSTOMER_ADDRESS',
    ),
    'theme' => array(
        'color' => 'green'
    )
);

// Encode Razorpay checkout options as JSON string
$checkoutOptionsJson = json_encode($checkoutOptions);

// Razorpay checkout script
$checkoutScript = "<script src='https://checkout.razorpay.com/v1/checkout.js'></script>";
$checkoutScript .= "<script>var options = $checkoutOptionsJson; var rzp = new Razorpay(options); rzp.on('payment.failed', function (response) { alert(response.error.code + ' - ' + response.error.description); }); rzp.open(); </script>";

// Output Razorpay checkout button and script
echo $checkoutScript;

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="<?php $_SERVER['PHP_SELF']?>" method="POST">
    Amount:
    <input type="number" name="amount" required/>
    <input type="submit" name="sub" />
</form>
</body>
</html>