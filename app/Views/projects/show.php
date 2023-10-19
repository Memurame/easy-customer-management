<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<?php
$offer = ($project->date_offer) ? new DateTime($project->date_offer) : null;
$order = ($project->date_order) ? new DateTime($project->date_order) : null;
$finish = ($project->date_finish) ? new DateTime($project->date_finish) : null;
?>

    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Projekt
                    </div>
                    <h2 class="page-title">
                        <?php echo $project->name ?>
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="<?=base_url(route_to('project.index'))?>" class="btn btn-secondary d-none d-sm-inline-block">
                            Zurück
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Projektinfos</h3>
                            <div class="card-actions">
                                <?php if(auth()->user()->can('project.edit')): ?>
                                    <a href="<?=base_url(route_to('project.edit', $project->id))?>" class="btn btn-primary">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                            <path d="M16 5l3 3"></path>
                                        </svg>
                                        Bearbeiten

                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Status</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php if($project->status == 1):?>
                                        <span class="badge text-bg-success">Aktiv</span>
                                    <?php elseif($project->status == 2):?>
                                        <span class="badge text-bg-secondary">Archiviert</span>
                                    <?php else:?>
                                        <span class="badge text-bg-danger">Inaktiv</span>
                                    <?php endif;?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Projektname</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php echo $project->name ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Kunde</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php if(auth()->user()->can('customer.show')): ?>
                                        <a href="<?=base_url().route_to('customer.show', $project->getCustomerInfo('id'))?>"><?=$project->getCustomerInfo('customername')?></a>
                                    <?php else: ?>
                                        <?=$project->getCustomerInfo('customername')?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Offerte erstellt</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?= ($offer) ? $offer->format('d.m.Y') : '---'?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Projekt gestartet</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?= ($order) ? $order->format('d.m.Y') : '---'?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Projekt abgeschlossen</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?= ($finish) ? $finish->format('d.m.Y') : '---'?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <textarea class="form-control" rows="8"><?= $project->notes ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Kommentare</h3>
                            <div class="card-actions">
                                <?php if(auth()->user()->can('comment.add')): ?>
                                    <a href="<?=base_url(route_to('comment.add'))?>?projectId=<?=$project->id?>" class="btn btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 5l0 14"></path>
                                            <path d="M5 12l14 0"></path>
                                        </svg>
                                        Neu
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table" id="table-comments">

                                    <thead>
                                    <th>Datum</th>
                                    <th>Art</th>
                                    <th>Text</th>
                                    <th>Verknüpfung</th>
                                    <th></th>
                                    </thead>
                                    <tbody>
                                    <?php foreach($comments as $index => $comment): ?>
                                        <tr>
                                            <td>

                                                <div class="flex-fill">
                                                    <div class="font-weight-medium"><?=$comment->updated_at->format('Y.m.d - H:i')?></div>
                                                    <?php if($comment->updated_at > $comment->created_at):?>
                                                        <div class="text-secondary small lh-base">(wurde bearbeitet)</div>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if($comment->comment_typ == -1): ?>
                                                    <span class="badge bg-red text-red-fg">Negativ</span>
                                                <?php elseif($comment->comment_typ == 0): ?>
                                                    <span class="badge bg-azure text-azure-fg">Neutral</span>
                                                <?php elseif($comment->comment_typ == 1): ?>
                                                    <span class="badge bg-green text-green-fg">Positiv</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?=$comment->comment?></td>
                                            <td>
                                                <?=($comment->customer_id)? '<span class="badge text-bg-secondary">Kunde</span>': null; ?>
                                                <?=($comment->project_id)? '<span class="badge text-bg-secondary">Projekt</span>': null; ?>
                                                <?=($comment->website_id)? '<span class="badge text-bg-secondary">Webseite</span>': null; ?>
                                            </td>
                                            <td class="text-end">
                                                <?php if(auth()->user()->can('comment.edit')): ?>
                                                    <a href="<?=base_url(route_to('comment.edit', $comment->id))?>?ref=customer" class="btn btn-icon text-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                                            <path d="M16 5l3 3"></path>
                                                        </svg>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if(auth()->user()->can('comment.delete')): ?>
                                                    <button class="text-danger p-0 btn btn-icon delete-comment"
                                                            data-id="<?=$comment->id?>">
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
                                    <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>












<?= $this->endSection() ?>