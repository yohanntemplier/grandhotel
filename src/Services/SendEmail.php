<?php

namespace App\Services;

use App\Controller\AbstractController;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class SendEmail extends AbstractController
{
    /**
     * sends a message to the hotel mailbox
     * @param string $expeditorName
     * @param string $expeditorEmail
     * @param string $submitedMessage
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
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

        $message->setBody($this->twig->render(
            'Email.html.twig',
            ['expeditorName' => $expeditorName,
                'expeditorEmail' => $expeditorEmail,
                'submitedMessage' => $submitedMessage]
        ), 'text/html');
        $mailer->send($message);
    }
}
