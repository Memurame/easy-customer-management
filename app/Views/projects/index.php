<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<div class="d-flex border-bottom pb-2 mb-4">
    <div class="p-1 flex-grow-1">
        <ol class="breadcrumb my-0 ">
            <li class="breadcrumb-item"><a href="<?=base_url()?>">Übersicht</a></li>
            <li class="breadcrumb-item active" aria-current="page">Projekte</li>
        </ol>
    </div>

    <div class="">
        <a href="<?=base_url()?><?=route_to('project.add')?>" class="btn btn-primary btn-sm">Neues
            Projekt</a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <h4 class="c-grey-900 mB-20">Projekte / Aufträge</h4>
            <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Projektname</th>
                        <th>Kunde</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($projects as $index => $project):
            

            ?>

                    <tr>
                        <td class="align-middle"><?=$project->name?></td>
                        <td class="align-middle">
                            <?=($project->getCustomerInfo('company')) ? '<a href="'.base_url() . route_to('customer.show', $project->getCustomerInfo('id')).'">'.$project->getCustomerInfo('company').'</a>': '---'?>
                        </td>
                        <td class="align-middle">
                            <?php if($project->status == 1):?>
                            <span class="badge text-bg-success">Aktiv</span>
                            <?php elseif($project->status == 2):?>
                            <span class="badge text-bg-secondary">Archiviert</span>
                            <?php else:?>
                            <span class="badge text-bg-danger">Inaktiv</span>
                            <?php endif;?>
                        </td>
                        <td class="text-end">
                            <div class="btn-group">
                                <a href="<?=base_url()?><?=route_to('project.show', $project->id)?>"
                                    class="btn btn-link text-primary"><i class="fa-solid fa-eye"></i></a>
                                <a href="<?=base_url()?><?=route_to('project.edit', $project->id)?>"
                                    class="btn btn-link text-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="#" class="delete-project btn btn-linkr text-danger"
                                    data-id="<?=$project->id?>"><i class="fa-solid fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                </tbody>


            </table>
        </div>
    </div>



    <?= $this->endSection() ?>