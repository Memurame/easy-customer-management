<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<?php
$offer = ($project->date_offer) ? new DateTime($project->date_offer) : null;
$order = ($project->date_order) ? new DateTime($project->date_order) : null;
$finish = ($project->date_finish) ? new DateTime($project->date_finish) : null;

?>

<div class="d-flex border-bottom pb-2 mb-4">
    <div class="p-1 flex-grow-1">
        <ol class="breadcrumb my-0 ">
            <li class="breadcrumb-item"><a href="<?=base_url()?>">Übersicht</a></li>
            <li class="breadcrumb-item"><a href="<?=base_url()?><?=route_to('project.index')?>">Projekte</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?=$project->name?></li>
        </ol>
    </div>

    <div class="">
        <a href="<?=base_url()?><?=route_to('project.edit', $project->id)?>"
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
                <?php if($project->status == 1):?>
                <span class="badge text-bg-success">Aktiv</span>
                <?php elseif($project->status == 2):?>
                <span class="badge text-bg-secondary">Archiviert</span>
                <?php else:?>
                <span class="badge text-bg-danger">Inaktiv</span>
                <?php endif;?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-5">
                <h6 class="mb-0">Projektname</h6>
            </div>
            <div class="col-sm-7 text-secondary">
                <?php echo $project->name ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-5">
                <h6 class="mb-0">Kunde</h6>
            </div>
            <div class="col-sm-7 text-secondary">
                <?= $project->getCustomerInfo('company')?: '---' ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-5">
                <h6 class="mb-0">Offerte erstellt</h6>
            </div>
            <div class="col-sm-7 text-secondary">
                <?= ($offer) ? $offer->format('d.m.Y') : '---'?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-5">
                <h6 class="mb-0">Projekt gestartet</h6>
            </div>
            <div class="col-sm-7 text-secondary">
                <?= ($order) ? $order->format('d.m.Y') : '---'?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-5">
                <h6 class="mb-0">Projekt abgeschlossen</h6>
            </div>
            <div class="col-sm-7 text-secondary">
                <?= ($finish) ? $finish->format('d.m.Y') : '---'?>
            </div>
        </div>
        <div class="row mb-3">
            <textarea class="form-control" rows="8"><?= $project->notes ?></textarea>
        </div>
    </div>
    <div class="col-6">

    </div>
</div>





<?= $this->endSection() ?>