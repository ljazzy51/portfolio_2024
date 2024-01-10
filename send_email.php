<?php

use Mailtrap\Config;
use Mailtrap\Helper\ResponseHelper;
use Mailtrap\MailtrapClient;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Mailtrap\EmailHeader\CategoryHeader;

require __DIR__ . '/vendor/autoload.php';

$apiKey = '5553eea8613e6b9ede9733f5fc497029';
$mailtrap = new MailtrapClient(new Config($apiKey));

$email = (new Email())
    ->from(new Address('mailtrap@lilyannejaczko.com', 'Mailtrap Test'))
    ->to(new Address("lily92415@gmail.com"))
    ->subject('You are awesome!')
    ->text('Congrats for sending test email with Mailtrap!')
;

$email->getHeaders()
    ->add(new CategoryHeader('Integration Test'))
;

$response = $mailtrap->sending()->emails()->send($email);

var_dump(ResponseHelper::toArray($response));
?>


<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor\autoload.php';

    $errors = [];
    $errorMessage = ' ';
    $successMessage = ' ';
    echo 'sending ...';
    if (!empty($_POST)){
        $name = $_POST['firstName'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        if (empty($name)) {
            $errors[] = 'Name is empty';
        }

        if (empty($email)) {
            $errors[] = 'Email is empty';
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email is invalid';

        }

        if (empty($message)) {
            $errors[] = 'Message is empty';
        }

        if (!empty($errors)) {
            $allErrors = join ('<br/>', $errors);
            $errorMessage = "<p style='color: red; '>{$allErrors}</p>";
        } else {
            $fromEmail = 'anyname@example.com';
            $emailSubject = 'New email from your contact form';

            // Create a new PHPMailer instance
            $mail = new PHPMailer(exceptions: true);
            try {
                // Configure the PHPMailer instance
                $mail->isSMTP();
                $mail->Host = 'live.smtp.mailtrap.io';
                $mail->SMTPAuth = true;
                $mail->Username = 'api';
                $mail->Password = 'your_smtp_password';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                
                // Set the sender, recipient, subject, and body of the message 
                $mail->setFrom($email);
                $mail->addAddress($email);
                $mail->setFrom($fromEmail);
                $mail->Subject = $emailSubject;
                $mail->isHTML( isHtml: true);
                $mail->Body = "<p>Name: {$name}</p><p>Email: {$email}</p><p>Message: {$message}</p>";
                
                    // Send the message
                $mail->send () ;
                $successMessage = "<p style='color: green; '>Thank you for contacting us :)</p>";
            } catch (Exception $e) {
                $errorMessage = "<p style='color: red; '>Oops, something went wrong. Please try again later</p>";
                echo $errorMessage;
            }
        }
    }
?>