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
                    
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <?= view("templates/message_block.php") ?>
            <div class="alert alert-info">
                Anleitung zum aktualisieren der Telefonliste für ProCall.<br>
                <a href="https://doku.bernerbauern.ch/books/admin-telefonie/page/procall-aktualisierung-telefonliste" target="_blank">Zur Anleitung</a>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header card-header-light">
                        <h3 class="card-title">Kalahari</h3>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="alert alert-info d-flex align-items-center" role="alert">
                                <div>
                                    Die Excel Datei von Kalahari muss vorgängig in ein JSON Format umgewandelt werden.
                                    Die Excel Datei kann bei der unten verlinkten Seite hochgeladen und anschliessend wieder heruntergeladen werden.<br>
                                    Dies muss jedoch nur einmal im Jahr gemacht werden.<br>
                                    <a href="https://kinoar.github.io/xlsx-to-json/" class="alert-link">Jetzt umwandeln</a>
                                </div>
                            </div>

                            <?= form_open_multipart('tools/estos/kalahari') ?>
                            <?= csrf_field() ?>
                            <div class="input-group">
                                <input type="file" class="form-control" id="kalahari_import" name="kalahari_import" aria-label="Upload">
                                <button class="btn btn-outline-secondary" type="submit">Hochladen</button>
                            </div>
                            <small class="text-muted">Upload der Kalahari Einträge als .json Datei.<br>
                                <b>Letzter Import: <?=service('settings')->get('App.lastKalahariImport') ?></b></small>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header card-header-light">
                        <h3 class="card-title">Herunterladen</h3>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <p>Die Telefonliste wird automatisch jede Nacht neu generiert.<br>
                            Ein manuelles exportieren aus dem Abacus ist nicht mehr notwendig</p>
                            <?php if(file_exists(WRITEPATH . 'uploads/temp/.kalahari')):?>
                                <div class="alert alert-important alert-danger">
                                    Zurzeit läuft die erstellung der Telefonliste im hintergrund.<br>
                                    Versuche es später nochmals mit dem herunterladen der Liste.
                                </div>
                            <?php elseif(!file_exists(WRITEPATH . 'export/telefonliste.csv')):?>
                                <div class="alert alert-important alert-danger">
                                    Die Telefonliste wurde noch nicht generiert.<br>
                                    Versuche es später nochmals oder melde dich beim Administrator.
                                </div>
                            <?php else:?>
                                <a href="<?=base_url(route_to('estos.export'))?>" class="btn btn-primary d-none d-sm-inline-block">
                                    Telefonliste herunterladen
                                </a>
                            <?php endif;?>
                            <small class="text-muted mt-2">
                                <b>Letzte erstellung der Telefonliste: <?=service('settings')->get('App.lastTelefonlistDate') ?></b></small>
                            </form>
                            

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>