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

        $transport = (new Swift_SmtpTransport(APP_MAIL_HOST, APP_MAIL_PORT, APP_MAIL_ENCRYPTION));
        $transport->setUsername(APP_MAIL_USER);
        $transport->setPassword(APP_MAIL_PWD);

        $mailer = new Swift_Mailer($transport);
        $message = new Swift_Message();
        $message->setSubject('Message de ' . $expeditorName);
        $message->setFrom([APP_MAIL_USER => $expeditorName]);
        $message->addTo(APP_MAIL_USER, 'Vous');


        $message->setBody($submitedMessage . '
        
        
        Ce message vous a été envoyé par ' . $expeditorName . '. vous pouvez lui répondre sur '
            . $expeditorEmail . ' .');

        $mailer->send($message);
    }
}
