var rootUrl =  document.querySelector('meta[name="url"]').getAttribute('href')
var currentUrl =  document.querySelector('meta[name="currentUrl"]').getAttribute('href')
var csrfName = document.getElementById('csrf_security').getAttribute('name')
var csrfHash = document.getElementById('csrf_security').getAttribute('value')

$('#table-customer').DataTable({
    "pageLength": 100,
    "lengthMenu": [ [50, 100, 200, -1], [50, 100, 200, "All"] ]});
$('#table-project').DataTable({
    "pageLength": 100,
    "lengthMenu": [ [50, 100, 200, -1], [50, 100, 200, "All"] ]});
$('#table-comments').DataTable({
    order: [[0, 'desc']]
});
$('#table-invoice').DataTable({
    "pageLength": 100,
    "lengthMenu": [ [50, 100, 200, -1], [50, 100, 200, "All"] ],
    "columns": [
        { "width": "30px" },
        { "width": "60px" },
        null,
        null,
        null,
        null,
        null
      ]});
$('#table-contacts').DataTable({
    "pageLength": 100,
    "lengthMenu": [ [50, 100, 200, -1], [50, 100, 200, "All"] ]
});
$('#table-estos').DataTable({
    "pageLength": 100,
    "lengthMenu": [ [50, 100, 200, -1], [50, 100, 200, "All"] ]
});

$('.tinymce').tinymce({
        height: 300,
        menubar: false,
        statusbar: false,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'fullscreen',
            'insertdatetime', 'media', 'table', 'code', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | blocks | bold italic backcolor | ' +
            'alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist outdent indent | removeformat | help',
        content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; -webkit-font-smoothing: antialiased; }'
    }
);

$("#mail_template").change(function() {
    if($("#mail_template option:selected").val() > 0) {
        window.location.href = rootUrl + 'mail/'+ $("#mail_template option:selected").val()
    } else {
        window.location.href = rootUrl + 'mail'
    }
});

$("#invoice_template").change(function() {
    if($("#invoice_template option:selected").val() > 0) {
        window.location.href = currentUrl + '?template=' + $("#invoice_template option:selected").val()
    }
});

$("#receiver-select").change(function() {
    if($("#receiver-select option:selected").val() > 0) {
        const {value: text} = Swal.fire({
            title: 'Neue Nachricht',
            input: 'textarea',
            inputPlaceholder: 'Schreibe deine Nachricht',
            showCancelButton: true,
            html: "<b>Empfänger: </b>" + $("#receiver-select option:selected").text() +
                '<input type="hidden" id="swal2-receiver" value="' + $("#receiver-select option:selected").val() + '">',
            preConfirm: (login) => {
                $.ajax({
                    type: "POST",
                    url: rootUrl + 'api/0/message',
                    contentType: 'application/json',
                    dataType: 'json',
                    data: JSON.stringify({
                        'receiver': $("#swal2-receiver").val(),
                        'message': $("#swal2-textarea").val(),
                        [csrfName]: csrfHash
                    }),
                    cache: false,
                    statusCode: {
                        200: function (respond) {
                            window.location.href = rootUrl + '/message?chat=' + respond.chat_id
                        },
                        400: function (error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Fehler',
                                text: 'Fehler beim überprüfen deiner Nachricht. Du musst eine Nachricht eingeben.'
                            })
                        }
                    }
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        })
    }

});
$(".action-copyinvoicepos" ).click(function(e) {
    e.preventDefault()
    $.ajax({
        url: rootUrl + '/api/0/invoice/position/'  + $(this).data('id') + '/copy',
        type: 'POST',
        dataType: 'json',
        statusCode: {
            204: function() {
                Swal.fire({
                    icon: 'success',
                    text: "Position wurde als Vorlage gespeichert.",
                })
            },
            404: function() {
                Swal.fire({
                    icon: 'error',
                    text: "Diese Position wurde nicht gefunden.",
                })
            }
        },
    });
});
$(".action-mailreset" ).click(function(e) {
    e.preventDefault()
    $.ajax({
        url: rootUrl + '/api/0/mail/' + $(this).data('id') + '/reset',
        type: 'PATCH',
        dataType: 'json',
        statusCode: {
            204: function() {
                window.location.href = currentUrl
            },
            404: function() {
                Swal.fire({
                    icon: 'error',
                    text: response.responseJSON.messages.error,
                })
            }
        },
    });
});
$(".delete-mailsent" ).click(function(e) {
    e.preventDefault()
    Swal.fire({
        title: 'Löschen',
        text: "Möchtest du diese Mail wirklich löschen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        cancelButtonText: 'Abbrechen',
        confirmButtonText: 'Löschen'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: rootUrl + '/api/0/mail/' + $(this).data('id'),
                type: 'DELETE',
                dataType: 'json',
                statusCode: {
                    200: function() {
                        window.location.href = currentUrl
                    },
                    404: function() {
                        Swal.fire({
                            icon: 'error',
                            text: response.responseJSON.messages.error,
                        })
                    }
                },
            });
        }
    })
});

