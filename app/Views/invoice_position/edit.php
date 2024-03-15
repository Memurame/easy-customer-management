<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<form method="post">
<?= csrf_field() ?>
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Rechnung
                    </div>
                    <h2 class="page-title">
                        Position bearbeiten
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
                        <div class="col-2">
                            <label for="title" class="form-label">Position <span class="text-danger">*</span></label>
                            <input type="number" class="form-control <?php if(session('errors.position')) : ?>is-invalid<?php endif ?>" id="position" name="position" value="<?=$position->position ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="title" class="form-label">Titel <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php if(session('errors.title')) : ?>is-invalid<?php endif ?>" id="title" name="title" value="<?=$position->title ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="description" class="form-label">Bezeichnung</label>
                            <input type="text" class="form-control <?php if(session('errors.description')) : ?>is-invalid<?php endif ?>" id="description" name="description"
                                value="<?=$position->description ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="price" class="form-label">Einzelpreis <span class="text-danger">*</span></label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">CHF</span>
                                <input type="number" name="price" id="price" step="0.01" class="form-control <?php if(session('errors.price')) : ?>is-invalid<?php endif ?>" placeholder="00.00"
                                    value="<?=$position->price ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="multiplication" class="form-label">Menge <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="multiplication" id="multiplication" class="form-control <?php if(session('errors.multiplication')) : ?>is-invalid<?php endif ?>"
                                value="<?=$position->multiplication ?>">
                        </div>
                        <div class="col-md-3">
                            <label for="unit" class="form-label">Einheit <span class="text-danger">*</span></label>
                            <input type="text" name="unit" id="unit" class="form-control <?php if(session('errors.unit')) : ?>is-invalid<?php endif ?>" placeholder="Stk" value="<?=$position->unit ?>">
                        </div>
                        <div class="col-md-3">
                            <label for="mwst" class="form-label">MwsT <span class="text-danger">*</span></label>
                            <select id="mwst" name="mwst" class="form-select tomselect-default <?php if(session('errors.mwst')) : ?>is-invalid<?php endif ?>">
                                <option value="0" <?=($position->mwst == '0') ? 'selected' : ''?>>0%</option>
                                <option value="2.5" <?=($position->mwst == '2.5') ? 'selected' : ''?>>2.5%</option>
                                <option value="7.7" <?=($position->mwst == '7.7') ? 'selected' : ''?>>7.7%</option>
                                <option value="8.1" <?=($position->mwst == '8.1') ? 'selected' : ''?>>8.1%</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="price_inkl" name="price_inkl" <?= ($position->price_inkl)?'checked':''?>>
                                <label class="form-check-label" for="price_inkl">Einzelpreis bereits inkl.
                                    Mehrwertsteuer</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="notes" class="form-label">Notizen</label>
                            <textarea class="form-control" rows="5" id="notes" name="notes"><?=$position->notes ?></textarea>
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <div class="btn-list justify-content-end">
                        <a href="<?=base_url(route_to('invoice.show', $invoice->id))?>" class="btn">
                            Abbrechen
                        </a>
                        <button class="btn btn-success d-none d-sm-inline-block">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
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
</form>



<?= $this->endSection() ?>