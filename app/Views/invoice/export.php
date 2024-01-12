<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<?php 
$date = ($invoice->invoice) ? new DateTime($invoice->invoice) : null; 
?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    Rechnung
                </div>
                <h2 class="page-title">
                    <?php echo $invoice->description ?> (Export)
                </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <a href="<?=base_url(route_to('invoice.show', $invoice->id))?>" class="btn btn-secondary d-none d-sm-inline-block">
                    Zurück
                </a>
                <button type="button" class="btn btn-primary" onclick="javascript:window.print();">
                    <!-- Download SVG icon from http://tabler-icons.io/i/printer -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                        <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                        <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                    </svg>
                    Drucken
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Page body -->
<div class="page-body">
    <div class="container-xl">

        <div class="card print-wrapper">
            <div class="card-body">
                <div class="row print-header">
                    <div class="col-6 print-logo">
                        <img src="<?= base_url() . setting('Site.logo')?>">
                    </div>
                    <div class="col-2">

                    </div>
                    <div class="col-3 print-sender">
                        <address>
                            <span>
                                <?=service('settings')->get('Company.name')?><br>
                                <?=service('settings')->get('Company.street')?><br>
                                <?=service('settings')->get('Company.postcode')?> <?=service('settings')->get('Company.city')?></span>
                        </address>
                    </div>
                </div>

                <div class="print-body">
                    <div class="row mt-6">
                        <div class="col-7 print-receiver">
                            <address>
                                <strong><?=$invoice->address['name']?></strong><br>
                                <?=$invoice->address['street']?><br>
                                <?=$invoice->address['postcode']?> <?=$invoice->address['city']?><br>
                            </address>
                        </div>
                        <div class="col-5">
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
                                        <td>RE-<?=str_pad($invoice->id,5,0,STR_PAD_LEFT)?></td>
                                    </tr>
                                    <?php if($invoice->contact_name):?>
                                    <tr>
                                        <td>Zuständig:</td>
                                        <td contenteditable="true"><?=$invoice->contact_name?></td>
                                    </tr>
                                    <?php endif;?>
                                    <?php if($invoice->contact_mail):?>
                                    <tr>
                                        <td>E-Mail:</td>
                                        <td contenteditable="true"><?=$invoice->contact_mail?></td>
                                    </tr>
                                    <?php endif;?>
                                    <?php if($invoice->contact_phone):?>
                                    <tr>
                                        <td>Tel. direkt:</td>
                                        <td contenteditable="true"><?=$invoice->contact_phone?></td>
                                    </tr>
                                    <?php endif;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row title">
                        <span>Rechnung</span>
                    </div>
                    <div class="row subtitle">
                        <span contenteditable="true"><?=$invoice->description?></span>
                    </div>
                    <?php if(!empty($invoice->notes_top)): ?>
                    <div class="row notes">
                        <?=$invoice->notes_top?>
                    </div>
                    <?php endif; ?>
                    <table class="table table-transparent table-responsive print-table">
                        <thead>
                            <tr>
                                <th class="text-start" style="width: 1%">#</th>
                                <th>Beschreibung</th>
                                <th class="text-end" style="width: 1%">Einzelbetrag</th>
                                <th class="text-end" style="width: 1%">Anzahl</th>
                                <th class="text-end" style="width: 1%">Gesamtpreis</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($invoice->getPositions() as $position): ?>
                            <tr>
                                <td class="text-start"><?=$position->position?></td>
                                <td>
                                    <p class="strong mb-1"><?=$position->title?></p>
                                    <div class="text-secondary"><?=$position->description?></div>
                                </td>
                                <td class="text-end">
                                    CHF <?=$position->getPositionUnitprice(false)?>
                                </td>
                                <td class="text-end">
                                    <?=$position->multiplication?> <?=$position->unit?>
                                </td>
                                <td class="text-end">
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
                                <td colspan="3" class="text-end">CHF <?php echo $invoice->getTotal(false, false) ?></td>
                            </tr>
                            <?php foreach($invoice->getMwst() as $mwst): ?>
                            <tr>
                                <td colspan="3" class="text-end">
                                    Mehrwertsteuer (<?=$mwst['mwst']?>%)
                                </td>
                                <td colspan="3" class="text-end">CHF <?=$mwst['value']?></td>
                            </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="3" class="text-end text-nowrap">
                                    <strong>Rechnungsbetrag</strong>
                                </td>
                                <td colspan="3" class="text-end">
                                    <strong>CHF <?php echo $invoice->getTotal(true, true) ?></strong>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <?php if(!empty($invoice->notes_bottom)): ?>
                    <div class="row notes">
                        <?=$invoice->notes_bottom?>
                    </div>
                    <?php endif; ?>
                    <?php if(!empty($invoice->payment_terms)): ?>
                    <strong>Zahlungskondition:</strong> Zahlbar innerhalb von <?=setting('Company.payment_deadline') ?> Tagen<br>
                    <?php endif; ?>

                    <?php if(setting('Company.invoice') == 2 AND $qr): ?>
                    <div class="print-invoice">
                        <?=$qr?>
                    </div>
                    <?php elseif(setting('Company.invoice') == 1): ?>
                    <strong>Adresse:</strong> <?=setting('Company.name') ?>, <?=setting('Company.street') ?>, <?=setting('Company.postcode') ?> <?=setting('Company.city') ?><br>
                    <?php if(setting('Company.iban')): ?>
                    <strong>Konto:</strong> <?=setting('Company.iban') ?>
                    <?php else: ?>
                    <strong class="text-bg-danger">Keine IBAN hinterlegt</strong>
                    <?php endif; ?>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>



    <?= $this->endSection() ?>