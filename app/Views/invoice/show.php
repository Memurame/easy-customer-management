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
                    <?php echo $invoice->description ?>
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="<?=base_url(route_to('invoice.index'))?>" class="btn btn-secondary d-none d-sm-inline-block">
                        Zurück
                    </a>
                    <!--
                    <a href="<?=base_url(route_to('invoice.export', $invoice->id))?>" target="_blank" class="btn btn-primary d-none d-sm-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-send" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M10 14l11 -11"></path>
                            <path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5"></path>
                        </svg>
                        Mail
                    </a>
                    <a href="<?=base_url(route_to('invoice.export', $invoice->id))?>" target="_blank" class="btn btn-primary d-none d-sm-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-share" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M6 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                            <path d="M18 6m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                            <path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                            <path d="M8.7 10.7l6.6 -3.4"></path>
                            <path d="M8.7 13.3l6.6 3.4"></path>
                        </svg>
                        Teilen
                    </a>
                    -->
                    <?php if($invoice->id != setting('App.invoiceTemplateId')): ?>
                    <a href="<?=base_url(route_to('invoice.export', $invoice->id))?>" class="btn btn-primary d-none d-sm-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-printer" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2"></path>
                            <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4"></path>
                            <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z"></path>
                        </svg>
                        Vorschau
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <?php if($invoice->id != setting('App.invoiceTemplateId')): ?>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Rechnungsinfo</h3>
                        <div class="card-actions">
                            <?php if(auth()->user()->can('invoice.edit')): ?>
                            <a href="<?=base_url(route_to('invoice.edit', $invoice->id))?>?ref=show" class="btn btn-primary">
                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                    <path d="M16 5l3 3"></path>
                                </svg>
                                Bearbeiten
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="row mb-2">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">Tags</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        <?php if($invoice->renew_interval == 1):?>
                                        <span class="badge text-bg-<?=($invoice->renew) ? 'success' : 'danger'?>">Monatlich
                                            (Rechnungsdatum)</span>
                                        <?php elseif($invoice->renew_interval == 2):?>
                                        <span class="badge text-bg-<?=($invoice->renew) ? 'success' : 'danger'?>">Monatlich
                                            (1. im Monat)</span>
                                        <?php elseif($invoice->renew_interval == 3):?>
                                        <span class="badge text-bg-<?=($invoice->renew) ? 'success' : 'danger'?>">Jährlich
                                            (Rechnungsdatum)</span>
                                        <?php elseif($invoice->renew_interval == 4):?>
                                        <span class="badge text-bg-<?=($invoice->renew) ? 'success' : 'danger'?>">Jährlich
                                            (1. Januar)</span>
                                        <?php else:?>
                                        <span class="badge text-bg-<?=($invoice->renew) ? 'success' : 'danger'?>">Einmalig</span>
                                        <?php endif;?>

                                        <?php if($invoice->paid == 1):?>
                                        <span class="badge text-bg-success">Bezahlt</span>
                                        <?php elseif($invoice->paid == 2):?>
                                        <span class="badge text-bg-warning">Rechnung generieren</span>
                                        <?php elseif($invoice->paid == 3):?>
                                        <span class="badge text-bg-danger">Überfällig</span>
                                        <?php elseif($invoice->paid == 4):?>
                                        <span class="badge text-bg-info">Geplant</span>
                                        <?php elseif($invoice->paid == 5):?>
                                        <span class="badge text-bg-dark">Entwurf</span>
                                        <?php else:?>
                                        <span class="badge text-bg-warning">Offen</span>
                                        <?php endif;?>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">Bezechnung</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        <?php echo $invoice->description ?>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">Betrag</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        CHF <?php echo $invoice->getTotal() ?>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">Rechnungsdatum</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        <?= ($date) ? $date->format('d.m.Y') : '---'?>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">Kunde</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        <?php if(auth()->user()->can('invoice.edit')): ?>
                                        <a href="<?=base_url(route_to('customer.show', $invoice->getCustomerInfo('id')))?>"><?=$invoice->getCustomerInfo('customername')?></a>
                                        <?php else: ?>
                                        <?=$invoice->getCustomerInfo('customername')?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row mb-2">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">Projekt</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        <?php if(auth()->user()->can('invoice.edit')): ?>
                                        <?=($invoice->getProjectInfo('name') ? '<a href="'.base_url(route_to('project.show', $invoice->getProjectInfo('id'))).'">'.$invoice->getProjectInfo('name').'</a>' : '---') ?>
                                        <?php else: ?>
                                        <?=($invoice->getProjectInfo('name') ? $invoice->getProjectInfo('name') : '---') ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">Webseite</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        <?php if(auth()->user()->can('invoice.edit')): ?>
                                        <?=($invoice->getWebsiteInfo('website_url') ? '<a href="'.base_url(route_to('website.show', $invoice->getWebsiteInfo('id'))).'">'.$invoice->getWebsiteInfo('website_url').'</a>' : '---') ?>
                                        <?php else: ?>
                                        <?=($invoice->getWebsiteInfo('website_url') ? $invoice->getWebsiteInfo('website_url') : '---') ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">Zuständig</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        <?=$invoice->contact_name ?: '---' ?>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">Kontakt E-Mail</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        <?=$invoice->contact_mail ?: '---' ?>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">Kontakt Telefon</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        <?=$invoice->contact_phone ?: '---' ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Positionen</h3>
                        <div class="card-actions">
                            <?php if(auth()->user()->can('invoice.edit')): ?>

                            <a href="<?=base_url(route_to('invoicepos.add', $invoice->id))?>" class="btn btn-primary">
                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M12 5l0 14"></path>
                                    <path d="M5 12l14 0"></path>
                                </svg>
                                Position
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-body">


                        <table class="table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Titel</th>
                                    <th>Einzelpreis</th>
                                    <th>Menge</th>
                                    <th>MwSt</th>
                                    <th>Positionspreis (inkl. MwSt)</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($invoice->getPositions() as $position): ?>
                                <tr>
                                    <td class="align-middle">
                                        <?=$position->position?>
                                    </td>
                                    <td class="align-middle">
                                        <strong><?=$position->title?></strong><br><?=$position->description?>
                                    </td>
                                    <td class="align-middle">
                                        CHF <?=$position->price?>
                                        <span style="font-size:11px"><?= ($position->price_inkl) ? '(inkl. MwSt)' : '(exkl. MwSt)' ?></span>
                                    </td>
                                    <td class="align-middle">
                                        <?=$position->multiplication?> <?=$position->unit?>
                                    </td>
                                    <td class="align-middle">
                                        <?=($position->mwst >= 0) ? $position->mwst .'%' : 'inkl.' ?>
                                    </td>
                                    <td class="align-middle">
                                        CHF <?=$position->getPositionTotal()?>
                                    </td>
                                    <td class="text-end">
                                        <?php if(auth()->user()->can('invoice.edit')): ?>
                                        <div class="dropdown">
                                            <button class="btn dropdown-toggle align-text-top" data-bs-toggle="dropdown">
                                                Aktion
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <?php if($invoice->id != setting('App.invoiceTemplateId')): ?>
                                                <button class="dropdown-item text-primary action-copyinvoicepos" data-id="<?=$position->id?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                                        <path d="M21 21l-6 -6"></path>
                                                    </svg>
                                                    Pos. als Vorlage speichern
                                                </button>
                                                <?php endif; ?>

                                                <a href="<?=base_url(route_to('invoicepos.edit', $position->id))?>" class="dropdown-item">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                                        <path d="M16 5l3 3"></path>
                                                    </svg>
                                                    Bearbeiten
                                                </a>

                                                <button class="text-danger dropdown-item delete-invoicepos" data-id="<?=$invoice->id?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M4 7l16 0"></path>
                                                        <path d="M10 11l0 6"></path>
                                                        <path d="M14 11l0 6"></path>
                                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                    </svg>
                                                    Löschen
                                                </button>

                                            </div>
                                        </div>

                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>





<?= $this->endSection() ?>