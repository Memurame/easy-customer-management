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
                            Newsletter Empfänger
                        </div>
                        <h2 class="page-title">
                            <?php echo $address->email ?>
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
                        <div class="row">
                            <div class="col-md-6">
                                <label for="email" class="form-label">E-Mail <span class="text-danger">*</span></label>
                                <input type="text"
                                    class="form-control <?php if(session('errors.email')) : ?>is-invalid<?php endif ?>" id="email"
                                    name="email" value="<?=$address->email ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="firstname" class="form-label">Vorname</label>
                                <input type="text"
                                    class="form-control <?php if(session('errors.firstname')) : ?>is-invalid<?php endif ?>" id="firstname"
                                    name="firstname" value="<?=$address->firstname ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="lastname" class="form-label">Nachname</label>
                                <input type="text"
                                    class="form-control <?php if(session('errors.lastname')) : ?>is-invalid<?php endif ?>" id="lastname"
                                    name="lastname" value="<?=$address->lastname ?>">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="btn-list justify-content-end">
                            <a href="<?=base_url(route_to('newsletter.index'))?>" class="btn">
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