$(".delete-mailtemplate" ).click(function(e) {
    e.preventDefault()
    Swal.fire({
        title: 'Löschen',
        text: "Möchtest du diese Vorlage wirklich löschen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        cancelButtonText: 'Abbrechen',
        confirmButtonText: 'Löschen'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: rootUrl + '/api/0/mail/' + $(this).data('id'),
                type: 'DELETE',
                dataType: 'json',
                statusCode: {
                    200: function() {
                        window.location.href = rootUrl + '/mail'
                    },
                    404: function() {
                        Swal.fire({
                            icon: 'error',
                            text: response.responseJSON.messages.error,
                        })
                    }
                },
            });
        }
    })
});
$(".delete-chat" ).click(function() {
    Swal.fire({
        title: 'Löschen',
        text: "Möchtest du diesen Chat und alle Nachrichten löschen? Der Chat wird für beide Chat Teilnehmer unwiederruflich gelöscht!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        cancelButtonText: 'Abbrechen',
        confirmButtonText: 'Löschen'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: rootUrl + '/api/0/chat/' + $(this).data('id'),
                type: 'DELETE',
                dataType: 'json',
                statusCode: {
                    200: function() {
                        window.location.href = rootUrl + '/message'
                    },
                    404: function() {
                        Swal.fire({
                            icon: 'error',
                            text: response.responseJSON.messages.error,
                        })
                    }
                },
            });
        }
    })
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
            $.ajax({
                url: rootUrl + '/api/0/website/' + $(this).data('id'),
                type: 'DELETE',
                dataType: 'json',
                statusCode: {
                    200: function() {
                        row.remove();
                    },
                    404: function() {
                        Swal.fire({
                            icon: 'error',
                            text: response.responseJSON.messages.error,
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
            $.ajax({
                url: rootUrl + '/api/0/customer/' + $(this).data('id'),
                type: 'DELETE',
                dataType: 'json',
                statusCode: {
                    200: function() {
                        row.remove();
                    },
                    404: function() {
                        Swal.fire({
                            icon: 'error',
                            text: response.responseJSON.messages.error,
                        })
                    }
                }
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
            $.ajax({
                url: rootUrl + '/api/0/project/' + $(this).data('id'),
                type: 'DELETE',
                dataType: 'json',
                statusCode: {
                    200: function() {
                        row.remove();
                    },
                    404: function() {
                        Swal.fire({
                            icon: 'error',
                            text: response.responseJSON.messages.error,
                        })
                    }
                }
            });
        }
    })
});


$(".delete-customer-contact" ).click(function() {

    Swal.fire({
        title: 'Löschen',
        text: "Möchtest du diesen Kontakt wirklich löschen?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        cancelButtonText: 'Abbrechen',
        confirmButtonText: 'Löschen'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: rootUrl + '/api/0/contact/' + $(this).data('id'),
                type: 'DELETE',
                dataType: 'json',
                statusCode: {
                    200: function() {
                        row.remove();
                    },
                    404: function() {
                        Swal.fire({
                            icon: 'error',
                            text: response.responseJSON.messages.error,
                        })
                    }
                }
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
            $.ajax({
                url: rootUrl + '/api/0/invoice/' + $(this).data('id'),
                type: 'DELETE',
                dataType: 'json',
                statusCode: {
                    200: function() {
                        row.remove();
                    },
                    404: function() {
                        Swal.fire({
                            icon: 'error',
                            text: response.responseJSON.messages.error,
                        })
                    }
                }
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
            $.ajax({
                url: rootUrl + '/api/0/comment/' + $(this).data('id'),
                type: 'DELETE',
                dataType: 'json',
                statusCode: {
                    200: function() {
                        row.remove();
                    },
                    404: function() {
                        Swal.fire({
                            icon: 'error',
                            text: response.responseJSON.messages.error,
                        })
                    }
                }
            });
        }
    })
});

$(".delete-user" ).click(function() {

    var row = $(this).closest('tr');
    Swal.fire({
        title: 'Löschen',
        text: "Möchtest du diesen Benutzer wirklich löschen?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        cancelButtonText: 'Abbrechen',
        confirmButtonText: 'Löschen'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: rootUrl + '/api/0/user/' + $(this).data('id') + '',
                type: 'DELETE',
                dataType: 'json',
                statusCode: {
                    200: function() {
                        location.reload()
                    },
                    400: function(response) {
                        Swal.fire({
                            icon: 'error',
                            text: response.responseJSON.messages.error,
                        })
                    },
                    403: function(response) {
                        Swal.fire({
                            icon: 'error',
                            text: response.responseJSON.messages.error,
                        })
                    },
                    404: function(response) {
                        Swal.fire({
                            icon: 'error',
                            text: response.responseJSON.messages.error,
                        })
                    }
                }
            });
        }
    })
});

$(".delete-tag" ).click(function() {

    var row = $(this).closest('tr');
    Swal.fire({
        title: 'Löschen',
        text: "Möchtest du dieses Tag wirklich löschen?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        cancelButtonText: 'Abbrechen',
        confirmButtonText: 'Löschen'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: rootUrl + '/api/0/tag/' + $(this).data('id'),
                type: 'DELETE',
                dataType: 'json',
                statusCode: {
                    200: function() {
                        row.remove();
                    },
                    404: function(response) {
                        Swal.fire({
                            icon: 'error',
                            text: response.responseJSON.messages.error,
                        })
                    }
                }
            });
        }
    })
});

