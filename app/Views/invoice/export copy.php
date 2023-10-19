<?php
$date = ($invoice->invoice) ? new DateTime($invoice->invoice) : null;

?>
<!DOCTYPE html>
<html lang="de_CH">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title><?=$invoice->description?></title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
              integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
              crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="<?=base_url()?>assets/css/print.css" rel="stylesheet">
    </head>
    <body class="invoice_print">
        <div class="wrapper">
            <section class="invoice">
                <div class="controls">
                    <button id="export-print"><i class="fa-solid fa-print"></i> Drucken</button>
                </div>
                <div class="row" style="margin-top:130px;">
                    <div class="col-6 address-receiver">
                        <address contenteditable="true">
                            <strong><?=$invoice->address['name']?></strong><br>
                            <?=$invoice->address['street']?><br>
                            <?=$invoice->address['postcode']?> <?=$invoice->address['city']?><br>
                        </address>
                    </div>
                    <div class="col-6">
                        <table class="company-info">
                            <tbody>
                                <tr>
                                    <td>Firma:</td>
                                    <td contenteditable="true"><?=service('settings')->get('Company.name')?></td>
                                </tr>
                                <?php if(!empty(service('settings')->get('Company.mwst'))): ?>
                                <tr>
                                    <td>MWST-Nummer:</td>
                                    <td contenteditable="true"><?=service('settings')->get('Company.mwst')?></td>
                                </tr>
                                <?php endif; ?>
                                <tr>
                                    <td>Datum:</td>
                                    <td contenteditable="true"><?= $date->format('d.m.Y') ?></td>
                                </tr>
                                <?php if($invoice->getCustomerInfo('addressnumber')):?>
                                <tr>
                                    <td>Kundennummer:</td>
                                    <td contenteditable="true"><?=$invoice->getCustomerinfo('addressnumber')?></td>
                                </tr>
                                <?php endif;?>
                                <tr>
                                    <td>Rechnungsnummer:</td>
                                    <td><?= $date->format('Y') ?>/<?= $invoice->id ?></td>
                                </tr>
                                <tr>
                                    <td>Zuständig:</td>
                                    <td contenteditable="true"><?=$invoice->contact_name?></td>
                                </tr>
                                <tr>
                                    <td>E-Mail:</td>
                                    <td contenteditable="true"><?=$invoice->contact_mail?></td>
                                </tr>
                                <tr>
                                    <td>Tel. direkt:</td>
                                    <td contenteditable="true"><?=$invoice->contact_phone?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row invoice-items mt-3 mb-3">
                    <div class="col-xs-12 table-responsive">
                        <span class="title" contenteditable="true">Rechnung</span>
                        <span class="invoice-name" contenteditable="true"><?=$invoice->description?></span>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Beschreibung</th>
                                <th class="text-end">Einzelbetrag</th>
                                <th class="text-end">Anzahl</th>
                                <th class="text-end">Gesamtpreis</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($invoice->getPositions() as $position): ?>
                            <tr>
                                <td contenteditable="true">
                                    <?=$position->title?>
                                    <span class="position-description"><?=$position->description?></span>

                                </td>
                                <td nowrap class="text-end">
                                    CHF <?=$position->getPositionUnitprice(false)?>
                                </td>
                                <td nowrap class="text-end">
                                    <?=$position->multiplication?>
                                </td>
                                <td nowrap class="text-end">
                                    CHF <?=$position->getPositionTotal(false)?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="3" class="text-end">
                                    Total (netto)
                                </td>
                                <td class="text-end">CHF <?php echo $invoice->getTotal(false, false) ?></td>
                            </tr>
                            <?php foreach($invoice->getMwst() as $mwst): ?>
                                <tr>
                                    <td colspan="3" class="text-end">
                                        Mehrwertsteuer (<?=$mwst['mwst']?>%)
                                    </td>
                                    <td class="text-end">CHF <?=$mwst['value']?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="3" class="text-end text-nowrap">
                                    <strong>Rechnungsbetrag</strong>
                                </td>
                                <td class="text-end">
                                    <strong>CHF <?php echo $invoice->getTotal(true, true) ?></strong>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <div contenteditable="true" class="paymentTerms">
                            <?=$invoice->notes_md?>
                        </div>
                    </div>
                </div>


                <footer class="footer">
                    <p>
                        <strong>Adresse</strong>: <span contenteditable="true"><?=service('settings')->get('Company.name')?>,
                        <?=service('settings')->get('Company.street')?>,
                            <?=service('settings')->get('Company.postcode')?> <?=service('settings')->get('Company.city')?></span>
                        <br>
                        <?php if(!empty(service('settings')->get('Company.iban'))): ?>
                            <strong>Bankverbindung</strong>: <span contenteditable="true"><?=service('settings')->get('Company.iban')?></span>
                            <br>
                            <strong>Zahlungszweck</strong>: <span contenteditable="true">#<?= $date->format('Y') ?>/<?= $invoice->id ?></span>
                            <br>
                            <strong>Zahlung</strong>: <span contenteditable="true"><?=service('settings')->get('Company.payment_deadline')?> Tage netto</span>
                        <?php endif; ?>

                    </p>
                </footer>
            </section>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
                integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
                crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            $('#export-print').click(function(){
                window.print();
                return false;
            });
        </script>
    </body>

</html>
