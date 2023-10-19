<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;

class apiMailController extends BaseController
{
    use ResponseTrait;

    public function delete($mail_id = null)
    {
        $mail = model("MailModel")->find($mail_id);

        if (!$mail) {
            return $this->failNotFound("The mail does not exist");
        }

        $deleted = model("MailModel")->delete($mail_id);
        if (!$deleted) {
            return $this->fail("Error deleting the mail", 500);
        }

        return $this->respondDeleted();
    }

    public function resetError($mail_id)
    {
        $mail = model("MailModel")->find($mail_id);

        if (!$mail) {
            return $this->failNotFound("The mail does not exist");
        }

        $mail->type = "queue";
        $mail->error_retries = null;
        $mail->error = null;
        if ($mail->hasChanged()) {
            model("MailModel")->save($mail);
        }

        return $this->respondNoContent();
    }
}