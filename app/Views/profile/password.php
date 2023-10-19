<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>


    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Account Einstellungen
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
                                <a href="<?=base_url(route_to('profile.index'))?>" class="list-group-item list-group-item-action">Benutzerangaben</a>
                            </div>
                            <div class="list-group list-group-transparent">
                                <a href="<?=base_url(route_to('profile.password'))?>" class="list-group-item list-group-item-action d-flex align-items-center active">Sicherheit</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-9 d-flex flex-column">
                        <form method="post">
                            <?= csrf_field() ?>
                            <div class="card-body">
                                <h2 class="mb-4">Sicherheit</h2>
                                <h3 class="card-title">Passwort ändern</h3>
                                <!--<div class="row g-3 pb-3">
                                    <div class="col-md-4">
                                        <div class="form-label">Aktuelles Passwort</div>
                                        <input type="password" class="form-control <?php if(session('errors.password-old')) : ?>is-invalid<?php endif ?>" id="password-old" name="password-old">
                                        <div class="invalid-feedback"><?= session('errors.password-old') ?></div>
                                    </div>
                                </div>-->
                                <div class="row g-3 pb-3">
                                    <div class="col-md-4">
                                        <div class="form-label">Neues Passwort</div>
                                        <input type="password" class="form-control <?php if(session('errors.password')) : ?>is-invalid<?php endif ?>" id="password" name="password">
                                        <div class="invalid-feedback"><?= session('errors.password') ?></div>
                                    </div>
                                </div>

                                <div class="row g-2 ">
                                    <div class="col-md-4">
                                        <div class="form-label">Neues Passwort (wiederholen)</div>
                                        <input type="password" class="form-control <?php if(session('errors.password-confirm')) : ?>is-invalid<?php endif ?>" id="password-confirm" name="password-confirm">
                                        <div class="invalid-feedback"><?= session('errors.password-confirm') ?></div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer bg-transparent mt-auto">
                                <div class="btn-list justify-content-end">
                                    <a href="#" class="btn">
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