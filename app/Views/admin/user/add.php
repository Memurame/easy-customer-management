<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<form method="post">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Benutzer
                    </div>
                    <h2 class="page-title">
                        Neuer Benutzer
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="form-label">Benutzergruppe <span class="text-danger">*</span></label>
                                    <select name="group" id="group" class="form-select tomselect-default">
                                        <?php if(auth()->user()->can('user.manage-admins')):?>
                                        <option value="superadmin">Superadmin</option>
                                        <option value="admin">Admin</option>
                                        <?php endif; ?>
                                        <option value="user" selected>Mitarbeiter</option>
                                    </select>

                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <?php if(auth()->user()->can('user.manage-admins')):?>
                                    <div class="alert alert-info">
                                        Die Gruppe Superadmin und Admin benötigen keine zusätzliche Berechtigung.
                                    </div>
                                    <?php endif; ?>
                                    <label class="form-label">Zusätzliche Berechtigung</label>
                                    <select name="right" id="right" class="form-select tomselect-multiple-check" multiple>
                                        <?php foreach(service('settings')->get('AuthGroups.groups') as $key => $group): ?>
                                        <?php if(!in_array($key, ['superadmin','admin','user'])): ?>

                                        <option value="<?=$key ?>"><?=$group['title']?></option>


                                        <?php endif; ?>

                                        <?php endforeach; ?>
                                    </select>

                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="username" class="form-label">Benutzername <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?php if(session('errors.username')) : ?>is-invalid<?php endif ?>" id="username" name="username"
                                        value="<?=old('username') ?>">
                                    <div class="invalid-feedback"><?= session('errors.username') ?></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="email" class="form-label">E-Mail <span class="text-danger">*</span></label>
                                    <input type="mail" class="form-control <?php if(session('errors.email')) : ?>is-invalid<?php endif ?>" id="email" name="email" value="<?=old('email') ?>">
                                    <div class="invalid-feedback"><?= session('errors.email') ?></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="firstname" class="form-label">Vorname <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?php if(session('errors.firstname')) : ?>is-invalid<?php endif ?>" id="firstname" name="firstname"
                                        value="<?=old('firstname') ?>">
                                    <div class="invalid-feedback"><?= session('errors.firstname') ?></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="lastname" class="form-label">Nachname <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?php if(session('errors.lastname')) : ?>is-invalid<?php endif ?>" id="lastname" name="lastname"
                                        value="<?=old('lastname') ?>">
                                    <div class="invalid-feedback"><?= session('errors.lastname') ?></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="phone" class="form-label">Telefon</label>
                                    <input type="text" class="form-control <?php if(session('errors.phone')) : ?>is-invalid<?php endif ?>" id="phone" name="phone" value="<?=old('phone') ?>">
                                    <div class="invalid-feedback"><?= session('errors.phone') ?></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="department" class="form-label">Abteilung</label>
                                    <input type="text" class="form-control <?php if(session('errors.department')) : ?>is-invalid<?php endif ?>" id="department" name="department"
                                        value="<?=old('department') ?>">
                                    <div class="invalid-feedback"><?= session('errors.department') ?></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        Das Passwort wird automatisch generiert und der Benutzer erhält eine E-Mail mit seinen Zugangsdaten.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="btn-list justify-content-end">
                                <a href="<?=base_url(route_to('user.index'))?>" class="btn">
                                    Abbrechen
                                </a>
                                <button class="btn btn-success d-none d-sm-inline-block">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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
        </div>
    </div>
</form>





<?= $this->endSection() ?>