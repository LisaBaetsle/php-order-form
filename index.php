<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);

//we are going to use session variables so we need to enable sessions
session_start();

// define variables and set to empty values
$emailErr = $streetErr = $streetnumberErr = $cityErr = $zipcodeErr = $productsErr = "";
$email = $street = $streetnumber = $city = $zipcode = $products = "";

// Validate and check requirements form
if (!empty($_POST)) {
  //email
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = $_POST["email"];
  };

  // check if e-mail address is well-formed
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $emailErr = "Invalid email format";
  }

  //street
  if (empty($_POST["street"])) {
    $streetErr = "street is required";
  } else {
    $street = $_POST["street"];
  }

  //street number
  if (empty($_POST["streetnumber"])) {
    $streetnumberErr = "street number is required";
  } else {
    $streetnumber = $_POST["streetnumber"];
    // check if the streetnumber only consists out of numbers
    if (!preg_match("/^[0-9]*$/", $streetnumber)) {
      $streetnumberErr = "Only numbers are allowed";
    }
  }

  //city
  if (empty($_POST["city"])) {
    $cityErr = "city is required";
  } else {
    $city = $_POST["city"];
  }

  //zipcode
  if (empty($_POST["zipcode"])) {
    $zipcodeErr = "zipcode is required";
  } else {
    $zipcode = $_POST["zipcode"];
    // check if the zipcode only consists out of numbers
    if (!preg_match("/^[0-9]*$/", $zipcode)) {
      $zipcodeErr = "Only numbers are allowed";
    }
  }

  //products
  if (empty($_POST["products"])) {
    $productsErr = "Pick at least one product";
  } else {
    $products = $_POST["products"];
  }
};


// Check if session excist and store them in the values to autofill the form.
if (isset($_SESSION["email"])) {
  $email = $_SESSION["email"];
};
if (isset($_SESSION["street"])) {
  $street = $_SESSION["street"];
};
if (isset($_SESSION["streetnumber"])) {
  $streetnumber = $_SESSION["streetnumber"];
};
if (isset($_SESSION["city"])) {
  $city = $_SESSION["city"];
};
if (isset($_SESSION["zipcode"])) {
  $zipcode = $_SESSION["zipcode"];
};



// The form is valid
$submit = "";
$deliveryTime = "";
$totalMessage = "";
$total = 0;

if (!empty($_POST["email"]) && !empty($_POST["street"]) && !empty($_POST["streetnumber"]) && !empty($_POST["city"]) && !empty($_POST["zipcode"]) && !empty($_POST["products"])) {
  createSessionValues();

  $submit = 'Thank you! Your order is submitted. </br>';

  $deliveryTime = estimateDeliveryTime();
  $total = totalAmountPerOrder();
  $totalMessage = 'The total amount of this order is €' . totalAmountPerOrder() . "</br>";
};

// Create the session values
function createSessionValues()
{
  $_SESSION["email"] = $_POST["email"];
  $_SESSION["street"] = $_POST["street"];
  $_SESSION["streetnumber"] = $_POST["streetnumber"];
  $_SESSION["city"] = $_POST["city"];
  $_SESSION["zipcode"] = $_POST["zipcode"];
};



//your products with their price.
if (isset($_GET["drinks"]) && $_GET['drinks'] == 1) {
  $products = [
    ['name' => 'Cola', 'price' => 2],
    ['name' => 'Fanta', 'price' => 2],
    ['name' => 'Sprite', 'price' => 2],
    ['name' => 'Ice-tea', 'price' => 3],
  ];
} else {
  $products = [
    ['name' => 'Club Ham', 'price' => 3.20],
    ['name' => 'Club Cheese', 'price' => 3],
    ['name' => 'Club Cheese & Ham', 'price' => 4],
    ['name' => 'Club Chicken', 'price' => 4],
    ['name' => 'Club Salmon', 'price' => 5]
  ];
};

// Calculate the total amount per order
function totalAmountPerOrder()
{
  $totalValue = 0;
  foreach ($_POST["products"] as $value) {
    // echo "$value <br>";
    $totalValue += $value;
  }

  return $totalValue;
}

// Delivery time
function estimateDeliveryTime()
{
  $timeNow = date("H:i");

  if (!empty($_POST["expressDelivery"])) {
    $hourExpressDel = date('H:i', strtotime('+45 minutes', strtotime($timeNow)));
    return "Your order will be delivered at " . $hourExpressDel . "</br>";
  } else {
    $hourNormalDel = date('H:i', strtotime('+2 hours', strtotime($timeNow)));
    return "Your order will be delivered at " . $hourNormalDel . "</br>";
  };
}

//Total value with cookies
$totalAmount = 0;

if (isset($_COOKIE['amountOverall'])) {
  $totalAmount = $_COOKIE['amountOverall'] + $total;
};

$cookie = "$totalAmount";
setcookie("amountOverall", $cookie, time() + (86400 * 30), "/"); // 86400 = 1 day

function whatIsHappening()
{
  echo '<h2>$_GET</h2>';
  var_dump($_GET);
  echo '<h2>$_POST</h2>';
  var_dump($_POST);
  echo '<h2>$_COOKIE</h2>';
  var_dump($_COOKIE);
  echo '<h2>$_SESSION</h2>';
  var_dump($_SESSION);
}

// whatIsHappening();

require 'form-view.php';
