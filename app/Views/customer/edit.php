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
        <div class="col-2">
            <label for="customernumber" class="form-label">Kundennummer</label>
            <input type="text"
                class="form-control <?php if(session('errors.customernumber')) : ?>is-invalid<?php endif ?>"
                id="customernumber" name="customernumber" value="<?=$customer->customernumber ?>">
        </div>
        <div class="col-md-10">
            <label for="company" class="form-label">Firmenname</label>
            <input type="text" class="form-control <?php if(session('errors.company')) : ?>is-invalid<?php endif ?>"
                id="company" name="company" value="<?=$customer->company ?>">
        </div>
        <div class="col-md-4">
            <label for="contact_mail" class="form-label">E-Mail <span class="text-danger">*</span></label>
            <input type="text"
                class="form-control <?php if(session('errors.contact_mail')) : ?>is-invalid<?php endif ?>"
                id="contact_mail" name="contact_mail" value="<?=$customer->contact_mail ?>">
        </div>
        <div class="col-md-4">
            <label for="contact_firstname" class="form-label">Vorname <span class="text-danger">*</span></label>
            <input type="text"
                class="form-control <?php if(session('errors.contact_firstname')) : ?>is-invalid<?php endif ?>"
                id="contact_firstname" name="contact_firstname" value="<?=$customer->contact_firstname ?>">
        </div>
        <div class="col-md-4">
            <label for="contact_lastname" class="form-label">Nachname <span class="text-danger">*</span></label>
            <input type="text"
                class="form-control <?php if(session('errors.contact_lastname')) : ?>is-invalid<?php endif ?>"
                id="contact_lastname" name="contact_lastname" value="<?=$customer->contact_lastname ?>">
        </div>
        <div class="col-md-5">
            <label for="street" class="form-label">Strasse</label>
            <input type="text" class="form-control <?php if(session('errors.street')) : ?>is-invalid<?php endif ?>"
                id="street" name="street" value="<?=$customer->street ?>">
        </div>
        <div class="col-md-2">
            <label for="postcode" class="form-label">PLZ</label>
            <input type="text" class="form-control <?php if(session('errors.postcode')) : ?>is-invalid<?php endif ?>"
                id="postcode" name="postcode" value="<?=$customer->postcode ?>">
        </div>
        <div class="col-md-5">
            <label for="city" class="form-label">Stadt</label>
            <input type="text" class="form-control <?php if(session('errors.city')) : ?>is-invalid<?php endif ?>"
                id="city" name="city" value="<?=$customer->city ?>">
        </div>
    </div>
    <div class="row g-3 pb-3">

        <div class="col-12">
            <label for="notes" class="form-label">Notizen</label>
            <textarea class="form-control" rows="5" id="notes" name="notes"><?=$customer->notes ?></textarea>
        </div>
    </div>
    <div class="row g-3">

        <div class="col-4">

            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
            <select id="status" name="status" class="form-select">
                <option value="0" <?= ($customer->status == 0) ? 'selected' : null ?>>Inaktiv</option>
                <option value="1" <?= ($customer->status == 1) ? 'selected' : null ?>>Aktiv</option>
            </select>

        </div>
    </div>
</form>




<?= $this->endSection() ?>