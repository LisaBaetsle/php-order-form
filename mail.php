 <?php
  /* // Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';


// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
  //Server settings
  //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
  $mail->isSMTP();                                            // Send using SMTP
  $mail->Host       = 'smtp.live.com';                    // Set the SMTP server to send through
  $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
  $mail->Username   = 'lisa_baetsle@hotmail.com';                     // SMTP username
  $mail->Password   = 'paswoord';                               // SMTP password
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
  $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

  //Recipients
  $mail->setFrom('lisa_baetsle@hotmail.com', 'Lisa Baetsle');
  $mail->addAddress('lisa_baetsle@hotmail.com');     // Add a recipient
  $mail->addReplyTo('lisa_baetsle@hotmail.com', 'Lisa Baetsle');
  //$mail->addCC('cc@example.com');
  //$mail->addBCC('bcc@example.com');

  // Attachments
  //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
  //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

  // Content
  $mail->isHTML(true);                                  // Set email format to HTML
  $mail->Subject = "Your order with 'the Personal Ham Processors'";
  $mail->Body    = $submit . "</br>" . $deliveryTime . "</br>" . $totalMessage . "</br>";
  $mail->AltBody = $submit . "</br>" . $deliveryTime . "</br>" . $totalMessage . "</br>";

  $mail->send();
  echo 'Message has been sent';
} catch (Exception $e) {
  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
} */


  /* Namespace alias. */

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  /* Include the Composer generated autoload.php file. */

  require 'vendor/autoload.php';

  /* If you installed PHPMailer without Composer do this instead: */
  /*
require 'C:\PHPMailer\src\Exception.php';
require 'C:\PHPMailer\src\PHPMailer.php';
require 'C:\PHPMailer\src\SMTP.php';
*/

  /* Create a new PHPMailer object. Passing TRUE to the constructor enables exceptions. */
  $mail = new PHPMailer(TRUE);

  /* Open the try/catch block. */
  try {
    /* Set the mail sender. */
    $mail->setFrom('lisa_baetsle@hotmail.com', 'Lisa Baetsle');

    /* Add a recipient. */
    $mail->addAddress('lisa_baetsle@hotmail.com', 'Lisa Baetsle');

    /* Set the subject. */
    $mail->Subject = "Your order with 'the Personal Ham Processors'";

    /* Set the mail message body. */
    $mail->Body = 'Yay. It worked!';

    /* Finally send the mail. */
    $mail->send();
    echo 'Message has been sent';
  } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
