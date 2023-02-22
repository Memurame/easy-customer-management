<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<?php
$date = ($invoice->invoice) ? new DateTime($invoice->invoice) : null;

?>

<div class="d-flex border-bottom pb-2 mb-4">
    <div class="p-1 flex-grow-1">
        <ol class="breadcrumb my-0 ">
            <li class="breadcrumb-item"><a href="<?=base_url()?>">Übersicht</a></li>
            <li class="breadcrumb-item"><a href="<?=base_url()?><?=route_to('invoice.index')?>">Rechnungen</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?=$invoice->dscription?></li>
        </ol>
    </div>

    <div class="">
        <a href="<?=base_url()?><?=route_to('invoice.edit', $invoice->id)?>"
            class="btn btn-outline-primary btn-sm">Bearbeiten</a>
    </div>
</div>
<div class="row g-3">
    <div class="col-6">
        <div class="row mb-3">
            <div class="col-sm-5">
                <h6 class="mb-0">Status</h6>
            </div>
            <div class="col-sm-7 text-secondary">
                <?php if($invoice->status == 1):?>
                <span class="badge text-bg-success">Aktiv</span>
                <?php elseif($invoice->status == 2):?>
                <span class="badge text-bg-secondary">Archiviert</span>
                <?php else:?>
                <span class="badge text-bg-danger">Inaktiv</span>
                <?php endif;?>
            </div>
        </div>
        <div class="row mb-3">
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
                <span class="badge text-bg-warning">Pendent</span>
                <?php elseif($invoice->paid == 3):?>
                <span class="badge text-bg-danger">Überfällig</span>
                <?php else:?>
                <span class="badge text-bg-warning">Offen</span>
                <?php endif;?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-5">
                <h6 class="mb-0">Bezechnung</h6>
            </div>
            <div class="col-sm-7 text-secondary">
                <?php echo $invoice->description ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-5">
                <h6 class="mb-0">Betrag</h6>
            </div>
            <div class="col-sm-7 text-secondary">
                <?php echo $invoice->amount ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-5">
                <h6 class="mb-0">Kunde</h6>
            </div>
            <div class="col-sm-7 text-secondary">
                <?=($invoice->getCustomerInfo('company') ? '<a href="'.base_url().route_to('customer.show', $invoice->getCustomerInfo('id')).'">'.$invoice->getCustomerInfo('company').'</a>' : '---') ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-5">
                <h6 class="mb-0">Projekt</h6>
            </div>
            <div class="col-sm-7 text-secondary">
                <?=($invoice->getProjectInfo('name') ? '<a href="'.base_url().route_to('project.show', $invoice->getProjectInfo('id')).'">'.$invoice->getProjectInfo('name').'</a>' : '---') ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-5">
                <h6 class="mb-0">Webseite</h6>
            </div>
            <div class="col-sm-7 text-secondary">
                <?=($invoice->getWebsiteInfo('website_url') ? '<a href="'.base_url().route_to('website.show', $invoice->getWebsiteInfo('id')).'">'.$invoice->getWebsiteInfo('website_url').'</a>' : '---') ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-5">
                <h6 class="mb-0">Rechnungsdatum</h6>
            </div>
            <div class="col-sm-7 text-secondary">
                <?= ($date) ? $date->format('d.m.Y') : '---'?>
            </div>
        </div>
        <div class="row mb-3">
            <textarea class="form-control" rows="8"><?= $invoice->notes ?></textarea>
        </div>
    </div>
    <div class="col-6">

    </div>
</div>





<?= $this->endSection() ?>