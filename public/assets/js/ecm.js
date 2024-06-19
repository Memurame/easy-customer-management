var rootUrl =  document.querySelector('meta[name="url"]').getAttribute('href')
var currentUrl =  document.querySelector('meta[name="currentUrl"]').getAttribute('href')
var csrfName = document.getElementById('csrf_security').getAttribute('name')
var csrfHash = document.getElementById('csrf_security').getAttribute('value')

if($('#jsoneditor').length){
    let valueJSON = document.getElementById("json");
    const options = {
        onChangeText: function (json) {
            valueJSON.value = json;
        },
        modes: ['text', 'code', 'tree', 'view'],
        mode: 'tree',
        ace: ace
    }
    const editor = new JSONEditor(document.getElementById("jsoneditor"), options)
    
    
    const initialJson = {
        "sections": {
            "exampleSection1": {
                "title": "Section1",
                "fields": {
                    "os": {
                        "title": "Welches OS",
                        "type": "select",
                        "desc": "Hier eine Beschreibung",
                        "option": {
                            "0": "Windows",
                            "1": "Linux",
                            "2": "OSX"
                        },
                        "required": true,
                        "outerClass": "col-md-6"
                    },
                    "zustand": {
                        "title": "Wie geht es Dir heute?",
                        "type": "text",
                        "desc": "Kurzer Text über deinen Zustandg",
                        "required": true,
                        "outerClass": "col-md-6"
                        }
                }
            },
            "exampleSection2": {
                "title": "Section2",
                "editable":false,
                "fields": {
                    "about": {
                        "title": "Deine Geschichte",
                        "type": "textarea",
                        "outerClass": "col-md-12"
                    },
                    "transport": {
                        "title": "Velotransport",
                        "type": "checkbox",
                        "log": true,
                        "option": {
                            "0": "Ich kann mein Velo nicht selbst transportieren"
                        },
                        "required": false,
                        "outerClass": "col-md-12"
                    }
                }
            }
        }
    }
    if(valueJSON.value){
        editor.set(valueJSON.value)
        console.log('Exist value');
    } else {
        editor.set(initialJson)
        valueJSON.value = JSON.stringify(initialJson);
        console.log('No value');
    }
    editor.expandAll()
}



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
        { "width": "350px" },
        null,
        { "width": "100px" },
        null,
        null
      ],
    "columnDefs": [{ 
        target: 0, 
        render: DataTable.render.datetime( "DD.MM.Y" ) 
    }]
});
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
        plugins: 'preview importcss searchreplace autolink directionality code visualblocks visualchars fullscreen image link media codesample table charmap nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
        toolbar: "undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | forecolor backcolor removeformat | align numlist bullist | link image | table media | lineheight outdent indent| charmap emoticons | code fullscreen preview | save print | codesample"
    }
);

