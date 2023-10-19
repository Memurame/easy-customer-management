<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>


    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Tools
                    </div>
                    <h2 class="page-title">
                        Estos Telefonliste
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="<?=base_url(route_to('estos.export'))?>" class="btn btn-primary d-none d-sm-inline-block">
                            Exportieren
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="alert alert-info d-flex align-items-center" role="alert">
                                <div>
                                    Die Excel Dateien von Abacus und auch Kalahari müssen zurzeit noch vorgängig in ein JSON Format umgewandelt werden.
                                    Die Excel Dateien können Einzeln bei der unten verlinkten Seite hochgeladen und anschliessend wieder heruntergeladen werden.<br><a
                                        href="https://kinoar.github.io/xlsx-to-json/" class="alert-link">Jetzt umwndeln</a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <?= form_open_multipart('tools/estos/kalahari') ?>
                                <label for="abacus_import">Kalahari Einträge</label>
                                <div class="input-group">
                                    <input type="file" class="form-control" id="kalahari_import" name="kalahari_import" aria-label="Upload">
                                    <button class="btn btn-outline-secondary" type="submit">Hochladen</button>
                                </div>
                                <small class="text-muted">Upload der Kalahari Einträge als .json Datei. Diese muss <span style="color:red">nur einmal im Jahr</span> aktualisiert werden.<br>
                                    <b>Letzter Import: <?=service('settings')->get('App.lastKalahariImport') ?></b></small>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <?= form_open_multipart('tools/estos/abacus') ?>
                                    <label for="abacus_import">Abacus Adressen</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" id="abacus_import" name="abacus_import" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                                        <button class="btn btn-outline-secondary" type="submit">Hochladen</button>
                                    </div>
                                    <small class="text-muted">Upload aller Adressen aus dem Abacus als .json Datei.<br>
                                        <b>Letzter Import: <?=service('settings')->get('App.lastAbacusImport') ?></b></small>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <?php if($preview == 'yes'): ?>
                                <div class="table-responsive">
                                    <table class="table table-vcenter card-table" id="table-estos">
                                        <thead>
                                        <tr>
                                            <th>Abacus</th>
                                            <th>Name</th>
                                            <th>Telefon</th>
                                            <th>Mobile</th>
                                            <th>Mitgliederart</th>
                                            <th>Zahldatum</th>
                                            <th>Status</th>
                                            <th>Kalahari</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($adressen as  $key => $adresse):?>

                                            <tr>
                                                <td class="align-middle"><?=$adresse['AbacusNr']?></td>
                                                <td class="align-middle"><?=$adresse['Vorname'] ?> <?=$adresse['Nachname'] ?></td>
                                                <td class="align-middle"><?=$adresse['Telefon']?></td>
                                                <td class="align-middle"><?=$adresse['Mobile']?></td>
                                                <td class="align-middle"><?=$adresse['Mitgliederart']?></td>
                                                <td class="align-middle"><?=$adresse['Zahldatum']?></td>
                                                <td class="align-middle"><?=$adresse['Status']?></td>
                                                <td class="align-middle"><?=$adresse['KalahariId']?></td>
                                            </tr>
                                        <?php endforeach; ?>

                                        </tbody>


                                    </table>
                                </div>
                            <?php else: ?>
                                <a href="<?=base_url(route_to('estos.index'))?>?preview=yes" class="btn btn-primary">Vorschau laden</a>

                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>