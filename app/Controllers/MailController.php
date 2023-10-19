<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\AbacusConnectorSOAP;

use App\Entities\Mail;

class MailController extends BaseController
{
    public function index($mail_id = null)
    {

        $mails = model("MailModel")
            ->where("type", "template")
            ->findAll();

        if ($mail_id) {
            $template = model("MailModel")->find($mail_id);
            if (!$template) {
                return redirect()->route("mail.index");
            }
        }

        return view("mail/mail", [
            "list" => $mails ?? [],
            "current" => $mail_id,
            "entwurf" => $template ?? null,
        ]);
    }

    public function detail($mail_id)
    {
        $mail = model("MailModel")
            ->whereIn("type", ["sent", "queue", "error"])
            ->where("id", $mail_id)
            ->first();

        if (!$mail) {
            return redirect()
                ->to(route_to("mail.sent"))
                ->with("msg_error", "Diese Mail existiert nicht");
        }

        return view("mail/mail_detail", [
            "mail" => $mail,
        ]);
    }

    public function sent()
    {
        $mails = model("MailModel")
            ->whereIn("type", ["sent", "error", "queue"])
            ->findAll();

        return view("mail/mail_sent", [
            "mails" => $mails,
        ]);
    }

    public function send()
    {
        $time = time();

        $rules = [
            "input_receiver" => "required",
            "input_subject" => "required",
            "input_text" => "required",
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with("errors", $this->validator->getErrors());
        }

        $mail = new Mail();
        $parser = new \Parsedown();

        $mail->receiver = $this->request->getVar("input_receiver");
        $mail->name = !empty($this->request->getVar("save_name"))
            ? $this->request->getVar("save_name")
            : "Entwurf ohne Namen";
        $mail->reply_to = !empty($this->request->getVar("input_sender"))
            ? $this->request->getVar("input_sender")
            : null;
        $mail->subject = $this->request->getVar("input_subject");
        $mail->text = $parser
            ->setBreaksEnabled(true)
            ->text($this->request->getVar("input_text"));
        $mail->type = "queue";
        $mail->user_id = user_id();

        model("MailModel")->save($mail);

        return redirect()
            ->route("mail.index")
            ->with(
                "msg_success",
                "Die Mails werden in den nächsten 5 Minuten automatisch versendet.",
            );
    }

    public function save($mail_id = null)
    {
        $mail = $mail_id ? model("MailModel")->find($mail_id) : null;

        if (!$mail) {
            $mail = new Mail();
        }

        $mail->name = !empty($this->request->getVar("save_name"))
            ? $this->request->getVar("save_name")
            : "Entwurf ohne Namen";
        $mail->reply_to = !empty($this->request->getVar("input_sender"))
            ? $this->request->getVar("input_sender")
            : null;
        $mail->subject = $this->request->getVar("input_subject");
        $mail->text = $this->request->getVar("input_text");

        if ($mail_id) {
            if ($mail->hasChanged()) {
                model("MailModel")->save($mail);
                session()->setFlashdata(
                    "msg_success",
                    "Die änderungen an der Vorlage wurden gespeichert.",
                );
            }
        } else {
            $mail->type = "template";
            model("MailModel")->save($mail);
            session()->setFlashdata(
                "msg_success",
                "Das Mail wurde als Vorlage gespeichert.",
            );
        }

        return $mail_id
            ? redirect()->route("mail.load", [$mail_id])
            : redirect()->route("mail.index");
    }
}