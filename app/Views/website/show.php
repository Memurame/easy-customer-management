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
                <li class="breadcrumb-item active" aria-current="page"><?=$website->contact_lastname?> <?=$website->contact_firstname?></li>
            </ol>
        </div>

        <div class="">
            <a href="<?=base_url()?><?=route_to('website.edit', $website->id)?>" class="btn btn-primary btn-sm">Bearbeiten</a>
        </div>
    </div>
    <div class="row g-3">
        <div class="col-6">
            <div class="row mb-3">
                <div class="col-sm-5">
                    <h6 class="mb-0">Name, Vorname</h6>
                </div>
                <div class="col-sm-7 text-secondary">
                    <?php echo $website->contact_lastname . ' ' . $website->contact_firstname ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-5">
                    <h6 class="mb-0">Firma</h6>
                </div>
                <div class="col-sm-7 text-secondary">
                    <?= $website->contact_company ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-5">
                    <h6 class="mb-0">E-Mail</h6>
                </div>
                <div class="col-sm-7 text-secondary">
                    <a href="mailto:<?= $website->contact_mail ?>"><?= $website->contact_mail ?></a>
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
                    <h6 class="mb-0">Update Abo</h6>
                </div>
                <div class="col-sm-7 text-secondary">
                    <?php if($website->update_abo != 'Kein Abo'):?>
                        <span class="badge rounded-pill text-bg-success"><?=$website->update_abo?></span>
                    <?php else:?>
                        <span class="badge rounded-pill text-bg-danger"><?=$website->update_abo?></span>
                    <?php endif;?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-5">
                    <h6 class="mb-0">BEBV Mitglied</h6>
                </div>
                <div class="col-sm-7 text-secondary">
                    <?php if($website->bebv_member):?>
                        <span class="badge rounded-pill text-bg-success">Ja</span>
                    <?php else:?>
                        <span class="badge rounded-pill text-bg-danger">Nein</span>
                    <?php endif;?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-5">
                    <h6 class="mb-0">PopularFX Lizenz</h6>
                </div>
                <div class="col-sm-7 text-secondary">
                    <?php if($website->license_popularfx):?>
                        <span class="badge rounded-pill text-bg-success">Ja</span>
                    <?php else:?>
                        <span class="badge rounded-pill text-bg-danger">Nein</span>
                    <?php endif;?>
                </div>
            </div>
            <div class="row mb-3">
                <textarea class="form-control" rows="8"><?= $website->notes ?></textarea>
            </div>
        </div>
        <div class="col-6">
            <table class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>Datum</th>
                        <th>Bezahlt</th>
                        <th>Erneuern</th>
                    </tr>
                </thead>
                <tbody>
                
            
                </tbody>
            </table>
        </div>
    </div>





<?= $this->endSection() ?>
