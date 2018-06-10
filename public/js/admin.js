function dialogCreation(table){
    swal({
        padding: 20,
        width: '500px',
        background: '#fff',
        timer: null,
        animation: false,
        allowOutsideClick: true,
        allowEscapeKey: true,
        showConfirmButton: true,
        input: null,
        text: null,
        title: 'Création nouvelle catégorie',
        html: '\n\
        <form id="new_category">\n\
        <div class="row">\n\
        <div class="col-xs-12 col-md-12">\n\
        <div class="md-form mt-2">\n\
        <i class="material-icons prefix">title</i>\n\
        <input type="text" id="name_fr" name="name_fr" class="form-control">\n\
        <label for="name_fr">Nom</label>\n\
        </div>\n\
        </div>\n\
        <div class="col-xs-12 col-md-12">\n\
        <div class="md-form mt-2">\n\
        <i class="material-icons prefix">title</i>\n\
        <input type="text" id="name_eng" name="name_eng" class="form-control">\n\
        <label for="name_eng">Name</label>\n\
        </div>\n\
        </div>\n\
        </div>\n\
        </form>',
        type: null,
        showCancelButton: true,
        buttonsStyling: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        confirmButtonColor: '#4caf50',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK',
        cancelButtonText: "CANCEL",
        reverseButtons: true,
        focusCancel: false,
        showCloseButton: false,
        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve, reject) {
                if (type_action !== "info") {
                    $.ajax({
                        url: $("#action_categories").html(),
                        data: 'type_action=create&'+ $('#new_category').serialize(),
                        type: 'POST',
                        dataType: 'json',
                        encode: true
                    })
                    .done(function (data) {
                        if (!data.success) {
                            reject('aie');
                        }else{
                            resolve([
                                data.category_settings[0],
                                $('input[name=name_fr]').val(),
                                $('input[name=name_eng]').val(),
                                data.category_settings[1],
                                ]);
                        }

                    })
                    .fail(function (data) {
                        reject('aie');
                    });
                }
                else{
                    resolve();
                }
            });

        },
        imageUrl: null,
        imageWidth: null,
        imageHeight: null,
        imageClass: null,
        inputPlaceholder: '', 
        inputValue: '', 
        inputAutoTrim: true,
        inputClass: null,
        onOpen: null
    }).then(function (result) {
        swal({
            title: 'Confirmée!',
            text: 'La catégorie '+result[1]+' a bien été créee',
            type: 'success',
            allowOutsideClick: false
        }).then(function () {
            $(table).DataTable().row.add({
                "DT_RowId": "category_" + result[0],
                "name_fr": result[1],
                "name_eng": result[2],
                "created_at": result[3],
                "actions_category": '<button type="button" data-toggle="tooltip"  data-placement="left" title="Edit Category" class="btn btn-success btn-simple btn-icon action_category" data-type-action="edit">\n\
                <i class="fa fa-edit"></i>\n\
                </button><br/>\n\
                <button type="button" data-toggle="tooltip" data-placement="left" title="Delete Category" class="btn btn-danger btn-simple btn-icon action_category" data-type-action="delete">\n\
                <i class="fa fa-times"></i>\n\
                </button>'
            }).draw().node();
        });

    }).catch(swal.noop);

}

$(".add_new_item").on('click', function(){
    dialogCreation($(this).attr('data-table'));
});

/*search filter on DataTables*/
$('input[name=name_search]').on('keyup',function () {
    $($(this).parent('.table_search').attr('data-table')).DataTable().columns($(this).attr('data-table-column')).search($(this).val()).draw();
});

/*Sort by Filter*/
$('select[name=filter]').on('change', function(e) {
    if ($(this).val()[1] === "a") {
        $($(this).attr('data-table')).DataTable().column($(this).val()[0]).order('asc').draw();
    }else{
        $($(this).attr('data-table')).DataTable().column($(this).val()[0]).order('desc').draw();
    }
});

