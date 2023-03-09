var rootUrl =  document.querySelector('meta[name="url"]').getAttribute('href')
var csrfName = document.getElementById('csrf_security').getAttribute('name')
var csrfHash = document.getElementById('csrf_security').getAttribute('value')

jQuery.fn.extend({

    load_websites: function() {
        if($(this).length && $(this).children("option:selected").val() > 0){
            var selected = $(this).children("option:selected").val();
    

            $.getJSON( rootUrl + '/api/0/websites', { "customer_id": selected })
            .done(function (response) {

                $('#csrf_security').val(response.token);
                csrfHash = response.token;

                $("#website_id option:not(:first)").remove()
                $("#website_id").prop('disabled', true)

                if(response.success == 1) {
                    $.each( response.data, function( key, value ) {
                        var $option = $("<option/>", {
                            value: value.id,
                            text: value.website_url
                            });
                            $("#website_id").prop('disabled', false).append($option);
                    });

                }
        
                
        
            })
            .fail(function( jqxhr, textStatus, error ) {
                var err = textStatus + ", " + error;
                console.log( "Request Failed: " + err );
            });
        }
    },
    load_projects: function() {
        if($(this).length && $(this).children("option:selected").val() > 0){
            var selected = $(this).children("option:selected").val();
    

            $.getJSON( rootUrl + '/api/0/projects', { "customer_id": selected })
            .done(function (response) {

                $('#csrf_security').val(response.token);
                csrfHash = response.token;

                $("#project_id option:not(:first)").remove()
                $("#project_id").prop('disabled', true)

                if(response.success == 1) {
                    $.each( response.data, function( key, value ) {
                        var $option = $("<option/>", {
                            value: value.id,
                            text: value.name
                            });
                            $("#project_id").prop('disabled', false).append($option);
                            
                    });

                }
                
        
            })
            .fail(function( jqxhr, textStatus, error ) {
                var err = textStatus + ", " + error;
                console.log( "Request Failed: " + err );
            });
        }
    }
});


$(document).ready(function () {


    $('.select2-tags').select2({
        theme: 'bootstrap-5'
    });
    $('.select2-group').select2({
        theme: 'bootstrap-5'
    });
    $('.select2').select2({
        theme: 'bootstrap-5'
    });

    $(this).load_websites();   
    $(this).load_projects(); 
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
                url: rootUrl + '/api/0/website/delete/' + $(this).data('wid'),
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

$(".delete-project" ).click(function() {

    var row = $(this).closest('tr');
    Swal.fire({
        title: 'Löschen',
        text: "Möchtest du dieses Projekt wirklich löschen?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        cancelButtonText: 'Abbrechen',
        confirmButtonText: 'Löschen'
    }).then((result) => {
        if (result.isConfirmed) {
            var xhr = $.ajax({
                url: rootUrl + '/api/0/project/delete/' + $(this).data('id'),
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
                url: rootUrl + '/api/0/customer/delete/' + $(this).data('wid'),
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

$(".delete-invoice" ).click(function() {

    var row = $(this).closest('tr');
    Swal.fire({
        title: 'Löschen',
        text: "Möchtest du diese Rechnung wirklich löschen?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        cancelButtonText: 'Abbrechen',
        confirmButtonText: 'Löschen'
    }).then((result) => {
        if (result.isConfirmed) {
            var xhr = $.ajax({
                url: rootUrl + '/api/0/invoice/delete/' + $(this).data('id'),
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

$(".delete-comment" ).click(function() {

    var row = $(this).closest('tr');
    Swal.fire({
        title: 'Löschen',
        text: "Möchtest du diesen Kommentar wirklich löschen?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        cancelButtonText: 'Abbrechen',
        confirmButtonText: 'Löschen'
    }).then((result) => {
        if (result.isConfirmed) {
            var xhr = $.ajax({
                url: rootUrl + '/api/0/comment/delete/' + $(this).data('id'),
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

$(".delete-user" ).click(function() {

    var row = $(this).closest('tr');
    Swal.fire({
        title: 'Löschen',
        text: "Möchtest du diesn Benutzer wirklich löschen?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        cancelButtonText: 'Abbrechen',
        confirmButtonText: 'Löschen'
    }).then((result) => {
        if (result.isConfirmed) {
            var xhr = $.ajax({
                url: rootUrl + '/api/0/user/delete/' + $(this).data('id'),
                type: 'DELETE',
                dataType: 'json',
                data: JSON.stringify({
                    [csrfName]: csrfHash
                }),
                success: function (response) {
                    if(response.success == 1) {
                        location.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            text: response.message,
                        })
                    }

                },
            });
        }
    })
});

$(".delete-tag" ).click(function() {

    var row = $(this).closest('tr');
    Swal.fire({
        title: 'Löschen',
        text: "Möchtest du dieses Schlagwort wirklich löschen?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        cancelButtonText: 'Abbrechen',
        confirmButtonText: 'Löschen'
    }).then((result) => {
        if (result.isConfirmed) {
            var xhr = $.ajax({
                url: rootUrl + '/api/0/tag/delete/' + $(this).data('id'),
                type: 'DELETE',
                dataType: 'json',
                data: JSON.stringify({
                    [csrfName]: csrfHash
                }),
                success: function (response) {
                    if(response.success == 1) {
                        location.reload();
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

$(".token-create" ).click(function(e) {
    e.preventDefault();
    var row = $(this).closest('tr');
    Swal.fire({
        title: 'Neuer Token',
        text: "Möchtest du für diesen Benutzer wirklich einen Token erstellen?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#4caf50',
        cancelButtonColor: '#3085d6',
        cancelButtonText: 'Abbrechen',
        confirmButtonText: 'Generieren'
    }).then((result) => {
        if (result.isConfirmed) {
            var xhr = $.ajax({
                url: rootUrl + '/api/0/profile/createToken',
                type: 'GET',
                dataType: 'json',
                data: JSON.stringify({
                    [csrfName]: csrfHash
                }),
                success: function (response) {
                    if(response.success == 1) {
                        $('#csrf_security').val(response.token);
                        location.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            text: response.message,
                        })
                    }

                },
            });
        }
    })
});

$(".token-delete" ).click(function(e) {
    e.preventDefault();
    var row = $(this).closest('tr');
    Swal.fire({
        title: 'Token löschen',
        text: "Möchtest du den Token für diesen Benutzer wirklich löschen?",
        icon: 'questioon',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        cancelButtonText: 'Abbrechen',
        confirmButtonText: 'Löschen'
    }).then((result) => {
        if (result.isConfirmed) {
            var xhr = $.ajax({
                url: rootUrl + '/api/0/profile/deleteToken',
                type: 'GET',
                dataType: 'json',
                data: JSON.stringify({
                    [csrfName]: csrfHash
                }),
                success: function (response) {
                    if(response.success == 1) {
                        $('#csrf_security').val(response.token);
                        csrfHash = response.token;
                        row.remove();
                        Swal.fire({
                            icon: 'success',
                            text: response.message
                          })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            text: response.message,
                        })
                    }

                },
            });
        }
    })
});

$("#customer_id").change(function(e){
    $(this).load_websites();   
    $(this).load_projects(); 
});