<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    Testimonial
                </div>
                <h2 class="page-title">
                    Formulare
                </h2>
            </div>
            <!-- Page title actions -->
            <?php if(auth()->user()->can('testimonial.forms')): ?>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="<?=base_url(route_to('testimonial.index'))?>" class="btn btn-secondary d-none d-sm-inline-block">
                            Zurück
                        </a>
                        <a href="<?=base_url(route_to('testimonialForm.add'))?>" class="btn btn-primary d-none d-sm-inline-block">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M5 12l14 0"></path></svg>
                            Neues Formular
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive-md">
                    <table class="table table-vcenter card-table" id="table-customer">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($testimonialForms as  $key => $form):?>

                            <tr>
                                <td class="align-middle"><?=$form->id?></td>
                                <td class="align-middle">
                                    <?=$form->title?>
                                </td>
                                <td class="align-middle">
                                    <?php
                                    if($form->active){
                                        echo'<span class="badge text-bg-success text-white">Aktiv</span>';
                                    } else {
                                        echo'<span class="badge text-bg-danger text-white">Inaktiv</span>';
                                    }

                                    ?>
                                </td>
                                <td class="text-end">
                                    
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle align-text-top" data-bs-toggle="dropdown">
                                            Aktion
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                                <a href="<?=base_url(route_to('testimonialForm.edit', $form->id))?>" class="dropdown-item text-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                                        <path d="M16 5l3 3"></path>
                                                    </svg>
                                                    Bearbeiten
                                                </a>
                                                <button class="text-dark dropdown-item copy-to-clipboard"
                                                        data-text="<?=base_url(route_to('testimonial.register'))?>?form=<?=$form->token?>">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-link" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 15l6 -6" /><path d="M11 6l.463 -.536a5 5 0 0 1 7.071 7.072l-.534 .464" /><path d="M13 18l-.397 .534a5.068 5.068 0 0 1 -7.127 0a4.972 4.972 0 0 1 0 -7.071l.524 -.463" /></svg>
                                                    Link kopieren
                                                </button>
                                                <button class="text-danger dropdown-item delete-testimonialform"
                                                        data-id="<?=$form->id?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M4 7l16 0"></path>
                                                        <path d="M10 11l0 6"></path>
                                                        <path d="M14 11l0 6"></path>
                                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                    </svg>
                                                    Löschen
                                                </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        </tbody>


                    </table>
                </div>
            </div>

        </div>
    </div>
</div>







<?= $this->endSection() ?>