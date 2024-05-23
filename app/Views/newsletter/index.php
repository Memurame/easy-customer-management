<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <h2 class="page-title">
                    Newsletter Empfänger
                </h2>
            </div>
            <!-- Page title actions -->
            <?php if(auth()->user()->can('testimonial.forms')): ?>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        
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
                            <th>E-Mail</th>
                            <th>Name</th>
                            <th>Abacus</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($addresses as  $key => $address):?>

                            <tr>
                                <td class="align-middle">
                                    <?=$address->email?>
                                </td>
                                <td class="align-middle">
                                    <?=$address->firstname?> <?=$address->lastname?>
                                </td>
                                <td class="align-middle">
                                    <?=$address->abacus?>
                                </td>
                                
                                <td class="text-end">
                                    <?php if($address->abacus == NULL):?>
                                        <a href="<?=base_url(route_to('newsletter.edit', $address->id))?>" class="btn btn-icon text-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                                <path d="M16 5l3 3"></path>
                                            </svg>
                                        </a>

                                        <button class="text-danger p-0 btn btn-icon delete-newsletter"
                                                data-id="<?=$address->id?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M4 7l16 0"></path>
                                                <path d="M10 11l0 6"></path>
                                                <path d="M14 11l0 6"></path>
                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                            </svg>
                                        </button>
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