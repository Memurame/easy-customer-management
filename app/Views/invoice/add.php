<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<form method="post">
    <div class="d-flex border-bottom pb-2 mb-4">
        <div class="p-1 flex-grow-1">
            <ol class="breadcrumb my-0 ">
                <li class="breadcrumb-item"><a href="<?=base_url()?>">Übersicht</a></li>
                <li class="breadcrumb-item"><a href="<?=base_url()?><?=route_to('invoice.index')?>">Rechnungen</a></li>
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
            <div class="row mb-3">
                <div class="col-9">
                    <label for="description" class="form-label">Bezeichnung <span class="text-danger">*</span></label>
                    <input type="text"
                        class="form-control <?php if(session('errors.description')) : ?>is-invalid<?php endif ?>"
                        id="description" name="description" value="<?=old('description') ?>">
                </div>
                <div class="col-3">
                    <label for="amount" class="form-label">Betrag <span class="text-danger">*</span></label>
                    <input type="text"
                        class="form-control <?php if(session('errors.amount')) : ?>is-invalid<?php endif ?>" id="amount"
                        name="amount" value="<?=old('amount') ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="customer_id" class="form-label">Kunde <span class="text-danger">*</span></label>
                    <select id="customer_id" name="customer_id" class="form-select ">
                        <option value="0" selected>-- Bitte auswählen --</option>
                        <?php foreach($customers as $index => $customer): ?>
                        <option value="<?=$customer->id?>">
                            <?= $customer->company?: $customer->contact_lastname . ' ' . $customer->contact_firstname ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="project_id" class="form-label">Projekt <span class="text-danger">*</span></label>
                    <select id="project_id" name="project_id" class="form-select ">
                        <option value="0" selected>-- Bitte auswählen --</option>
                        <?php foreach($projects as $index => $project): ?>
                        <option value="<?=$project->id?>"><?=$project->name?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="website_id" class="form-label">Webseite <span class="text-danger">*</span></label>
                    <select id="website_id" name="website_id" class="form-select ">
                        <option value="0" selected>-- Bitte auswählen --</option>
                        <?php foreach($websites as $index => $website): ?>
                        <option value="<?=$website->id?>"><?=$website->website_url?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="invoice" class="form-label">Rechnungsdatum</label>
                    <input type="date" class="form-control" id="invoice" name="invoice" value="<?=old('invoice') ?>">
                </div>
                <div class="col-md-6">
                    <label for="paid" class="form-label">Bezahlt <span class="text-danger">*</span></label>
                    <select id="paid" name="paid" class="form-select">
                        <option value="0" selected>Nein (Rechnung versendet)</option>
                        <option value="1">Ja</option>
                        <option value="2">Rechnung generieren</option>
                        <option value="3">Überfällig</option>
                        <option value="4">Geplannt</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="renew_interval" class="form-label">Intervall <span class="text-danger">*</span></label>
                    <select id="renew_interval" name="renew_interval" class="form-select">
                        <option value="0" selected>Einmalig</option>
                        <option value="1">Monatlich (Rechnungsdatum)</option>
                        <option value="2">Monatlich (1. im Monat)</option>
                        <option value="3">Jährlich (Rechnungsdatum)</option>
                        <option value="4">Jährlich (1. Januar)</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="renew" class="form-label">Automatisch erneuern <span
                            class="text-danger">*</span></label>
                    <select id="renew" name="renew" class="form-select">
                        <option value="0" selected>Nein</option>
                        <option value="1">Ja</option>

                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <label for="notes" class="form-label">Notizen</label>
                    <textarea class="form-control" rows="5" id="notes" name="notes"><?=old('notes') ?></textarea>
                </div>
            </div>
        </div>
    </div>
</form>




<?= $this->endSection() ?>