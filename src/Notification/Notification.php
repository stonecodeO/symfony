<?php
namespace App\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


class ContactNotification extends AbstractController{


    public function notify(MailerInterface $mailer,String $sujet,String $nom,String $email,String $phone, String $msg){
        $email = (new Email())
            ->from($email)
            ->to('contact@commerce.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject($sujet)
            ->text($msg)
            ->html('<p>$phone</p>');

        /** @var Symfony\Component\Mailer\SentMessage $sentEmail */
        $sentEmail = $mailer->send($email);
        // $messageId = $sentEmail->getMessageId()
    }
}