<?= $this->extend('testimonial/register/layout') ?>
<?= $this->section('main') ?>
<div>
    <div class="w-100 position-relative">
        <div class="bg-body-extra-light pt-5">
            <div class="content content-full">
                <div class="row g-0 justify-content-center">
                    <div class="col-md-12 col-xl-8 py-4 px-4 px-lg-5">
                        <?=$form->message_success?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>