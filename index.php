<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);

//we are going to use session variables so we need to enable sessions
session_start();

// define variables and set to empty values
$emailErr = $streetErr = $streetnumberErr = $cityErr = $zipcodeErr = $productsErr = "";
$email = $street = $streetnumber = $city = $zipcode = $products = "";


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



// Message for user if form is valid
$total = 0;
if (!empty($_POST["email"]) && !empty($_POST["street"]) && !empty($_POST["streetnumber"]) && !empty($_POST["city"]) && !empty($_POST["zipcode"]) && !empty($_POST["products"])) {
  $_SESSION["email"] = $_POST["email"];
  $_SESSION["street"] = $_POST["street"];
  $_SESSION["streetnumber"] = $_POST["streetnumber"];
  $_SESSION["city"] = $_POST["city"];
  $_SESSION["zipcode"] = $_POST["zipcode"];

  echo 'Your order is submitted, thank you';

  estimateDeliveryTime();
  $total = totalAmountPerOrder();
};




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


echo 'this is the total of the order ' . $total;

// Delivery time
function estimateDeliveryTime()
{
  $timeNow = date("h:i");

  if (!empty($_POST["expressDelivery"])) {
    $hourExpressDel = date('h:i', strtotime('+45 minutes', strtotime($timeNow)));
    echo "your order will be delivered at " . $hourExpressDel;
  } else {
    $hourNormalDel = date('h:i', strtotime('+2 hours', strtotime($timeNow)));
    echo "your order will be delivered at " . $hourNormalDel;
  };
}

//Total value with cookies
$totalAmount = 0;
// if cookie is set for the variable, it'll go to $countVisit and get added by 1; otherwise it'll show 0 for tha variable
if (isset($_COOKIE['testCookie'])) {
  $totalAmount = $_COOKIE['testCookie'] + $total;
};

echo "this is the total overall:" . $totalAmount;


$cookie = "$totalAmount";
setcookie("testCookie", $cookie, time() + (86400 * 30), "/"); // 86400 = 1 day

echo "this is the cookie total amount overall:" . $_COOKIE["testCookie"];

whatIsHappening();

require 'form-view.php';
