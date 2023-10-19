<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>

    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Admin
                    </div>
                    <h2 class="page-title">
                        Benutzerverwaltung
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <?php if(auth()->user()->can('user.add')): ?>
                            <a href="<?=base_url(route_to('user.add'))?>" class="btn btn-primary d-none d-sm-inline-block">
                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M5 12l14 0"></path></svg>
                                Neuer Benutzer
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
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
                                    <th>Benutzername</th>
                                    <th>Letzte Aktivität</th>
                                    <th>Gruppe</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($users as $index => $user):
                                    if($user->isActivated()){
                                        $status = 'border: 2px solid green;';
                                    } else {
                                         $status = 'border: 2px solid red;';
                                    } ?>

                                <tr>
                                    <td data-label="Name">
                                        <div class="d-flex py-1 align-items-center">
                                            <span class="avatar me-2" style="<?=$status?> background-image: url(<?= profile($user->id)->avatar ?? 'http://www.gravatar.com/avatar'?>)"></span>
                                            <div class="flex-fill">
                                                <div class="font-weight-medium"><?=profile($user->id)->firstname?> <?=profile($user->id)->lastname?></div>
                                                <div class="text-secondary"><?=$user->email ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <?=$user->last_active?>
                                    </td>
                                    <td class="align-middle">
                                        <?php foreach($user->getGroups() as $group): ?>
                                            <?php if($group == 'superadmin'): ?>
                                                <span class="badge bg-red text-red-fg"><?=$group?></span>
                                            <?php elseif($group == 'admin'): ?>
                                                <span class="badge bg-orange text-red-fg"><?=$group?></span>
                                            <?php elseif($group == 'user'): ?>
                                                <span class="badge bg-blue text-red-fg"><?=$group?></span>
                                            <?php else: ?>
                                                <span class="badge text-bg-lime text-white"><?=$group?></span>
                                            <?php endif; ?>

                                        <?php endforeach; ?>
                                    </td>
                                    <td class="text-end">
                                        <?php if((in_array('superadmin', $user->getGroups()) OR
                                            in_array('admin', $user->getGroups())) AND
                                            auth()->user()->can('user.manage-admins') OR
                                            (!in_array('superadmin', $user->getGroups()) AND
                                                !in_array('admin', $user->getGroups()))): ?>
                                            <?php if(auth()->user()->can('user.edit') OR auth()->user()->can('user.delete')): ?>
                                                <div class="dropdown">
                                                    <button class="btn dropdown-toggle align-text-top" data-bs-toggle="dropdown">
                                                        Aktion
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <?php if(auth()->user()->can('user.edit')): ?>
                                                            <a href="<?=base_url(route_to('user.edit', $user->id))?>" class="dropdown-item">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                                                    <path d="M16 5l3 3"></path>
                                                                </svg>
                                                                Bearbeiten
                                                            </a>
                                                            <button type="button" id="admin-password-reset" class="dropdown-item" data-id="<?=$user->id?>">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-key" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                    <path d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z"></path>
                                                                    <path d="M15 9h.01"></path>
                                                                </svg>
                                                                Neues Passwort zusenden</button>
                                                        <?php endif; ?>
                                                        <?php if(auth()->user()->can('user.delete')): ?>
                                                            <button class="text-danger dropdown-item delete-user"
                                                                    data-id="<?=$user->id?>">
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