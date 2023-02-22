<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<?php


$installed = ($website->website_installed) ? new DateTime($website->website_installed) : null;
$golive = ($website->website_live) ? new DateTime($website->website_live) : null;

?>

<div class="d-flex border-bottom pb-2 mb-4">
    <div class="p-1 flex-grow-1">
        <ol class="breadcrumb my-0 ">
            <li class="breadcrumb-item"><a href="<?=base_url()?>">Übersicht</a></li>
            <li class="breadcrumb-item"><a href="<?=base_url()?><?=route_to('website.index')?>">Webseiten</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?=$website->contact_lastname?>
                <?=$website->contact_firstname?></li>
        </ol>
    </div>

    <div class="">
        <a href="<?=base_url()?><?=route_to('website.edit', $website->id)?>"
            class="btn btn-primary btn-sm">Bearbeiten</a>
    </div>
</div>
<div class="row g-3">
    <div class="col-6">
        <div class="row mb-3">
            <div class="col-sm-5">
                <h6 class="mb-0">Name, Vorname</h6>
            </div>
            <div class="col-sm-7 text-secondary">
                <?php echo $website->getCustomerInfo('contact_lastname') . ' ' . $website->getCustomerInfo('contact_firstname') ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-5">
                <h6 class="mb-0">Firma</h6>
            </div>
            <div class="col-sm-7 text-secondary">
                <?=($website->getCustomerInfo('company') ? '<a href="'.base_url().route_to('customer.show', $website->getCustomerInfo('id')).'">'.$website->getCustomerInfo('company').'</a>' : '---') ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-5">
                <h6 class="mb-0">E-Mail</h6>
            </div>
            <div class="col-sm-7 text-secondary">
                <a
                    href="mailto:<?= $website->getCustomerInfo('contact_mail') ?>"><?= $website->getCustomerInfo('contact_mail') ?></a>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-5">
                <h6 class="mb-0">Webseite Installiert</h6>
            </div>
            <div class="col-sm-7 text-secondary">
                <?= ($website->website_installed) ? $installed->format('d.m.Y') : '---'?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-5">
                <h6 class="mb-0">Webseite aufschaltung</h6>
            </div>
            <div class="col-sm-7 text-secondary">
                <?= ($website->website_live) ? $golive->format('d.m.Y') : '---'?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-5">
                <h6 class="mb-0">Tags</h6>
            </div>
            <div class="col-sm-7 text-secondary">
                <?php foreach($website->getTags() as $tag):?>
                <span
                    class="badge rounded-pill <?=($tag['class']) ? $tag['class'] : 'text-bg-secondary'?>"><?=$tag['name']?></span>
                <?php endforeach;?>
            </div>
        </div>
        <div class="row mb-3">
            <textarea class="form-control" rows="8"><?= $website->notes ?></textarea>
        </div>
    </div>
    <div class="col-6">

    </div>
</div>





<?= $this->endSection() ?>