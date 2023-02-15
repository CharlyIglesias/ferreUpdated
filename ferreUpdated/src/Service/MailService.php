<?php

namespace App\Service;

use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface as ObjectManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class MailService
{
    protected $om;
    // private $encoderFactory;

    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    public function sendEmail($fromWho, $subject, $toWho, $content, $link = null): string{
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom($fromWho, $fromWho);
        $email->setSubject($subject);
        $email->addTo($_ENV['base_email']);
        $email->addContent("text/html", $content);
        $apiKey = $_ENV['SENDGRID_API_KEY'];
        $sendgrid = new \SendGrid($apiKey);
        try {
            $response = $sendgrid->send($email);
            $funciono = "true";

        } catch (Exception $e) {
            $funciono = "false";
            echo 'Caught exception: ' . $e->getMessage() . "\n";
        }
        // $this->saveNotificationByEmail($toWho, $subject, $link);
        return $funciono;
    }
}
?>