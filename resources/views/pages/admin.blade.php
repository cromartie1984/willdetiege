@extends('main', ['body_class' => 'fixed-sn slight-blue-skin'])

@section('stylesheets')
{{ Html::style('https://cdnjs.cloudflare.com/ajax/libs/datedropper/2.0/datedropper.min.css')}}
@endsection

@section('title', '| ' . $pagetitle)

@section('content')

@include('partials._navadmin')

<!--Main layout-->
<main class="admin">

    <div class="container-fluid">

        <!-- First row -->
        <div class="row mb-3">

            <div class="col-md-3">

                <div class="data-card text-center">
                    <h3>6 104</h3>
                    <p class="text-uppercase">Sessions</p>
                </div>

            </div>
            <div class="col-md-3">

                <div class="data-card text-center">
                    <h3>420</h3>
                    <p class="text-uppercase">Pages per session</p>
                </div>

            </div>
            <div class="col-md-3">

                <div class="data-card text-center">
                    <h3>1 785</h3>
                    <p class="text-uppercase">New Sessions</p>
                </div>

            </div>
            <div class="col-md-3">

                <div class="data-card text-center">
                    <h3>1 890</h3>
                    <p class="text-uppercase">Users</p>
                </div>

            </div>

        </div>
        <!-- /.First row -->

        <!--Section: Main Chart-->
        <section class="section">

            <!--Main row-->
            <div class="row">

                <div class="col-md-12">
                    <!--Card-->
                    <div class="card card-cascade narrower">

                        <!--Admin panel-->
                        <div class="admin-panel">

                            <!--First row-->
                            <div class="row mb-0">

                                <!--First column-->
                                <div class="col-md-5">

                                    <!--Panel title-->
                                    <div class="view left primary-color">
                                        <h2>Traffic</h2>
                                    </div>
                                    <!--/Panel title-->

                                    <!--Panel data-->
                                    <div class="row card-block pt-5">

                                        <!--First column-->
                                        <div class="col-md-12">

                                            <!--Date select-->
                                            <h4><span class="badge big-badge primary-color">Data range</span></h4>
                                            <select class="select">
                                                <option value="" disabled selected>Choose time period</option>
                                                <option value="1">Today</option>
                                                <option value="2">Yesterday</option>
                                                <option value="3">Last 7 days</option>
                                                <option value="3">Last 30 days</option>
                                                <option value="3">Last week</option>
                                                <option value="3">Last month</option>
                                            </select>
                                            <br/>

                                            <!--Date pickers-->
                                            <h4><span class="badge big-badge primary-color">Custom date</span></h4>
                                            <br/>
                                            <div class="md-form d-inline-block">
                                                <input placeholder="Selected date" type="text" id="from" class="form-control datepicker">
                                                    <label for="date-picker-example">From</label>
                                            </div>
                                            <div class="md-form d-inline-block float-md-right">
                                                <input placeholder="Selected date" type="text" id="to" class="form-control datepicker">
                                                    <label for="date-picker-example">To</label>
                                            </div>

                                        </div>
                                        <!--/First column-->

                                    </div>
                                    <!--/Panel data-->
                                </div>
                                <!--/First column-->

                                <!--Second column-->
                                <div class="col-md-7">
                                    <!--Cascading element-->
                                    <div class="view right primary-color mb-3">
                                        <!--Main chart-->
                                        <canvas id="traffic" height="155px"></canvas>
                                    </div>
                                    <!--/Cascading element-->
                                </div>
                                <!--/Second column-->

                            </div>
                            <!--/First row-->

                        </div>
                        <!--/Admin panel-->

                    </div>
                    <!--/.Card-->
                </div>

            </div>
            <!--/Main row-->

        </section>
        <!--/Section: Main chart-->

        <!-- Section: data tables -->
        <section class="section">

            <div class="row">
                <div class="col-md-4">

                    <div class="card mb-5">
                        <div class="card-block">
                            <h4 class="h4-responsive text-center mb-2">
                                Visits by Browser
                            </h4>

                            <canvas id="seo"></canvas>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-block">
                            <div class="table-responsive">
                                <table class="table large-header">
                                    <thead>
                                        <tr>
                                            <th>Keywords</th>
                                            <th>Visits</th>
                                            <th>Pages</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Material Design</td>
                                            <td>15</td>
                                            <td>307</td>
                                        </tr>
                                        <tr>
                                            <td>Bootstrap</td>
                                            <td>32</td>
                                            <td>504</td>
                                        </tr>
                                        <tr>
                                            <td>MDBootstrap</td>
                                            <td>41</td>
                                            <td>613</td>
                                        </tr>
                                        <tr>
                                            <td>Frontend</td>
                                            <td>14</td>
                                            <td>208</td>
                                        </tr>
                                        <tr>
                                            <td>CSS Framework</td>
                                            <td>24</td>
                                            <td>314</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <button class="btn-flat waves-effect float-right">View full report</button>

                        </div>

                    </div>

                </div>

                <div class="col-md-8">
                    <div class="card mb-5">
                        <div class="card-block">
                            <table class="table large-header">
                                <thead>
                                    <tr>
                                        <th>Country</th>
                                        <th>Visits</th>
                                        <th>Pages</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><img src="/img/flags/us.png" class="flag"> United States</td>
                                        <td>15</td>
                                        <td>307</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/img/flags/in.png" class="flag"> India</td>
                                        <td>32</td>
                                        <td>504</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/img/flags/cn.png" class="flag"> China</td>
                                        <td>41</td>
                                        <td>613</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/img/flags/pl.png" class="flag"> Poland</td>
                                        <td>14</td>
                                        <td>208</td>
                                    </tr>
                                    <tr>
                                        <td><img src="/img/flags/it.png" class="flag"> Italy</td>
                                        <td>24</td>
                                        <td>314</td>
                                    </tr>
                                </tbody>
                            </table>

                            <button class="btn-flat waves-effect float-right">View full report</button>

                        </div>

                    </div>

                    <div class="card mb-3">
                        <div class="card-block">
                            <table class="table large-header">
                                <thead>
                                    <tr>
                                        <th>Browser</th>
                                        <th>Visits</th>
                                        <th>Pages</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Google Chrome</td>
                                        <td>15</td>
                                        <td>307</td>
                                    </tr>
                                    <tr>
                                        <td>Mozilla Firefox</td>
                                        <td>32</td>
                                        <td>504</td>
                                    </tr>
                                    <tr>
                                        <td>Safari</td>
                                        <td>41</td>
                                        <td>613</td>
                                    </tr>
                                    <tr>
                                        <td>Opera</td>
                                        <td>14</td>
                                        <td>208</td>
                                    </tr>
                                    <tr>
                                        <td>Microsoft Edge</td>
                                        <td>24</td>
                                        <td>314</td>
                                    </tr>
                                </tbody>
                            </table>

                            <button class="btn-flat waves-effect float-right">View full report</button>

                        </div>

                    </div>

                    <div class="card mb-r">
                        <div id="chart-1-container"></div>
                        <div id="chart-2-container"></div>
                    </div>

                </div>
            </div>                    

        </section>
        <!-- /.Section: data tables -->


    </div>

