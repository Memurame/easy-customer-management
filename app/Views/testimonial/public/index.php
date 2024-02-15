<!doctype html>
<html lang="de">

<head>
    <meta name="url" href="<?php echo base_url(); ?>">
    <meta name="currentUrl" href="<?php echo current_url(); ?>">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Thomas Hirter vom Berner Bauern Verband">
    <title><?= service("settings")->get("Site.title") ?></title>

    <link rel="icon" href="<?=base_url() . setting('Site.logo')?>">
    <link rel="icon" type="image/png" href="<?=base_url() . setting('Site.logo')?>" sizes="16x16">
    <link rel="icon" type="image/png" href="<?=base_url() . setting('Site.logo')?>" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=base_url() . setting('Site.logo')?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
   
</head>

<body>
    
    <div class="py-4">
        <?php
        if(file_exists(ROOTPATH . '/writable/testimonial/' . $testimonial->id .'.php')){
            require_once ROOTPATH . '/writable/testimonial/' . $testimonial->id .'.php';
        } else {
            require_once ROOTPATH . '/App/Views/testimonial/public/default.php';
        }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>