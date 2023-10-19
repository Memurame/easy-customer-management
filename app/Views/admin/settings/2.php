<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>


<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    System Einstellungen
                </h2>
            </div>
        </div>
    </div>
</div>
<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="row g-0">
                <div class="col-12 col-md-3 border-end">
                    <div class="card-body">
                        <div class="list-group list-group-transparent">
                            <a href="<?=base_url(route_to('setting.1'))?>" class="list-group-item list-group-item-action">Allgemein</a>
                        </div>
                        <div class="list-group list-group-transparent">
                            <a href="<?=base_url(route_to('setting.2'))?>" class="list-group-item list-group-item-action d-flex align-items-center active">Firmenangaben</a>
                        </div>
                        <div class="list-group list-group-transparent">
                            <a href="<?=base_url(route_to('setting.3'))?>" class="list-group-item list-group-item-action">E-Mail</a>
                        </div>
                        <div class="list-group list-group-transparent">
                            <a href="<?=base_url(route_to('setting.4'))?>" class="list-group-item list-group-item-action">Sicherheit</a>
                        </div>

                    </div>
                </div>
                <div class="col-12 col-md-9 d-flex flex-column">
                    <form method="post">
                        <?= csrf_field() ?>
                        <div class="card-body">
                            <h2 class="mb-4">Firmenangaben</h2>
                            <h3 class="card-title">Angabe zur Firma</h3>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="company_name" class="form-label">Firmenname <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?php if(session('errors.company_name')) : ?>is-invalid<?php endif ?>" id="company_name" name="company_name"
                                        value="<?=service('settings')->get('Company.name'); ?>">
                                    <div class="invalid-feedback"><?= session('errors.company_name') ?></div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="company_street" class="form-label">Strasse <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?php if(session('errors.company_street')) : ?>is-invalid<?php endif ?>" id="company_street" name="company_street"
                                        value="<?=service('settings')->get('Company.street'); ?>">
                                    <div class="invalid-feedback"><?= session('errors.company_street') ?></div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="company_postcode" class="form-label">PLZ <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?php if(session('errors.company_postcode')) : ?>is-invalid<?php endif ?>" id="company_postcode" name="company_postcode"
                                        value="<?=service('settings')->get('Company.postcode'); ?>">
                                    <div class="invalid-feedback"><?= session('errors.company_postcode') ?></div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="company_city" class="form-label">Ort <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?php if(session('errors.company_city')) : ?>is-invalid<?php endif ?>" id="company_city" name="company_city"
                                        value="<?=service('settings')->get('Company.city'); ?>">
                                    <div class="invalid-feedback"><?= session('errors.company_city') ?></div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="company_phone" class="form-label">Telefon <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?php if(session('errors.company_phone')) : ?>is-invalid<?php endif ?>" id="company_phone" name="company_phone"
                                        value="<?=service('settings')->get('Company.phone'); ?>">
                                    <div class="invalid-feedback"><?= session('errors.company_phone') ?></div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="company_mail" class="form-label">Mail <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?php if(session('errors.company_mail')) : ?>is-invalid<?php endif ?>" id="company_mail" name="company_mail"
                                        value="<?=service('settings')->get('Company.mail'); ?>">
                                    <div class="invalid-feedback"><?= session('errors.company_mail') ?></div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="company_website" class="form-label">Webseite</label>
                                    <input type="text" class="form-control <?php if(session('errors.company_website')) : ?>is-invalid<?php endif ?>" id="company_website" name="company_website"
                                        value="<?=service('settings')->get('Company.website'); ?>">
                                    <div class="invalid-feedback"><?= session('errors.company_website') ?></div>
                                </div>

                            </div>
                            <h3 class="card-title">Rechnungen</h3>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="company_mwst" class="form-label">MWST-Nummer</label>
                                    <input type="text" class="form-control <?php if(session('errors.company_mwst')) : ?>is-invalid<?php endif ?>" id="company_mwst" name="company_mwst"
                                        value="<?=service('settings')->get('Company.mwst'); ?>">
                                    <div class="invalid-feedback"><?= session('errors.company_mwst') ?></div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="iban" class="form-label">IBAN-Nummer <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?php if(session('errors.iban')) : ?>is-invalid<?php endif ?>" id="iban" name="iban"
                                        value="<?=service('settings')->get('Company.iban'); ?>">
                                    <div class="invalid-feedback"><?= session('errors.iban') ?></div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="payment_deadline" class="form-label">Zahlungsziel</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control <?php if(session('errors.payment_deadline')) : ?>is-invalid<?php endif ?>" id="payment_deadline" name="payment_deadline"
                                            value="<?=service('settings')->get('Company.payment_deadline'); ?>">
                                        <span class="input-group-text" id="basic-addon2">Tage</span>
                                        <div class="invalid-feedback"><?= session('errors.payment_deadline') ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="invoice" class="form-label">Einzahlungsschein an Rechnunung anhängen?</label>
                                    <select name="invoice" class="form-select tomselect-default">
                                        <option value="1" <?=(service('settings')->get('Company.invoice') == true) ?'selected':'' ?>>Ja, anhängen
                                        </option>
                                        <option value="0" <?=(service('settings')->get('Company.invoice') == false) ?'selected':'' ?>>Nein, nicht anhängen
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="invoice_qr" class="form-label">QR-Optionen</label>
                                    <select name="invoice_qr" class="form-select tomselect-default">
                                        <option value="qr-iban" <?=(service('settings')->get('Company.invoice_qr') == 'qr-iban') ?'selected':'' ?>>QR-IBAN
                                        </option>
                                        <option value="iban" <?=(service('settings')->get('Company.invoice_qr') == 'iban') ?'selected':'' ?>>Nur IBAN
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="qriban" class="form-label">QR-IBAN</label>
                                    <input type="text" class="form-control <?php if(session('errors.qriban')) : ?>is-invalid<?php endif ?>" id="qriban" name="qriban"
                                        value="<?=service('settings')->get('Company.qriban'); ?>">
                                    <div class="invalid-feedback"><?= session('errors.qriban') ?></div>
                                    <small class="text-muted">Nur erforderlich wenn QR-IBAN ausgewählt.</small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="qriban_reference" class="form-label">QR-Referenz ID</label>
                                    <input type="text" class="form-control <?php if(session('errors.qriban_reference')) : ?>is-invalid<?php endif ?>" id="qriban_reference" name="qriban_reference"
                                        value="<?=service('settings')->get('Company.qriban_reference'); ?>">
                                    <div class="invalid-feedback"><?= session('errors.qriban_reference') ?></div>
                                    <small class="text-muted">Nur erforderlich wenn QR-IBAN ausgewählt.</small>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer bg-transparent mt-auto">
                            <div class="btn-list justify-content-end">
                                <a href="<?=base_url(route_to('home'))?>" class="btn">
                                    Abbrechen
                                </a>
                                <button type="submit" class="btn btn-success">
                                    Speichern
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>





<?= $this->endSection() ?>