</main>
        <!--/Main layout-->
<!--/ Main container-->
@endsection
@section('scripts')
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/datedropper/2.0/datedropper.min.js') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/easy-pie-chart/2.1.6/jquery.easypiechart.min.js') !!}
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.min.js"></script>

<script>
$(document).ready(function () {

    new WOW().init();
    $(".select").dropdown();
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
    // Tooltips Initialization
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
    $(function () {
        $('.min-chart#chart-sales').easyPieChart({
            barColor: "#4caf50",
            onStep: function (from, to, percent) {
                $(this.el).find('.percent').text(Math.round(percent));
            }
        });
    });
    /*Linechart*/

    var data = {
        labels: ["January", "February", "March", "April", "May", "June", "July"],
        datasets: [{
                label: "My First dataset",
                fillColor: "rgba(220,220,220,0.2)",
                strokeColor: "rgba(220,220,220,1)",
                pointColor: "rgba(220,220,220,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(0,0,0,.15)",
                data: [65, 59, 80, 81, 56, 55, 40],
                backgroundColor: "#4CAF50"
            }, {
                label: "My Second dataset",
                fillColor: "rgba(255,255,255,.25)",
                strokeColor: "rgba(255,255,255,.75)",
                pointColor: "#fff",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(0,0,0,.15)",
                data: [28, 48, 40, 19, 86, 27, 90]
            }]
    };
    var options = {
        responsive: true,
        // set font color
        scaleFontColor: "#fff",
        // font family
        defaultFontFamily: "'Roboto', sans-serif",
        // background grid lines color
        scaleGridLineColor: "rgba(255,255,255,.1)",
        // hide vertical lines
        scaleShowVerticalLines: false,
    };

    var ctx = $("#traffic");

    var myLineChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options
    });

    var dataPie = {
        labels: [
            "Google Chrome",
            "Edge",
            "Firefox"
        ],
        datasets: [
            {
                data: [300, 50, 100],
                backgroundColor: [
                    "#4caf50",
                    "#03a9f4",
                    "#d32f2f"
                ],
                hoverBackgroundColor: [
                    "#66bb6a",
                    "#29b6f6",
                    "#e53935"
                ]
            }]
    };

    var pie = $("#seo");
    var myPieChart = new Chart(pie, {
        type: 'pie',
        data: dataPie,
        options: options
    });
    // Data Picker Initialization
    /*old version of datepicker*/
    /*$('.datepicker').dateDropper(
     {
     format: "d / m / Y",
     lang: "fr",
     placeholder: "Date de début",
     minYear: "1916",
     animation: "bounce",
     years_multiple: "20",
     color: "#5CB1BB",
     textColor: "#5CB1BB",
     bgColor: "#ffffff",
     borderColor: "#5CB1BB"
     }
     );*/

    /*new version of datepicker*/
    $('.datepicker').dateDropper();
    /* $('.main').perfectScrollbar({suppressScrollX:true});*/
});
</script>
@endsection