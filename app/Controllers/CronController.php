<?php

namespace App\Controllers;

use RuntimeException;

class CronController extends BaseController
{
    public function index()
    {
        $this->mail();
    }
    public function invoice()
    {
    }

    public function mail()
    {
        $mails = model("MailModel")
            ->where("type", "queue")
            ->findAll();

        foreach ($mails as $mail) {
            $emailer = emailer()->setFrom(
                setting("Email.fromEmail"),
                setting("Email.fromName") ?? "",
            );

            $emailer->setFrom(
                setting("Email.fromEmail"),
                setting("Email.fromName"),
            );

            if (!empty($mail->reply_to)) {
                $emailer->setReplyTo($mail->reply_to);
            }
            $emailer->setTo($mail->receiver);

            $emailer->setSubject($mail->subject);
            $emailer->setMessage(
                view("templates/email/sendmail.php", [
                    "betreff" => $mail->subject,
                    "text" => $mail->text,
                ]),
            );

            if ($emailer->send(false) === false) {
                $mail->error_retries++;
                $mail->error = $emailer->printDebugger(["headers"]);
                if ($mail->error_retries >= 3) {
                    $mail->type = "error";
                }
            } else {
                $mail->error_retries = null;
                $mail->error = null;
                $mail->sent_at = time();
                $mail->type = "sent";
            }

            model("MailModel")->save($mail);
        }
    }
}