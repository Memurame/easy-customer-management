<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    Mail
                </div>
                <h2 class="page-title">
                    Detail anzeige
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
                <div class="mb-3 row">
                    <label for="input_sender" class="col-sm-2 col-form-label">Absender</label>
                    <div class="col-sm-10">
                        <input type="text" value="<?= $mail->reply_to ?>"
                            placeholder="<?= setting('Email.fromEmail') ?>" class="form-control" disabled>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="input_sender" class="col-sm-2 col-form-label">Empfänger</label>
                    <div class="col-sm-10">
                        <input type="text" value="<?= $mail->receiver ?>" class="form-control" disabled>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="input_sender" class="col-sm-2 col-form-label">Betreff</label>
                    <div class="col-sm-10">
                        <input type="text" value="<?= $mail->subject ?>" class="form-control" disabled>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="input_sender" class="col-sm-2 col-form-label">Inhalt</label>
                    <div class="col-sm-10">
                        <div class="border p-2"><?= $mail->text ?></div>
                    </div>
                </div>
                <?php if($mail->error):?>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Fehlermeldung</label>
                    <div class="col-sm-10">
                        <pre><?=$mail->error?></pre>
                    </div>
                </div>

                <?php endif;?>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>