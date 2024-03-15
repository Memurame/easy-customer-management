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
                                <a href="<?=base_url(route_to('setting.3'))?>" class="list-group-item list-group-item-action">E-Mail</a>
                            </div>
                            <div class="list-group list-group-transparent">
                                <a href="<?=base_url(route_to('setting.4'))?>" class="list-group-item list-group-item-action d-flex align-items-center active">Sicherheit</a>
                            </div>

                        </div>
                    </div>
                    <div class="col-12 col-md-9 d-flex flex-column">
                        <form method="post">
                            <?= csrf_field() ?>
                            <div class="card-body">
                                <h2 class="mb-4">Sicherheit</h2>
                                <h3 class="card-title">Login und Registrierung</h3>
                                <div class="row mb-3">
                                    <div class="col-lg-8 col-xl-6">
                                        <label for="allowRegistration" class="form-label">Erlaube Registrierung</label>
                                        <select name="allowRegistration" class="form-select tomselect-default">
                                            <option value="1" <?=(service('settings')->get('Auth.allowRegistration')) ?'selected':'' ?>>
                                                Ja
                                            </option>
                                            <option value="0"
                                                <?=(!service('settings')->get('Auth.allowRegistration')) ?'selected':'' ?>>Nein
                                            </option>
                                        </select>
                                    </div>

                                </div>

                                <h3 class="card-title">Captcha</h3>
                                <div class="row mb-3">
                                    <div class="col-lg-8 col-xl-6">
                                        <label for="turnstile_public" class="form-label">Site Key</label>
                                        <input type="text" class="form-control <?php if(session('errors.turnstile_public')) : ?>is-invalid<?php endif ?>" id="turnstile_public" name="turnstile_public"
                                            value="<?=service('settings')->get('Site.cfSiteKey'); ?>">
                                        <div class="invalid-feedback"><?= session('errors.turnstile_public') ?></div>
                                    </div>

                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-8 col-xl-6">
                                        <label for="turnstile_secret" class="form-label">Secret Key</label>
                                        <input type="password" class="form-control <?php if(session('errors.turnstile_secret')) : ?>is-invalid<?php endif ?>" id="turnstile_secret" name="turnstile_secret"
                                            placeholder="***">
                                        <div class="invalid-feedback"><?= session('errors.turnstile_secret') ?></div>
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