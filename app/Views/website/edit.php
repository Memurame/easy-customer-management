<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>

    <form method="post">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <!-- Page pre-title -->
                        <div class="page-pretitle">
                            Webseite
                        </div>
                        <h2 class="page-title">
                            <?php echo $website->website_url ?>&nbsp;<span class="badge badge-outline text-blue" style="font-size: 10px">bearbeitungs Modus</span>
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="customer_id" class="form-label">Kunde <span class="text-danger">*</span></label>
                                <select class="form-select tomselect-search" name="customer_id" id="customer_id">
                                    <option value="0">-- Kunde auswählen --</option>
                                    <?php foreach($customers as $customer): ?>
                                    <option value="<?=$customer->id ?>"
                                        <?= ($website->customer_id == $customer->id) ? 'selected' : '' ?>>
                                        <?= $customer->customername ?>
                                    </option>

                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback"><?= session('errors.customer_id') ?></div>
                            </div>
                            <div class="col-6">
                                <label for="project_id" class="form-label">Projekt</label>
                                <select class="form-select" name="project_id" id="project_id" data-selected="<?=$website->project_id?>">

                                </select>
                                <div class="invalid-feedback"><?= session('errors.project_id') ?></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="website_url" class="form-label">Domain <span class="text-danger">*</span></label>
                                <input type="text"
                                    class="form-control <?php if(session('errors.website_url')) : ?>is-invalid<?php endif ?>"
                                    id="website_url" name="website_url" value="<?=$website->website_url ?>">
                                <div class="invalid-feedback"><?= session('errors.website_url') ?></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="website_url" class="form-label">Tags</label>
                                <select class="tomselect-multiple-check form-select" name="tags[]" id="tags" multiple="multiple">
                                    <?php foreach($taglist as $tag): ?>
                                    <option value="<?=$tag->id ?>" <?= ($website->hasTag($tag->id) ? 'selected' : '')?>>
                                        <?=$tag->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback"><?= session('errors.tags') ?></div>

                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="website_installed" class="form-label">Webseite installiert am</label>
                                <div class="input-icon mb-2">
                                    <input class="form-control tabler-datepicker-icon" id="website_installed" name="website_installed"
                                           value="<?=$website->website_installed ?>">
                                    <span class="input-icon-addon"><!-- Download SVG icon from http://tabler-icons.io/i/calendar -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M11 15h1" /><path d="M12 15v3" /></svg>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="website_live" class="form-label">Webseite aufgeschalten am</label>
                                <div class="input-icon mb-2">
                                    <input class="form-control tabler-datepicker-icon" id="website_live" name="website_live"
                                           value="<?=$website->website_live ?>">
                                    <span class="input-icon-addon"><!-- Download SVG icon from http://tabler-icons.io/i/calendar -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M11 15h1" /><path d="M12 15v3" /></svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="notes" class="form-label">Notizen</label>
                                <textarea class="form-control" rows="5" id="notes" name="notes"><?=$website->notes ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="btn-list justify-content-end">
                            <a href="<?=base_url(route_to('website.show', $website->id))?>" class="btn">
                                Abbrechen
                            </a>
                            <button class="btn btn-success d-none d-sm-inline-block">
                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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
</form>





<?= $this->endSection() ?>