CRUDitem = function( item, columns_list, column_defs, order, ajaxUrl, paging, buttons ) {
        //'<"row filter_parameters"<"col-xs-12 col-sm-6 col-md-2 col-lg-2"f><"col-xs-12 col-sm-6 col-md-4 col-lg-2"><"col-xs-12 col-sm-6 col-md-2 col-lg-2"B>>iprtip'
            var table = $('#'+item+'s-list').DataTable({
                serverSide: ajaxUrl ? true : false,
                processing: ajaxUrl ? true : false,
                ajax: ajaxUrl ? ajaxUrl : false,
                "paging":  paging ? true : false,
                "info":     false,
                "scrollCollapse": true,
                "columns": columns_list,
                "dom": paging ? 'pt' : '',
                responsive: false,
                fixedHeader: true,
                select: false,
                scrollCollapse: true,
                "pageLength": paging ? paging : '',
                columnDefs: column_defs,
                "order": order ? [order] : [],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "<Filter>",
                    paginate: {
                        previous: "&nbsp;",
                        next : "&nbsp;"
                    },
                    "zeroRecords": item == 'comment-post' ? " " : "No matching records found - Clear the filter to see the full list",
                },
                "drawCallback": function (settings) {
                    $('[data-toggle="tooltip"]').tooltip({
                        container: 'table'
                    });
                },
                "createdRow": function (row, data, index) {
                    if($("#show-action-button i").hasClass('fa-eye-slash')) $(row).addClass('show-action-button');
                    if($("#display_grid").hasClass('active')) $(row).addClass('grid-item');

                    $("#display_grid").click(function(){
                        $(".display-type").removeClass("active");
                        if(!$(this).hasClass("active")){
                            $(this).addClass("active");
                            $(row).addClass("grid-item");
                        } 
                    });

                    $("#display_list").click(function(){
                        $(".display-type").removeClass("active");
                        if(!$(this).hasClass("active")){
                            $(this).addClass("active");
                            $(row).removeClass("grid-item");
                        } 
                    });
                },
                initComplete: function () {
                //$('#participation_filter').selectpicker();
                    /*  $('<select class="selectpicker show-tick" id="participation_filter" data-style="btn-info" data-width="100%" title="Trier par">\n\
                        <option value="5a">Titre A-Z</option>\n\
                        <option value="5d">Titre Z-A</option>\n\
                        <option data-divider="true"></option>\n\
                        <option value="1a">Date asc</option>\n\
                        <option value="1d" selected>Date desc</option>\n\
                    </select>')
                        .appendTo($(".filter_parameters > div:last-child"))
                        .on('change', function () {
                            var col = $(this).val();
                            if (col[1] === "a") {
                                article.column(col[0]).order('asc').draw();
                            }
                            else
                            {
                                article.column(col[0]).order('desc').draw();
                            }

                        });
                $('#participation_filter').selectpicker();
                this.api().columns([3, 4]).every(function () {
                    var column = this;
                    var nom_select = '', numero_select = 0;
                    if (column[0][0] === 3) {
                        nom_select = 'auteur';
                        numero_select = "2";
                    }
                    else
                    {
                        nom_select = 'catégorie';
                        numero_select = "3";
                    }
                    var select = $('<select class="selectpicker show-tick" id="' + nom_select + '_filter" data-style="btn-info" data-width="100%" title="Filtrer par ' + nom_select + '"><option value="" selected>Tous</option></select>')
                            .appendTo($(".filter_parameters > div:nth-child(" + numero_select + ")"))
                            .on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                        );
                                column
                                        .search(val ? '^' + val + '$' : '', true, false)
                                        .draw();
                            });
                    column.data().unique().sort().each(function (d, j) {
                        if (d !== "") {
                            select.append('<option value="' + d + '" class="text-capitalize">' + d + '</option>');
                        }
                    });
                    $('#' + nom_select + '_filter').selectpicker();
                });*/

                }
        }); 

            if(ajaxUrl) $(".content_pagination").append($(".dataTables_paginate"));

        }   

    /*Sidebar*/

    $('.button-collapse').on('click', function (event) {
        event.preventDefault();
        $("body").append('<div class="sidenav-overlay" ></div>');
        $("body").addClass('st-effect-1');
        setTimeout(function () {
            $("body").addClass('st-menu-open');
        }, 25);
    });
    $('body').on('click', '.sidenav-overlay', function (event) {
        event.preventDefault();
        $(".sidenav-overlay").remove();
        $("body").removeClass('st-effect-1');
        setTimeout(function () {
            $("body").removeClass('st-menu-open');
        }, 25);
    });
    $(".arrow-r").on("click", function () {
        $(".arrow-r").not(this).find(".fa-angle-down").removeClass("rotate-element");
        $(this).find(".fa-angle-down").toggleClass("rotate-element");
    });
   // $('.st-menu').perfectScrollbar();
    var fields_to_fill = ["titre_article", "url_article", "cover_image", "resume_article", "categorie_article", "tags_article", "contenu_article"];


    

    copyrighterOverview = function () {

        var imageCrop = '', type_action = '', first_close = false, text_confirmation = '', titre_dialog = '', contenu_dialog = '',
                id_author = '', rowData = '', prenom_author = '', nom_author = '', email_author = '', description_author = '',
                website_author = '', google_author = '', linkedin_author = '', facebook_author = '', twitter_author = '', hide_cancel_avatar = '',
                type_dialog = '', edition_options = '', date_inscription_author = '', actions_author = '', photo_author = '', nombre_erreur = 0,
                new_photo, old_photo = '',
                input_active_icon = [" active", " active", " active", "", "", "", "", "", ""],
                input_active_label = [' class="active"', ' class="active"', ' class="active"', "", "", "", "", "", ""],
                formulaire_auteur = 'Vous souhaitez créer un nouvel auteur ? Remplissez les différents champs ci-dessous : <br/><br/>\n\
                <form id="creation_author" method="POST" enctype="multipart/form-data">\n\
                    <div class="row">\n\
                        <div class="col-md-6 avatar_overlay">\n\
                            <div class="row">\n\
                                <div class="col-xs-12">\n\
                                    <div class="view overlay hm-white-slight">\n\
                                        <img class="avatar_image img-fluid mx-auto d-block" src="' + $("#avatar_image").html() + '"/>\n\
                                        <a>\n\
                                            <div class="mask waves-effect waves-light"></div>\n\
                                        </a>\n\
                                    </div>\n\
                                </div>\n\
                                <div class="col-xs-12">\n\
                                    <a class="btn btn-info file-btn" type="button">\n\
                                        <i class="fa fa-folder-open-o"></i>\n\
                                        <input type="file" id="upload" value="Choose a file" accept="image/*">\n\
                                    </a>\n\
                                    <button type="button" class="btn btn-danger cancel_avatar hidden-xs-up" data-deg="90"><i class="fa fa-trash" aria-hidden="true"></i></button>\n\
                                    <button type="button" class="btn btn-info rotate_left hidden-xs-up" data-deg="90"><i class="fa fa-repeat" aria-hidden="true"></i></button><br/><br/>\n\
                                </div>\n\
                            </div>\n\
                        </div>\n\
                        <div class="col-md-6">\n\
                            <div class="row">\n\
                                <div class="col-xs-12">\n\
                                    <div class="md-form">\n\
                                        <i class="material-icons prefix">face</i>\n\
                                        <input type="text" id="first_name" name="first_name" class="form-control">\n\
                                        <label for="first_name">Prénom</label>\n\
                                    </div>\n\
                                </div>\n\
                                <div class="col-xs-12">\n\
                                    <div class="md-form">\n\
                                        <i class="fa fa-user prefix"></i>\n\
                                        <input type="text" id="last_name" name="last_name" class="form-control">\n\
                                        <label for="last_name">Nom</label>\n\
                                    </div>\n\
                                </div>\n\
                                <div class="col-xs-12">\n\
                                    <div class="md-form">\n\
                                        <i class="fa fa-envelope prefix"></i>\n\
                                        <input type="text" id="email" name="email" class="form-control">\n\
                                        <label for="email">Email</label>\n\
                                    </div>\n\
                                </div>\n\
                                <div class="col-xs-12">\n\
                                    <div class="md-form">\n\
                                        <i class="material-icons prefix">web</i>\n\
                                        <input type="text" id="website" name="website" class="form-control">\n\
                                        <label for="website">Website</label>\n\
                                    </div>\n\
                                </div>\n\
                            </div>\n\
                        </div>\n\
                    </div>\n\
                    <div class="row">\n\
                        <div class="col-md-12">\n\
                            <div class="md-form">\n\
                                <i class="material-icons prefix">title</i>\n\
                                <textarea name="description" id="description" class="md-textarea"></textarea>\n\
                                <label for="description">Description</label>\n\
                            </div>\n\
                        </div>\n\
                    </div>\n\
                    <div class="row">\n\
                        <div class="col-md-6">\n\
                            <div class="md-form">\n\
                                <i class="fa fa-google prefix"></i>\n\
                                <input type="text" id="google" name="google" class="form-control">\n\
                                <label for="google">Google +</label>\n\
                            </div>\n\
                        </div>\n\
                        <div class="col-md-6">\n\
                            <div class="md-form">\n\
                                <i class="fa fa-linkedin prefix"></i>\n\
                                <input type="text" id="linkedin" name="linkedin" class="form-control">\n\
                                <label for="linkedin">Linkedin</label>\n\
                            </div>\n\
                        </div>\n\
                    </div>\n\
                    <div class="row">\n\
                        <div class="col-md-6">\n\
                            <div class="md-form">\n\
                                <i class="fa fa-facebook prefix"></i>\n\
                                <input type="text" id="facebook" name="facebook" class="form-control">\n\
                                <label for="facebook">Facebook</label>\n\
                            </div>\n\
                        </div>\n\
                        <div class="col-md-6">\n\
                            <div class="md-form">\n\
                                <i class="fa fa-twitter prefix"></i>\n\
                                <input type="text" id="twitter" name="twitter" class="form-control">\n\
                                <label for="twitter">Twitter</label>\n\
                            </div>\n\
                        </div>\n\
                    </div>\n\
                </form>';
        var author = $('#author_overview').DataTable({
            processing: true,
            serverSide: false,
            ajax: $("#extraction_authors").html(),
            columns: [
                {"data": "identification_author"},
                {"data": "date_inscription_author"},
                {"data": "email_author"},
                {"data": "nom_author"},
                {"data": "prenom_author"},
                {"data": "photo_author"},
                {"data": "description_author"},
                {"data": "website_author"},
                {"data": "google_author"},
                {"data": "linkedin_author"},
                {"data": "facebook_author"},
                {"data": "twitter_author"},
                {"data": "actions_author"}
            ],
            lengthChange: true,
            lengthMenu: [[5, 10, 15, -1], [5, 10, 15, "Tous"]],
            scrollCollapse: true,
            paging: true,
            dom: '<"row filter_parameters"<"col-xs-12 col-sm-6 col-md-4 col-lg-4"l><"col-xs-12 col-sm-6 col-md-4 col-lg-4"f><"col-xs-12 col-sm-6 col-md-4 col-lg-4">>Biprtip',
            pageResize: false,
            buttons: [
                {
                    text: '<i class="fa fa-user fa-2x" aria-hidden="true"></i> Créer un auteur',
                    className: 'btn-info',
                    action: function (e, dt, node, config) {
                        swal({
                            padding: 20,
                            width: '800px',
                            background: '#fff',
                            timer: null,
                            animation: true,
                            allowOutsideClick: true,
                            allowEscapeKey: true,
                            showConfirmButton: true,
                            input: null,
                            text: null,
                            title: 'Création auteur',
                            html: formulaire_auteur,
                            type: null,
                            showCancelButton: true,
                            buttonsStyling: true,
                            confirmButtonClass: 'btn btn-success',
                            cancelButtonClass: 'btn btn-danger',
                            confirmButtonColor: '#4caf50',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'OUI, je confirme',
                            cancelButtonText: 'Non, plus tard',
                            reverseButtons: false,
                            focusCancel: false,
                            showCloseButton: false,
                            showLoaderOnConfirm: true,
                            preConfirm: function () {
                                return new Promise(function (resolve, reject) {
                                    nombre_erreur = 0;
                                    nombre_erreur += ($("input[name=last_name]").val()).trim() === '' ? error_text("Un last_name est obligatoire.", "last_name") : remove_error("last_name");
                                    nombre_erreur += ($("input[name=first_name]").val()).trim() === '' ? error_text("Un prénom est obligatoire.", "first_name") : remove_error("first_name");
                                    nombre_erreur += ($("input[name=email]").val()).trim() === '' ? error_text("Une adresse e-mail est obligatoire.", "email") : remove_error("email");
                                    if (nombre_erreur === 0) {
                                        if ($(".avatar_overlay .cr-boundary").length) {
                                            imageCrop.croppie('result', {
                                                type: 'blob',
                                                size: 'viewport',
                                                quality: 0.8,
                                                format: "jpeg",
                                                circle: false
                                            }).then(function (resp) {

                                                blobToDataURL(resp, function (dataurl) {

                                                    $.ajax({
                                                        url: $("#action_author").html(),
                                                        type: "POST",
                                                        data: 'type_action=creation&id_author=' + id_author + '&' + $('#creation_author').serialize() + '&' + $.param({'avatar_image': dataurl}),
                                                        dataType: 'json',
                                                        encode: true
                                                    })
                                                            .done(function (data) {

                                                                if (data.success) {

                                                                    resolve([
                                                                        $('#creation_author input[name=last_name]').val(),
                                                                        $('#creation_author input[name=first_name]').val(),
                                                                        $('#creation_author input[name=email]').val(),
                                                                        $('#creation_author input[name=website]').val(),
                                                                        $('#creation_author textarea[name=description]').val(),
                                                                        $('#creation_author input[name=google]').val(),
                                                                        $('#creation_author input[name=linkedin]').val(),
                                                                        $('#creation_author input[name=facebook]').val(),
                                                                        $('#creation_author input[name=twitter]').val(),
                                                                        data.creation[0],
                                                                        data.creation[1],
                                                                        data.creation[2],
                                                                    ]);
                                                                }
                                                                else
                                                                {
                                                                    reject();
                                                                }
                                                            })
                                                            .fail(function (data) {
                                                                reject();
                                                                console.log("fail");
                                                            });
                                                });
                                            });
                                        }
                                        else
                                        {
                                            $.ajax({
                                                url: $("#action_author").html(),
                                                type: "POST",
                                                data: 'type_action=creation&id_author=' + id_author + '&' + $('#creation_author').serialize(),
                                                dataType: 'json',
                                                encode: true
                                            })
                                                    .done(function (data) {

                                                        if (data.success) {
                                                            remove_error("email");
                                                            resolve([
                                                                $('#creation_author input[name=last_name]').val(),
                                                                $('#creation_author input[name=first_name]').val(),
                                                                $('#creation_author input[name=email]').val(),
                                                                $('#creation_author input[name=website]').val(),
                                                                $('#creation_author textarea[name=description]').val(),
                                                                $('#creation_author input[name=google]').val(),
                                                                $('#creation_author input[name=linkedin]').val(),
                                                                $('#creation_author input[name=facebook]').val(),
                                                                $('#creation_author input[name=twitter]').val(),
                                                                data.creation[0],
                                                                data.creation[1],
                                                                $("#avatar_image").html(),
                                                            ]);
                                                        }
                                                        else
                                                        {
                                                            data.errors.email ? error_text(data.errors.email, "email") : '';
                                                            reject();
                                                        }
                                                    })
                                                    .fail(function (data) {
                                                        reject();
                                                        console.log("fail");
                                                    });
                                        }
                                    }
                                    else
                                    {
                                        reject();
                                    }
                                });
                            },
                            imageUrl: null,
                            imageWidth: null,
                            imageHeight: null,
                            imageClass: null,
                            inputPlaceholder: '', inputValue: '', inputAutoTrim: true,
                            inputClass: null,
                            onOpen: null
                        }).then(function (result) {

                            swal({
                                title: 'Confirmée!',
                                text: "L'auteur a bien été crée.",
                                type: 'success',
                                allowOutsideClick: false
                            }).then(function () {
                                description_author = result[4] ? '<p>' + result[4] + '</p>' : '';
                                website_author = result[3] ? '<p>' + result[3] + '</p>' : '';
                                google_author = result[5] ? '<a class="btn btn-just-icon btn-google" href="' + result[5] + '" target="_blank" type="button"><i class="fa fa-linkedin" aria-hidden="true"></i></a>' : '';
                                linkedin_author = result[6] ? '<a class="btn btn-just-icon btn-linkedin" href="' + result[6] + '" target="_blank" type="button"><i class="fa fa-linkedin" aria-hidden="true"></i></a>' : '';
                                facebook_author = result[7] ? '<a class="btn btn-just-icon btn-facebook" href="' + result[7] + '" target="_blank" type="button"><i class="fa fa-linkedin" aria-hidden="true"></i></a>' : '';
                                twitter_author = result[8] ? '<a class="btn btn-just-icon btn-twitter" href="' + result[8] + '" target="_blank" type="button"><i class="fa fa-linkedin" aria-hidden="true"></i></a>' : '';
                                author.row.add({
                                    "DT_RowId": "author" + result[9],
                                    "identification_author": '<div class="container-fluid ">\n\
                     <div class="row">\n\
                     <div class="col-lg-2 col-xs-12">\n\
                        <div class="view overlay hm-white-slight">\n\
                            <img width="125" src="' + result[11] + '" class="img-fluid"/>\n\
                            <a>\n\
                                <div class="mask waves-effect waves-light"></div>\n\
                            </a>\n\
                        </div>\n\
                     </div>\n\
                     <div class="col-xs-12 col-lg-9">\n\
                     <h4 class="text-success"><strong>' + result[1].substr(0, 1).toUpperCase() + result[1].substr(1) + ' ' + result[0].toUpperCase() + '</strong></h4>\n\
                     <p><strong>' + result[2] + '</strong></p>\n\
                     ' + description_author + '\n\
                     ' + website_author + '\n\
                     ' + google_author + '\n\
                     ' + linkedin_author + '\n\
                     ' + facebook_author + '\n\
                     ' + twitter_author + '\n\
                     </div>\n\
                     </div>\n\
                     </div>',
                                    "date_inscription_author": result[10],
                                    "email_author": result[2],
                                    "nom_author": result[0],
                                    "prenom_author": result[1],
                                    "photo_author": result[11],
                                    "description_author": result[4],
                                    "website_author": result[3],
                                    "google_author": result[5],
                                    "linkedin_author": result[6],
                                    "facebook_author": result[7],
                                    "twitter_author": result[8],
                                    "actions_author": '<button type="button" class="btn btn-info action_author" data-type-action="edit">\n\
                                                    <i class="fa fa-edit fa-4x" aria-hidden="true"></i>\n\
                                                </button><button type="button" class="btn btn-danger action_author" data-type-action="delete">\n\
                                                    <i class="fa fa-trash fa-4x" aria-hidden="true"></i>\n\
                                                </button>'
                                }).draw().node();
                            });
                        }).catch(swal.noop);
                        $('#upload').on('change', function () {
                            var selected_file_name = $(this).val();
                            if (selected_file_name.length > 0) {
                                /* Some file selected */
                                var reader = new FileReader();
                                reader.onload = function (e) {
                                    if (!$(".avatar_overlay .cr-boundary").length) {
                                        imageCrop = initCrop();
                                        $(".cancel_avatar i").removeClass("fa-trash").addClass("fa-ban");
                                        $(".cancel_avatar").removeClass("hidden-xs-up");
                                        $('.avatar_image').removeClass("img-fluid mx-auto d-block");
                                        $(".avatar_overlay .rotate_left").removeClass("hidden-xs-up");
                                    }
                                    imageCrop.croppie('bind', {
                                        url: e.target.result
                                    });
                                };
                                reader.readAsDataURL(this.files[0]);
                            }
				$(this).val('');
                        });
                        $('.rotate_left').on('click', function (ev) {
                            imageCrop.croppie('rotate', parseInt($(this).data('deg')));
                        });
                        $(".cancel_avatar").on('click', function (ev) {
                            if ($(".avatar_overlay .cr-boundary").length) {
                                imageCrop.croppie('destroy');
                                reset_avatar(imageCrop);
                                $(".cancel_avatar").addClass("hidden-xs-up");
                            }
                            else
                            {
                                if ($(".avatar_image").attr("src") !== $("#avatar_image").html()) {
                                    $(".avatar_image").attr({"src": $("#avatar_image").html()});
                                }
                            }
                        });
                    }
                }
            ],
            responsive: true,
            language: {
                "decimal": "",
                "emptyTable": "Aucune donnée disponible dans cette table",
                "info": " _START_ à _END_ de _TOTAL_ authors",
                "infoEmpty": "Aucune entrée",
                "infoFiltered": "(filtered from _MAX_ total entries)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Montrer _MENU_ authors",
                "loadingRecords": "Chargement...",
                "processing": "Traitement...",
                "search": "_INPUT_",
                "zeroRecords": "Aucune donnée trouvée",
                searchPlaceholder: "Rechercher par titre",
                "paginate": {
                    "first": "Premier",
                    "last": "Dernier",
                    "next": "Suivant",
                    "previous": "Précédent"
                },
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                }
            },
            columnDefs: [
                /*{
                 "searchable": false,
                 "orderable": false,
                 "targets": [0]
                 },*/
                {
                    "searchable": false,
                    "orderable": false,
                    "targets": [0]
                },
                {
                    "targets": -1,
                    "className": 'td-actions text-xs-right'
                },
                {
                    "targets": [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                    "visible": false
                },
                {
                    "targets": [1, 2, 6, 7, 8, 9, 10, 11, 12],
                    "searchable": false
                },
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: 2}],
            order: [[1, 'desc']],
            "drawCallback": function (settings) {
                var api = this.api();
                /* $('[data-toggle="tooltip"]').tooltip({
                 container: 'table'
                 });*/

                /* Apply the tooltips */
                $('td', api.table().container()).tooltip({
                    container: 'body'
                });
            },
            initComplete: function () {
                $('<select class="selectpicker show-tick" id="author_filter" data-style="btn-info" data-width="100%" title="Trier par">\n\
                        <option value="3a">Nom A-Z</option>\n\
                        <option value="3d">Nom Z-A</option>\n\
                        <option data-divider="true"></option>\n\
                        <option value="1a">Date asc</option>\n\
                        <option value="1d">Date desc</option>\n\
                    </select>')
                        .appendTo($(".filter_parameters > div:last"))
                        .on('change', function () {
                            var col = $(this).val();
                            if (col[1] === "a") {
                                author.column(col[0]).order('asc').draw();
                            }
                            else
                            {
                                author.column(col[0]).order('desc').draw();
                            }

                        });
                $('#author_filter').selectpicker();
            }
        });
        $('#author_overview').on('click', 'tr .action_author', function () {

            tr = $(this).closest('tr');
            tr.addClass('selected');
            rowData = author.rows(tr).data();
            first_close = false;
            type_action = $(this).attr("data-type-action");
            id_author = rowData[0]["DT_RowId"].replace("author", "");
            date_inscription_author = rowData[0]["date_inscription_author"];
            prenom_author = rowData[0]["prenom_author"];
            nom_author = rowData[0]["nom_author"];
            email_author = rowData[0]["email_author"];
            photo_author = rowData[0]["photo_author"];
            description_author = '';
            website_author = '';
            google_author = '';
            linkedin_author = '';
            facebook_author = '';
            twitter_author = '';
            hide_cancel_avatar = photo_author === $("#avatar_image").html() ? ' hidden-xs-up' : '';
            if (rowData[0]["description_author"]) {
                description_author = rowData[0]["description_author"];
                input_active_icon[3] = " active";
                input_active_label[3] = ' class="active"';
            }

            if (rowData[0]["website_author"]) {
                website_author = rowData[0]["website_author"];
                input_active_icon[4] = " active";
                input_active_label[4] = ' class="active"';
            }

            if (rowData[0]["google_author"]) {
                google_author = rowData[0]["google_author"];
                input_active_icon[5] = " active";
                input_active_label[5] = ' class="active"';
            }

            if (rowData[0]["linkedin_author"]) {
                linkedin_author = rowData[0]["linkedin_author"];
                input_active_icon[6] = " active";
                input_active_label[6] = ' class="active"';
            }

            if (rowData[0]["facebook_author"]) {
                facebook_author = rowData[0]["facebook_author"];
                input_active_icon[7] = " active";
                input_active_label[7] = ' class="active"';
            }

            if (rowData[0]["twitter_author"]) {
                twitter_author = rowData[0]["twitter_author"];
                input_active_icon[8] = " active";
                input_active_label[8] = ' class="active"';
            }

            actions_author = rowData[0]["actions_author"];
            if (type_action === "delete") {
                text_confirmation = "L'auteur a bien été supprimé.";
                titre_dialog = 'Suppression auteur';
                contenu_dialog = '';
                type_dialog = 'warning';
            }
            else if (type_action === "edit")
            {
                text_confirmation = "L'auteur a bien été modifié.";
                titre_dialog = 'Edition auteur';
                type_dialog = null;
                contenu_dialog = 'Vous souhaitez modifier l&#39;auteur ? Remplissez les différents champs ci-dessous : <br/><br/>\n\
                <form id="edition_author" method="POST" enctype="multipart/form-data">\n\
                    <div class="row">\n\
                        <div class="col-md-6 avatar_overlay">\n\
                            <div class="row">\n\
                                <div class="col-xs-12">\n\
                                    <div class="view overlay hm-white-slight">\n\
                                        <img class="avatar_image img-fluid mx-auto d-block" src="' + photo_author + '" />\n\
                                        <a>\n\
                                            <div class="mask waves-effect waves-light"></div>\n\
                                        </a>\n\
                                    </div>\n\
                                </div>\n\
                                <div class="col-xs-12">\n\
                                    <a class="btn btn-info file-btn" type="button">\n\
                                        <i class="fa fa-folder-open-o"></i>\n\
                                        <input type="file" id="upload" value="Choose a file" accept="image/*">\n\
                                    </a>\n\
                                    <button type="button" class="btn btn-danger cancel_avatar' + hide_cancel_avatar + '" data-deg="90"><i class="fa fa-trash" aria-hidden="true"></i></button>\n\
                                    <button type="button" class="btn btn-info rotate_left hidden-xs-up" data-deg="90"><i class="fa fa-repeat" aria-hidden="true"></i></button><br/><br/>\n\
                                </div>\n\
                            </div>\n\
                        </div>\n\
                        <div class="col-md-6">\n\
                            <div class="row">\n\
                                <div class="col-xs-12">\n\
                                    <div class="md-form">\n\
                                        <i class="material-icons prefix' + input_active_icon[0] + '">face</i>\n\
                                        <input type="text" id="first_name" name="first_name" class="form-control" value="' + prenom_author + '">\n\
                                        <label for="first_name" ' + input_active_label[0] + '>Prénom</label>\n\
                                    </div>\n\
                                </div>\n\
                                <div class="col-xs-12">\n\
                                    <div class="md-form">\n\
                                        <i class="fa fa-user prefix' + input_active_icon[1] + '"></i>\n\
                                        <input type="text" id="last_name" name="last_name" class="form-control" value="' + nom_author + '">\n\
                                        <label for="last_name" ' + input_active_label[1] + '>Nom</label>\n\
                                    </div>\n\
                                </div>\n\
                                <div class="col-xs-12">\n\
                                    <div class="md-form">\n\
                                        <i class="fa fa-envelope prefix' + input_active_icon[2] + '"></i>\n\
                                        <input type="text" id="email" name="email" class="form-control" value="' + email_author + '">\n\
                                        <label for="email" ' + input_active_label[2] + '>Email</label>\n\
                                    </div>\n\
                                </div>\n\
                                <div class="col-xs-12">\n\
                                    <div class="form-group float-left">\n\
                                        <input type="checkbox" class="filled-in" id="show-email" name="show-email" checked="checked">\n\
                                        <label for="show-email">Show its email</label>\n\
                                    </div>\n\
                                </div>\n\
                                <div class="clearfix"></div>\n\
                            </div>\n\
                        </div>\n\
                    </div>\n\
                    <div class="row">\n\
                        <div class="col-xs-12">\n\
                            <div class="md-form">\n\
                                <i class="material-icons prefix' + input_active_icon[4] + '">web</i>\n\
                                <input type="text" id="website" name="website" class="form-control" value="' + website_author + '">\n\
                                <label for="website" ' + input_active_label[4] + '>Website</label>\n\
                            </div>\n\
                        </div>\n\
                        <div class="col-xs-12">\n\
                            <div class="md-form">\n\
                                <i class="material-icons prefix' + input_active_icon[3] + '">title</i>\n\
                                <textarea name="description" id="description" class="md-textarea">' + description_author + '</textarea>\n\
                                <label for="description" ' + input_active_label[3] + '>Description</label>\n\
                            </div>\n\
                        </div>\n\
                    </div>\n\
                    <div class="row">\n\
                        <div class="col-md-6">\n\
                            <div class="md-form">\n\
                                <i class="fa fa-google prefix' + input_active_icon[5] + '"></i>\n\
                                <input type="text" id="google" name="google" class="form-control" value="' + google_author + '">\n\
                                <label for="google" ' + input_active_label[5] + '>Google +</label>\n\
                            </div>\n\
                        </div>\n\
                        <div class="col-md-6">\n\
                            <div class="md-form">\n\
                                <i class="fa fa-linkedin prefix' + input_active_icon[6] + '"></i>\n\
                                <input type="text" id="linkedin" name="linkedin" class="form-control" value="' + linkedin_author + '">\n\
                                <label for="linkedin" ' + input_active_label[6] + '>Linkedin</label>\n\
                            </div>\n\
                        </div>\n\
                    </div>\n\
                    <div class="row">\n\
                        <div class="col-md-6">\n\
                            <div class="md-form">\n\
                                <i class="fa fa-facebook prefix' + input_active_icon[7] + '"></i>\n\
                                <input type="text" id="facebook" name="facebook" class="form-control" value="' + facebook_author + '">\n\
                                <label for="facebook" ' + input_active_label[7] + '>Facebook</label>\n\
                            </div>\n\
                        </div>\n\
                        <div class="col-md-6">\n\
                            <div class="md-form">\n\
                                <i class="fa fa-twitter prefix' + input_active_icon[8] + '"></i>\n\
                                <input type="text" id="twitter" name="twitter" class="form-control" value="' + twitter_author + '">\n\
                                <label for="twitter" ' + input_active_label[8] + '>Twitter</label>\n\
                            </div>\n\
                        </div>\n\
                    </div>\n\
                </form>';
            }

            swal({
                padding: 20,
                width: '800px',
                background: '#fff',
                timer: null,
                animation: true,
                allowOutsideClick: true,
                allowEscapeKey: true,
                showConfirmButton: true,
                input: null,
                text: null,
                title: titre_dialog,
                html: contenu_dialog,
                type: type_dialog,
                showCancelButton: true,
                buttonsStyling: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonColor: '#4caf50',
                cancelButtonColor: '#d33',
                confirmButtonText: 'OUI, je confirme',
                cancelButtonText: 'Non, plus tard',
                reverseButtons: false,
                focusCancel: false,
                showCloseButton: false,
                showLoaderOnConfirm: true,
                preConfirm: function () {
                    edition_options = type_action === "edit" ? '&' + $('#edition_author').serialize() : '';
                    return new Promise(function (resolve, reject) {
                        nombre_erreur = 0;
                        nombre_erreur += $("input[name=last_name]").length > 0 && ($("input[name=last_name]").val()).trim() === '' ? error_text("Un last_name est obligatoire.", "last_name") : remove_error("last_name");
                        nombre_erreur += $("input[name=first_name]").length > 0 && ($("input[name=first_name]").val()).trim() === '' ? error_text("Un prénom est obligatoire.", "first_name") : remove_error("first_name");
                        nombre_erreur += $("input[name=email]").length > 0 && ($("input[name=email]").val()).trim() === '' ? error_text("Une adresse e-mail est obligatoire.", "email") : remove_error("email");
                        if (nombre_erreur === 0) {
                            if ($(".avatar_overlay .cr-boundary").length) {
                                imageCrop.croppie('result', {
                                    type: 'blob',
                                    size: 'viewport',
                                    /*size: 'original',keep aspect ratio*/
                                    /*size:  { width: 1920, height: 1080 },*/
                                    quality: 0.8,
                                    format: "jpeg",
                                    circle: false
                                }).then(function (resp) {


                                    blobToDataURL(resp, function (dataurl) {

                                        $.ajax({
                                            url: $("#action_author").html(),
                                            type: "POST",
                                            data: 'type_action=' + type_action + '&id_author=' + id_author + edition_options + '&old_photo=' + photo_author + '&' + $.param({'avatar_image': dataurl}),
                                            dataType: 'json',
                                            encode: true
                                        })
                                                .done(function (data) {

                                                    if (data.success) {
                                                        remove_error("email");
                                                        resolve([
                                                            $('#edition_author input[name=last_name]').val(),
                                                            $('#edition_author input[name=first_name]').val(),
                                                            $('#edition_author input[name=email]').val(),
                                                            $('#edition_author input[name=website]').val(),
                                                            $('#edition_author textarea[name=description]').val(),
                                                            $('#edition_author input[name=google]').val(),
                                                            $('#edition_author input[name=linkedin]').val(),
                                                            $('#edition_author input[name=facebook]').val(),
                                                            $('#edition_author input[name=twitter]').val(),
                                                            data.new_avatar
                                                        ]);
                                                        first_close = true;
                                                    }
                                                    else
                                                    {
                                                        data.errors.email ? error_text(data.errors.email, "email") : '';
                                                        reject();
                                                    }
                                                })
                                                .fail(function (data) {

                                                    reject('aie');
                                                });
                                    });
                                });
                            }
                            else
                            {

                                new_photo = $(".avatar_image").attr("src") === $("#avatar_image").html() ? '&new_photo=' + $(".avatar_image").attr("src") : '';
                                $.ajax({
                                    url: $("#action_author").html(),
                                    data: 'type_action=' + type_action + '&id_author=' + id_author + edition_options + '&old_photo=' + photo_author + new_photo,
                                    type: 'POST',
                                    dataType: 'json',
                                    encode: true
                                })
                                        .done(function (data) {
                                            if (type_action === "edit") {
                                                if (data.success) {
                                                    remove_error("email");
                                                    var new_avatar = data.new_avatar ? data.new_avatar : (new_photo ? $("#avatar_image").html() : photo_author);
                                                    resolve([
                                                        $('#edition_author input[name=last_name]').val(),
                                                        $('#edition_author input[name=first_name]').val(),
                                                        $('#edition_author input[name=email]').val(),
                                                        $('#edition_author input[name=website]').val(),
                                                        $('#edition_author textarea[name=description]').val(),
                                                        $('#edition_author input[name=google]').val(),
                                                        $('#edition_author input[name=linkedin]').val(),
                                                        $('#edition_author input[name=facebook]').val(),
                                                        $('#edition_author input[name=twitter]').val(),
                                                        new_avatar
                                                    ]);
                                                }
                                                else
                                                {
                                                    data.errors.email ? error_text(data.errors.email, "email") : '';
                                                    reject();
                                                }
                                            }
                                            else
                                            {
                                                resolve();
                                            }
                                            first_close = true;
                                        })
                                        .fail(function (data) {
                                            console.log(data)
                                            reject('aie');
                                        });
                            }
                        }
                        else
                        {
                            reject();
                        }
                    });
                },
                imageUrl: null,
                imageWidth: null,
                imageHeight: null,
                imageClass: null,
                inputPlaceholder: '', inputValue: '', inputAutoTrim: true,
                inputClass: null,
                onOpen: null,
                onClose: function () {
                    if (!first_close) {
                        tr.removeClass('selected');
                    }
                    first_close = true;
                }


            }).then(function (result) {

                swal({
                    title: 'Confirmée!',
                    text: text_confirmation,
                    type: 'success',
                    allowOutsideClick: false
                }).then(function () {

                    author.rows('.selected').remove().draw(false);
                    if (type_action === "edit")
                    {
                        description_author = result[4] ? '<p>' + result[4] + '</p>' : '';
                        website_author = result[3] ? '<p>' + result[3] + '</p>' : '';
                        google_author = result[5] ? '<a class="btn btn-just-icon btn-google" href="' + result[5] + '" target="_blank" type="button"><i class="fa fa-linkedin" aria-hidden="true"></i></a>' : '';
                        linkedin_author = result[6] ? '<a class="btn btn-just-icon btn-linkedin" href="' + result[6] + '" target="_blank" type="button"><i class="fa fa-linkedin" aria-hidden="true"></i></a>' : '';
                        facebook_author = result[7] ? '<a class="btn btn-just-icon btn-facebook" href="' + result[7] + '" target="_blank" type="button"><i class="fa fa-linkedin" aria-hidden="true"></i></a>' : '';
                        twitter_author = result[8] ? '<a class="btn btn-just-icon btn-twitter" href="' + result[8] + '" target="_blank" type="button"><i class="fa fa-linkedin" aria-hidden="true"></i></a>' : '';
                        author.row.add({
                            "DT_RowId": "author" + id_author,
                            "identification_author": '<div class="container-fluid ">\n\
                     <div class="row">\n\
                     <div class="col-lg-2 col-xs-12">\n\
                        <div class="view overlay hm-white-slight">\n\
                            <img width="125" src="' + result[9] + '" class="img-fluid"/>\n\
                            <a>\n\
                                <div class="mask waves-effect waves-light"></div>\n\
                            </a>\n\
                        </div>\n\
                     </div>\n\
                     <div class="col-xs-12 col-lg-9">\n\
                     <h4 class="text-success"><strong>' + result[1].substr(0, 1).toUpperCase() + result[1].substr(1) + ' ' + result[0].toUpperCase() + '</strong></h4>\n\
                     <p><strong>' + result[2] + '</strong></p>\n\
                     ' + description_author + '\n\
                     ' + website_author + '\n\
                     ' + google_author + '\n\
                     ' + linkedin_author + '\n\
                     ' + facebook_author + '\n\
                     ' + twitter_author + '\n\
                     </div>\n\
                     </div>\n\
                     </div>',
                            "date_inscription_author": date_inscription_author,
                            "email_author": result[2],
                            "nom_author": result[0],
                            "prenom_author": result[1],
                            "photo_author": result[9],
                            "description_author": result[4],
                            "website_author": result[3],
                            "google_author": result[5],
                            "linkedin_author": result[6],
                            "facebook_author": result[7],
                            "twitter_author": result[8],
                            "actions_author": actions_author
                        }).draw().node();
                    }
                });
            }).catch(swal.noop);
            /* function rotateImage(original_src, callback) {
             // the exif.js lib is required for this to work
             var rotated_src; // where the rotate image content will be
             var exifImg = new Image;
             // original_src is the original image content
             exifImg.onload = function () {
             EXIF.getData(exifImg, function () {
             var orientation = EXIF.getTag(this, "Orientation");
             var canvas = $('<canvas id="canvas_exif" width="' + exifImg.width + '" height="' + exifImg.height + '"></canvas>');
             $("body").append(canvas);
             var ctx = $("#canvas_exif")[0].getContext('2d');
             ctx.translate(exifImg.width * 0.5, exifImg.height * 0.5);
             
             switch (orientation) {
             case 2:
             // horizontal flip
             ctx.translate(canvas.width, 0);
             ctx.scale(-1, 1);
             break;
             case 3:
             // 180° rotate left
             ctx.translate(canvas.width, canvas.height);
             ctx.rotate(Math.PI);
             break;
             case 4:
             // vertical flip
             ctx.translate(0, canvas.height);
             ctx.scale(1, -1);
             break;
             case 5:
             // vertical flip + 90 rotate right
             ctx.rotate(0.5 * Math.PI);
             ctx.scale(1, -1);
             break;
             case 6:
             // 90° rotate right
             ctx.rotate(0.5 * Math.PI);
             ctx.translate(0, -canvas.height);
             break;
             case 7:
             // horizontal flip + 90 rotate right
             ctx.rotate(0.5 * Math.PI);
             ctx.translate(canvas.width, -canvas.height);
             ctx.scale(-1, 1);
             break;
             case 8:
             // 90° rotate left
             ctx.rotate(-0.5 * Math.PI);
             ctx.translate(-canvas.width, 0);
             break;
             }
             
             ctx.translate(-exifImg.width * 0.5, -exifImg.height * 0.5);
             ctx.drawImage(exifImg, 0, 0);
             return_src = $("#canvas_exif")[0].toDataURL();
             $("#canvas_exif").remove();
             
             });
             callback(rotated_src);
             }
             exifImg.src = original_src;
             
             }*/

            function readFile(input, imageCrop) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        rotateImage(e.target.result, function (src) {
                            imageCrop.croppie('bind', {url: src});
                        });
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            /*$('#upload').on('change', function () {
             readFile(this, imageCrop);
             });*/

            $('#upload').on('change', function () {
                old_photo = $(".avatar_image").attr("src");
                console.log(old_photo)
                var selected_file_name = $(this).val();
                if (selected_file_name.length > 0) {
                    /* Some file selected */
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        if (!$(".avatar_overlay .cr-boundary").length) {
                            imageCrop = initCrop();
                            $(".cancel_avatar i").removeClass("fa-trash").addClass("fa-ban");
                            $(".cancel_avatar").removeClass("hidden-xs-up");
                            $('.avatar_image').removeClass("img-fluid mx-auto d-block");
                            $(".avatar_overlay .rotate_left").removeClass("hidden-xs-up");
                        }
                        imageCrop.croppie('bind', {
                            url: e.target.result
                        });
                    };
                    reader.readAsDataURL(this.files[0]);
                }
		          $(this).val('');
            });
            $(".cancel_avatar").on('click', function (ev) {
                console.log(old_photo)
                if ($(".avatar_overlay .cr-boundary").length) {
                    reset_avatar(imageCrop);
                    old_photo === $("#avatar_image").html() ? $(".cancel_avatar").addClass("hidden-xs-up") : '';
                }
                else
                {
                    if ($(".avatar_image").attr("src") !== $("#avatar_image").html()) {
                        $(".avatar_image").attr({"src": $("#avatar_image").html()});
                        $(".cancel_avatar").addClass("hidden-xs-up");
                    }
                }
            });
            $('.rotate_left').on('click', function (ev) {
                imageCrop.croppie('rotate', parseInt($(this).data('deg')));
            });
        });
    };
    blogOverview = function () {


    };

    contactsOverview = function () {

        var contacts = $('#contacts').DataTable({
            processing: true,
            serverSide: false,
            ajax: $("#extraction_contacts").html(),
            columns: [
                {"data": "identification_contact"},
                {"data": "date_inscription_contact"},
                {"data": "nom_contact"},
                {"data": "email_contact"},
                {"data": "message_contact"},
                {"data": "actions_contact"},
                {"data": "historique"}
            ],
            lengthChange: true,
            lengthMenu: [[5, 10, 15, -1], [5, 10, 15, "Tous"]],
            scrollCollapse: true,
            paging: true,
            dom: '<"row filter_parameters_2"<"col-xs-12 col-sm-3 col-md-2 col-lg-2"f><"col-xs-12 col-sm-3 col-md-2 col-lg-2"><"col-xs-12 col-sm-3 col-md-2 col-lg-2"B>>iprtip',
            pageResize: false,
            buttons: [
                {
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i> Excel',
                    className: 'excel',
                    title: "Liste des contacts",
                    exportOptions: {
                        columns: [1, 2, 3, 4]

                    }
                }
            ],
            responsive: true,
            language: {
                "decimal": "",
                "emptyTable": "Aucune donnée disponible dans cette table",
                "info": " _START_ à _END_ de _TOTAL_ contacts",
                "infoEmpty": "Aucune entrée",
                "infoFiltered": "(filtered from _MAX_ total entries)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Montrer _MENU_ contacts",
                "loadingRecords": "Chargement...",
                "processing": "Traitement...",
                "search": "_INPUT_",
                "zeroRecords": "Aucune donnée trouvée",
                searchPlaceholder: "Rechercher par nom",
                "paginate": {
                    "first": "Premier",
                    "last": "Dernier",
                    "next": "Suivant",
                    "previous": "Précédent"
                },
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                }
            },
            columnDefs: [
                {
                    "searchable": false,
                    "orderable": false,
                    "targets": [0]
                },
                {
                    "targets": 5,
                    "className": 'td-actions text-xs-right'
                },
                {
                    "targets": [1, 2, 3, 4, 6],
                    "visible": false
                },
                {
                    "targets": [0, 1, 4, 5, 6],
                    "searchable": false
                },
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: 2}],
            order: [[1, 'desc']],
            "drawCallback": function () {
                $('[data-toggle="tooltip"]').tooltip({
                    container: 'table'
                });
            },
            initComplete: function () {
                $('<select class="selectpicker show-tick" id="participation_filter" data-style="btn-info" data-width="100%" title="Trier par">\n\
                        <option value="2a">Nom A-Z</option>\n\
                        <option value="2d">Nom Z-A</option>\n\
                        <option data-divider="true"></option>\n\
                        <option value="1a">Date asc</option>\n\
                        <option value="1d" selected>Date desc</option>\n\
                    </select>')
                        .appendTo($(".filter_parameters_2 > div:nth-child(2)"))
                        .on('change', function () {
                            var col = $(this).val();
                            if (col[1] === "a") {
                                contacts.column(col[0]).order('asc').draw();
                            }
                            else
                            {
                                contacts.column(col[0]).order('desc').draw();
                            }

                        });
                $('#participation_filter').selectpicker();
            }
        });

        var tr = '', first_close = false, type_action = '', id_contact = '', rowData = '', text_confirmation = '', titre_dialog = '',
                contenu_dialog = '', type_dialog = '', dialog_length = '', nom_contact = '', confirmButtonText = '', showCancelButton = false,
                number_of_tasks = 0, last_task = '', edition_options = '', historique_contact = '', tache = '', email_contact = '',
                message_contact = '', date_inscription_contact = '', titre_tache = '',
                select_options = ["Contacter par téléphone", "Contact non présent", "Contact par email", "Réponse contact", "Non intéressé"],
                comment_active_icon = '', comment_active_label = '';

        $('#contacts').on('click', 'tr .action_contact', function () {

            tr = $(this).closest('tr');
            tr.addClass('selected');
            rowData = contacts.rows(tr).data();
            first_close = false;
            type_action = $(this).attr("data-type-action");
            id_contact = rowData[0]["DT_RowId"].replace("contact_", "");
            historique_contact = rowData[0]["historique"] ? rowData[0]["historique"].split("#") : '';
            nom_contact = rowData[0]["nom_contact"];
            email_contact = rowData[0]["email_contact"];
            message_contact = rowData[0]["message_contact"];
            date_inscription_contact = rowData[0]["date_inscription_contact"];
            if (type_action === "delete") {
                text_confirmation = "Le contact " + nom_contact + " a bien été supprimé.";
                dialog_length = '500px';
                titre_dialog = 'Suppression du contact ' + nom_contact + ' ?';
                contenu_dialog = '';
                type_dialog = 'warning';
                confirmButtonText = "OK";
                showCancelButton = true;
            }
            else if (type_action === "edit")
            {
                text_confirmation = "L'historique du contact a bien été mis à jour.";
                dialog_length = '800px';
                titre_dialog = 'Ajout Tâche';
                contenu_dialog = '\
                <br/>\n\
                <form id="edition_history">\n\
                    <div class="row">\n\
                        <div class="col-xs-8 col-sm-10 text-info text-xs-left">\n\
                            <h2>Tâche</h2>\n\
                        </div>\n\
                        <div class="col-xs-4 col-sm-2 text-xs-center">\n\
                            <button class="cbutton cbutton--effect-sanja add_task" id="add_task" type="button"><i class="fa fa-plus fa-2x text-info" aria-hidden="true"></i></div>\n\
                        </div>\n\
                    </div>\n\
                    <div class="row" id="tasks">';

                for (var z = 0; z < historique_contact.length; z++) {
                    comment_active_icon = '';
                    comment_active_label = '';
                    titre_tache = '';
                    tache = historique_contact[z].split("*");
                    if (tache[2] !== '') {
                        comment_active_icon = " active";
                        comment_active_label = ' class="active"';
                    }
                    for (var y = 0; y < select_options.length; y++) {
                        var selected_value = tache[1] === select_options[y] ? " selected" : "";
                        titre_tache += '<option value="' + select_options[y] + '"' + selected_value + '>' + select_options[y] + '</option>';
                    }

                    contenu_dialog += '\
                        <div class="col-xs-8 col-sm-10 task_' + z + '">\n\
                            <div class="row">\n\
                                <div class="col-xs-12 text-xs-left">\n\
                                    <h4><i class="fa fa-calendar"></i> <span class="text-capitalize">' + moment(tache[0]).format("dddd MMMM LL") + '</span> à ' + moment(tache[0]).format("kk") + 'h' + moment(tache[0]).format("mm") + '</h4>\n\
                                    <input type="hidden" id="date_tache_' + z + '" name="date_tache_' + z + '" class="" value="' + moment(tache[0]).format("YYYY-MM-DD LTS") + '">\n\
                                </div>\n\
                                <div class="col-xs-12">\n\
                                    <select class="mdb-select text-xs-center colorful-select dropdown-primary" name="titre_tache_' + z + '">\n\
                                        ' + titre_tache + '\n\
                                    </select><br/><br/>\n\
                                </div>\n\
                                <div class="col-xs-12 col-sm-12">\n\
                                    <div class="md-form">\n\
                                        <i class="material-icons prefix ' + comment_active_icon + '">insert_comment</i>\n\
                                        <textarea name="comments_' + z + '" id="comments_' + z + '" class="md-textarea">' + tache[2] + '</textarea>\n\
                                        <label for="comments_' + z + '" ' + comment_active_label + '>Commentaires</label>\n\
                                    </div>\n\
                                </div>\n\
                            </div>\n\
                        </div>\n\
                        <div class="col-xs-4 col-sm-2 task_' + z + '">\n\
                            <a class="btn-floating btn-large red waves-effect waves-light cbutton cbutton--effect-sanja delete_task" data-task="' + z + '" type="button"><i class="fa fa-times fa-2x" aria-hidden="true"></i></a>\n\
                        </div>\n\
                        <div class="col-xs-10 task offset-xs-1 task_' + z + '"><hr/></div>';
                }
                contenu_dialog += '\
                    </div>\n\
                </form>';
                confirmButtonText = "OK";
                showCancelButton = true;
                type_dialog = null;
            }
            else
            {
                dialog_length = '650px';
                titre_dialog = 'Contact History';
                contenu_dialog = '\
                <br/>\n\
                <div class="agenda">';
                for (var z = 0; z < historique_contact.length; z++) {
                    tache = historique_contact[z].split("*");
                    contenu_dialog += '<div class="row">\n\
                        <div class="col-xs-2">\n\
                            <div class="date">\n\
                                <div class="nom_jour text-capitalize">' + moment(tache[0]).format("ddd") + '</div>\n\
                                <div class="num_jour">' + moment(tache[0]).format("Do") + '</div>\n\
                                <div class="mois text-capitalize">' + moment(tache[0]).format("MMM") + '</div>\n\
                            </div>\n\
                        </div>\n\
                        <div class="col-xs-10 evenement text-xs-left">\n\
                            <div class="heure">' + moment(tache[0]).format("LT") + '</div>\n\
                            <div class="action_c">' + tache[1] + '</div>\n\
                            <p>' + tache[2] + '</p>\n\
                        </div>\n\
                    </div><br/>';
                }
                if (historique_contact === '') {
                    contenu_dialog += '<h3>Aucune tâche</h3>';
                }
                contenu_dialog += '</div>';
                confirmButtonText = "Fermer";
                showCancelButton = false;
                type_dialog = null;
            }
            swal({
                padding: 20,
                width: dialog_length,
                background: '#fff',
                timer: null,
                animation: false,
                allowOutsideClick: true,
                allowEscapeKey: true,
                showConfirmButton: true,
                input: null,
                text: null,
                title: titre_dialog,
                html: contenu_dialog,
                type: type_dialog,
                showCancelButton: showCancelButton,
                buttonsStyling: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonColor: '#4caf50',
                cancelButtonColor: '#d33',
                confirmButtonText: confirmButtonText,
                cancelButtonText: "CANCEL",
                reverseButtons: true,
                focusCancel: false,
                showCloseButton: false,
                showLoaderOnConfirm: true,
                customClass: 'animated tada',
                preConfirm: function () {
                    edition_options = type_action === "edit" ? '&' + $('#edition_history').serialize() : '';
                    last_task = $("#tasks .task").length ? $("#tasks .task").last().attr("class") : '';
                    number_of_tasks = last_task ? parseInt(last_task.substr(last_task.lastIndexOf(' ') + 1).replace("task_", "")) + 1 : 0;
                    return new Promise(function (resolve, reject) {
                        if (type_action !== "info") {
                            $.ajax({
                                url: $("#action_contact").html(),
                                data: 'type_action=' + type_action + '&id_contact=' + id_contact + edition_options + '&last_select=' + number_of_tasks,
                                type: 'POST',
                                dataType: 'json',
                                encode: true
                            })
                                    .done(function (data) {
                                        if (!data.success) {
                                            reject('aie');
                                        }
                                        else
                                        {
                                            resolve(data.historique);
                                            first_close = true;
                                        }

                                    })
                                    .fail(function (data) {
                                        reject('aie');
                                    });
                        }
                        else
                        {
                            resolve();
                        }
                    });

                },
                imageUrl: null,
                imageWidth: null,
                imageHeight: null,
                imageClass: null,
                inputPlaceholder: '', inputValue: '', inputAutoTrim: true,
                inputClass: null,
                onOpen: null,
                onClose: function () {
                    if (!first_close) {
                        tr.removeClass('selected');
                    }
                    first_close = true;
                }
            }).then(function (result) {
                if (type_action !== "info") {
                    swal({
                        title: 'Confirmée!',
                        text: text_confirmation,
                        type: 'success',
                        allowOutsideClick: false
                    }).then(function () {
                        if (type_action === "delete") {
                            contacts.rows('.selected').remove().draw(false);
                        }
                        else if (type_action === "edit")
                        {
                            contacts.rows('.selected').remove().draw(false);
                            contacts.row.add({
                                "DT_RowId": "contact_" + id_contact,
                                "identification_contact": '\
                                    <h3>Nom : <strong>' + nom_contact + '</strong></h3>\n\
                                    <p>Email : <strong>' + email_contact + '</strong></p>\n\
                                    <p>Message : ' + message_contact + '</p>',
                                "date_inscription_contact": date_inscription_contact,
                                "nom_contact": nom_contact,
                                "email_contact": email_contact,
                                "message_contact": message_contact,
                                "actions_contact": '<button type="button" data-toggle="tooltip"  data-placement="left" title="Historique" class="btn btn-info btn-simple btn-icon action_contact" data-type-action="info">\n\
                                                    <i class="fa fa-info-circle"></i>\n\
                                                </button><br/>\n\
                                                <button type="button" data-toggle="tooltip"  data-placement="left" title="Edit Post" class="btn btn-success btn-simple btn-icon action_contact" data-type-action="edit">\n\
                                                    <i class="fa fa-edit"></i>\n\
                                                </button><br/>\n\
                                                <button type="button" data-toggle="tooltip" data-placement="left" title="Remove Post" class="btn btn-danger btn-simple btn-icon action_contact" data-type-action="delete">\n\
                                                    <i class="fa fa-times"></i>\n\
                                                </button>',
                                "historique": result
                            }).draw().node();

                        }
                        else
                        {
                            tr.removeClass('selected');
                        }

                    });
                }

            }).catch(swal.noop);

            click_effect();

            for (var h = 0; h < historique_contact.length; h++) {
                $('select[name=titre_tache_' + h + ']').material_select();
            }


            $("#add_task").click(function () {
                last_task = $("#tasks .task").length ? $("#tasks .task").last().attr("class") : '';
                number_of_tasks = last_task ? parseInt(last_task.substr(last_task.lastIndexOf(' ') + 1).replace("task_", "")) + 1 : 0;

                $("#tasks").append('<div class="col-xs-8 col-sm-10 task_' + number_of_tasks + '">\n\
                            <div class="row">\n\
                                <div class="col-xs-12 text-xs-left">\n\
                                    <h4><i class="fa fa-calendar"></i> <span class="text-capitalize">' + moment().format("dddd MMMM LL") + '</span> à ' + moment().format("kk") + 'h' + moment().format("mm") + '</h4>\n\
                                    <input type="hidden" id="date_tache_' + number_of_tasks + '" name="date_tache_' + number_of_tasks + '" class="" value="' + moment().format("YYYY-MM-DD LTS") + '">\n\
                                </div>\n\
                                <div class="col-xs-12">\n\
                                    <select class="mdb-select text-xs-center colorful-select dropdown-primary" name="titre_tache_' + number_of_tasks + '">\n\
                                        <option value="Contacter par téléphone">Contacter par téléphone</option>\n\
                                        <option value="Contact non présent">Contact non présent</option>\n\
                                        <option value="Contact par email">Contact par email</option>\n\
                                        <option value="Réponse contact">Réponse contact</option>\n\
                                        <option value="Non intéressé">Non intéressé</option>\n\
                                    </select><br/><br/>\n\
                                </div>\n\
                                <div class="col-xs-12 col-sm-12">\n\
                                    <div class="md-form">\n\
                                        <i class="material-icons prefix">insert_comment</i>\n\
                                        <textarea name="comments_' + number_of_tasks + '" id="comments_' + number_of_tasks + '" class="md-textarea"></textarea>\n\
                                        <label for="comments_' + number_of_tasks + '">Commentaires</label>\n\
                                    </div>\n\
                                </div>\n\
                            </div>\n\
                        </div>\n\
                        <div class="col-xs-4 col-sm-2 task_' + number_of_tasks + '">\n\
                            <a class="btn-floating btn-large red waves-effect waves-light cbutton cbutton--effect-sanja delete_task" data-task="' + number_of_tasks + '" type="button"><i class="fa fa-times fa-2x" aria-hidden="true"></i></a>\n\
                        </div>\n\
                        <div class="col-xs-10 task offset-xs-1 task_' + number_of_tasks + '"><hr/></div>');

                $('select[name=titre_tache_' + number_of_tasks + ']').material_select();

            });

            $("#tasks").on('click', '.delete_task', function () {
                var task_to_remove = $(this).attr("data-task");
                $(".task_" + task_to_remove).remove();
            });


        });


    };


    webtimelineOverview = function () {

        var timeline = $('#web-timeline').DataTable({
            processing: true,
            serverSide: false,
            ajax: $("#extraction-webtimeline").html(),
            columns: [
                {"data": "identification_web_timeline"},
                {"data": "title_fr"},
                {"data": "title_eng"},
                {"data": "start_date"},
                {"data": "end_date"},
                {"data": "content_fr"},
                {"data": "content_eng"},
                {"data": "badge_icon"},
                {"data": "badge_color"},
                {"data": "created_at"},
                {"data": "actions_timeline"}
            ],
            lengthChange: true,
            lengthMenu: [[5, 10, 15, -1], [5, 10, 15, "Tous"]],
            scrollCollapse: true,
            paging: true,
            dom: '<"row filter_parameters"<"col-xs-12 col-sm-6 col-md-2 col-lg-2"f><"col-xs-12 col-sm-6 col-md-4 col-lg-2"><"col-xs-12 col-sm-6 col-md-2 col-lg-2"B>>iprtip',
            buttons: [
                {
                    text: '<i class="fa fa-user fa-2x" aria-hidden="true"></i> Créer un élément',
                    className: 'btn-primary',
                    action: function (e, dt, node, config) {

                    }
                }
            ],
            pageResize: false,
            responsive: true,
            language: {
                "decimal": "",
                "emptyTable": "Aucune donnée disponible dans cette table",
                "info": " _START_ à _END_ de _TOTAL_ items",
                "infoEmpty": "Aucune entrée",
                "infoFiltered": "(filtered from _MAX_ total entries)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Montrer _MENU_ items",
                "loadingRecords": "Chargement...",
                "processing": "Traitement...",
                "search": "_INPUT_",
                "zeroRecords": "Aucune donnée trouvée",
                searchPlaceholder: "Rechercher par titre",
                "paginate": {
                    "first": "Premier",
                    "last": "Dernier",
                    "next": "Suivant",
                    "previous": "Précédent"
                },
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                }
            },
            columnDefs: [
                {
                    "searchable": false,
                    "orderable": false,
                    "targets": [0]
                },
                {
                    "targets": 10,
                    "className": 'td-actions text-xs-right'
                },
                {
                    "targets": [1, 2, 3, 4, 6, 7, 8, 9],
                    "visible": false
                },
                {
                    "targets": [0, 1, 4, 5, 6],
                    "searchable": false
                },
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: 2}],
            order: [[9, 'desc']],
            "drawCallback": function () {
                $('[data-toggle="tooltip"]').tooltip({
                    container: 'table'
                });
            },
            initComplete: function () {
                $('<select class="selectpicker show-tick" id="participation_filter" data-style="btn-info" data-width="100%" title="Trier par">\n\
                        <option value="1a">Nom A-Z</option>\n\
                        <option value="1d">Nom Z-A</option>\n\
                        <option data-divider="true"></option>\n\
                        <option value="9a">Date asc</option>\n\
                        <option value="9d" selected>Date desc</option>\n\
                    </select>')
                        .appendTo($(".filter_parameters > div:nth-child(2)"))
                        .on('change', function () {
                            var col = $(this).val();
                            if (col[1] === "a") {
                                timeline.column(col[0]).order('asc').draw();
                            }
                            else
                            {
                                timeline.column(col[0]).order('desc').draw();
                            }

                        });
                $('#participation_filter').selectpicker();
            }
        });

        var tr = '', first_close = false, type_action = '', id_contact = '', rowData = '', text_confirmation = '', titre_dialog = '',
                contenu_dialog = '', type_dialog = '', dialog_length = '', nom_contact = '', confirmButtonText = '', showCancelButton = false,
                number_of_tasks = 0, last_task = '', edition_options = '', historique_contact = '', tache = '', email_contact = '',
                message_contact = '', date_inscription_contact = '', titre_tache = '',
                select_options = ["Contacter par téléphone", "Contact non présent", "Contact par email", "Réponse contact", "Non intéressé"],
                comment_active_icon = '', comment_active_label = '';

        $('#web-timeline').on('click', 'tr .action_timeline', function () {

            tr = $(this).closest('tr');
            tr.addClass('selected');
            rowData = timeline.rows(tr).data();
            first_close = false;
            type_action = $(this).attr("data-type-action");
            id_timeline = rowData[0]["DT_RowId"].replace("timeline_", "");
            titre_fr = rowData[0]["titre_fr"];
            titre_eng = rowData[0]["titre_eng"];
            if (type_action === "delete") {
                text_confirmation = "La branche " + nom_contact + " a bien été supprimée.";
                dialog_length = '500px';
                titre_dialog = 'Suppression de la branche ' + nom_contact + ' ?';
                contenu_dialog = '';
                type_dialog = 'warning';
                confirmButtonText = "OK";
                showCancelButton = true;
            }
            else if (type_action === "edit")
            {
                text_confirmation = "La branche a bien été mise à jour.";
                dialog_length = '800px';
                titre_dialog = 'Edition branche';
                contenu_dialog = '\
                <br/>\n\
                <form id="edition_timeline">\n\
                    <div class="row">\n\
                        <div class="col-xs-12 col-md-12">\n\
                            <div class="btn-group" data-toggle="buttons">\n\
                                <label class="btn btn-cyan btn-rounded active">\n\
                                    <input type="radio" checked autocomplete="off" name="language" value="fr"> Français <i class="fa fa-user ml-2"></i>\n\
                                </label>\n\
                                <label class="btn btn-cyan btn-rounded">\n\
                                    <input type="radio" autocomplete="off" name="language" value="eng"> English <i class="fa fa-code ml-2"></i>\n\
                                </label>\n\
                            </div>\n\
                        </div>\n\
                        <div class="col-xs-12 col-md-12">\n\
                            <div class="md-form mt-2">\n\
                                <i class="material-icons prefix">title</i>\n\
                                <input type="text" id="title_fr" name="title_fr" class="form-control">\n\
                                <label for="title_fr">Titre</label>\n\
                            </div>\n\
                        </div>\n\
                        <div class="col-xs-12 col-md-6">\n\
                            <div class="md-form">\n\
                                <i class="fa fa-calendar prefix"></i>\n\
                                <input type="text" id="start_date" name="start_date" class="form-control datepicker">\n\
                                <label for="start_date">Start Date</label>\n\
                            </div>\n\
                        </div>\n\
                        <div class="col-xs-12 col-md-6">\n\
                            <div class="md-form">\n\
                                <i class="fa fa-calendar prefix"></i>\n\
                                <input type="text" id="end_date" name="end_date" class="form-control datepicker">\n\
                                <label for="end_date">End date</label>\n\
                            </div>\n\
                        </div>\n\
                        <div class="col-xs-12 col-sm-12">\n\
                            <div class="md-form">\n\
                                <i class="material-icons prefix">insert_comment</i>\n\
                                <textarea name="content_fr" id="content_fr" class="md-textarea"></textarea>\n\
                                <label for="content_fr">Content</label>\n\
                            </div>\n\
                        </div>\n\
                        <div class="col-xs-12 col-md-6">\n\
                            <div class="md-form">\n\
                                <i class="fa fa-id-badge prefix"></i>\n\
                                <input type="text" id="badge_icon" name="badge_icon" class="form-control">\n\
                                <label for="badge_icon">Badge icon</label>\n\
                            </div>\n\
                        </div>\n\
                        <div class="col-xs-12 col-md-6">\n\
                            <div class="md-form">\n\
                                <i class="fa fa-id-badge prefix"></i>\n\
                                <input type="text" id="badge_color" name="badge_color" class="form-control">\n\
                                <label for="badge_color">Badge color</label>\n\
                            </div>\n\
                        </div>\n\
                    </div>\n\
                </form>';
                confirmButtonText = "OK";
                showCancelButton = true;
                type_dialog = null;
            }
            swal({
                padding: 20,
                width: dialog_length,
                background: '#fff',
                timer: null,
                animation: false,
                allowOutsideClick: true,
                allowEscapeKey: true,
                showConfirmButton: true,
                input: null,
                text: null,
                title: titre_dialog,
                html: contenu_dialog,
                type: type_dialog,
                showCancelButton: showCancelButton,
                buttonsStyling: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonColor: '#4caf50',
                cancelButtonColor: '#d33',
                confirmButtonText: confirmButtonText,
                cancelButtonText: "CANCEL",
                reverseButtons: true,
                focusCancel: false,
                showCloseButton: false,
                showLoaderOnConfirm: true,
                customClass: 'animated tada',
                preConfirm: function () {
                    edition_options = type_action === "edit" ? '&' + $('#edition_timeline').serialize() : '';

                    return new Promise(function (resolve, reject) {
                        if (type_action !== "info") {
                            $.ajax({
                                url: $("#action_timeline").html(),
                                data: 'type_action=' + type_action + '&id_contact=' + id_contact + edition_options,
                                type: 'POST',
                                dataType: 'json',
                                encode: true
                            })
                                    .done(function (data) {
                                        if (!data.success) {
                                            reject('aie');
                                        }
                                        else
                                        {
                                            resolve(data.historique);
                                            first_close = true;
                                        }

                                    })
                                    .fail(function (data) {
                                        reject('aie');
                                    });
                        }
                        else
                        {
                            resolve();
                        }
                    });

                },
                imageUrl: null,
                imageWidth: null,
                imageHeight: null,
                imageClass: null,
                inputPlaceholder: '', inputValue: '', inputAutoTrim: true,
                inputClass: null,
                onOpen: null,
                onClose: function () {
                    if (!first_close) {
                        tr.removeClass('selected');
                    }
                    first_close = true;
                }
            }).then(function (result) {
                if (type_action !== "info") {
                    swal({
                        title: 'Confirmée!',
                        text: text_confirmation,
                        type: 'success',
                        allowOutsideClick: false
                    }).then(function () {
                        if (type_action === "delete") {
                            timeline.rows('.selected').remove().draw(false);
                        }
                        else if (type_action === "edit")
                        {
                            timeline.rows('.selected').remove().draw(false);
                            timeline.row.add({
                                "DT_RowId": "contact_" + id_contact,
                                "identification_contact": '\
                                    <h3>Nom : <strong>' + nom_contact + '</strong></h3>\n\
                                    <p>Email : <strong>' + email_contact + '</strong></p>\n\
                                    <p>Message : ' + message_contact + '</p>',
                                "date_inscription_contact": date_inscription_contact,
                                "nom_contact": nom_contact,
                                "email_contact": email_contact,
                                "message_contact": message_contact,
                                "actions_contact": '<button type="button" data-toggle="tooltip"  data-placement="left" title="Historique" class="btn btn-info btn-simple btn-icon action_contact" data-type-action="info">\n\
                                                    <i class="fa fa-info-circle"></i>\n\
                                                </button><br/>\n\
                                                <button type="button" data-toggle="tooltip"  data-placement="left" title="Edit Post" class="btn btn-success btn-simple btn-icon action_contact" data-type-action="edit">\n\
                                                    <i class="fa fa-edit"></i>\n\
                                                </button><br/>\n\
                                                <button type="button" data-toggle="tooltip" data-placement="left" title="Remove Post" class="btn btn-danger btn-simple btn-icon action_contact" data-type-action="delete">\n\
                                                    <i class="fa fa-times"></i>\n\
                                                </button>',
                                "historique": result
                            }).draw().node();

                        }
                        else
                        {
                            tr.removeClass('selected');
                        }

                    });
                }

            }).catch(swal.noop);
            $('input[name="language"]').on('click',function(){
                console.log("oui y")
            });

            $('.datepicker').dateDropper();

        });


    };

    categoriesOverview = function () {

        var column_list = [
        { "data": "name_fr" },
        { "data": "name_eng" },
        { "data": "created_at" },
        { "data": "actions" }
        ],column_defs = [ 
        {
            "targets": [2],
            "visible": false
        },
        {
            "targets": [2, 3],
            "searchable": false
        },
        {
            "targets": -1,
            "className": 'td-actions text-xs-right'
        },
        {responsivePriority: 1, targets: 0},
        {responsivePriority: 2, targets: 2}
        ];

        CRUDitem( "categorie", column_list, column_defs, [ 2, 'desc' ], '/admin/categories/list', 5);

        var tr = '', first_close = false, type_action = '', category_id = '', rowData = '', text_confirmation = '', titre_dialog = '',
                contenu_dialog = '', type_dialog = '', nom_category = '', actions_category = '', confirmButtonText = '', showCancelButton = false;

        $('#categories').on('click', 'tr .action_category', function () {

            tr = $(this).closest('tr');
            tr.addClass('selected');
            rowData = categories.rows(tr).data();
            first_close = false;
            type_action = $(this).attr("data-type-action");
            category_id = rowData[0]["DT_RowId"].replace("category_", "");
            name_fr = rowData[0]["name_fr"];
            name_eng = rowData[0]["name_eng"];
            created_at = rowData[0]["created_at"];
            actions_category = rowData[0]["actions_category"];
            if (type_action === "delete") {
                text_confirmation = "La catégorie " + name_fr + " a bien été supprimée.";
                titre_dialog = 'Suppression de la catégorie ' + name_fr + ' ?';
                contenu_dialog = '';
                type_dialog = 'warning';
                confirmButtonText = "OK";
                showCancelButton = true;
            }
            else if (type_action === "edit")
            {
                text_confirmation = "La catégorie a bien été mise à jour.";
                titre_dialog = 'Edition catégorie';
                contenu_dialog= '\n\
                            <form id="edit_category">\n\
                                <div class="row">\n\
                                    <div class="col-xs-12 col-md-12">\n\
                                        <div class="md-form mt-2">\n\
                                            <i class="material-icons prefix active">title</i>\n\
                                            <input type="text" id="name_fr" name="name_fr" class="form-control" value="'+name_fr+'">\n\
                                            <label for="name_fr" class="active">Nom</label>\n\
                                        </div>\n\
                                    </div>\n\
                                    <div class="col-xs-12 col-md-12">\n\
                                        <div class="md-form mt-2">\n\
                                            <i class="material-icons prefix active">title</i>\n\
                                            <input type="text" id="name_eng" name="name_eng" class="form-control" value="'+name_eng+'">\n\
                                            <label for="name_eng" class="active">Name</label>\n\
                                        </div>\n\
                                    </div>\n\
                                </div>\n\
                            </form>',
                confirmButtonText = "OK";
                showCancelButton = true;
                type_dialog = null;
            }
            swal({
                padding: 20,
                width: '500px',
                background: '#fff',
                timer: null,
                animation: false,
                allowOutsideClick: true,
                allowEscapeKey: true,
                showConfirmButton: true,
                input: null,
                text: null,
                title: titre_dialog,
                html: contenu_dialog,
                type: type_dialog,
                showCancelButton: showCancelButton,
                buttonsStyling: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonColor: '#4caf50',
                cancelButtonColor: '#d33',
                confirmButtonText: confirmButtonText,
                cancelButtonText: "CANCEL",
                reverseButtons: true,
                focusCancel: false,
                showCloseButton: false,
                showLoaderOnConfirm: true,
                preConfirm: function () {
                    edition_options = type_action === "edit" ? '&' + $('#edit_category').serialize() : '';

                    return new Promise(function (resolve, reject) {
                        $.ajax({
                            url: $("#action_categories").html(),
                            data: 'type_action=' + type_action + '&category_id=' + category_id + edition_options,
                            type: 'POST',
                            dataType: 'json',
                            encode: true
                        })
                        .done(function (data) {
                            if (!data.success) {
                                reject('aie');
                            }
                            else
                            {
                                resolve([
                                    $('input[name=name_fr]').val(),
                                    $('input[name=name_eng]').val()
                                    ]);
                                first_close = true;
                            }

                        })
                        .fail(function (data) {
                            reject('aie');
                        });
                    });
                },
                imageUrl: null,
                imageWidth: null,
                imageHeight: null,
                imageClass: null,
                inputPlaceholder: '', 
                inputValue: '', 
                inputAutoTrim: true,
                inputClass: null,
                onOpen: null,
                onClose: function () {
                    if (!first_close) {
                        tr.removeClass('selected');
                    }
                    first_close = true;
                }
            }).then(function (result) {
                swal({
                    title: 'Confirmée!',
                    text: text_confirmation,
                    type: 'success',
                    allowOutsideClick: false
                }).then(function () {
                    if (type_action === "delete") {
                        categories.rows('.selected').remove().draw(false);
                    }
                    else
                    {
                        categories.rows('.selected').remove().draw(false);
                        categories.row.add({
                            "DT_RowId": "category_" + category_id,
                            "name_fr": result[0],
                            "name_eng": result[1],
                            "created_at": created_at,
                            "actions_category": actions_category
                        }).draw().node();
                    }
                });

            }).catch(swal.noop);
        });
    };

    tagsOverview = function () {

        var tags = $('#tags').DataTable({
            processing: true,
            serverSide: false,
            ajax: $("#extraction-tags").html(),
            columns: [
                {"data": "name_fr"},
                {"data": "name_eng"},
                {"data": "created_at"},
                {"data": "actions_tag"}
            ],
            lengthChange: true,
            lengthMenu: [[5, 10, 15, -1], [5, 10, 15, "Tous"]],
            scrollCollapse: true,
            paging: true,
            dom: '<"row filter_parameters"<"col-xs-12 col-sm-6 col-md-2 col-lg-2"f><"col-xs-12 col-sm-6 col-md-4 col-lg-2"><"col-xs-12 col-sm-6 col-md-2 col-lg-2"B>>iprtip',
            buttons: [
                {
                    text: '<i class="fa fa-user fa-2x" aria-hidden="true"></i> Créer un tag',
                    className: 'btn-primary',
                    action: function (e, dt, node, config) {
                        swal({
                            padding: 20,
                            width: '500px',
                            background: '#fff',
                            timer: null,
                            animation: false,
                            allowOutsideClick: true,
                            allowEscapeKey: true,
                            showConfirmButton: true,
                            input: null,
                            text: null,
                            title: 'Création nouveau tag',
                            html: '\n\
                            <form id="new_tag">\n\
                                <div class="row">\n\
                                    <div class="col-xs-12 col-md-12">\n\
                                        <div class="md-form mt-2">\n\
                                            <i class="material-icons prefix">title</i>\n\
                                            <input type="text" id="name_fr" name="name_fr" class="form-control">\n\
                                            <label for="name_fr">Nom</label>\n\
                                        </div>\n\
                                    </div>\n\
                                    <div class="col-xs-12 col-md-12">\n\
                                        <div class="md-form mt-2">\n\
                                            <i class="material-icons prefix">title</i>\n\
                                            <input type="text" id="name_eng" name="name_eng" class="form-control">\n\
                                            <label for="name_eng">Name</label>\n\
                                        </div>\n\
                                    </div>\n\
                                </div>\n\
                            </form>',
                            type: null,
                            showCancelButton: true,
                            buttonsStyling: true,
                            confirmButtonClass: 'btn btn-success',
                            cancelButtonClass: 'btn btn-danger',
                            confirmButtonColor: '#4caf50',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'OK',
                            cancelButtonText: "CANCEL",
                            reverseButtons: true,
                            focusCancel: false,
                            showCloseButton: false,
                            showLoaderOnConfirm: true,
                            preConfirm: function () {
                                return new Promise(function (resolve, reject) {
                                    if (type_action !== "info") {
                                        $.ajax({
                                            url: $("#action_tags").html(),
                                            data: 'type_action=create&'+ $('#new_tag').serialize(),
                                            type: 'POST',
                                            dataType: 'json',
                                            encode: true
                                        })
                                        .done(function (data) {
                                            if (!data.success) {
                                                reject('aie');
                                            }
                                            else
                                            {
                                                resolve([
                                                        data.tag_settings[0],
                                                        $('input[name=name_fr]').val(),
                                                        $('input[name=name_eng]').val(),
                                                        data.tag_settings[1],
                                                    ]);
                                            }

                                        })
                                        .fail(function (data) {
                                            reject('aie');
                                        });
                                    }
                                    else
                                    {
                                        resolve();
                                    }
                                });

                            },
                            imageUrl: null,
                            imageWidth: null,
                            imageHeight: null,
                            imageClass: null,
                            inputPlaceholder: '', 
                            inputValue: '', 
                            inputAutoTrim: true,
                            inputClass: null,
                            onOpen: null
                        }).then(function (result) {
                            swal({
                                title: 'Confirmée!',
                                text: 'Le tag '+result[1]+' a bien été crée',
                                type: 'success',
                                allowOutsideClick: false
                            }).then(function () {
                                tags.row.add({
                                    "DT_RowId": "tag_" + result[0],
                                    "name_fr": result[1],
                                    "name_eng": result[2],
                                    "created_at": result[3],
                                    "actions_tag": '<button type="button" data-toggle="tooltip"  data-placement="left" title="Edit tag" class="btn btn-success btn-simple btn-icon action_tag" data-type-action="edit">\n\
                                    <i class="fa fa-edit"></i>\n\
                                    </button><br/>\n\
                                    <button type="button" data-toggle="tooltip" data-placement="left" title="Delete tag" class="btn btn-danger btn-simple btn-icon action_tag" data-type-action="delete">\n\
                                    <i class="fa fa-times"></i>\n\
                                    </button>'
                                }).draw().node();
                            });

                        }).catch(swal.noop);
                    }
                }
            ],
            pageResize: false,
            responsive: true,
            language: {
                "decimal": "",
                "emptyTable": "Aucune donnée disponible dans cette table",
                "info": " _START_ à _END_ de _TOTAL_ tags",
                "infoEmpty": "Aucune entrée",
                "infoFiltered": "(filtered from _MAX_ total entries)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Montrer _MENU_ tags",
                "loadingRecords": "Chargement...",
                "processing": "Traitement...",
                "search": "_INPUT_",
                "zeroRecords": "Aucune donnée trouvée",
                searchPlaceholder: "Rechercher par titre",
                "paginate": {
                    "first": "Premier",
                    "last": "Dernier",
                    "next": "Suivant",
                    "previous": "Précédent"
                },
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                }
            },
            columnDefs: [
                {
                    "searchable": false,
                    "orderable": false,
                    "targets": [0]
                },
                {
                    "targets": 3,
                    "className": 'td-actions text-xs-right'
                },
                {
                    "targets": [2],
                    "visible": false
                },
                {
                    "targets": [3],
                    "searchable": false
                },
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: 3}],
            order: [[2, 'desc']],
            "drawCallback": function () {
                $('[data-toggle="tooltip"]').tooltip({
                    container: 'table'
                });
            },
            initComplete: function () {
                $('<select class="selectpicker show-tick" id="participation_filter" data-style="btn-info" data-width="100%" title="Trier par">\n\
                        <option value="0a">Nom A-Z</option>\n\
                        <option value="0d">Nom Z-A</option>\n\
                        <option data-divider="true"></option>\n\
                        <option value="2a">Date asc</option>\n\
                        <option value="2d" selected>Date desc</option>\n\
                    </select>')
                        .appendTo($(".filter_parameters > div:nth-child(2)"))
                        .on('change', function () {
                            var col = $(this).val();
                            if (col[1] === "a") {
                                tags.column(col[0]).order('asc').draw();
                            }
                            else
                            {
                                tags.column(col[0]).order('desc').draw();
                            }

                        });
                $('#participation_filter').selectpicker();
            }
        });

        var tr = '', first_close = false, type_action = '', tag_id = '', rowData = '', text_confirmation = '', titre_dialog = '',
                contenu_dialog = '', type_dialog = '', nom_tag = '', actions_tag = '', confirmButtonText = '', showCancelButton = false;

        $('#tags').on('click', 'tr .action_tag', function () {

            tr = $(this).closest('tr');
            tr.addClass('selected');
            rowData = tags.rows(tr).data();
            first_close = false;
            type_action = $(this).attr("data-type-action");
            tag_id = rowData[0]["DT_RowId"].replace("tag_", "");
            name_fr = rowData[0]["name_fr"];
            name_eng = rowData[0]["name_eng"];
            created_at = rowData[0]["created_at"];
            actions_tag = rowData[0]["actions_tag"];
            if (type_action === "delete") {
                text_confirmation = "Le tag " + name_fr + " a bien été supprimé.";
                titre_dialog = 'Suppression du tag ' + name_fr + ' ?';
                contenu_dialog = '';
                type_dialog = 'warning';
                confirmButtonText = "OK";
                showCancelButton = true;
            }
            else if (type_action === "edit")
            {
                text_confirmation = "Le tag a bien été mis à jour.";
                titre_dialog = 'Edition tag';
                contenu_dialog= '\n\
                            <form id="edit_tag">\n\
                                <div class="row">\n\
                                    <div class="col-xs-12 col-md-12">\n\
                                        <div class="md-form mt-2">\n\
                                            <i class="material-icons prefix active">title</i>\n\
                                            <input type="text" id="name_fr" name="name_fr" class="form-control" value="'+name_fr+'">\n\
                                            <label for="name_fr" class="active">Nom</label>\n\
                                        </div>\n\
                                    </div>\n\
                                    <div class="col-xs-12 col-md-12">\n\
                                        <div class="md-form mt-2">\n\
                                            <i class="material-icons prefix active">title</i>\n\
                                            <input type="text" id="name_eng" name="name_eng" class="form-control" value="'+name_eng+'">\n\
                                            <label for="name_eng" class="active">Name</label>\n\
                                        </div>\n\
                                    </div>\n\
                                </div>\n\
                            </form>',
                confirmButtonText = "OK";
                showCancelButton = true;
                type_dialog = null;
            }
            swal({
                padding: 20,
                width: '500px',
                background: '#fff',
                timer: null,
                animation: false,
                allowOutsideClick: true,
                allowEscapeKey: true,
                showConfirmButton: true,
                input: null,
                text: null,
                title: titre_dialog,
                html: contenu_dialog,
                type: type_dialog,
                showCancelButton: showCancelButton,
                buttonsStyling: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonColor: '#4caf50',
                cancelButtonColor: '#d33',
                confirmButtonText: confirmButtonText,
                cancelButtonText: "CANCEL",
                reverseButtons: true,
                focusCancel: false,
                showCloseButton: false,
                showLoaderOnConfirm: true,
                preConfirm: function () {
                    edition_options = type_action === "edit" ? '&' + $('#edit_tag').serialize() : '';

                    return new Promise(function (resolve, reject) {
                        $.ajax({
                            url: $("#action_tags").html(),
                            data: 'type_action=' + type_action + '&tag_id=' + tag_id + edition_options,
                            type: 'POST',
                            dataType: 'json',
                            encode: true
                        })
                        .done(function (data) {
                            if (!data.success) {
                                reject('aie');
                            }
                            else
                            {
                                resolve([
                                    $('input[name=name_fr]').val(),
                                    $('input[name=name_eng]').val()
                                    ]);
                                first_close = true;
                            }

                        })
                        .fail(function (data) {
                            reject('aie');
                        });
                    });
                },
                imageUrl: null,
                imageWidth: null,
                imageHeight: null,
                imageClass: null,
                inputPlaceholder: '', 
                inputValue: '', 
                inputAutoTrim: true,
                inputClass: null,
                onOpen: null,
                onClose: function () {
                    if (!first_close) {
                        tr.removeClass('selected');
                    }
                    first_close = true;
                }
            }).then(function (result) {
                swal({
                    title: 'Confirmée!',
                    text: text_confirmation,
                    type: 'success',
                    allowOutsideClick: false
                }).then(function () {
                    if (type_action === "delete") {
                        tags.rows('.selected').remove().draw(false);
                    }
                    else
                    {
                        tags.rows('.selected').remove().draw(false);
                        tags.row.add({
                            "DT_RowId": "tag_" + tag_id,
                            "name_fr": result[0],
                            "name_eng": result[1],
                            "created_at": created_at,
                            "actions_tag": actions_tag
                        }).draw().node();
                    }
                });

            }).catch(swal.noop);
        });
    };




