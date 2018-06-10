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
                    <i class="material-icons blue darken-3">contact_phone</i>
                    <div class="data">
                        <h3>Résumé</h3>
                    </div>
                </div>
                <!--/.Card Data-->

                <!--Card content-->
                <div class="card-block">
                    <div class="material-datatables">
                        <table class="table table-hover row-border" width="100%" id="contacts-list" cellspacing="0">
                            <thead  style="white-space: nowrap">
                                <tr>
                                    <th>Identification</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Message</th>
                                    <th>History</th>
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
			{ "data": "name" },
			{ "data": "email" },
			{ "data": "message" },
			{ "data": "history" },
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
				"targets": [1, 2, 3, 4, 5, 6],
				"visible": false
			},
			{
				"targets": -1,
				"className": 'td-actions text-xs-right'
			},
			{responsivePriority: 1, targets: 0},
            {responsivePriority: 2, targets: 2}
			];

			CRUDitem( "contact", column_list, column_defs, [ 5, 'desc' ], '/admin/contacts/list', 5);
		

		
	});
</script>
@endsection