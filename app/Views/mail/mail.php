<?= $this->extend("templates/layout") ?>
<?= $this->section("main") ?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    Mail
                </div>
                <h2 class="page-title">
                    Neue Mail erfassen
                </h2>
            </div>
        </div>
    </div>
</div>
<!-- Page body -->
<div class="page-body">
    <form method="POST" action="<?= base_url(route_to("mail.index")) ?>">
        <div class="container-xl">
            <div class="card">
                <div class="card-body">
                    <?= csrf_field() ?>
                    <div class="row mb-3">
                        <label for="mail_template" class="col-sm-2 col-form-label">Vorlage</label>
                        <div class="col-sm-10">
                            <select name="mail_template" id="mail_template" class="form-select tomselect-default">
                                <?php if ($list): ?>
                                <option value="0">-- Ohne Vorlage --</option>
                                <?php foreach ($list as $entry): ?>
                                <option value="<?= $entry->id ?>" <?= $current ==
$entry->id
    ? "selected"
    : "" ?>>
                                    <?= $entry->name ?></option>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <option value="0">-- Keine Vorlagen vorhanden --</option>
                                <?php endif; ?>
                            </select>
                        </div>

                    </div>
                    <hr>
                    <div class=" mb-3 row">
                        <label for="input_sender" class="col-sm-2 col-form-label">Absender</label>
                        <div class="col-sm-10">
                            <input type="text" value="<?= $entwurf
                                ? $entwurf->reply_to
                                : old(
                                    "input_sender",
                                ) ?>" placeholder="<?= setting(
    "Email.fromEmail",
) ?>" id="input_sender" name="input_sender" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="input_receiver" class="col-sm-2 col-form-label">Empfänger</label>
                        <div class="col-sm-10">
                            <input type="text" value="<?= old(
                                "input_receiver",
                            ) ?>" id="input_receiver" name="input_receiver" class="form-control <?php if (
    session("errors.input_receiver")
): ?>is-invalid<?php endif; ?>">
                            <div class="invalid-feedback"><?= session(
                                "errors.input_receiver",
                            ) ?></div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="input_subject" class="col-sm-2 col-form-label">Betreff</label>
                        <div class="col-sm-10">
                            <input value="<?= $entwurf
                                ? $entwurf->subject
                                : old(
                                    "input_subject",
                                ) ?>" type="text" class="form-control <?php if (
    session("errors.input_subject")
): ?>is-invalid<?php endif; ?>" name="input_subject" id="input_subject">
                            <div class="invalid-feedback"><?= session(
                                "errors.input_subject",
                            ) ?></div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="input_text" class="col-sm-2 col-form-label">Nachricht</label>
                        <div class="col-sm-10">
                            <textarea rows="10" name="input_text" id="input_mail_text" class="tinymce form-control <?php if (
                                session("errors.input_text")
                            ): ?>is-invalid<?php endif; ?>"><?= $entwurf
    ? $entwurf->text
    : old("input_text") ?></textarea>
                            <div class="invalid-feedback"><?= session(
                                "errors.input_text",
                            ) ?></div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between flex-md-row flex-column">
                        <div>
                            <div class="input-group">

                                <input type="text" class="form-control" name="save_name" placeholder="Speichern als..." value="<?= $entwurf
                                        ? $entwurf->name
                                        : "" ?>">

                                <button type=" submit" class="btn btn-success" formaction="<?= $current
                                    ? base_url(route_to("mail.edit", $current))
                                    : base_url(route_to("mail.save")) ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2">
                                        </path>
                                        <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                        <path d="M14 4l0 4l-6 0l0 -4"></path>
                                    </svg>
                                    Speichern
                                </button>
                            </div>
                        </div>
                        <div class="">
                            <?php if ($current): ?>
                            <button class="btn btn-danger delete-mail" data-id="<?= $current ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M4 7l16 0"></path>
                                    <path d="M10 11l0 6"></path>
                                    <path d="M14 11l0 6"></path>
                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                </svg>
                                Vorlage löschen
                            </button>
                            <?php endif; ?>
                            <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-send" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M10 14l11 -11"></path>
                                    <path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5">
                                    </path>
                                </svg>
                                Senden
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?= $this->endSection() ?>