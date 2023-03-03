<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>


<div class="d-flex border-bottom pb-2 mb-4">
    <div class="p-1 flex-grow-1">
        <ol class="breadcrumb my-0 ">
            <li class="breadcrumb-item"><a href="<?=base_url()?>">Übersicht</a></li>
            <li class="breadcrumb-item active" aria-current="page">Benutzer</li>
        </ol>
    </div>

    <div class="">
        <a href="<?=base_url()?><?=route_to('user.add')?>" class="btn btn-primary btn-sm">Neuer
            Benutzer</a>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <h4 class="c-grey-900 mB-20">Benutzerübersicht</h4>
            <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Benutzername</th>
                        <th>Status</th>
                        <th>Letzte Aktivität</th>
                        <th>Gruppe</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($users as $index => $user): ?>


                    <tr>
                        <td class="align-middle"><?=$user->username?></td>
                        <td class="align-middle">
                            <?php if($user->isActivated()):?>
                            <span class="badge text-bg-success text-white">bestätigt</span>
                            <?php else:?>
                            <span class="badge text-bg-danger text-white">nicht bestätigt</span>
                            <?php endif;?>
                        </td>
                        <td class="align-middle">
                            <?=$user->last_active?>
                        </td>
                        <td class="align-middle">
                            <?php foreach($user->getGroups() as $group): ?>
                            <?php if($group == 'superadmin'): ?>
                            <span class="badge text-bg-danger text-white"><?=$group?></span>
                            <?php elseif($group == 'admin'): ?>
                            <span class="badge text-bg-danger text-white"><?=$group?></span>
                            <?php else: ?>
                            <span class="badge text-bg-primary text-white"><?=$group?></span>
                            <?php endif; ?>

                            <?php endforeach; ?>
                        </td>
                        <td class="text-end">
                            <div class="btn-group">
                                <a href="<?=base_url()?><?=route_to('user.edit', $user->id)?>"
                                    class="btn btn-link text-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="#" class="delete-user btn btn-link text-danger" data-id="<?=$user->id?>"><i
                                        class="fa-solid fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                </tbody>


            </table>
        </div>
    </div>
</div>





<?= $this->endSection() ?>