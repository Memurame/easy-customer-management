<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<?php


$installed = ($website->website_installed) ? new DateTime($website->website_installed) : null;
$golive = ($website->website_live) ? new DateTime($website->website_live) : null;

?>

<div class="d-flex border-bottom pb-2 mb-4">
    <div class="p-1 flex-grow-1">
        <ol class="breadcrumb my-0 ">
            <li class="breadcrumb-item"><a href="<?=base_url()?>">Übersicht</a></li>
            <li class="breadcrumb-item"><a href="<?=base_url()?><?=route_to('website.index')?>">Webseiten</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?=$website->contact_lastname?>
                <?=$website->contact_firstname?></li>
        </ol>
    </div>
</div>
<div class="row g-3">
    <div class="col-6">
        <div class="bgc-white p-20 bd">
            <div class="d-flex justify-content-between">
                <h6 class="c-grey-900">Webseiteninfo</h6>
                <a href="<?=base_url()?><?=route_to('website.edit', $website->id)?>"
                    class="btn btn-primary btn-sm">Bearbeiten</a>
            </div>
            <div class="mT-30">
                <div class="row mb-3">
                    <div class="col-sm-5">
                        <h6 class="mb-0">Name, Vorname</h6>
                    </div>
                    <div class="col-sm-7 text-secondary">
                        <?php echo $website->getCustomerInfo('contact_lastname') . ' ' . $website->getCustomerInfo('contact_firstname') ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-5">
                        <h6 class="mb-0">Firma</h6>
                    </div>
                    <div class="col-sm-7 text-secondary">
                        <?=($website->getCustomerInfo('company') ? '<a href="'.base_url().route_to('customer.show', $website->getCustomerInfo('id')).'">'.$website->getCustomerInfo('company').'</a>' : '---') ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-5">
                        <h6 class="mb-0">Projekt</h6>
                    </div>
                    <div class="col-sm-7 text-secondary">
                        <?=($website->getProjectInfo('name') ? '<a href="'.base_url().route_to('project.show', $website->getProjectInfo('id')).'">'.$website->getProjectInfo('name').'</a>' : '---') ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-5">
                        <h6 class="mb-0">E-Mail</h6>
                    </div>
                    <div class="col-sm-7 text-secondary">
                        <a
                            href="mailto:<?= $website->getCustomerInfo('contact_mail') ?>"><?= $website->getCustomerInfo('contact_mail') ?></a>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-5">
                        <h6 class="mb-0">Webseite Installiert</h6>
                    </div>
                    <div class="col-sm-7 text-secondary">
                        <?= ($website->website_installed) ? $installed->format('d.m.Y') : '---'?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-5">
                        <h6 class="mb-0">Webseite aufschaltung</h6>
                    </div>
                    <div class="col-sm-7 text-secondary">
                        <?= ($website->website_live) ? $golive->format('d.m.Y') : '---'?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-5">
                        <h6 class="mb-0">Tags</h6>
                    </div>
                    <div class="col-sm-7 text-secondary">
                        <?php foreach($website->getTags() as $tag):?>
                        <span
                            class="badge <?=($tag['class']) ? $tag['class'] : 'text-bg-secondary'?>"><?=$tag['name']?></span>
                        <?php endforeach;?>
                    </div>
                </div>
                <div class="row mb-3">
                    <textarea class="form-control" rows="8"><?= $website->notes ?></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="bgc-white p-20 bd">
            <div class="d-flex justify-content-between">
                <h6 class="c-grey-900">Kommentare</h6>
                <a href="<?=base_url()?><?=route_to('comment.add')?>?websiteId=<?=$website->id?>"
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
                                <a href="<?=base_url()?><?=route_to('comment.edit', $comment->id)?>?ref=website"
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