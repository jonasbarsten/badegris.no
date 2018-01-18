<?php

require_once('phpmailer/class.phpmailer.php');

$mail = new PHPMailer();

if( isset( $_POST['template-contactform-submit'] ) AND $_POST['template-contactform-submit'] == 'submit' ) {
    if( $_POST['template-contactform-name'] != '' AND $_POST['template-contactform-email'] != '' AND $_POST['template-contactform-message'] != '' ) {

        $name = $_POST['template-contactform-name'];
        $email = $_POST['template-contactform-email'];
        $phone = $_POST['template-contactform-phone'];
        $subject = $_POST['template-contactform-subject'];
        $message = $_POST['template-contactform-message'];

        $subject = isset($subject) ? $subject : 'Ny interessert i serverrom';

        $botcheck = $_POST['template-contactform-botcheck'];

        $toemail = 'jonas@olyp.no'; // Your Email Address
        $toname = 'Badegris'; // Your Name

        if( $botcheck == '' ) {

            $mail->SetFrom( $email , $name );
            $mail->AddReplyTo( $email , $name );
            $mail->AddAddress( $toemail , $toname );
            $mail->Subject = $subject;

            $name = isset($name) ? "Name: $name<br><br>" : '';
            $email = isset($email) ? "Email: $email<br><br>" : '';
            $phone = isset($phone) ? "Phone: $phone<br><br>" : '';
            $message = isset($message) ? "Message: $message<br><br>" : '';

            $referrer = $_SERVER['HTTP_REFERER'] ? '<br><br><br>This Form was submitted from: ' . $_SERVER['HTTP_REFERER'] : '';

            $body = "$name $email $phone $message $referrer";

            $mail->MsgHTML( $body );
            $sendEmail = $mail->Send();

            if( $sendEmail == true ):
                echo 'Vi har mottatt meldingen din og tar kontakt med deg så snart som mulig';
            else:
                echo 'Meldingen kunne ikke bli sendt, vennligst ta kontakt per telefon eller epost<br /><br /><strong>Reason:</strong><br />' . $mail->ErrorInfo . '';
            endif;
        } else {
            echo 'Bot <strong>Detected</strong>.! Clean yourself Botster.!';
        }
    } else {
        echo 'Vennligst <strong>Fyll ut</strong> alle feltene og prøv igjen.';
    }
} else {
    echo 'En <strong>ukjent feil</strong> har forekommet. Vennligst ta kontakt per telefon eller epost.';
}

?>