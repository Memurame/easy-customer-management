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
                        Testimonial
                    </div>
                    <h2 class="page-title">
                        Neues Formular
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
                            <label for="title" class="form-label">Formularname <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php if(session('errors.title')) : ?>is-invalid<?php endif ?>" id="title" name="title" value="<?=old('title') ?>">
                            <div class="invalid-feedback"><?= session('errors.title') ?></div>
                        </div>
                        <div class="col-6">
                            <label for="description" class="form-label">Kurze Beschreibung <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php if(session('errors.description')) : ?>is-invalid<?php endif ?>" id="description" name="description" value="<?=old('description') ?>">
                            <div class="invalid-feedback"><?= session('errors.description') ?></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="alert alert-info">
                                Beim erstellen eines Formulars ist ein Beispiel Code bereits zu sehen.<br>
                                Dieser dient als Hilfe um alle möglichen Elemente zu sehen.
                            </div>
                            <div id="jsoneditor" style="width: 100%; height: 800px;"></div>
                            <input type="hidden" name="json" id="json">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-12">
                            <label class="form-label">Nachricht bei erfolgreichem Formular</label>
                            <textarea rows="10" name="message_success" id="message_success" class="tinymce form-control <?php if (
                                session("errors.message_success")
                            ): ?>is-invalid<?php endif; ?>"><?=old('message_success') ?></textarea>
                            <div class="invalid-feedback"><?= session(
                                "errors.message_success", 
                            ) ?></div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-12">
                            <label class="form-label">Text für Freigabe Anforderung</label>
                            <textarea rows="10" name="mail_new" id="mail_new" class="tinymce form-control <?php if (
                                session("errors.mail_new")
                            ): ?>is-invalid<?php endif; ?>"><?=old('mail_new') ?></textarea>
                            <div class="invalid-feedback"><?= session(
                                "errors.mail_new", 
                            ) ?></div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-12">
                            <label class="form-label">Text für Bestätgungsmail</label>
                            <textarea rows="10" name="mail_confirmation" id="mail_confirmation" class="tinymce form-control <?php if (
                                session("errors.mail_confirmation")
                            ): ?>is-invalid<?php endif; ?>"><?=old('mail_confirmation') ?></textarea>
                            <div class="invalid-feedback"><?= session(
                                "errors.mail_confirmation", 
                            ) ?></div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-12">
                            <label class="form-label">Text für Freigabemail</label>
                            <textarea rows="10" name="mail_approved" id="mail_approved" class="tinymce form-control <?php if (
                                session("errors.mail_approved")
                            ): ?>is-invalid<?php endif; ?>"><?=old('mail_approved') ?></textarea>
                            <div class="invalid-feedback"><?= session(
                                "errors.mail_approved", 
                            ) ?></div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-12">
                            <label class="form-label">Text wenn abgelehnt</label>
                            <textarea rows="10" name="mail_rejected" id="mail_rejected" class="tinymce form-control <?php if (
                                session("errors.mail_rejected")
                            ): ?>is-invalid<?php endif; ?>"><?=old('mail_rejected') ?></textarea>
                            <div class="invalid-feedback"><?= session(
                                "errors.mail_rejected", 
                            ) ?></div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-12">
                            <label class="form-label">Neue Einträge an folgende Benutzer melden</label>
                            <select class="form-select tomselect-multiple-check" name="notify[]" name="notify" multiple="multiple">
                                <?php foreach($users as $user): ?>
                                    <option value="<?=$user->id?>"><?=$user->email?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= session(
                                "errors.mail_rejected", 
                            ) ?></div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="btn-list justify-content-end">
                        <a href="<?=base_url(route_to('testimonialForm.index'))?>" class="btn">
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