<?php


namespace App\Services;

use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class SendEmail
{
    /**
     * sends a message to the hotel mailbox
     * @param string $expeditorName
     * @param string $expeditorEmail
     * @param string $submitedMessage
     */
    public function sendEmail(string $expeditorName, string $expeditorEmail, string $submitedMessage): void
    {

        // Create the SMTP Transport
        $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'));
        //the gmail password is unique for my computer, and only for swift mailer. It can't be used somewhere else,
        //and you can't connect with it on gmail.
        $transport->setUsername('legrandhotelorleans@gmail.com');
        $transport->setPassword('fznzeojlxcsnzvou');
        // Create the Mailer using the created Transport
        $mailer = new Swift_Mailer($transport);
        // Create a message
        $message = new Swift_Message();

        // Set a "subject"
        $message->setSubject('Message de ' . $expeditorName);

        // Set the "From address"
        $message->setFrom(['legrandhotelorleans@gmail.com' => $expeditorName]);

        // Set the "To address" [Use setTo method for multiple recipients, argument should be array]
        $message->addTo('legrandhotelorleans@gmail.com', 'Vous');

        // Set the plain-text "Body"
        $message->setBody($submitedMessage . '
        
        
        Ce message vous a été envoyé par ' . $expeditorName . '. vous pouvez lui répondre sur '
            . $expeditorEmail . ' .');
        // Send the message
        $mailer->send($message);
    }
}
