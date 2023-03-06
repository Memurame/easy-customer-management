<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<form method="post">
    <?= csrf_field() ?>
    <div class="d-flex border-bottom pb-2 mb-4">
        <div class="p-1 flex-grow-1">
            <ol class="breadcrumb my-0 ">
                <li class="breadcrumb-item"><a href="<?=base_url()?>">Übersicht</a></li>
                <li class="breadcrumb-item"><a href="<?=base_url()?><?=route_to('user.index')?>">Benutzer</a></li>
                <li class="breadcrumb-item active" aria-current="page">Bearbeiten</li>
            </ol>
        </div>

    </div>
    <?= view('templates/message_block.php') ?>
    <div class="row g-3 mb-3">
        <div class="col-lg-6">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <div class="d-flex justify-content-between">
                    <h6 class="c-grey-900">Benutzerdaten</h6>
                    <button type="submit" class="btn btn-success btn-sm btn-color">Speichern</button>
                </div>
                <div class="mT-30">
                    <div class="row mb-3">
                        <div class="col-12">

                            <label class="form-label">Gruppe <span class="text-danger">*</span></label>
                            <?php foreach(service('settings')->get('AuthGroups.groups') as $key => $group): ?>
                            <?php if(($group['isAdmin'] && auth()->user()->can('user.manage-admins')) OR 
                        !$group['isAdmin']): ?>
                            <div class="form-check">
                                <label class="form-label form-check-label">
                                    <input class="form-check-input" type="checkbox" name="group[<?=$key ?>]"
                                        <?= (in_array($key, $user->getGroups())) ? 'checked' : '' ?>>
                                    <?=$group['title']?>
                                </label>
                            </div>
                            <?php endif; ?>

                            <?php endforeach; ?>

                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="username" class="form-label">Benutzername</label>
                            <input type="text"
                                class="form-control <?php if(session('errors.username')) : ?>is-invalid<?php endif ?>"
                                id="username" name="username" value="<?=$user->username ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="email" class="form-label">E-Mail</label>
                            <input type="mail"
                                class="form-control <?php if(session('errors.email')) : ?>is-invalid<?php endif ?>"
                                id="email" name="email" value="<?=$user->email ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="password" class="form-label">Passwort</label>
                            <input type="password"
                                class="form-control <?php if(session('errors.password')) : ?>is-invalid<?php endif ?>"
                                id="password" name="password" placeholder="****">
                        </div>
                    </div>

                </div>
            </div>
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <div class="d-flex justify-content-between">
                    <h6 class="c-grey-900">Aktionen</h6>

                </div>
                <div class="mT-30">

                    <div class="gap-10 peers">
                        <div class="peer">
                            <button type="button" class="btn cur-p btn-primary btn-color">Neues Passwort
                                zusenden</button>
                        </div>
                        <div class="peer">
                            <button type="button" class="btn cur-p btn-primary btn-color">Login Link zusenden</button>
                        </div>
                        <div class="peer">
                            <button type="button" class="btn cur-p btn-danger btn-color">Benutzer löschen</button>
                        </div>

                    </div>


                </div>
            </div>
        </div>
        <div class="col-lg-6">

        </div>
    </div>
</form>




<?= $this->endSection() ?>