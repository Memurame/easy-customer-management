<?php

namespace App\Controllers;

use RuntimeException;

class CronController extends BaseController
{
    public function index($filter = 'default')
    {
        if($filter == 'default'){
            $this->mail();
            $this->invoice();
        }
        
        if($filter == 'daily'){
            
            $this->kalahari();
            $this->telefonlist();
        }
        
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

    public function kalahari(){
        
        $filepath = WRITEPATH . 'uploads/temp/kalahari.json';
        $pending = WRITEPATH . 'uploads/temp/.kalahari';
        
        if(file_exists($filepath) AND !file_exists($pending)){
            file_put_contents($pending, null);
            

            $json = json_decode(file_get_contents($filepath), true);
            $kalahari = $json[array_key_first($json)];

            $abaKalahariModel = model('AbaKalahariModel');
            $abaKalahariModel->truncateTable();

            $abaAddressKalahariModel = model('AbaAddressKalahariModel');
            $abaAddressKalahariModel->truncateTable();

            
            foreach($kalahari as $key => $val){
                if(!empty($val['tel_1'])){

                    $telefon = removeSpecialchar($val['tel_1']);
                    $telefon = (string)((int)($telefon));

                    $check = $abaKalahariModel->find($val['id_nr']);
                    if(!$check){

                        $data = [
                            'kalahari' => $val['id_nr'],
                            'phone'    => $telefon
                        ];
                        $abaKalahariModel->save($data);
                    }
                    
                }
            }
            

            $adressen = model('abaAddressModel')
                ->where('abacus IS NOT', null)
                ->where('inactive', NULL)
                ->findAll();

              

            foreach($adressen as $adresse){

                // Bei den Telefonnummern die (Sonder)Zeichen: / . - ' entfernen
                // Die Telefonnummer und handynummer so formatieren damit diese mit der Kalahariliste abgeglichen werden können
                // Diese sollten im Format sein wie im folgenden Beispiel: 319382280
                $phone1 = removeSpecialchar($adresse->phone1, true);
                $phone2 = removeSpecialchar($adresse->phone2, true);
                $mobile = removeSpecialchar($adresse->mobile, true);


                $search = [];
                $search[] = (string)((int)($phone1));
                $search[] = (string)((int)($phone2));
                $search[] = (string)((int)($mobile));

                
                foreach($search as $v1){
                    
                    $exists = $abaKalahariModel->where('phone', $v1)->findAll();
                    foreach($exists as $v2){
                        $data = [
                            'abacus'    =>  $adresse->abacus,
                            'kalahari'  =>  $v2['kalahari']
                        ];
                        $abaAddressKalahariModel->save($data);
                    }
                    

                }

            }

            service('settings')->set('App.lastKalahariImport', date('d.m.Y - H:i:s'));

            unlink($filepath);
            unlink($pending);

            /*
            if(service('settings')->get('App.lastKalahariImportReceiver')){
                $email = emailer()->setFrom(setting('Email.fromEmail'), setting('Email.fromName') ?? '');
                $email->setTo(service('settings')->get('App.lastKalahariImportReceiver'));
                $email->setSubject("Kalahariliste Importiert");
                $email->setMessage(view('templates/email/kalahari.php'));
                if ($email->send(false) === false) {
                    throw new \RuntimeException("Cannot send email \n" . $email->printDebugger(['headers']));
                }
            }
            */
            
            
            
        }

        

    }

    public function telefonlist(){

        $adressen = model('abaAddressModel')
            ->where('abacus IS NOT NULL', null)
            ->where('inactive', NULL)
            ->asArray()
            ->findAll();

        $currentDate['year'] = date('Y');
        $currentDate['month'] = date('m');

        $title = [
            'AbacusNr',
            'Vorname',
            'Nachname',
            'Strasse',
            'Plz',
            'Ort',
            'Telefon',
            'Mobile',
            'Mail',
            'Mitgliederart',
            'Bezahlt in %',
            'Zahldatum',
            'Status',
            'KalahariId',
            'Telefon2'
        ];
        $returnArray = [];

        $outputfile = FCPATH . '../writable/export/telefonliste.csv';

        $fileOut = fopen($outputfile, 'w');
        fputcsv($fileOut, $title, ';');

        // Alle Adressen durchschleifen
        for($i = 0; $i < count($adressen); $i++){

            // Prüfen on ein Zahldatum gesetzt ist.
            // von Juli-Dezember die Mitgliederart anhand des Zahldatums anpassen
            // NM welche im laufenden Jahr ab Juli bezahlt haben und über 70 % bezahlt haben, die Mitgliederart auf AM Wechseln

            if(isset($adressDate) AND
                $currentDate['year'] == $adressDateArray[2] AND
                $currentDate['month'] >= 7 AND
                $adressen[$i]['paid_percent'] >= 70 AND
                $adressen[$i]['member_typ'] == "NM"){
                $adressen[$i]['member_typ'] = "AM";
            }

            // Bei Mitgliederart AM und MK den Status "Rechnung bezahlt" setzen.
            if($adressen[$i]['member_typ'] == "AM" OR $adressen[$i]['member_typ'] == "MK"){
                $adressen[$i]['Status'] = "Rechnung bezahlt";
            }
            // CAJB Mitglieder erhalten den Status "CAJB"
            else if($adressen[$i]['member_typ'] == "CAJB"){
                $adressen[$i]['Status'] = "CAJB";
            }
            // Adressen mit einem NM erhalten den Status "UNBEZAHLT"
            else if($adressen[$i]['member_typ'] == "NM"){
                $adressen[$i]['Status'] = "UNBEZAHLT";
            }
            // Alle Anderen erhalten den Status "Keine Rechnung"
            else {
                $adressen[$i]['Status'] = "keine Rechnung";
            }

            $kalahari = model('abaAddressKalahariModel')
                ->select('kalahari')
                ->where('abacus', $adressen[$i]['abacus'])
                ->asArray()
                ->findAll();

            $kalahariIdString = NULL;
            if($kalahari){
                $kalahariId = [];
                foreach($kalahari as $kal){
                    $kalahariId[] = $kal['kalahari'];
                }
                $kalahariIdString = implode(', ', $kalahariId);
            }


            // Export der Mitgliederdaten aufbereiten
            $returnArray[$i][$title[0]] = $adressen[$i]['abacus'];
            $returnArray[$i][$title[1]] = $adressen[$i]['firstname'];
            $returnArray[$i][$title[2]] = $adressen[$i]['lastname'];
            $returnArray[$i][$title[3]] = $adressen[$i]['street'];
            $returnArray[$i][$title[4]] = $adressen[$i]['postcode'];
            $returnArray[$i][$title[5]] = $adressen[$i]['city'];
            $returnArray[$i][$title[6]] = $adressen[$i]['phone1'];
            $returnArray[$i][$title[7]] = $adressen[$i]['mobile'];
            $returnArray[$i][$title[8]] = $adressen[$i]['email'];
            $returnArray[$i][$title[9]] = $adressen[$i]['member_typ'];
            $returnArray[$i][$title[10]] = $adressen[$i]['paid_percent'];
            $returnArray[$i][$title[11]] = $adressen[$i]['paid_date'];
            $returnArray[$i][$title[12]] = $adressen[$i]['Status'];
            $returnArray[$i][$title[13]] = $kalahariIdString;
            $returnArray[$i][$title[14]] = $adressen[$i]['phone2'];
            fputcsv($fileOut, $returnArray[$i], ';');
            

        }

        fclose($fileOut);
    }
}