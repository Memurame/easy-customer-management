<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <h2 class="page-title">
                    Abacus Adressen
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
        <div class="card mb-2">
            <form method="POST">
            <?= csrf_field() ?>
                <div class="card-stamp">
                    <div class="card-stamp-icon bg-green">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-adjustments"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 10a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M6 4v4" /><path d="M6 12v8" /><path d="M10 16a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M12 4v10" /><path d="M12 18v2" /><path d="M16 7a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M18 4v1" /><path d="M18 9v11" /></svg>
                    </div>
                </div>

                <div class="card-body">
                    <h3 class="card-title">Filter</h3>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="groups" class="form-label">Gruppierungen</label>
                            <select class="form-select tomselect-multiple-check" name="groups[]" id="groups" multiple="multiple">
                                <?php foreach($groups as $group): ?>
                                <option value="<?=$group['id'] ?>"<?=(isset($request['groups']) AND in_array($group['id'], $request['groups'])) ? 'selected' : '' ?> > <?=$group['group_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="membertype" class="form-label">Mitgliederart</label>
                            <select class="form-select tomselect-multiple-check" name="membertype[]" id="membertype" multiple="multiple">
                                <?php foreach($types as $type): ?>
                                <option value="<?=$type['id'] ?>" <?=(isset($request['membertype']) AND in_array($type['id'], $request['membertype'])) ? 'selected' : '' ?> ><?=$type['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="btn-list justify-content-end">
                            <button class="btn btn-primary d-none d-sm-inline-block" type="submit">
                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"></path>
                                    <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                    <path d="M14 4l0 4l-6 0l0 -4"></path>
                                </svg>
                                Suchen
                            </button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive-md">
                    <table class="table table-vcenter card-table" id="table-customer">
                        <thead>
                        <tr>
                            <th style="width: 30px">#</th>
                            <th>Name</th>
                            <th>Typ</th>
                            <th>Zahldatum</th>
                            <th>Telefon</th>
                            <th style="width:150px">Mail</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($addresses as  $key => $address):?>

                            <tr>
                                <td class="align-middle"><?=$address->abacus?></td>
                                <td class="align-middle">
                                    <?=$address->firstname?> <?=$address->lastname?>
                                </td>
                                <td class="align-middle">
                                    <?=$address->member_typ?>
                                </td>
                                <td class="align-middle">
                                    
                                </td>
                                <td class="align-middle">
                                    <?=$address->phone1?>
                                    <?php if($address->phone2 != NULL){
                                        echo"<br>" . $address->phone2;
                                    }
                                    
                                    if($address->mobile != NULL){
                                        echo"<br>" . $address->mobile;
                                    }?>
                                </td>
                                <td class="align-middle">
                                    <?=$address->email?>
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