$('#notes_top').tinymce({
    height: 200,
    menubar: false,
    statusbar: false,
    plugins: [
        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
        'anchor', 'searchreplace', 'visualblocks', 'fullscreen',
        'insertdatetime', 'media', 'table', 'code', 'help', 'wordcount'
    ],
    toolbar: 'undo redo | bold italic backcolor | ' +
        'removeformat | help',
    content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; -webkit-font-smoothing: antialiased; }'
});
$('#notes_bottom').tinymce({
    height: 200,
    menubar: false,
    statusbar: false,
    plugins: [
        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
        'anchor', 'searchreplace', 'visualblocks', 'fullscreen',
        'insertdatetime', 'media', 'table', 'code', 'help', 'wordcount'
    ],
    toolbar: 'undo redo | bold italic backcolor | ' +
        'removeformat | help',
    content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; -webkit-font-smoothing: antialiased; }'
});

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
$(document).on('click', '.action-invoicemoveup', function() {
    console.log("UP");
    var currentRow = $(this).parents().parents("tr:first");
    var prevRow = currentRow.prev();
    if(prevRow.index()>=0){
        currentRow.insertBefore(prevRow);
        $.ajax({
            url: rootUrl + 'api/0/invoice/position/'  + $(this).data('id') + '/up',
            type: 'PATCH',
            dataType: 'json',
            data: JSON.stringify({
                [csrfName]: csrfHash
            })
        });
    }
});
$(document).on('click', '.action-invoicemovedown', function() {
    console.log("DOWN");
    var currentRow = $(this).parents().parents("tr:first");
    var nextRow = currentRow.next();
    currentRow.insertAfter(nextRow);
    $.ajax({
        url: rootUrl + 'api/0/invoice/position/'  + $(this).data('id') + '/down',
        type: 'PATCH',
        dataType: 'json',
        data: JSON.stringify({
            [csrfName]: csrfHash
        })
    });
});
$(document).on('click', '.action-addinvoicetitle', function() {
    e.preventDefault()
    const {value: text} = Swal.fire({
        title: 'Position Titel',
        input: "text",
        inputLabel: "Neuer Titel eingeben",
        showCancelButton: true,
        preConfirm: (call) => {
            $.ajax({
                type: "POST",
                url: rootUrl + 'api/0/invoice/' + $(this).data('id') + '/title',
                contentType: 'application/json',
                dataType: 'json',
                data: JSON.stringify({
                    'title': $("#swal2-input").val(),
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
                            text: 'Du musst einen Titel eingeben!'
                        })
                    }
                }
            });
        },
        allowOutsideClick: () => !Swal.isLoading()
    })
});
$(document).on('click', '.copy-to-clipboard', function() {
    e.preventDefault()

    navigator.clipboard.writeText($(this).data('text'));
});
$(document).on('click', '.action-copyinvoicepos', function() {

    e.preventDefault()
    $.ajax({
        url: rootUrl + '/api/0/invoice/position/'  + $(this).data('id') + '/copy',
        type: 'POST',
        dataType: 'json',
        data: JSON.stringify({
            [csrfName]: csrfHash
        }),
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
$(document).on('click', '.action-mailreset', function() {

    e.preventDefault()
    $.ajax({
        url: rootUrl + '/api/0/mail/' + $(this).data('id') + '/reset',
        type: 'PATCH',
        dataType: 'json',
        data: JSON.stringify({
            [csrfName]: csrfHash
        }),
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
$(document).on('click', '.delete-mailsent', function() {

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
                data: JSON.stringify({
                    [csrfName]: csrfHash
                }),
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
$(document).on('click', '.delete-mailtemplate', function() {

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
                data: JSON.stringify({
                    [csrfName]: csrfHash
                }),
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
$(document).on('click', '.delete-chat', function() {

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
                data: JSON.stringify({
                    [csrfName]: csrfHash
                }),
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
$(document).on('click', '.delete-website', function() {

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
                data: JSON.stringify({
                    [csrfName]: csrfHash
                }),
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
$(document).on('click', '.delete-custome', function() {


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
                data: JSON.stringify({
                    [csrfName]: csrfHash
                }),
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
$(document).on('click', '.delete-project', function() {


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
                data: JSON.stringify({
                    [csrfName]: csrfHash
                }),
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

$(document).on('click', '.delete-customer-contact', function() {

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
                data: JSON.stringify({
                    [csrfName]: csrfHash
                }),
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
$(document).on('click', '.delete-invoice', function() {

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
                data: JSON.stringify({
                    [csrfName]: csrfHash
                }),
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
$(document).on('click', '.delete-comment', function() {

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
                data: JSON.stringify({
                    [csrfName]: csrfHash
                }),
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
$(document).on('click', '.delete-user', function() {

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
                data: JSON.stringify({
                    [csrfName]: csrfHash
                }),
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
$(document).on('click', '.delete-tag', function() {

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
                data: JSON.stringify({
                    [csrfName]: csrfHash
                }),
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
$(document).on('click', '.delete-invoicepos', function() {


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
                data: JSON.stringify({
                    [csrfName]: csrfHash
                }),
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
$(document).on('click', '.delete-testimonial', function() {
    var row = $(this).closest('tr');
    Swal.fire({
        title: 'Löschen',
        text: "Möchtest du dieser Testimonial Eintrag wirklich löschen?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        cancelButtonText: 'Abbrechen',
        confirmButtonText: 'Löschen'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: rootUrl + '/api/0/testimonial/' + $(this).data('id'),
                type: 'DELETE',
                dataType: 'json',
                data: JSON.stringify({
                    [csrfName]: csrfHash
                }),
                statusCode: {
                    200: function(response) {
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
$(document).on('click', '.delete-testimonialform', function() {
    var row = $(this).closest('tr');
    Swal.fire({
        title: 'Löschen',
        text: "Möchtest du dieses Formular wirklich löschen? Alle Testimonial welche mit diesem Formular erstellt wurden, können danach nicht mehr geöffnet werden.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        cancelButtonText: 'Abbrechen',
        confirmButtonText: 'Löschen'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: rootUrl + '/api/0/testimonial/form/' + $(this).data('id'),
                type: 'DELETE',
                dataType: 'json',
                data: JSON.stringify({
                    [csrfName]: csrfHash
                }),
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
$(document).on('click', '.admin-password-reset', function() {

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
                data: JSON.stringify({
                    [csrfName]: csrfHash
                }),
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

$(document).on('click', '.delete-newsletter', function() {
    var row = $(this).closest('tr');
    Swal.fire({
        title: 'Löschen',
        text: "Möchtest du diesen Empfänger wirklich löschen?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        cancelButtonText: 'Abbrechen',
        confirmButtonText: 'Löschen'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: rootUrl + '/api/0/newsletter/' + $(this).data('id'),
                type: 'DELETE',
                dataType: 'json',
                data: JSON.stringify({
                    [csrfName]: csrfHash
                }),
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
