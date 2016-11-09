<?php
error_reporting(E_ALL & ~E_NOTICE);
//Needs JotForm API to be included
include "jotform-api-php-master/JotForm.php";

//Set API key here
$jotformAPI = new JotForm("YOUR API HERE");

//Use getHistory of account, use parameter specific for emails
$history = $jotformAPI->getHistory('emails','lastWeek','ASC');

//Get submission ID via POST
$submissionID = $_POST['submission_id'];

date_default_timezone_set('GMT');


//Download and require PHPMailer here
require 'PHPMailer-master/PHPMailerAutoload.php';
//require 'PHPMailer-master/class.phpmailer.php';


$mail = new PHPMailer();

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
//$mail->SMTPDebug = 1;
$mail->Host = 'YOUR SMTP HOST';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'YOUR EMAIL';                 // SMTP username
$mail->Password = 'YOUR PASSWORD';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);

$mail->setFrom('FROM EMAIL', 'Mailer');
$mail->addAddress('RECIPIENT', '');     // Add a recipient
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

foreach($history as $result) {

		$resultSubmissionID = $result['submissionID'];

		if($submissionID == $resultSubmissionID) {

			//Check if the status of the email alert failed, if it does, trigger PHPmail
			if($result['status'] == "FAILED") {


			//Can echo the output of the failed email alert here. Or create a thank you message here OR redirect a user to another link
			echo "You can write the Thank you message here.<br> So far, the details of the failed email for this submission is printed below for troubleshooting purposes:<br><br>";
			echo 'Form ID: '.$result['formID'].'<br>';
			echo 'Submission ID: '.$result['submissionID'].'<br>';
			echo 'Provider: '.$result['provider'].'<br>';	
			echo 'From: '.$result['from'].'<br>';
			echo 'To: '.$result['to'].'<br>';
			echo 'Status: '.$result['status'].'<br><br>';


			//Apend the details of the email alert that failed on this submission that will be sent to backup email
			$mail->Body .= 'Form ID: '.$result['formID'].'<br>'
						.'Submission ID: '.$result['submissionID'].'<br>'
						.'Provider: '.$result['provider'].'<br>'
						.'From: '.$result['from'].'<br>'
						.'To: '.$result['to']
						.'<br>'.'Status: '.$result['status'].'<br><br>';

		
				if(!$mail->send()) {
				    echo 'Message could not be sent.<br>';
				    echo 'Mailer Error: ' . $mail->ErrorInfo;
				} else {
				    echo '<br>Email status checker has been sent.<br>';
				}

		}

	}
	
}

?>
		
</body>

</html>
