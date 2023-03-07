<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<form method="post">
    <div class="d-flex border-bottom pb-2 mb-4">
        <div class="p-1 flex-grow-1">
            <ol class="breadcrumb my-0 ">
                <li class="breadcrumb-item"><a href="<?=base_url()?>">Übersicht</a></li>
                <li class="breadcrumb-item active" aria-current="page">Einstellungen</li>
            </ol>
        </div>

        <div class="">
            <button type="submit" class="btn btn-success btn-sm">Speichern</button>
        </div>
    </div>
    <?= view('templates/message_block.php') ?>
    <div class="row g-3">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <div class="d-flex justify-content-between">
                <h6 class="c-grey-900">Allgemein</h6>
            </div>
            <div class="mT-30">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="title" class="form-label">Setentitel <span class="text-danger">*</span></label>
                        <input type="text"
                            class="form-control <?php if(session('errors.title')) : ?>is-invalid<?php endif ?>"
                            id="title" name="title" value="<?=service('settings')->get('App.siteName'); ?>">
                    </div>

                </div>
                <div class="row mb-3">
                    <div class="col-lg-8 col-xl-6">
                        <label for="defaultLocale" class="form-label">Sprache</label>
                        <select name="defaultLocale" class="form-select">
                            <option value="de"
                                <?=(service('settings')->get('App.defaultLocale') == 'de') ?'selected':'' ?>>Deutsch
                            </option>
                            <option value="en"
                                <?=(service('settings')->get('App.defaultLocale') == 'en') ?'selected':'' ?>>English
                            </option>
                            <option value="fr"
                                <?=(service('settings')->get('App.defaultLocale') == 'fr') ?'selected':'' ?>>Française
                            </option>
                            <option value="it"
                                <?=(service('settings')->get('App.defaultLocale') == 'it') ?'selected':'' ?>>Italiano
                            </option>
                        </select>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row g-3">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <div class="d-flex justify-content-between">
                <h6 class="c-grey-900">E-Mail</h6>
            </div>
            <div class="mT-30">
                <div class="row mb-3">
                    <div class="col-lg-8 col-xl-6">
                        <label for="protocol" class="form-label">Protokol<span class="text-danger">*</span></label>
                        <select name="protocol" class="form-select">
                            <option value="smtp"
                                <?=(service('settings')->get('Email.protocol') == 'smtp') ?'selected':'' ?>>SMTP
                            </option>
                            <option value="sendmail"
                                <?=(service('settings')->get('Email.protocol') == 'sendmail') ?'selected':'' ?>>Sendmail
                            </option>
                            <option value="mail"
                                <?=(service('settings')->get('Email.protocol') == 'mail') ?'selected':'' ?>>Mail
                            </option>
                        </select>
                    </div>

                </div>
                <div class="row mb-3">
                    <div class="col-lg-8 col-xl-6">
                        <label for="from_email" class="form-label">Absender Adresse<span
                                class="text-danger">*</span></label>
                        <input type="text"
                            class="form-control <?php if(session('errors.from_email')) : ?>is-invalid<?php endif ?>"
                            id="from_email" name="from_email"
                            value="<?=service('settings')->get('Email.fromEmail'); ?>">
                    </div>

                </div>
                <div class="row mb-3 pb-3" style="border-bottom: 1px solid lightgray">
                    <div class="col-lg-8 col-xl-6">
                        <label for="from_name" class="form-label">Absender Name<span
                                class="text-danger">*</span></label>
                        <input type="text"
                            class="form-control <?php if(session('errors.from_name')) : ?>is-invalid<?php endif ?>"
                            id="from_name" name="from_name" value="<?=service('settings')->get('Email.fromName'); ?>">
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
                        <input type="text"
                            class="form-control <?php if(session('errors.smtp_host')) : ?>is-invalid<?php endif ?>"
                            id="smtp_host" name="smtp_host" value="<?=service('settings')->get('Email.SMTPHost'); ?>">
                    </div>

                </div>
                <div class="row mb-3">
                    <div class="col-lg-8 col-xl-6">
                        <label for="smtp_user" class="form-label">SMTP Benutzer</label>
                        <input type="text"
                            class="form-control <?php if(session('errors.smtp_user')) : ?>is-invalid<?php endif ?>"
                            id="smtp_user" name="smtp_user" value="<?=service('settings')->get('Email.SMTPUser'); ?>">
                    </div>

                </div>
                <div class="row mb-3">
                    <div class="col-lg-8 col-xl-6">
                        <label for="smtp_pass" class="form-label">SMTP Passwort</label>
                        <input type="text"
                            class="form-control <?php if(session('errors.smtp_pass')) : ?>is-invalid<?php endif ?>"
                            id="smtp_pass" name="smtp_pass" placeholder="*****">
                    </div>

                </div>
                <div class="row mb-3">
                    <div class="col-lg-8 col-xl-6">
                        <label for="smtp_port" class="form-label">SMTP Port</label>
                        <input type="text"
                            class="form-control <?php if(session('errors.smtp_port')) : ?>is-invalid<?php endif ?>"
                            id="smtp_port" name="smtp_port" value="<?=service('settings')->get('Email.SMTPPort'); ?>">
                    </div>

                </div>
                <div class="row mb-3">
                    <div class="col-lg-8 col-xl-6">
                        <label for="smtp_secure" class="form-label">SMTP Sicherheit </label>
                        <select name="smtp_secure" class="form-select">
                            <option value="ssl"
                                <?=(service('settings')->get('Email.SMTPCrypto') == 'ssl') ?'selected':'' ?>>SSL
                            </option>
                            <option value="tls"
                                <?=(service('settings')->get('Email.SMTPCrypto') == 'tls') ?'selected':'' ?>>TLS
                            </option>
                        </select>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row g-3">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <div class="d-flex justify-content-between">
                <h6 class="c-grey-900">Authentisierung</h6>
            </div>
            <div class="mT-30">
                <div class="row mb-3">
                    <div class="col-lg-8 col-xl-6">
                        <label for="allowRegistration" class="form-label">Erlaube Registrierung</label>
                        <select name="allowRegistration" class="form-select">
                            <option value="1" <?=(service('settings')->get('Auth.allowRegistration')) ?'selected':'' ?>>
                                Ja
                            </option>
                            <option value="0"
                                <?=(!service('settings')->get('Auth.allowRegistration')) ?'selected':'' ?>>Nein
                            </option>
                        </select>
                    </div>

                </div>
            </div>
        </div>
    </div>
</form>




<?= $this->endSection() ?>