<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<form method="post">
    <div class="d-flex border-bottom pb-2 mb-4">
        <div class="p-1 flex-grow-1">
            <ol class="breadcrumb my-0 ">
                <li class="breadcrumb-item"><a href="<?=base_url()?>">Übersicht</a></li>
                <li class="breadcrumb-item"><a href="<?=base_url()?><?=route_to('website.index')?>">Webseiten</a></li>
                <li class="breadcrumb-item active" aria-current="page">Neu</li>
            </ol>
        </div>

        <div class="">
            <button type="submit" class="btn btn-success btn-sm">Speichern</button>
        </div>
    </div>
    <?= view('templates/message_block.php') ?>
    <div class="row g-3">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <div class="row mb-3">
                <div class="col-6">
                    <label for="customer_id" class="form-label">Kunde <span class="text-danger">*</span></label>
                    <select class="form-select" name="customer_id" id="customer_id">
                        <option value="0" selected>-- Kunde auswählen --</option>
                        <?php foreach($customers as $customer): ?>
                        <option value="<?=$customer->id ?>">
                            <?= $customer->company?: $customer->contact_lastname . ' ' . $customer->contact_firstname ?>
                        </option>

                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-6">
                    <label for="project_id" class="form-label">Projekt</label>
                    <select class="form-select" name="project_id" id="project_id">
                        <option value="0" selected>-- Projekt auswählen --</option>
                        <?php foreach($projects as $project): ?>
                        <option value="<?=$project->id ?>"><?= $project->name ?></option>

                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <label for="website_url" class="form-label">Domain <span class="text-danger">*</span></label>
                    <input type="text"
                        class="form-control <?php if(session('errors.website_url')) : ?>is-invalid<?php endif ?>"
                        id="website_url" name="website_url" value="<?=old('website_url') ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <label for="website_url" class="form-label">Tags</label>
                    <select class="select2-tags form-select" name="tags[]" id="tags" multiple="multiple">
                        <?php foreach($taglist as $tag): ?>
                        <option value="<?=$tag->id ?>"><?=$tag->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="website_installed" class="form-label">Webseite installiert am</label>
                    <input type="date" class="form-control" id="website_installed" name="website_installed"
                        value="<?=old('website_installed') ?>">
                </div>
                <div class="col-md-6">
                    <label for="website_live" class="form-label">Webseite aufgeschalten am</label>
                    <input type="date" class="form-control" id="website_live" name="website_live"
                        value="<?=old('website_live') ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <label for="notes" class="form-label">Notizen</label>
                    <textarea class="form-control" rows="5" id="notes" name="notes"><?=old('notes') ?></textarea>
                </div>
            </div>
        </div>
    </div>
</form>




<?= $this->endSection() ?>