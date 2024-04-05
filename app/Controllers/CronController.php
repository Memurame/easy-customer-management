<?php

namespace App\Controllers;

use RuntimeException;

class CronController extends BaseController
{
    public function index()
    {
        $this->mail();
        $this->invoice();
    }
    public function invoice()
    {
        $invoiceModel = model('InvoiceModel');

        $userModel = model('UserModel');
        $users = $userModel->findAll();


        $paymentTerm = strtotime('-'.service('settings')->get('Company.payment_deadline').' days');
       
        /*
         * Auf überfällige Rechnungen prüfen
         */
        $invoices = $invoiceModel
            ->where('paid', 0)
            ->findAll();
            
        foreach($invoices as $key => $invoice){
            $invoiceDate = strtotime($invoice->invoice);
            if($invoiceDate <= $paymentTerm){
                
                $invoice->paid = 3;
                if($invoice->hasChanged()){
                    $invoiceModel->save($invoice);
                }
                
                
                $email = emailer()->setFrom(setting('Email.fromEmail'), setting('Email.fromName') ?? '');
                foreach($users as $user){
                    if(!empty($user->email) AND $user->inGroup('superadmin', 'admin')){
                        $mailReceiver[] = $user->email;
                    }
                    
                }
                $email->setTo($mailReceiver);
                $email->setSubject("Überfällige Rechnung - " . $invoice->description);
                $email->setMessage(view('templates/email/overdue.php', [
                    'invoice' => $invoice]));
                if ($email->send(false) === false) {
                    throw new \RuntimeException("Cannot send email \n" . $email->printDebugger(['headers']));
                }
                
            }
        }

        /*
         * Geplannet rechneungen bearbeiten und entsprechend status setzen
         */
        $invoices = $invoiceModel
            ->where('paid', 4)
            ->findAll();
        foreach($invoices as $key => $invoice){
            $invoiceDate = strtotime($invoice->invoice);
            if(time() >= strtotime('-30 days', $invoiceDate)){
                $invoice->paid = 5;
                if($invoice->hasChanged()){
                    $invoiceModel->save($invoice);
                }
            }
        }

         /*
         * Rechnungen welche automatisch Monatlich erneuert werden generieren und auf pendent setzen
         */
        $invoices = $invoiceModel
            ->where('renew', 1)
            ->where('renew_interval', 1)
            ->where('renewed', 0)
            ->findAll();

        foreach($invoices as $key => $invoice){
            $invoiceDate = strtotime($invoice->invoice);
            if(time() >= strtotime('+1 days', $invoiceDate)){

                $invoice->renewed = 1;
                if($invoice->hasChanged()){
                    $invoiceModel->save($invoice);
                }

                $invoice->id = null;
                $invoice->paid = 5;
                $invoice->renewed = 0;
                $invoice->invoice = date('Y.m.d', strtotime($invoice->invoice. '+1 months'));
                $invoiceModel->save($invoice);


                $newInvoiceID = $invoiceModel->getInsertID();
                $invoicePos = model('InvoicePositionModel')
                    ->where('invoice_id', $lastInvoiceID)
                    ->findAll();
                foreach($invoicePos as $pos){
                    $pos->id = null;
                    $pos->invoice_id = $newInvoiceID;
                    if(!$pos->type){
                        $pos->type = 1;
                    }
                    model('InvoicePositionModel')->save($pos);
                }


            }
        }

         /*
         * Rechnungen welche automatisch auf den 1. im Monat fällig sind generieren und auf entwurf setzen
         */
        $invoices = $invoiceModel
            ->where('renew', 1)
            ->where('renew_interval', 2)
            ->where('renewed', 0)
            ->findAll();

        foreach($invoices as $key => $invoice){
            $invoiceDate = strtotime($invoice->invoice);
            if(date('d', time()) > 1 && date('m', $invoiceDate) == date('m', time())){

                $invoice->renewed = 1;
                if($invoice->hasChanged()){
                    $invoiceModel->save($invoice);
                }

                $invoice->id = null;
                $invoice->paid = 5;
                $invoice->renewed = 0;
                $invoice->invoice = date('Y.m', strtotime($invoice->invoice. '+1 months')) . '.1';
                $invoiceModel->save($invoice);


                $newInvoiceID = $invoiceModel->getInsertID();
                $invoicePos = model('InvoicePositionModel')
                    ->where('invoice_id', $lastInvoiceID)
                    ->findAll();
                foreach($invoicePos as $pos){
                    $pos->id = null;
                    $pos->invoice_id = $newInvoiceID;
                    if(!$pos->type){
                        $pos->type = 1;
                    }
                    model('InvoicePositionModel')->save($pos);
                }

                
                

            }
        }
        

        /*
         * Rechnungen welche automatisch Jährlich erneuert werden generieren und auf pendent setzen
         */
        $invoices = $invoiceModel
            ->where('renew', 1)
            ->where('renew_interval', 3)
            ->where('renewed', null)
            ->findAll();

        foreach($invoices as $key => $invoice){
            $invoiceDate = strtotime($invoice->invoice);
            if(time() >= strtotime('+300 days', $invoiceDate)){
                $lastInvoiceID = $invoice->id;

                $invoice->renewed = 1;
                if($invoice->hasChanged()){
                    $invoiceModel->save($invoice);
                }

                $invoice->id = null;
                $invoice->paid = 4;
                $invoice->renewed = null;
                $invoice->invoice = date('Y.m.d', strtotime($invoice->invoice. '+1 year'));
                $invoiceModel->save($invoice);


                $newInvoiceID = $invoiceModel->getInsertID();
                $invoicePos = model('InvoicePositionModel')
                    ->where('invoice_id', $lastInvoiceID)
                    ->findAll();
                foreach($invoicePos as $pos){
                    $pos->id = null;
                    $pos->invoice_id = $newInvoiceID;
                    if(!$pos->type){
                        $pos->type = 1;
                    }
                    model('InvoicePositionModel')->save($pos);
                }

            }
        }
        die();

         /*
         * Rechnungen welche automatisch auf den 1. im Jahr fällig sind generieren und auf pendent setzen
         */
        $invoices = $invoiceModel
            ->where('renew', 1)
            ->where('renew_interval', 4)
            ->where('renewed', 0)
            ->findAll();

        foreach($invoices as $key => $invoice){
            $invoiceDate = strtotime($invoice->invoice);
            if(date('d', time()) >= 1 && date('m', time()) == 10 && date('Y', $invoiceDate) == date('Y', time())){

                $invoice->renewed = 1;
                if($invoice->hasChanged()){
                    $invoiceModel->save($invoice);
                }

                $invoice->id = null;
                $invoice->paid = 4;
                $invoice->renewed = 0;
                $invoice->invoice = date('Y.m', strtotime($invoice->invoice. '+1 year')) . '.1';
                $invoiceModel->save($invoice);


                $newInvoiceID = $invoiceModel->getInsertID();
                $invoicePos = model('InvoicePositionModel')
                    ->where('invoice_id', $lastInvoiceID)
                    ->findAll();
                foreach($invoicePos as $pos){
                    $pos->id = null;
                    $pos->invoice_id = $newInvoiceID;
                    if(!$pos->type){
                        $pos->type = 1;
                    }
                    model('InvoicePositionModel')->save($pos);
                }

            }
        }
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