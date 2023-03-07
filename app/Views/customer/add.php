<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<form method="post">
    <div class="d-flex border-bottom pb-2 mb-4">
        <div class="p-1 flex-grow-1">
            <ol class="breadcrumb my-0 ">
                <li class="breadcrumb-item"><a href="<?=base_url()?>">Übersicht</a></li>
                <li class="breadcrumb-item"><a href="<?=base_url()?><?=route_to('customer.index')?>">Kunden</a></li>
                <li class="breadcrumb-item active" aria-current="page">Neu</li>
            </ol>
        </div>

        <div class="">
            <button type="submit" class="btn btn-success btn-sm">Speichern</button>
        </div>
    </div>
    <?= view('templates/message_block.php') ?>
    <div class="row g-3 pb-3">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <div class="row mb-3">
                <div class="col-2">
                    <label for="customernumber" class="form-label">Kundennummer</label>
                    <input type="text"
                        class="form-control <?php if(session('errors.customernumber')) : ?>is-invalid<?php endif ?>"
                        id="customernumber" name="customernumber" value="<?=old('customernumber') ?>">
                </div>
                <div class="col-md-10">
                    <label for="company" class="form-label">Firmenname</label>
                    <input type="text"
                        class="form-control <?php if(session('errors.company')) : ?>is-invalid<?php endif ?>"
                        id="company" name="company" value="<?=old('company') ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="contact_mail" class="form-label">E-Mail <span class="text-danger">*</span></label>
                    <input type="text"
                        class="form-control <?php if(session('errors.contact_mail')) : ?>is-invalid<?php endif ?>"
                        id="contact_mail" name="contact_mail" value="<?=old('contact_mail') ?>">
                </div>
                <div class="col-md-6">
                    <label for="contact_tel" class="form-label">Telefon <span class="text-danger">*</span></label>
                    <input type="text"
                        class="form-control <?php if(session('errors.contact_tel')) : ?>is-invalid<?php endif ?>"
                        id="contact_tel" name="contact_tel" value="<?=old('contact_tel') ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="contact_firstname" class="form-label">Vorname <span class="text-danger">*</span></label>
                    <input type="text"
                        class="form-control <?php if(session('errors.contact_firstname')) : ?>is-invalid<?php endif ?>"
                        id="contact_firstname" name="contact_firstname" value="<?=old('contact_firstname') ?>">
                </div>
                <div class="col-md-6">
                    <label for="contact_lastname" class="form-label">Nachname <span class="text-danger">*</span></label>
                    <input type="text"
                        class="form-control <?php if(session('errors.contact_lastname')) : ?>is-invalid<?php endif ?>"
                        id="contact_lastname" name="contact_lastname" value="<?=old('contact_lastname') ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-5">
                    <label for="street" class="form-label">Strasse</label>
                    <input type="text"
                        class="form-control <?php if(session('errors.street')) : ?>is-invalid<?php endif ?>" id="street"
                        name="street" value="<?=old('street') ?>">
                </div>
                <div class="col-md-2">
                    <label for="postcode" class="form-label">PLZ</label>
                    <input type="text"
                        class="form-control <?php if(session('errors.postcode')) : ?>is-invalid<?php endif ?>"
                        id="postcode" name="postcode" value="<?=old('contact_firstname') ?>">
                </div>
                <div class="col-md-5">
                    <label for="city" class="form-label">Stadt</label>
                    <input type="text"
                        class="form-control <?php if(session('errors.city')) : ?>is-invalid<?php endif ?>" id="city"
                        name="city" value="<?=old('city') ?>">
                </div>
            </div>
            <div class="row g-3 mb-3">

                <div class="col-12">
                    <label for="notes" class="form-label">Notizen</label>
                    <textarea class="form-control" rows="5" id="notes" name="notes"><?=old('notes') ?></textarea>
                </div>
            </div>
            <div class="row g-3">

                <div class="col-4">

                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select id="status" name="status" class="form-select">
                        <option value="0">Inaktiv</option>
                        <option value="1" selected>Aktiv</option>
                    </select>

                </div>
            </div>
</form>




<?= $this->endSection() ?>