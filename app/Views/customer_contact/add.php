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
                            Neue Kontaktperson
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
                            <div class="col-md-3">
                                <label for="typ" class="form-label">Typ <span class="text-danger">*</span></label>
                                <select id="typ" name="typ"
                                        class="form-select tomselect-default <?php if(session('errors.typ')) : ?>is-invalid<?php endif ?>">
                                    <option value="GF">Geschäftsführer</option>
                                    <option value="AP" selected>Ansprechsperson</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="firstname" class="form-label">Vorname <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control <?php if(session('errors.firstname')) : ?>is-invalid<?php endif ?>"
                                       id="firstname" name="firstname" value="<?=old('firstname') ?>">
                                <div class="invalid-feedback"><?= session('errors.firstname') ?></div>
                            </div>
                            <div class="col-md-6">
                                <label for="lastname" class="form-label">Nachname <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control <?php if(session('errors.lastname')) : ?>is-invalid<?php endif ?>"
                                       id="lastname" name="lastname" value="<?=old('lastname') ?>">
                                <div class="invalid-feedback"><?= session('errors.lastname') ?></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="mail" class="form-label">E-Mail</label>
                                <input type="text"
                                       class="form-control <?php if(session('errors.mail')) : ?>is-invalid<?php endif ?>"
                                       id="mail" name="mail" value="<?=old('mail') ?>">
                                <div class="invalid-feedback"><?= session('errors.mail') ?></div>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Telefon</label>
                                <input type="text"
                                       class="form-control <?php if(session('errors.phone')) : ?>is-invalid<?php endif ?>"
                                       id="phone" name="phone" value="<?=old('phone') ?>">
                                <div class="invalid-feedback"><?= session('errors.phone') ?></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-5">
                                <label for="street" class="form-label">Strasse</label>
                                <input type="text"
                                       class="form-control <?php if(session('errors.street')) : ?>is-invalid<?php endif ?>" id="street"
                                       name="street" value="<?=old('street') ?>">
                                <div class="invalid-feedback"><?= session('errors.street') ?></div>
                            </div>
                            <div class="col-md-2">
                                <label for="postcode" class="form-label">PLZ</label>
                                <input type="text"
                                       class="form-control <?php if(session('errors.postcode')) : ?>is-invalid<?php endif ?>"
                                       id="postcode" name="postcode" value="<?=old('postcode') ?>">
                                <div class="invalid-feedback"><?= session('errors.postcode') ?></div>
                            </div>
                            <div class="col-md-5">
                                <label for="city" class="form-label">Stadt</label>
                                <input type="text"
                                       class="form-control <?php if(session('errors.city')) : ?>is-invalid<?php endif ?>" id="city"
                                       name="city" value="<?=old('city') ?>">
                                <div class="invalid-feedback"><?= session('errors.city') ?></div>
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
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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