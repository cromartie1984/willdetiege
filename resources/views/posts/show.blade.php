@extends('main', ['body_class' => 'fixed-sn slight-blue-skin'])

@section('title', '| ' . $pagetitle)

@section('content')

@include('partials._navadmin')

 <!--/.Double navigation-->
<!--Main layout-->
<main class="admin">
    <div class="container-fluid">
        <!-- Section: Create Page -->
        <section class="section">
            <div class="card card-cascade cascading-admin-card">
                <div class="admin-up">
                    <i class="fa fa-money blue darken-3"></i>
                    <div class="data">
                        <h3>Résumé</h3>
                    </div>
                </div>
                <!--/.Card Data-->

                <!--Card content-->
                <div class="card-block">
                    <div class="material-datatables">
                        <table class="table table-hover row-border" width="100%" id="blog-posts-list" cellspacing="0">
                            <thead  style="white-space: nowrap">
                                <tr>
                                    <th>Identification</th>
                                    <th>Author</th>
                                    <th>Category</th>
                                    <th>Title</th>
                                    <th>Body</th>
                                    <th>Slug</th>
                                    <th>Tags</th>
                                    <th>Cover_image</th>
                                    <th>Excerpt</th>
                                    <th>created_at</th>
                                    <th>updated_at</th>
                                    <th>Actions</th>
                                </tr>
                            </thead> 
                        </table>
                    </div>
                </div>
                <!-- end content-->
            </div>
        </section>
        <!-- /.Section: Create Page -->
    </div>
</main>
<!--/Main layout-->


@endsection

@section('scripts')
<!--   JS for dataTable plugin   -->
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/jszip-2.5.0/pdfmake-0.1.18/dt-1.10.12/b-1.2.2/b-colvis-1.2.2/b-flash-1.2.2/b-html5-1.2.2/b-print-1.2.2/r-2.1.0/sc-1.4.2/se-1.2.0/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.12/features/pageResize/dataTables.pageResize.min.js"></script>

<script>
	$(document).ready(function () {
		new WOW().init();
//$post->tags()->count()
		//$('.st-menu').perfectScrollbar();

		CRUDitem = function( item, columns_list, column_defs, order, ajaxUrl, paging ) {
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
					/*	$('<select class="selectpicker show-tick" id="participation_filter" data-style="btn-info" data-width="100%" title="Trier par">\n\
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


	

			var column_list = [
			{ "data": "identification" },
			{ "data": "author_id" },
			{ "data": "category" },
			{ "data": "title" },
			{ "data": "body" },
			{ "data": "slug" },
			{ "data": "tags" },
			{ "data": "cover_image" },
			{ "data": "excerpt" },
			{ "data": "created_at" },
			{ "data": "updated_at" },
			{ "data": "actions" }
			],column_defs = [ 
			{
				"targets": [0],
				"orderable": false,
				"searchable": false
			},
			{
				"targets": [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
				"visible": false
			},
			{
				"targets": -1,
				"className": 'td-actions text-xs-right'
			},
			{responsivePriority: 1, targets: 0},
            {responsivePriority: 2, targets: 2}
			];

			CRUDitem( "blog-post", column_list, column_defs, [ 5, 'desc' ], '/admin/posts/list', 5);
		

		$(".select").dropdown();

        $('.material-datatables input[name=blog_overview_length]').dropdown();
        var tr = '', first_close = false, type_action = '', id_article = '', rowData = '', text_confirmation = '', titre_dialog = '',
                contenu_dialog = '', type_dialog = '', dialog_length = '', nombre_erreur = 0, edition_options = '', titre_article = '';

        $('#blog_overview').on('click', 'tr .action_article', function () {

            tr = $(this).closest('tr');
            tr.addClass('selected');
            rowData = article.rows(tr).data();
            first_close = false;
            type_action = $(this).attr("data-type-action");
            id_article = rowData[0]["DT_RowId"].replace("article_", "");
            titre_article = rowData[0]["titre_article"];
            if (type_action === "delete") {
                text_confirmation = "L'article a bien été supprimé.";
                dialog_length = '500px';
                titre_dialog = 'Suppression de l&#39;article ' + titre_article + ' ?';
                contenu_dialog = '';
                type_dialog = 'warning';
                swal({
                    padding: 20,
                    width: dialog_length,
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
                        return new Promise(function (resolve, reject) {

                            $.ajax({
                                url: $("#action_article").html(),
                                data: 'type_action=' + type_action + '&post_id=' + id_article,
                                type: 'POST',
                                dataType: 'json',
                                encode: true
                            })
                                    .done(function (data) {
                                        resolve();
                                        first_close = true;
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
                        article.rows('.selected').remove().draw(false);
                    });
                }).catch(swal.noop);
            }
            else if (type_action === "edit")
            {

            }


        });
	});
</script>
@endsection