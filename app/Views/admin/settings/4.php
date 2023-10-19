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
                                <h2 class="mb-4">Allgemein</h2>
                                <h3 class="card-title">Allgemein Angaben zur Seite</h3>
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