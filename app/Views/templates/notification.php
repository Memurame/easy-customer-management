<?php if(session()->getFlashdata('msg_success')):?>
<script type="text/javascript">
Swal.fire({
    icon: 'success',
    iconColor: '#3d6208',
    color: '#3d6208',
    background: '#e0edcf',
    text: '<?= session()->getFlashdata('msg_success') ?>',
    toast: true,
    position: 'top-right',
    showConfirmButton: false,
    timer: 10000,
    timerProgressBar: true,
    showCloseButton: true

})
</script>
<?php endif;?>

<?php if(session()->getFlashdata('msg_error')):?>
<script type="text/javascript">
Swal.fire({
    icon: 'error',
    iconColor: '#841717',
    color: '#841717',
    background: '#f8d4d4',
    text: '<?= session()->getFlashdata('msg_error') ?>',
    toast: true,
    position: 'top-right',
    showConfirmButton: false,
    timer: 10000,
    timerProgressBar: true,
    showCloseButton: true

})
</script>
<?php endif;?>

<?php if(session()->getFlashdata('msg_warning')):?>
<script type="text/javascript">
Swal.fire({
    icon: 'warning',
    iconColor: '#8c3507',
    color: '#8c3507',
    background: '#fbdece',
    text: '<?= session()->getFlashdata('msg_warning') ?>',
    toast: true,
    position: 'top-right',
    showConfirmButton: false,
    timer: 10000,
    timerProgressBar: true,
    showCloseButton: true

})
</script>
<?php endif;?>

<?php if(session()->getFlashdata('msg_info')):?>
<script type="text/javascript">
Swal.fire({
    icon: 'info',
    iconColor: '#05576b',
    color: '#05576b',
    background: '#cee9f0',
    text: '<?= session()->getFlashdata('msg_info') ?>',
    toast: true,
    position: 'top-right',
    showConfirmButton: false,
    timer: 10000,
    timerProgressBar: true,
    showCloseButton: true

})
</script>
<?php endif;?>