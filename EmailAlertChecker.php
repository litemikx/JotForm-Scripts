<?php
/* Author: Charmie Q.
 * Description: Email status checker and notifier when email alert of the submission failed
 * Date: August 5, 2016
 * Version: 1.0
 * /

//Needs JotForm API to be included
include "jotform-api-php-master/JotForm.php";

//Set API key here
$jotformAPI = new JotForm("YOUR API KEY HERE");

//Use getHistory of account, use parameter specific for emails
$history = $jotformAPI->getHistory('emails','lastWeek','ASC');

//Get submission ID via POST
$submissionID = $_POST['submission_id'];



//Download and require PHPMailer here
require 'PHPMailer-master/PHPMailerAutoload.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com;smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'test@test.com';                 // SMTP username
$mail->Password = 'smtppassword';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom('test@test.com', 'Mailer');
$mail->addAddress('recipient@gmail.com', '');     // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional
//$mail->addReplyTo('info@example.com', 'Information');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Email Status Checker Notifier';
$mail->Body    = '<p>Email notification status: FAILED</p>';
//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';



?>

<!DOCTYPE html>
<html>

<body>

<?php 

//PHP script for checking and outputting if the submission that was sent has failed email alert
$resultSubmissionID = '';

foreach($history as $result) {

	$resultSubmissionID = $result['submissionID'];

	if($submissionID == $resultSubmissionID) {

		//Can echo the output of the failed email alert here.
		echo 'Form ID: '.$result['formID'].'<br>';
		echo 'Submission ID: '.$result['submissionID'].'<br>';
		echo 'Provider: '.$result['provider'].'<br>';	
		echo 'From: '.$result['from'].'<br>';
		echo 'To: '.$result['to'].'<br>';
		echo 'Status: '.$result['status'].'<br><br>';


		//Can append the email alert details that failed on this email body that will be sent to backup email
		$mail->Body .= 'Form ID: '.$result['formID'].'<br>'
					.'Submission ID: '.$result['submissionID'].'<br>'
					.'Provider: '.$result['provider'].'<br>'
					.'From: '.$result['from'].'<br>'
					.'To: '.$result['to']
					.'<br>'.'Status: '.$result['status'].'<br><br>';

		//Check if the status of the email alert failed, if it does, trigger PHPmail
		if($result['status'] == "FAILED") {

			if(!$mail->send()) {
			    echo 'Message could not be sent.';
			    echo 'Mailer Error: ' . $mail->ErrorInfo;
			} else {
			    echo 'Message has been sent';
			}

		}

	}
}

?>
		
</body>


</html>
