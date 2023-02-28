<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<?php
$offer = ($project->date_offer) ? new DateTime($project->date_offer) : null;
$order = ($project->date_order) ? new DateTime($project->date_order) : null;
$finish = ($project->date_finish) ? new DateTime($project->date_finish) : null;

?>

<div class="d-flex border-bottom pb-2 mb-4">
    <div class="p-1 flex-grow-1">
        <ol class="breadcrumb my-0 ">
            <li class="breadcrumb-item"><a href="<?=base_url()?>">Übersicht</a></li>
            <li class="breadcrumb-item"><a href="<?=base_url()?><?=route_to('project.index')?>">Projekte</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?=$project->name?></li>
        </ol>
    </div>
</div>
<div class="row g-3">
    <div class="col-6">

        <div class="bgc-white p-20 bd">
            <div class="d-flex justify-content-between">
                <h6 class="c-grey-900">Projektinfos</h6>
                <a href="<?=base_url()?><?=route_to('project.edit', $project->id)?>"
                    class="btn btn-primary btn-sm">Bearbeiten</a>
            </div>
            <div class="mT-30">
                <div class="row mb-3">
                    <div class="col-sm-5">
                        <h6 class="mb-0">Status</h6>
                    </div>
                    <div class="col-sm-7 text-secondary">
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
                    <div class="col-sm-5">
                        <h6 class="mb-0">Projektname</h6>
                    </div>
                    <div class="col-sm-7 text-secondary">
                        <?php echo $project->name ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-5">
                        <h6 class="mb-0">Kunde</h6>
                    </div>
                    <div class="col-sm-7 text-secondary">
                        <?= $project->getCustomerInfo('company')?: '---' ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-5">
                        <h6 class="mb-0">Offerte erstellt</h6>
                    </div>
                    <div class="col-sm-7 text-secondary">
                        <?= ($offer) ? $offer->format('d.m.Y') : '---'?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-5">
                        <h6 class="mb-0">Projekt gestartet</h6>
                    </div>
                    <div class="col-sm-7 text-secondary">
                        <?= ($order) ? $order->format('d.m.Y') : '---'?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-5">
                        <h6 class="mb-0">Projekt abgeschlossen</h6>
                    </div>
                    <div class="col-sm-7 text-secondary">
                        <?= ($finish) ? $finish->format('d.m.Y') : '---'?>
                    </div>
                </div>
                <div class="row mb-3">
                    <textarea class="form-control" rows="8"><?= $project->notes ?></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="bgc-white p-20 bd">
            <div class="d-flex justify-content-between">
                <h6 class="c-grey-900">Kommentare</h6>
                <a href="<?=base_url()?><?=route_to('comment.add')?>?projectId=<?=$project->id?>"
                    class="btn btn-primary btn-sm">Neuer
                    Kommentar</a>
            </div>
            <div class="mT-30">
                <table id="datatable-comments-simple" class="table" style="width:100%">
                    <tbody>
                        <?php foreach($comments as $index => $comment):
                            if($comment->comment_typ == -1){
                                $typ = 'table-danger';
                            } elseif($comment->comment_typ == 1){
                                $typ = 'table-success';
                            } else {
                                $typ = null;
                            }
                            ?>
                        <tr class="<?=$typ?>">
                            <td class="position-relative">
                                <a href="<?=base_url()?><?=route_to('comment.edit', $comment->id)?>?ref=project"
                                    class="position-absolute" style="top: 5px; right: 30px;"><i
                                        class="fa-solid fa-pen-to-square"></i></a>
                                <button class="position-absolute text-danger p-0 btn btn-link delete-comment"
                                    data-id="<?=$comment->id?>" style="top: 5px; right: 8px;"><i
                                        class="fa-solid fa-trash"></i></button>
                                <strong style="font-size:13px"><?=$comment->updated_at->format('d.m.Y - H:i')?></strong>
                                <?=($comment->updated_at > $comment->created_at) ? ' <span style="font-size:10px;">(wurde bearbeitet)</span>' : null; ?>

                                <p>
                                    <?=$comment->comment?>
                                </p>
                                <?=($comment->customer_id)? '<span class="badge text-bg-secondary">Kunde</span>': null; ?>
                                <?=($comment->project_id)? '<span class="badge text-bg-secondary">Projekt</span>': null; ?>
                                <?=($comment->website_id)? '<span class="badge text-bg-secondary">Webseite</span>': null; ?>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>


            </div>
        </div>
    </div>
</div>





<?= $this->endSection() ?>