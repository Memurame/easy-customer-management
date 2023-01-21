<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<div class="row">
    <div class="col-5 ">
        Die Exportierte Excel Datei aus dem Abacus hochladen.<br>
        Danach erscheinen verschiedene Optionen für das Filtern der Einträge.

        <div class="input-group mt-3">
            <input type="file" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
            <button class="btn btn-outline-secondary" type="button" id="inputGroupFileAddon04">Hochladen</button>
        </div>
    </div>
</div>



<?= $this->endSection() ?>
