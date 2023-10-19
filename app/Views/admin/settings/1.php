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
                            <a href="<?=base_url(route_to('setting.1'))?>" class="list-group-item list-group-item-action d-flex align-items-center active">Allgemein</a>
                        </div>
                        <div class="list-group list-group-transparent">
                            <a href="<?=base_url(route_to('setting.2'))?>" class="list-group-item list-group-item-action">Firmenangaben</a>
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
                    <form method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="card-body">
                            <h2 class="mb-4">Allgemein</h2>
                            <h3 class="card-title">Allgemein Angaben zur Seite</h3>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="form-label">Seitentitel</div>
                                    <input type="text" class="form-control <?php if(session('errors.title')) : ?>is-invalid<?php endif ?>" id="title" name="title"
                                        value="<?=service('settings')->get('Site.title'); ?>">
                                    <div class="invalid-feedback"><?= session('errors.title') ?></div>
                                </div>
                            </div>
                            <h3 class="card-title mt-4">Sprache</h3>

                            <div class="row g-2">
                                <div class="col-md-4">
                                    <label for="defaultLocale" class="form-label">Sprache</label>
                                    <select name="defaultLocale" class="form-select tomselect-default">
                                        <option value="de" <?=(service('settings')->get('App.defaultLocale') == 'de') ?'selected':'' ?>>Deutsch
                                        </option>
                                        <option value="en" <?=(service('settings')->get('App.defaultLocale') == 'en') ?'selected':'' ?>>English
                                        </option>
                                        <option value="fr" <?=(service('settings')->get('App.defaultLocale') == 'fr') ?'selected':'' ?>>Française
                                        </option>
                                        <option value="it" <?=(service('settings')->get('App.defaultLocale') == 'it') ?'selected':'' ?>>Italiano
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <h3 class="card-title mt-4">Logo</h3>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <div class="form-label">Logo wählen</div>

                                    <input type="file" class="form-control" name="image_logo">
                                    <img src="<?= base_url() . setting('Site.logo') ?>" height="50" alt="ECM" class=" mt-3">
                                </div>
                            </div>
                            <h3 class="card-title mt-4">Anmelde Bild</h3>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <div class="form-label">Bild wählen</div>
                                    <input type="file" class="form-control" name="image_login">
                                    <img src="<?= base_url() . setting('Site.loginImage') ?>" height="100" alt="ECM" class=" mt-3">
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