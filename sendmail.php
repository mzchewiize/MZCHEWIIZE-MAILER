<?php
/**
 * This example shows settings to use when sending via Google's Gmail servers.
 */

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');

require 'PHPMailerAutoload.php';
require 'config.php';

//send form //
$send_from = '';  
$send_from_name ='';
// reply to 
$reply_to = '';
$reply_to_name ='';
// sendmail _to
$send_mail_to = '';
$send_mail_to_name ='';
// email pack 
// Include Subject + body
$send_mail_subject ='';
$mail_body = '';

function sendmail($send_from, $send_from_name, $reply_to, $reply_to_name, $send_mail_to, $send_from_name, $send_mail_subject, $mail_body) {
	//Create a new PHPMailer instance
	$mail = new PHPMailer;
	//Tell PHPMailer to use SMTP
	$mail->isSMTP();
	$mail->smtpConnect([
	    'ssl' => [
	        'verify_peer' => false,
	        'verify_peer_name' => false,
	        'allow_self_signed' => true
	    ]
	]);
	//Enable SMTP debugging
	// 0 = off (for production use)
	// 1 = client messages
	// 2 = client and server messages
	$mail->SMTPDebug = 0;

	//Ask for HTML-friendly debug output
	//$mail->Debugoutput = 'html';
	//Set the hostname of the mail server
	$mail->Host = EMAIL_HOST;
	// $mail->Host = gethostbyname('smtp.gmail.com');
	// if your network does not support SMTP over IPv6

	//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
	$mail->Port = EMAIL_PORT;

	//Set the encryption system to use - ssl (deprecated) or tls
	$mail->SMTPSecure = EMAIL_SMTPSECURE;

	//Whether to use SMTP authentication
	$mail->SMTPAuth = EMAIL_SMTPAUTH;

	//Username to use for SMTP authentication - use full email address for gmail
	$mail->Username = EMAIL_ACCOUNT;

	//Password to use for SMTP authentication
	$mail->Password = EMAIL_PASSWORD;

	//Set who the message is to be sent from
	$mail->setFrom($send_from, $send_from_name);

	//Set an alternative reply-to address
	$mail->addReplyTo($reply_to, $reply_to_name);

	//Set who the message is to be sent to
	$mail->addAddress($send_mail_to, $send_mail_to_name);

	//Set the subject line
	$mail->Subject = $send_mail_subject;
	$mail->msgHTML($mail_body);

	//Replace the plain text body with one created manually
	//$mail->AltBody = 'This is a plain-text message body';
	//send the message, check for errors
	if (!$mail->send()) {
	    return $mail->ErrorInfo;
	} else {
	    return true;
	}

}
