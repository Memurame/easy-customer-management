<?= $this->extend('testimonial/register/layout') ?>
<?= $this->section('main') ?>
<div>
    <div class="w-100 position-relative">
        <div class="bg-body-extra-light pt-5">
            <div class="content content-full">
                <div class="row g-0 justify-content-center">
                    <div class="col-md-12 col-xl-8 py-4 px-4 px-lg-5">
                        <!-- Header -->
                        <div class="text-center">
                            <h1 class="h4  mb-1">
                                <?= $form->title ?>
                            </h1>
                            <?php if($form->description): ?>
                            <p class="text-muted mb-3">
                                <?= $form->description ?>
                            </p>
                            <?php endif ?>
                        </div>
                        <!-- END Header -->

                        <form method="POST" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <div class="row py-3">
                                <div class="col-6 mb-4">
                                    <label class="form-label" for="firstname">Vorname</label>
                                    <input
                                        class="form-control form-control-lg form-control-alt <?php if(session('errors.firstname')) : ?>is-invalid<?php endif ?>"
                                        name="firstname" id="firstname" type="text" value="<?=old('firstname') ?>">
                                </div>
                                <div class="col-6 mb-4">
                                    <label class="form-label" for="lastname">Nachname</label>
                                    <input
                                        class="form-control form-control-lg form-control-alt <?php if(session('errors.lastname')) : ?>is-invalid<?php endif ?>"
                                        name="lastname" id="lastname" type="text" value="<?=old('lastname') ?>">
                                </div>
                                <div class="col-12 mb-4">
                                    <label class="form-label" for="email">E-Mail</label>
                                    <input
                                        class="form-control form-control-lg form-control-alt <?php if(session('errors.email')) : ?>is-invalid<?php endif ?>"
                                        name="email" id="email" type="text" value="<?=old('email') ?>">
                                </div>
                            </div>
                            <?php foreach($formFields['sections'] as $section): ?>
                            <hr>
                            <div class="row py-3">
                                <?php foreach($section['fields'] as $fieldName => $field): ?>
                                <?php if($field['type'] == "text"): ?>
                                <div class="pb-3 <?= (isset($field['outerClass'])) ? $field['outerClass'] : null ?>">
                                    <label class="form-label" for="<?= $fieldName ?>"><?=$field['title'] ?>
                                        <?php if(isset($field['required']) && $field['required']): ?><span
                                            class="text-danger">*</span><?php endif; ?></label>
                                    <input
                                        class="form-control<?php if(session('errors.' .$fieldName)) : ?> is-invalid<?php endif ?> <?= (isset($field['inputClass'])) ? $field['inputClass'] : null ?>"
                                        name="<?= $fieldName ?>" id="<?= $fieldName ?>" type="text"
                                        value="<?=old($fieldName) ?>">
                                    <div class="invalid-feedback"><?= session('errors.' .$fieldName) ?></div>
                                    <?php if(isset($field['desc'])): ?>
                                    <div class="form-text text-primary"><?=$field['desc'] ?></div>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>

                                <?php if($field['type'] == "upload"): ?>
                                <div class="pb-3 <?= (isset($field['outerClass'])) ? $field['outerClass'] : null ?>">
                                    <label class="form-label" for="<?= $fieldName ?>"><?=$field['title'] ?>
                                        <?php if(isset($field['required']) && $field['required']): ?><span
                                            class="text-danger">*</span><?php endif; ?></label>
                                    <input
                                        class="form-control<?php if(session('errors.' .$fieldName)) : ?> is-invalid<?php endif ?> <?= (isset($field['inputClass'])) ? $field['inputClass'] : null ?>"
                                        name="<?= $fieldName ?>" id="<?= $fieldName ?>" type="file"
                                        value="<?=old($fieldName) ?>">
                                    <div class="invalid-feedback"><?= session('errors.' .$fieldName) ?></div>
                                    <?php if(isset($field['desc'])): ?>
                                    <div class="form-text text-primary"><?=$field['desc'] ?></div>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                                <?php if($field['type'] == "select"): ?>
                                <div class="pb-3 <?= (isset($field['outerClass'])) ? $field['outerClass'] : null ?>">
                                    <label class="form-label" for="<?= $fieldName ?>"><?=$field['title'] ?>
                                        <?php if(isset($field['required']) && $field['required']): ?><span
                                            class="text-danger">*</span><?php endif; ?></label>
                                    <select
                                        class="form-select form-control-lg form-control-alt<?php if(session('errors.' .$fieldName)) : ?> is-invalid<?php endif ?> <?= (isset($field['inputClass'])) ? $field['inputClass'] : null ?>"
                                        name="<?= $fieldName ?>" id="<?= $fieldName ?>">
                                        <?php
                                                    foreach($field['option'] as $value => $name){
                                                        echo '<option value="'.$value.'">'.$name.'</option>';
                                                    }
                                                    ?>
                                    </select>
                                    <div class="invalid-feedback"><?= session('errors.' .$fieldName) ?></div>
                                    <?php if(isset($field['desc'])): ?>
                                    <div class="form-text text-primary"><?=$field['desc'] ?></div>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>

                                <?php if($field['type'] == "textarea"): ?>
                                <div class="pb-3 <?= (isset($field['outerClass'])) ? $field['outerClass'] : null ?>">
                                    <label class="form-label" for="<?= $fieldName ?>"><?=$field['title'] ?>
                                        <?php if(isset($field['required']) && $field['required']): ?><span
                                            class="text-danger">*</span><?php endif; ?></label>
                                    <textarea
                                        class="form-control form-control-lg form-control-alt<?php if(session('errors.' .$fieldName)) : ?> is-invalid<?php endif ?> <?= (isset($field['inputClass'])) ? $field['inputClass'] : null ?>"
                                        name="<?= $fieldName ?>" id="<?= $fieldName ?>"
                                        rows="4"><?=old($fieldName) ?></textarea>
                                    <div class="invalid-feedback"><?= session('errors.' .$fieldName) ?></div>
                                    <?php if(isset($field['desc'])): ?>
                                    <div class="form-text text-primary"><?=$field['desc'] ?></div>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>

                                <?php if($field['type'] == "checkbox"): ?>
                                <div class="<?= (isset($field['outerClass'])) ? $field['outerClass'] : null ?>">
                                    <label class="form-label d-block"><?=$field['title'] ?>
                                        <?php if(isset($field['required']) && $field['required']): ?><span
                                            class="text-danger">*</span><?php endif; ?></label>
                                    <?php foreach($field['option'] as $key => $value): ?>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" value="<?= $key ?>"
                                            id="<?= $fieldName ?>[<?= $key ?>]" name="<?= $fieldName ?>[]">
                                        <label class="form-check-label"
                                            for="<?= $fieldName ?>[<?= $key ?>]"><?= $value ?></label>
                                    </div>
                                    <?php endforeach; ?>
                                    <div class="invalid-feedback"><?= session('errors.' .$fieldName) ?></div>
                                    <?php if(isset($field['desc'])): ?>
                                    <div class="form-text text-primary"><?=$field['desc'] ?></div>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                            <?php endforeach; ?>
                            <div class="row justify-content-center">
                                <div class="col-lg-6 col-xxl-5">
                                    <button type="submit" class="btn w-100 btn-alt-success">
                                        Absenden
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!-- END Sign Up Form -->
                    </div>
                </div>
            </div>
        </div>
        <!-- END Sign Up Section -->
    </div>


</div>
<!-- END Page Content -->
<?= $this->endSection() ?>