$(".delete-invoicepos" ).click(function() {

    var row = $(this).closest('tr');
    Swal.fire({
        title: 'Löschen',
        text: "Möchtest du diese Position wirklich löschen?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        cancelButtonText: 'Abbrechen',
        confirmButtonText: 'Löschen'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: rootUrl + '/api/0/invoice/position/'  + $(this).data('id'),
                type: 'DELETE',
                dataType: 'json',
                statusCode: {
                    200: function() {
                        row.remove();
                    },
                    403: function(response) {
                        Swal.fire({
                            icon: 'error',
                            text: response.responseJSON.messages.error,
                        })
                    },
                    404: function(response) {
                        Swal.fire({
                            icon: 'error',
                            text: response.responseJSON.messages.error,
                        })
                    }
                }
            });
        }
    })
});

$(".admin-password-reset" ).click(function() {

    var row = $(this).closest('tr');
    Swal.fire({
        title: 'Reset',
        text: "Möchtest du das Passwort dieses Benutzers wirklich zurücksetzen? Das neue Passwort wird dem Benutzer umgehend zugesendet. ",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        cancelButtonText: 'Abbrechen',
        confirmButtonText: 'Reset'
    }).then((result) => {
        if (result.isConfirmed) {
            var xhr = $.ajax({
                url: rootUrl + '/api/0/user/' + $(this).data('id') + '/password',
                type: 'PATCH',
                dataType: 'json',
                statusCode: {
                    200: function(response) {
                        console.log(response)
                        Swal.fire({
                            icon: 'success',
                            text: response.responseText,
                        })
                    },
                    403: function(response) {
                        console.log(response)
                        Swal.fire({
                            icon: 'error',
                            text: response.responseJSON.messages.error,
                        })
                    },
                    404: function(response) {
                        console.log(response)
                        Swal.fire({
                            icon: 'error',
                            text: response.responseJSON.messages.error,
                        })
                    },
                    500: function(response) {
                        console.log(response)
                        Swal.fire({
                            icon: 'error',
                            text: response.responseJSON.messages.error,
                        })
                    }
                }
            });
        }
    })
});


$("#filter-invoice").change(function(e){
    location.href = currentUrl + '?filter=' + $(this).val();
});