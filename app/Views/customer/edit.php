<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<form method="post">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Kunde
                    </div>
                    <h2 class="page-title">
                        <?php echo $customer->customername ?>
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-4">

                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select id="status" name="status" class="form-select tomselect-default">
                                <option value="0" <?= ($customer->status == 0) ? 'selected' : null ?>>Inaktiv</option>
                                <option value="1" <?= ($customer->status == 1) ? 'selected' : null ?>>Aktiv</option>
                            </select>
                            <div class="invalid-feedback"><?= session('errors.status') ?></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-2">
                            <label for="addressnumber" class="form-label">Adressnummer</label>
                            <input type="text" class="form-control <?php if(session('errors.addressnumber')) : ?>is-invalid<?php endif ?>" id="addressnumber" name="addressnumber"
                                value="<?=$customer->addressnumber ?>">
                            <div class="invalid-feedback"><?= session('errors.addressnumber') ?></div>
                        </div>
                        <div class="col-md-10">
                            <label for="customername" class="form-label">Kundenname <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php if(session('errors.customername')) : ?>is-invalid<?php endif ?>" id="customername" name="customername"
                                value="<?=$customer->customername ?>">
                            <div class="invalid-feedback"><?= session('errors.customername') ?></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="mail" class="form-label">E-Mail</label>
                            <input type="email" class="form-control <?php if(session('errors.mail')) : ?>is-invalid<?php endif ?>" id="mail" name="mail" value="<?=$customer->mail ?>">
                            <div class="invalid-feedback"><?= session('errors.mail') ?></div>
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Telefon</label>
                            <input type="text" class="form-control <?php if(session('errors.phone')) : ?>is-invalid<?php endif ?>" id="phone" name="phone" value="<?=$customer->phone ?>">
                            <div class="invalid-feedback"><?= session('errors.phone') ?></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-5">
                            <label for="street" class="form-label">Strasse <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php if(session('errors.street')) : ?>is-invalid<?php endif ?>" id="street" name="street" value="<?=$customer->street ?>">
                            <div class="invalid-feedback"><?= session('errors.street') ?></div>
                        </div>
                        <div class="col-md-2">
                            <label for="postcode" class="form-label">PLZ <span class="text-danger">*</span></label>
                            <input type="number" class="form-control <?php if(session('errors.postcode')) : ?>is-invalid<?php endif ?>" id="postcode" name="postcode" value="<?=$customer->postcode ?>">
                            <div class="invalid-feedback"><?= session('errors.postcode') ?></div>
                        </div>
                        <div class="col-md-5">
                            <label for="city" class="form-label">Stadt <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php if(session('errors.city')) : ?>is-invalid<?php endif ?>" id="city" name="city" value="<?=$customer->city ?>">
                            <div class="invalid-feedback"><?= session('errors.city') ?></div>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">

                        <div class="col-12">
                            <label for="notes" class="form-label">Notizen</label>
                            <textarea class="form-control" rows="5" id="notes" name="notes"><?=$customer->notes ?></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">

                            <label for="billing_contact" class="form-label">Rechnungskontakt</label>
                            <select id="billing_contact" name="billing_contact" class="form-select tomselect-default">
                                <option value="0">-- Kein separater Rechnungskontakt --</option>
                                <?php foreach($contacts as $contact): ?>
                                <option value="<?=$contact->id ?>" <?= ($customer->billing_contact == $contact->id) ? 'selected' : null ?>><?=$contact->lastname ?> <?=$contact->firstname ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text text-info">
                                Wenn nicht ausgewählt, wird die Hauptadresse des Kunden als Rechnungsadresse verwendet.
                            </div>
                        </div>
                        <div class="col-4">

                            <label for="main_contact" class="form-label">Hauptkontakt <span class="text-danger">*</span></label>
                            <select id="main_contact" name="main_contact" class="form-select tomselect-default">
                                <?php foreach($contacts as $contact): ?>
                                <option value="<?=$contact->id ?>" <?= ($customer->main_contact == $contact->id) ? 'selected' : null ?>><?=$contact->lastname ?> <?=$contact->firstname ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="btn-list justify-content-end">
                        <a href="<?=base_url(route_to('customer.show', $customer->id))?>" class="btn">
                            Abbrechen
                        </a>
                        <button class="btn btn-success d-none d-sm-inline-block">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"></path>
                                <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                <path d="M14 4l0 4l-6 0l0 -4"></path>
                            </svg>
                            Speichern
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>




<?= $this->endSection() ?>