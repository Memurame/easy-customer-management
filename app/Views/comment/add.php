<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<form method="post">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Kunde
                    </div>
                    <h2 class="page-title">
                        <?php echo $customer->customername ?>
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
                    <div class="row g-3 mb-3">
                        <div class="bgc-white bd bdrs-3 p-20 mB-20">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="comment_typ" class="form-label">Art <span class="text-danger">*</span></label>
                                    <select id="comment_typ" name="comment_typ" class="form-select">
                                        <option value="1">Positiv</option>
                                        <option value="0" selected>Neutral</option>
                                        <option value="-1">Negativ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label for="customer_id" class="form-label">Kunde <span class="text-danger">*</span></label>
                                    <select id="customer_id" name="customer_id" class="form-select tomselect-search">
                                        <option value="0" selected>-- Bitte auswählen --</option>
                                        <?php foreach($customers as $index => $value): ?>
                                        <option value="<?=$value->id?>" <?=($selected['customer'] == $value->id)? 'selected':''?>>
                                            <?= $value->customername ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="project_id" class="form-label">Projekt</label>
                                    <select id="project_id" name="project_id" class="form-select">
                                        <option value="0" selected>-- Keine Angabe --</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="website_id" class="form-label">Webseite</label>
                                    <select id="website_id" name="website_id" class="form-select">
                                        <option value="0" selected>-- Keine Angabe --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="comment" class="form-label">Kommentar</label>
                                    <textarea class="form-control" rows="7" id="comment" name="comment"><?=old('comment') ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="btn-list justify-content-end">
                        <a href="<?=base_url(route_to('customer.show', $customer->id))?>" class="btn">
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