 <?php
  // Import PHPMailer classes into the global namespace
  // These must be at the top of your script, not inside a function
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

  // Load Composer's autoloader
  require 'vendor/autoload.php';


  // MESSAGE
  $customerMsgHTML = "<h1>" . $submit . "</h1> </br>" . $deliveryTime . "</br>" . $totalMessage;
  $customerMsgTEXT = $submit . "</br>" . $deliveryTime . "</br>" . $totalMessage;

  // SEND MAIL
  $mail = new PHPMailer(true);

  try {
    // DEBUG
    // $mail->SMTPDebug = 3;

    // SERVER SETTINGS
    $mail->isSMTP();
    $mail->Host       = 'mail.gmx.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'lisa.baetsle@gmx.com';
    $mail->Password   = 'Becode2020';
    $mail->SMTPSecure = 'ssl'; //ssl -> 465  |  (gmail) tsl -> 587  |  (hotmail) PHPMailer::ENCRYPTION_STARTTLS -> 587
    $mail->Port       =  465;

    // SENDER
    $mail->setFrom('lisa.baetsle@gmx.com', 'Lisa Baetsle');

    // RECEIVER(S)
    $mail->addAddress('lisa_baetsle@hotmail.com', 'Happy Customer');
    //$mail->addAddress($customer2, 'Happy Customer2');

    // CONTENT
    $mail->isHTML(true);
    $mail->Subject = 'Your order with "the Personal Ham Processors"
    ';
    $mail->Body    = $customerMsgHTML; // Can be HTML
    $mail->AltBody = $customerMsgTEXT; // Should be plain text

    // SEND
    $mail->send();

    // INFORM USER
    echo "Email sent!";
  } catch (Exception $e) {
    echo "Error: {$mail->ErrorInfo}";
  }
