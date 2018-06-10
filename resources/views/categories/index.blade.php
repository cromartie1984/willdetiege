@extends('main', ['body_class' => 'fixed-sn slight-blue-skin'])

@section('stylesheets')
{{ Html::style('https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.22.2/sweetalert2.min.css')}}
@endsection

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
                    <i class="material-icons blue darken-3">date_range</i>
                    <div class="data">
                        <h3>Résumé</h3>
                    </div>
                </div>
                <!--/.Card Data-->

                <!--Card content-->
                <div class="card-block">
                    <div class="material-datatables">
                        <div class="row">
                            <div class="btn btn-primary add_new_item" data-title="" data-table="#categories-list">
                                <i class="fa fa-cube fa-2x" aria-hidden="true"></i> Créer une catégorie
                            </div>
                            <label class="float-right search table_search" data-table="#posts-list">
                                <input type="text" name="name_search" placeholder="<Filter>" data-table-column="0"/>
                                <div class="input_after"></div>
                            </label> 
                            <div class="float-right select">
                                <select class="d3-select form-control" name="filter" data-table="#categories-list" style="width:100%">
                                    <option value="0a">Nom A-Z</option>
                                    <option value="0d">Nom Z-A</option>
                                    <option value="2a">Date asc</option>
                                    <option value="2d" selected>Date desc</option> 
                                </select>
                            </div>
                        </div>
                        <table class="table table-hover row-border" width="100%" id="categories-list" cellspacing="0">
                            <thead  style="white-space: nowrap">
                                <tr>
                                    <th>Name</th>
                                    <th>Name eng</th>
                                    <th>Created At</th>
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
{{ Form::open(['class' => 'd-none', 'id' => 'new-category', 'data-table' => '#categories-list']) }}
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="md-form mt-2">
                <i class="material-icons prefix">title</i>
                <input type="text" id="name_fr" name="name_fr" class="form-control">
                <label for="name_fr">Nom</label>
            </div>
        </div>
        <div class="col-xs-12 col-md-12">
            <div class="md-form mt-2">
                <i class="material-icons prefix">title</i>
                <input type="text" id="name_eng" name="name_eng" class="form-control">
                <label for="name_eng">Name</label>
            </div>
        </div>
    </div>
{{ Form::close() }}
<!--/Main layout-->


@endsection

@section('scripts')
<!--   JS for dataTable plugin   -->
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/jszip-2.5.0/pdfmake-0.1.18/dt-1.10.12/b-1.2.2/b-colvis-1.2.2/b-flash-1.2.2/b-html5-1.2.2/b-print-1.2.2/r-2.1.0/sc-1.4.2/se-1.2.0/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.12/features/pageResize/dataTables.pageResize.min.js"></script>
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.22.2/sweetalert2.min.js') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/es6-promise/4.1.1/es6-promise.min.js') !!}
{!! Html::script('/js/admin.js') !!}
<script>
$(document).ready(function () {
    //$post->tags()->count()
    
    if($('#categories-list').length){
        categoriesOverview();
       
    }
});
</script>
@endsection