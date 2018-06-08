@extends('main')

@section('title','| Categories')

@section('content')

@include('partials._navadmin')

 <!--/.Double navigation-->
<!--Main layout-->
<main class="admin">
    <div class="container-fluid">
        <!-- Section: Create Page -->
         <section class="section">
                    <!-- First row -->
                    <div class="row">
                        <form method="POST" enctype="multipart/form-data" action="" class="w-100">
                            <!-- First column -->
                            <div class="col-lg-4">

                                <!-- Card -->
                                <div class="card contact-card card-cascade narrower mb-r">
                                    <div class="admin-panel info-admin-panel">
                                        <!-- Card title -->
                                        <div class="view primary-color">
                                            <h5>Edit Photo</h5>
                                        </div>
                                        <!-- /.Card title -->

                                        <!-- Card content -->
                                        <div class="card-block text-xs-center">
                                            <div class="row avatar_overlay">
                                                <div class="col-xs-12">
                                                    <div class="view overlay hm-white-slight">
                                                        <img class="avatar_image img-fluid mx-auto d-block" src="/blog_ressources/avatar/{{ $user->avatar }}"/>
                                                        <input type="hidden" name="old_photo" value="{{ $user->avatar }}"/>
                                                        <a>
                                                            <div class="mask waves-effect waves-light"></div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12">
                                                    <a class="btn btn-primary file-btn" type="button">
                                                        <i class="fa fa-folder-open-o"></i> 
                                                        <input type="file" id="upload" value="Choose a file" accept="image/*">
                                                    </a>
                                                    <button type="button" class="btn btn-danger cancel_avatar d-none" data-deg="90"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                    <button type="button" class="btn btn-primary rotate_left d-none" data-deg="90"><i class="fa fa-repeat" aria-hidden="true"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.Card content -->
                                    </div>
                                </div>
                                <!-- /.Card -->

                            </div>
                            <!-- /.First column -->
                            <!-- Second column -->
                            <div class="col-lg-8">
                                <!--Card-->
                                <div class="card card-cascade narrower mb-r">
                                    <div class="admin-panel info-admin-panel">
                                        <!--Card image-->
                                        <div class="view primary-color">
                                            <h5>Edit Account</h5>
                                        </div>
                                        <!--/Card image-->
                                        <!--Card content-->
                                        <div class="card-block">
                                            <!-- Edit Form -->

                                            <!--First row-->
                                            <div class="row">
                                                <!--First column-->
                                                <div class="col-md-6">
                                                    <div class="md-form">
                                                        <i class="material-icons prefix">face</i>
                                                        <input type="text" id="first_name" name="first_name" class="form-control" value="{{ $user->first_name }}"/>
                                                        <label for="first_name">Prénom</label>
                                                    </div>
                                                </div>
                                                <!--Second column-->
                                                <div class="col-md-6">
                                                    <div class="md-form">
                                                        <i class="fa fa-user prefix"></i>
                                                        <input type="text" id="last_name" name="last_name" class="form-control" value="{{ $user->last_name }}"/>
                                                        <label for="last_name">Nom</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/.First row-->
                                            <!--First row-->
                                            <div class="row">
                                                <!--First column-->
                                                <div class="col-md-6">
                                                    <div class="md-form">
                                                        <i class="fa fa-envelope prefix"></i>
                                                        <input type="text" id="email" name="email" class="form-control" value="{{ $user->email }}"/>
                                                        <label for="email">Email</label>
                                                    </div>
                                                </div>
                                                <!--Second column-->
                                                <div class="col-md-6">
                                                    <div class="md-form">
                                                        <i class="material-icons prefix">web</i>
                                                        <input type="text" id="website" name="website" class="form-control"  value="{{ $user->website }}"/>
                                                        <label for="website">Website</label>
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="row">
                                                <!--First column-->
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input type="checkbox" class="filled-in" id="show-email" name="show-email" {{ $user->show_email ? 'checked="checked"' : '' }} >
                                                        <label for="show-email">Montrer mon email</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/.First row-->
                                            <!--Third row-->
                                            <div class="row">
                                                <!--First column-->
                                                <div class="col-md-12">
                                                    <div class="md-form">
                                                        <i class="material-icons prefix">title</i>
                                                        <textarea type="text" id="description" name="description" class="md-textarea">{{ $user->description }}</textarea>
                                                        <label for="description">Description</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <!--First column-->
                                                <div class="col-md-12">
                                                    <div class="md-form">
                                                        <i class="material-icons prefix">title</i>
                                                        <textarea type="text" id="description_eng" name="description_eng" class="md-textarea">{{ $user->description_eng }}</textarea>
                                                        <label for="description_eng">English description</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/.Third row-->
                                            <div class="row">
                                                <!--First column-->
                                                <div class="col-md-6">
                                                    <div class="md-form">
                                                        <i class="fa fa-google prefix"></i>
                                                        <input type="text" id="google" name="google" class="form-control"  value="{{ $user->google }}"/>
                                                        <label for="google">Google+</label>
                                                    </div>
                                                </div>
                                                <!--Second column-->
                                                <div class="col-md-6">
                                                    <div class="md-form">
                                                        <i class="fa fa-linkedin prefix"></i>
                                                        <input type="text" id="linkedin" name="linkedin" class="form-control"  value="{{ $user->linkedin }}"/>
                                                        <label for="linkedin">Linkedin</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <!--First column-->
                                                <div class="col-md-6">
                                                    <div class="md-form">
                                                        <i class="fa fa-facebook prefix"></i>
                                                        <input type="text" id="facebook" name="facebook" class="form-control"  value="{{ $user->facebook }}"/>
                                                        <label for="facebook">Facebook</label>
                                                    </div>
                                                </div>
                                                <!--Second column-->
                                                <div class="col-md-6">
                                                    <div class="md-form">
                                                        <i class="fa fa-twitter prefix"></i>
                                                        <input type="text" id="twitter" name="twitter" class="form-control"  value="{{ $user->twitter }}"/>
                                                        <label for="twitter">Twitter</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Fourth row -->
                                            <div class="row">
                                                <div class="col-md-12 text-xs-center">
                                                    <button type="submit" value="Update Account" class="btn btn-primary">Update Account</button>
                                                </div>
                                            </div>
                                            <!-- /.Fourth row -->

                                            <!-- Edit Form -->
                                        </div>
                                        <!--/.Card content-->
                                    </div>
                                </div>
                                <!--/.Card-->
                            </div>
                            <!-- /.Second column -->
                        </form>
                    </div>
                    <!-- /.First row -->
                </section>
                <!-- /.Section: Edit Account -->
    </div>
</main>
<!--/Main layout-->


@endsection

@section('scripts')


<script>
	$(document).ready(function () {
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
	});
</script>
@endsection