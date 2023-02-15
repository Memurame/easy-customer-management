var rootUrl =  document.querySelector('meta[name="url"]').getAttribute('href')
var csrfName = document.getElementById('csrf_security').getAttribute('name')
var csrfHash = document.getElementById('csrf_security').getAttribute('value')

$(document).ready(function () {
    $('#example').DataTable();

});

$(".delete-website" ).click(function() {

    var row = $(this).closest('tr');
    Swal.fire({
        title: 'Löschen',
        text: "Möchtest du diese Webseite wirklich löschen?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        cancelButtonText: 'Abbrechen',
        confirmButtonText: 'Löschen'
    }).then((result) => {
        if (result.isConfirmed) {
            var xhr = $.ajax({
                url: rootUrl + '/api/website/delete/' + $(this).data('wid'),
                type: 'DELETE',
                dataType: 'json',
                data: JSON.stringify({
                    [csrfName]: csrfHash
                }),
                success: function (response) {
                    if(response.success == 1) {
                        $('#csrf_security').val(response.token);
                        csrfHash = response.token;
                        row.remove();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            text: response.error,
                        })
                    }

                },
            });
        }
    })
});

$(".delete-customer" ).click(function() {

    var row = $(this).closest('tr');
    Swal.fire({
        title: 'Löschen',
        text: "Möchtest du diesen Kunden wirklich löschen?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        cancelButtonText: 'Abbrechen',
        confirmButtonText: 'Löschen'
    }).then((result) => {
        if (result.isConfirmed) {
            var xhr = $.ajax({
                url: rootUrl + '/api/customer/delete/' + $(this).data('wid'),
                type: 'DELETE',
                dataType: 'json',
                data: JSON.stringify({
                    [csrfName]: csrfHash
                }),
                success: function (response) {
                    if(response.success == 1) {
                        $('#csrf_security').val(response.token);
                        csrfHash = response.token;
                        row.remove();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            text: response.error,
                        })
                    }

                },
            });
        }
    })
});

