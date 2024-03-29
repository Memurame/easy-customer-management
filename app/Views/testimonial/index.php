<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <h2 class="page-title">
                    Testimonial
                </h2>
            </div>
            <!-- Page title actions -->
            <?php if(auth()->user()->can('testimonial.forms')): ?>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="<?=base_url(route_to('testimonialForm.index'))?>" class="btn btn-primary d-none d-sm-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-list-details" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M13 5h8"></path>
                                <path d="M13 9h5"></path>
                                <path d="M13 15h8"></path>
                                <path d="M13 19h5"></path>
                                <path d="M3 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                                <path d="M3 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
                            </svg>
                            Formulare
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
                            <th style="width: 30px">#</th>
                            <th>Name</th>
                            <th style="width:150px">Form</th>
                            <th>Status</th>
                            <th style="width: 100px"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($testimonials as  $key => $testimonial):?>

                            <tr>
                                <td class="align-middle"><?=$testimonial->id?></td>
                                <td class="align-middle">
                                    <a href="<?=base_url(route_to('testimonial.view', $testimonial->token_view))?>" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-external-link" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6" />
                                        <path d="M11 13l9 -9" />
                                        <path d="M15 4h5v5" />
                                    </svg>
                                    <?=$testimonial->firstname?> <?=$testimonial->lastname?>
                                </a>
                                </td>
                                <td class="align-middle"><?=$testimonial->getFormTitle()?></td>
                                <td class="align-middle">
                                    <?php if($testimonial->active == 2):?>
                                    <span class="badge text-bg-success">Online</span>
                                    <?php elseif($testimonial->active == 1):?>
                                    <span class="badge text-bg-warning">Freizuschalten</span>
                                    <?php else:?>
                                    <span class="badge text-bg-danger">Offline</span>
                                    <?php endif;?>
                                </td>
                                <td class="text-end">
                                    <?php if(auth()->user()->can('testimonial.edit') or auth()->user()->can('testimonial.delete')): ?>
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle align-text-top" data-bs-toggle="dropdown">
                                            Aktion
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="<?=base_url(route_to('testimonial.preview', $testimonial->token_view))?>" target="_blank" class="dropdown-item text-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                                    <path d="M21 21l-6 -6"></path>
                                                </svg>
                                                Vorschau
                                            </a>
                                            <?php if(auth()->user()->can('testimonial.edit')): ?>
                                                <a href="<?=base_url(route_to('testimonial.edit', $testimonial->id))?>" class="dropdown-item text-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                                        <path d="M16 5l3 3"></path>
                                                    </svg>
                                                    Bearbeiten
                                                </a>
                                            <?php endif; ?>
                                            <?php if(auth()->user()->can('testimonial.delete')): ?>
                                                <button class="text-danger dropdown-item delete-testimonial"
                                                        data-id="<?=$testimonial->id?>">
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
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
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