<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<?php


?>

<div class="d-flex border-bottom pb-2 mb-4">
    <div class="p-1 flex-grow-1">
        <ol class="breadcrumb my-0 ">
            <li class="breadcrumb-item"><a href="<?=base_url()?>">Übersicht</a></li>
            <li class="breadcrumb-item"><a href="<?=base_url()?><?=route_to('customer.index')?>">Kunden</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?=$customer->contact_lastname?>
                <?=$customer->contact_firstname?></li>
        </ol>
    </div>

    <div class="">

    </div>
</div>
<div class="row g-3">
    <div class="col-6">
        <div class="bgc-white p-20 bd">
            <div class="d-flex justify-content-between">
                <h6 class="c-grey-900">Kundendaten</h6>
                <a href="<?=base_url()?><?=route_to('customer.edit', $customer->id)?>"
                    class="btn btn-primary btn-sm">Bearbeiten</a>
            </div>
            <div class="mT-30">

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Status</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <?php if($customer->status == 1):?>
                        <span class="badge text-bg-success">Aktiv</span>
                        <?php else:?>
                        <span class="badge text-bg-danger">Inaktiv</span>
                        <?php endif;?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Kundennummer</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <?php echo $customer->customernumber?: '---' ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Name, Vorname</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <?php echo $customer->contact_lastname . ' ' . $customer->contact_firstname ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">E-Mail</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <a href="mailto:<?= $customer->contact_mail ?>"><?= $customer->contact_mail ?></a>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Telefon</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <a href="tel:<?= $customer->contact_tel ?>"><?= $customer->contact_tel ?></a>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Firma</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <?= $customer->company?:'---' ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Adresse</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <?= $customer->street ?><br>
                        <?= $customer->postcode ?> <?= $customer->city ?>
                    </div>
                </div>
                <div class="row">
                    <textarea class="form-control" rows="8"><?= $customer->notes ?></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="bgc-white p-20 bd">
            <div class="d-flex justify-content-between">
                <h6 class="c-grey-900">Kommentare</h6>
                <a href="<?=base_url()?><?=route_to('comment.add')?>?customerId=<?=$customer->id?>"
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
                                <a href="<?=base_url()?><?=route_to('comment.edit', $comment->id)?>?ref=customer"
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