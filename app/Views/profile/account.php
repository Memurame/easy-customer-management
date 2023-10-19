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
                                <a href="<?=base_url(route_to('profile.index'))?>" class="list-group-item list-group-item-action d-flex align-items-center active">Benutzerangaben</a>
                            </div>
                            <div class="list-group list-group-transparent">
                                <a href="<?=base_url(route_to('profile.password'))?>" class="list-group-item list-group-item-action">Sicherheit</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-9 d-flex flex-column">
                        <form method="post">
                            <?= csrf_field() ?>
                            <div class="card-body">
                                <h2 class="mb-4">Benutzerangaben</h2>
                                <h3 class="card-title">Profilbild</h3>
                                <div class="row align-items-center">
                                    <div class="col-auto"><span class="avatar avatar-xl" style="background-image: url(<?= profile()->avatar ?? 'http://www.gravatar.com/avatar'?>)"></span>
                                    </div>
                                    <div class="col-auto">
                                        <a href="https://de.gravatar.com/" target="_blank">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-external-link" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6"></path>
                                                <path d="M11 13l9 -9"></path>
                                                <path d="M15 4h5v5"></path>
                                            </svg>
                                            Du kannst dein Profilbild auf Gravatar ändern.
                                        </a>
                                    </div>

                                </div>
                                <h3 class="card-title mt-4">Persönliche Angaben</h3>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="form-label">Benutzername</div>
                                        <input type="text" class="form-control <?php if(session('errors.username')) : ?>is-invalid<?php endif ?>" id="username" name="username" value="<?=$user->username ?>">
                                        <div class="invalid-feedback"><?= session('errors.username') ?></div>
                                    </div>
                                </div>
                                <div class="row g-3 mt-2">
                                    <div class="col-md">
                                        <div class="form-label">Vorname</div>
                                        <input type="text" class="form-control <?php if(session('errors.firstname')) : ?>is-invalid<?php endif ?>" id="firstname" name="firstname" value="<?=profile()->firstname ?>">
                                        <div class="invalid-feedback"><?= session('errors.firstname') ?></div>
                                    </div>
                                    <div class="col-md">
                                        <div class="form-label">Nachname</div>
                                        <input type="text" class="form-control <?php if(session('errors.lastname')) : ?>is-invalid<?php endif ?>" id="lastname" name="lastname" value="<?=profile()->lastname ?>">
                                        <div class="invalid-feedback"><?= session('errors.lastname') ?></div>
                                    </div>
                                </div>
                                <div class="row g-3 mt-2">
                                    <div class="col-md">
                                        <div class="form-label">Telefon</div>
                                        <input type="text" class="form-control <?php if(session('errors.phone')) : ?>is-invalid<?php endif ?>" id="phone" name="phone" value="<?=profile()->phone ?>">
                                        <div class="invalid-feedback"><?= session('errors.phone') ?></div>
                                    </div>
                                    <div class="col-md">
                                        <div class="form-label">Abteilung</div>
                                        <input type="text" class="form-control <?php if(session('errors.department')) : ?>is-invalid<?php endif ?>" id="department" name="department" value="<?=profile()->department ?>">
                                        <div class="invalid-feedback"><?= session('errors.department') ?></div>
                                    </div>
                                </div>
                                <h3 class="card-title mt-4">E-Mail</h3>
                                <div>
                                    <div class="row g-2">
                                        <div class="col-md-4">
                                            <input type="text" class="form-control <?php if(session('errors.email')) : ?>is-invalid<?php endif ?>" id="email" name="email" value="<?=$user->email ?>">
                                            <div class="invalid-feedback"><?= session('errors.email') ?></div>
                                        </div>
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