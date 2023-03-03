<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<form method="post">
    <?= csrf_field() ?>
    <div class="d-flex border-bottom pb-2 mb-4">
        <div class="p-1 flex-grow-1">
            <ol class="breadcrumb my-0 ">
                <li class="breadcrumb-item"><a href="<?=base_url()?>">Übersicht</a></li>
                <li class="breadcrumb-item"><a href="<?=base_url()?><?=route_to('user.index')?>">Benutzer</a></li>
                <li class="breadcrumb-item active" aria-current="page">Neu</li>
            </ol>
        </div>

        <div class="">
            <button type="submit" class="btn btn-success btn-sm">Speichern</button>
        </div>
    </div>
    <?= view('templates/message_block.php') ?>
    <div class="row g-3 mb-3">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <div class="row mb-3">
                <div class="col-md-4">

                    <label class="form-label">Gruppe <span class="text-danger">*</span></label>
                    <?php foreach(service('settings')->get('AuthGroups.groups') as $key => $group): ?>
                    <?php if(($group['isAdmin'] && auth()->user()->can('user.manage-admins')) OR 
                        !$group['isAdmin']): ?>
                    <div class="form-check">
                        <label class="form-label form-check-label">
                            <input class="form-check-input" type="checkbox" name="group[<?=$key ?>]"
                                <?= ($key == service('settings')->get('AuthGroups.defaultGroup')) ? 'checked' : '' ?>>
                            <?=$group['title']?>
                        </label>
                    </div>
                    <?php endif; ?>

                    <?php endforeach; ?>

                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="username" class="form-label">Benutzername</label>
                    <input type="text"
                        class="form-control <?php if(session('errors.username')) : ?>is-invalid<?php endif ?>"
                        id="username" name="username" value="<?=old('username') ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="email" class="form-label">E-Mail</label>
                    <input type="mail"
                        class="form-control <?php if(session('errors.email')) : ?>is-invalid<?php endif ?>" id="email"
                        name="email" value="<?=old('email') ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="password" class="form-label">Passwort</label>
                    <input type="password"
                        class="form-control <?php if(session('errors.password')) : ?>is-invalid<?php endif ?>"
                        id="password" name="password" value="<?=old('password') ?>">
                </div>
            </div>
            <div cvlass="row mb-3">
                <div class="col-md-4">
                    <div class="form-check">
                        <label class="form-label form-check-label">
                            <input class="form-check-input" type="checkbox"> Neuer Benutzer per Mail benachrichtigen und
                            die Zugangsdaten zusenden
                        </label>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>




<?= $this->endSection() ?>