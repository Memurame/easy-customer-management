<?= $this->extend('templates/layout') ?>
<?= $this->section('main') ?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    Testimonial
                </div>
                <h2 class="page-title">
                    <?=$testimonial->firstname?> <?=$testimonial->lastname?>
                </h2>
            </div>
        </div>
    </div>
</div>
<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
    <form method="post">
        <div class="card mb-3">
            <div class="card-body">
            <h3 class="card-title">Allgemein</h3>
                <div class="row mb-3">
                    <div class="col-6">
                        <label for="firstname" class="form-label">Vorname <span class="text-danger">*</span></label>
                        <input type="text"
                            class="form-control <?php if(session('errors.firstname')) : ?>is-invalid<?php endif ?>" id="firstname"
                            name="firstname" value="<?=$testimonial->firstname ?>">
                        <div class="invalid-feedback"><?= session('errors.firstname') ?></div>
                    </div>
                    <div class="col-6">
                        <label for="lastname" class="form-label">Nachname <span class="text-danger">*</span></label>
                        <input type="text"
                            class="form-control <?php if(session('errors.lastname')) : ?>is-invalid<?php endif ?>" id="lastname"
                            name="lastname" value="<?=$testimonial->lastname ?>">
                        <div class="invalid-feedback"><?= session('errors.lastname') ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label for="email" class="form-label">E-Mail <span class="text-danger">*</span></label>
                        <input type="text"
                            class="form-control <?php if(session('errors.email')) : ?>is-invalid<?php endif ?>" id="email"
                            name="email" value="<?=$testimonial->email ?>">
                        <div class="invalid-feedback"><?= session('errors.email') ?></div>
                    </div>
                </div>
            </div>
        </div>
        <?php foreach($formFields['sections'] as $section): ?>
        <div class="card mb-3">
            <div class="card-body">
                <h3 class="card-title"><?= $section['title'] ?></h3>
                <div class="row mb-3">
                    <?php foreach($section['fields'] as $fieldName => $field): ?>
                    <?php if($field['type'] == "text"): ?>
                    <div class="<?= (isset($field['outerClass'])) ? $field['outerClass'] : null ?>">
                        <label class="form-label" for="<?= $fieldName ?>"><?=$field['title'] ?>
                            <?php if(isset($field['required']) && $field['required']): ?><span
                                class="text-danger">*</span><?php endif; ?></label>
                        <input
                            class="form-control<?php if(session('errors.' .$fieldName)) : ?> is-invalid<?php endif ?> <?= (isset($field['inputClass'])) ? $field['inputClass'] : null ?>"
                            name="<?= $fieldName ?>" id="<?= $fieldName ?>" type="text"
                            value="<?=$testimonial->dataArray->{$fieldName} ?>">
                        <div class="invalid-feedback"><?= session('errors.' .$fieldName) ?></div>
                        <?php if(isset($field['desc'])): ?>
                        <div class="form-text text-primary"><?=$field['desc'] ?></div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <?php if($field['type'] == "select"): ?>
                    <div class="<?= (isset($field['outerClass'])) ? $field['outerClass'] : null ?>">
                        <label class="form-label" for="<?= $fieldName ?>"><?=$field['title'] ?>
                            <?php if(isset($field['required']) && $field['required']): ?><span
                                class="text-danger">*</span><?php endif; ?></label>
                        <select
                            class="form-select<?php if(session('errors.' .$fieldName)) : ?> is-invalid<?php endif ?> <?= (isset($field['inputClass'])) ? $field['inputClass'] : null ?>"
                            name="<?= $fieldName ?>" id="<?= $fieldName ?>">
                            <?php
                                foreach($field['option'] as $value => $name){
                                    echo '<option value="'.$value.'" '.(($testimonial->dataArray->{$fieldName} == $value) ? 'selected' : null) .'>'.$name.'</option>';
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
                    <div class="<?= (isset($field['outerClass'])) ? $field['outerClass'] : null ?>">
                        <label class="form-label" for="<?= $fieldName ?>"><?=$field['title'] ?>
                            <?php if(isset($field['required']) && $field['required']): ?><span
                                class="text-danger">*</span><?php endif; ?></label>
                        <textarea
                            class="form-control<?php if(session('errors.' .$fieldName)) : ?> is-invalid<?php endif ?> <?= (isset($field['inputClass'])) ? $field['inputClass'] : null ?>"
                            name="<?= $fieldName ?>" id="<?= $fieldName ?>"
                            rows="4"><?=$testimonial->dataArray->{$fieldName} ?></textarea>
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
                                id="<?= $fieldName ?>[<?= $key ?>]" name="<?= $fieldName ?>[]"
                                <?=($testimonial->dataArray->{$fieldName} != null && in_array($key, $testimonial->dataArray->{$fieldName})) ? 'checked' : null ?>>
                            <label class="form-check-label" for="<?= $fieldName ?>[<?= $key ?>]"><?= $value ?></label>
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
            </div>
        </div>
        <?php endforeach; ?>
        <div class="btn-list justify-content-end">
            <a href="<?=base_url(route_to('testimonial.index'))?>" class="btn">
        Abbrechen
            </a>
            <button class="btn btn-success d-none d-sm-inline-block">
                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"></path>
                    <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                    <path d="M14 4l0 4l-6 0l0 -4"></path>
                </svg>
                Speichern
            </button>
        </div>

        </form>                       
    </div>
</div>







<?= $this->endSection() ?>