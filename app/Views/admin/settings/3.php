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
                            <a href="<?=base_url(route_to('setting.2'))?>" class="list-group-item list-group-item-action">Firmenangaben</a>
                        </div>
                        <div class="list-group list-group-transparent">
                            <a href="<?=base_url(route_to('setting.3'))?>" class="list-group-item list-group-item-action d-flex align-items-center active">E-Mail</a>
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
                            <h2 class="mb-4">E-Mail</h2>
                            <h3 class="card-title">E-Mail Versand und Zugangsdaten</h3>
                            <div class="row mb-3">
                                <div class="col-lg-8 col-xl-6">
                                    <label for="protocol" class="form-label">Protokol<span class="text-danger">*</span></label>
                                    <select name="protocol" class="form-select tomselect-default">
                                        <option value="smtp" <?=(service('settings')->get('Email.protocol') == 'smtp') ?'selected':'' ?>>SMTP
                                        </option>
                                        <option value="sendmail" <?=(service('settings')->get('Email.protocol') == 'sendmail') ?'selected':'' ?>>Sendmail
                                        </option>
                                        <option value="mail" <?=(service('settings')->get('Email.protocol') == 'mail') ?'selected':'' ?>>Mail
                                        </option>
                                    </select>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-8 col-xl-6">
                                    <label for="from_email" class="form-label">Absender Adresse<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?php if(session('errors.from_email')) : ?>is-invalid<?php endif ?>" id="from_email" name="from_email"
                                        value="<?=service('settings')->get('Email.fromEmail'); ?>">
                                    <div class="invalid-feedback"><?= session('errors.from_email') ?></div>
                                </div>

                            </div>
                            <div class="row mb-3 pb-3" style="border-bottom: 1px solid lightgray">
                                <div class="col-lg-8 col-xl-6">
                                    <label for="from_name" class="form-label">Absender Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?php if(session('errors.from_name')) : ?>is-invalid<?php endif ?>" id="from_name" name="from_name"
                                        value="<?=service('settings')->get('Email.fromName'); ?>">
                                    <div class="invalid-feedback"><?= session('errors.from_name') ?></div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-8 col-xl-6">
                                    <div class="alert alert-info">Folgende Angaben sind nur notwendig wenn das Protokol SMTP
                                        ausgewählt
                                        wurde.</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-8 col-xl-6">
                                    <label for="smtp_host" class="form-label">SMTP Host</label>
                                    <input type="text" class="form-control <?php if(session('errors.smtp_host')) : ?>is-invalid<?php endif ?>" id="smtp_host" name="smtp_host"
                                        value="<?=service('settings')->get('Email.SMTPHost'); ?>">
                                    <div class="invalid-feedback"><?= session('errors.smtp_host') ?></div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-8 col-xl-6">
                                    <label for="smtp_user" class="form-label">SMTP Benutzer</label>
                                    <input type="text" class="form-control <?php if(session('errors.smtp_user')) : ?>is-invalid<?php endif ?>" id="smtp_user" name="smtp_user"
                                        value="<?=service('settings')->get('Email.SMTPUser'); ?>">
                                    <div class="invalid-feedback"><?= session('errors.smtp_user') ?></div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-8 col-xl-6">
                                    <label for="smtp_pass" class="form-label">SMTP Passwort</label>
                                    <input type="text" class="form-control <?php if(session('errors.smtp_pass')) : ?>is-invalid<?php endif ?>" id="smtp_pass" name="smtp_pass" placeholder="*****">
                                    <div class="invalid-feedback"><?= session('errors.smtp_pass') ?></div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-8 col-xl-6">
                                    <label for="smtp_port" class="form-label">SMTP Port</label>
                                    <input type="text" class="form-control <?php if(session('errors.smtp_port')) : ?>is-invalid<?php endif ?>" id="smtp_port" name="smtp_port"
                                        value="<?=service('settings')->get('Email.SMTPPort'); ?>">
                                    <div class="invalid-feedback"><?= session('errors.smtp_port') ?></div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-8 col-xl-6">
                                    <label for="smtp_secure" class="form-label">SMTP Sicherheit </label>
                                    <select name="smtp_secure" class="form-select tomselect-default">
                                        <option value="ssl" <?=(service('settings')->get('Email.SMTPCrypto') == 'ssl') ?'selected':'' ?>>SSL
                                        </option>
                                        <option value="tls" <?=(service('settings')->get('Email.SMTPCrypto') == 'tls') ?'selected':'' ?>>TLS
                                        </option>
                                    </select>
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