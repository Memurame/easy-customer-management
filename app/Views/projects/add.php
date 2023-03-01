<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<form method="post">
    <div class="d-flex border-bottom pb-2 mb-4">
        <div class="p-1 flex-grow-1">
            <ol class="breadcrumb my-0 ">
                <li class="breadcrumb-item"><a href="<?=base_url()?>">Übersicht</a></li>
                <li class="breadcrumb-item"><a href="<?=base_url()?><?=route_to('project.index')?>">Projekte</a></li>
                <li class="breadcrumb-item active" aria-current="page">Neu</li>
            </ol>
        </div>

        <div class="">
            <button type="submit" class="btn btn-success btn-sm">Speichern</button>
        </div>
    </div>
    <?= view('templates/message_block.php') ?>
    <div class="row g-3">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <div class="row">
                <div class="col-6">
                    <label for="customer_id" class="form-label">Kunde <span class="text-danger">*</span></label>
                    <select class="form-select" name="customer_id" id="customer_id">
                        <option value"0" selected>-- Kunde auswählen --</option>
                        <?php foreach($customers as $customer): ?>
                        <option value="<?=$customer->id ?>">
                            <?= $customer->company?: $customer->contact_lastname . ' ' . $customer->contact_firstname ?>
                        </option>

                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-6">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select" name="status" id="status">
                        <option value="0" selected>-- Status wählen --</option>
                        <option value="0">Inaktiv</option>
                        <option value="1">Aktiv</option>
                        <option value="2">Archiviert</option>
                    </select>
                </div>
                <div class="col-12">
                    <label for="name" class="form-label">Projektname <span class="text-danger">*</span></label>
                    <input type="text"
                        class="form-control <?php if(session('errors.name')) : ?>is-invalid<?php endif ?>" id="name"
                        name="name" value="<?=old('name') ?>">
                </div>
                <div class="col-md-4">
                    <label for="date_offer" class="form-label">Offerten Datum</label>
                    <input type="date" class="form-control" id="date_offer" name="date_offer"
                        value="<?=old('date_offer') ?>">
                </div>
                <div class="col-md-4">
                    <label for="date_order" class="form-label">Bestellt</label>
                    <input type="date" class="form-control" id="date_order" name="date_order"
                        value="<?=old('date_order') ?>">
                </div>
                <div class="col-md-4">
                    <label for="date_finish" class="form-label">Projekt abgeschlossen</label>
                    <input type="date" class="form-control" id="date_finish" name="date_finish"
                        value="<?=old('date_finish') ?>">
                </div>
                <div class="col-12">
                    <label for="notes" class="form-label">Notizen</label>
                    <textarea class="form-control" rows="5" id="notes" name="notes"><?=old('notes') ?></textarea>
                </div>
            </div>
        </div>
    </div>
</form>




<?= $this->endSection() ?>