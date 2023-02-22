<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<?php


?>

<div class="d-flex border-bottom pb-2 mb-4">
    <div class="p-1 flex-grow-1">
        <ol class="breadcrumb my-0 ">
            <li class="breadcrumb-item"><a href="<?=base_url()?>">Übersicht</a></li>
            <li class="breadcrumb-item"><a href="<?=base_url()?><?=route_to('customer.index')?>">Kunden</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?=$customer->contact_lastname?>
                <?=$customer->contact_firstname?></li>
        </ol>
    </div>

    <div class="">
        <a href="<?=base_url()?><?=route_to('customer.edit', $customer->id)?>"
            class="btn btn-primary btn-sm">Bearbeiten</a>
    </div>
</div>
<div class="row g-3">
    <div class="col-6">
        <div class="row mb-3">
            <div class="col-sm-5">
                <h6 class="mb-0">Status</h6>
            </div>
            <div class="col-sm-7 text-secondary">
                <?php if($customer->status == 1):?>
                <span class="badge rounded-pill text-bg-success">Aktiv</span>
                <?php else:?>
                <span class="badge rounded-pill text-bg-danger">Inaktiv</span>
                <?php endif;?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-5">
                <h6 class="mb-0">Kundennummer</h6>
            </div>
            <div class="col-sm-7 text-secondary">
                <?php echo $customer->customernumber ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-5">
                <h6 class="mb-0">Name, Vorname</h6>
            </div>
            <div class="col-sm-7 text-secondary">
                <?php echo $customer->contact_lastname . ' ' . $customer->contact_firstname ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-5">
                <h6 class="mb-0">E-Mail</h6>
            </div>
            <div class="col-sm-7 text-secondary">
                <a href="mailto:<?= $customer->contact_mail ?>"><?= $customer->contact_mail ?></a>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-5">
                <h6 class="mb-0">Firma</h6>
            </div>
            <div class="col-sm-7 text-secondary">
                <?= $customer->company ?>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-sm-5">
                <h6 class="mb-0">Adresse</h6>
            </div>
            <div class="col-sm-7 text-secondary">
                <?= $customer->street ?><br>
                <?= $customer->postcode ?> <?= $customer->city ?>
            </div>
        </div>
        <div class="row mb-3">
            <textarea class="form-control" rows="8"><?= $customer->notes ?></textarea>
        </div>
    </div>
    <div class="col-6">

    </div>
</div>





<?= $this->endSection() ?>