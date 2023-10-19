<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
    <form method="post">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <!-- Page pre-title -->
                        <div class="page-pretitle">
                            Projekt
                        </div>
                        <h2 class="page-title">
                            <?= $project->name ?>
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
                                        <?=($customer->id == $project->customer_id) ? 'selected' : ''?>>
                                        <?= $customer->customername ?>
                                    </option>

                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback"><?= session('errors.customer_id') ?></div>
                            </div>
                            <div class="col-6">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select tomselect-default" name="status" id="status">
                                    <option value="0" <?=($project->status == 0) ? 'selected' : ''?>>Inaktiv</option>
                                    <option value="1" <?=($project->status == 1) ? 'selected' : ''?>>Aktiv</option>
                                    <option value="2" <?=($project->status == 2) ? 'selected' : ''?>>Archiviert</option>
                                </select>
                                <div class="invalid-feedback"><?= session('errors.status') ?></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="name" class="form-label">Projektname <span class="text-danger">*</span></label>
                                <input type="text"
                                    class="form-control <?php if(session('errors.name')) : ?>is-invalid<?php endif ?>" id="name"
                                    name="name" value="<?=$project->name ?>">
                                <div class="invalid-feedback"><?= session('errors.name') ?></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="date_offer" class="form-label">Offerten Datum</label>
                                <div class="input-icon mb-2">
                                    <input class="form-control tabler-datepicker-icon" id="date_offer" name="date_offer"
                                           value="<?=$project->date_offer ?>">
                                    <span class="input-icon-addon"><!-- Download SVG icon from http://tabler-icons.io/i/calendar -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M11 15h1" /><path d="M12 15v3" /></svg>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="date_order" class="form-label">Bestellt</label>
                                <div class="input-icon mb-2">
                                    <input class="form-control tabler-datepicker-icon" id="date_order" name="date_order"
                                           value="<?=$project->date_order ?>">
                                    <span class="input-icon-addon"><!-- Download SVG icon from http://tabler-icons.io/i/calendar -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M11 15h1" /><path d="M12 15v3" /></svg>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="date_finish" class="form-label">Projekt abgeschlossen</label>
                                <div class="input-icon mb-2">
                                    <input class="form-control tabler-datepicker-icon" id="date_finish" name="date_finish"
                                           value="<?=$project->date_finish ?>">
                                    <span class="input-icon-addon"><!-- Download SVG icon from http://tabler-icons.io/i/calendar -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M11 15h1" /><path d="M12 15v3" /></svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="notes" class="form-label">Notizen</label>
                                <textarea class="form-control" rows="5" id="notes" name="notes"><?=$project->notes ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="btn-list justify-content-end">
                            <a href="<?=base_url(route_to('project.show', $project->id))?>" class="btn">
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